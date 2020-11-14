<?php

namespace App\Http\Controllers;

use App\Prestasi;
use App\Question;
use App\Answer;
use App\Hasil;
use App\Student;
use App\Keluhan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('siswa.profil', compact('user'));
    }

    public function edit_profil(Student $student)
    {
        return view('siswa.edit-profil', compact('student'));
    }

    public function update_profil(Request $request, Student $student)
    {

        $request->validate([
            'nama' => 'required|max:255',
            'NISN' => 'required|size:6',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
            'unit' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'NISN.required' => 'NISN harus diisi',
                'NISN.size' => 'NISN harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'unit.required' => 'Unit harus diisi',
            ]);

        Student::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NISN'=> $request->NISN,
                'kelas'=> $request->kelas,
                'unit'=> $request->unit,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
            ]);

        return redirect('siswa/profil-siswa')->with('status', 'Data berhasil diubah!');
    }

    public function update_avatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        return redirect('siswa/profil-siswa')->with('status', 'Gambar berhasil diubah!');
    }
    public function index()
    {
        $tahun = date('Y');

        $thn = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $data = DB::table('hasil')
            ->where('student_id', Auth::id())
            ->where('tahun', $tahun)
            ->groupBy('bulan')
            ->orderBy('created_at', 'asc')
            ->get();

        $dataprestasi = DB::table('prestasi')
            ->where('student_id', Auth::id())
            ->where('tahun', $tahun)
            ->select('rata', 'bulan')
            ->groupBy('bulan')
            ->orderBy('created_at', 'asc')
            ->get();

        if(!isset($data[0])){
            $nilai[] = null;
            $bulanksh[] = null;
            $prestasi[] = null;
            $bulan[] = null;
        }
        foreach ($data as $d)
        {
            $nilai[] = $d->nilai;
            $bulanksh[] = $d->bulan;
        }

        foreach ($dataprestasi as $p)
        {
            $prestasi[] = $p->rata;
            $bulan[] = $p->bulan;
        }

        return view('siswa.index', compact('data', 'bulan','nilai', 'prestasi', 'bulanksh', 'thn'));
    }

    public function filterindex(Request $request)
    {
        $tahun = date('Y');
        $thn = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $gettahun = $request->tahun;

        if ($gettahun == 'Pilih tahun') {
            $data = DB::table('hasil')
                ->where('student_id', Auth::id())
                ->where('tahun', $tahun)
                ->groupBy('bulan')
                ->orderBy('created_at', 'asc')
                ->get();

            $dataprestasi = DB::table('prestasi')
                ->where('student_id', Auth::id())
                ->where('tahun', $tahun)
                ->select('rata', 'bulan')
                ->groupBy('bulan')
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($data as $d) {
                $nilai[] = $d->nilai;
                $bulanksh[] = $d->bulan;
            }

            foreach ($dataprestasi as $p) {
                $prestasi[] = $p->rata;
                $bulan[] = $p->bulan;
            }
        }elseif ($gettahun != 'Pilih tahun'){
            $data = DB::table('hasil')
                ->where('student_id', Auth::id())
                ->where('tahun', $gettahun)
                ->groupBy('bulan')
                ->orderBy('created_at', 'desc')
                ->get();

            $dataprestasi = DB::table('prestasi')
                ->where('student_id', Auth::id())
                ->where('tahun', $gettahun)
                ->select('rata', 'bulan')
                ->groupBy('bulan')
                ->get();

            if(!isset($data[0])){
                $nilai[] = null;
                $bulanksh[] = null;
                $prestasi[] = null;
                $bulan[] = null;
            }

            foreach ($data as $d) {
                $nilai[] = $d->nilai;
                $bulanksh[] = $d->bulan;
            }

            foreach ($dataprestasi as $p) {
                $prestasi[] = $p->rata;
                $bulan[] = $p->bulan;
            }
        }

        return view('siswa.filter-index', compact('data', 'bulan','nilai', 'prestasi', 'bulanksh', 'thn', 'gettahun'));
    }

    public function pertanyaan()
    {
        $pertanyaan = Question::all();
        return view('siswa.pengisian-kuesioner', compact('pertanyaan'));
    }

    public function store_jawaban()
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $bulan1 = date('m');
        $bulan1 = $bulan[$bulan1];
        $tahun = date('Y');
        $jawaban = $_POST['jawaban'];
        $jumlah = 0;
        $id = Auth::id();
        $create = Carbon::now();
        $update = Carbon::now();
        $kelas = Auth::user()->kelas;
        $unit = Auth::user()->unit;

        foreach ($jawaban as $key => $value ){
            $data[] = '('.$value.','.$_POST[$value].','.$id.',"'.$create.'","'.$update.'","'.$bulan1.'","'.$tahun.'")';

            //menghitung skor kuesioner
            $jumlah += $_POST[$value];
        }

        $data = implode(',',$data);

        $kesimpulan = (($jumlah/(4*count($jawaban)))*100);
        if($kesimpulan == null){
            $hasil = 0;
        } elseif($kesimpulan <= 33.34){
            $hasil = 1;
        } elseif ($kesimpulan > 33.34 && $kesimpulan <= 66.66){
            $hasil = 2;
        } else if ($kesimpulan > 66.66){
            $hasil = 3;
        }

        if($hasil == 0){
            $ket = 'Tidak ada isi';
        } elseif($hasil == 1){
            $ket = 'Rendah';
        } elseif ($hasil == 2){
            $ket = 'Sedang';
        } else if ($hasil == 3){
            $ket = 'Tinggi';
        }

        if($ket == 'Tinggi'){
            $status = 'Status kesehatan mental baik';
        } elseif($ket == 'Sedang'){
            $status = 'Status kesehatan mental cukup baik';
        } elseif ($ket == 'Rendah'){
            $status = 'Disarankan untuk berkonsultasi dengan guru BK';
        }

        $cek = DB::table('answers')
            ->select('bulan')
            ->latest()
            ->limit(1)
            ->get();

        $tes = DB::table('answers')
            ->where('student_id', $id)
            ->first();

        if ($tes == null){
            $tes1 = 0;
        }else {
             $tes1 = $tes->student_id;
        }

        $cek1 = [];

        foreach ($cek as $c){
            $cek1[] = $c->bulan;
        }

    //Jawaban
        if ($tes1 == 0){
            DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values '.$data.' ');
        }elseif($tes1 != $id){
            if ($cek1[0] != $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values ' . $data . ' ');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values ' . $data . ' ');
            }
        }elseif ($tes1 == $id){
            if ($cek1[0] != $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values ' . $data . ' ');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values '.$data.' ');

                DB::table('answers')
                    ->where('bulan', $bulan1)
                    ->where('student_id', $id)
                    ->delete();

                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values '.$data.' ');
            }
        }

        //hasil
        if ($tes1 == 0){
            DB::insert('insert into hasil(student_id, skor, nilai, kesimpulan, keterangan, status, kelas, unit, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
        }elseif($tes1 != $id){
            if ($cek1[0] != $bulan1){
                DB::insert('insert into hasil(student_id, skor, nilai, kesimpulan, keterangan, status, kelas, unit,  bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into hasil(student_id, skor,  nilai, keterangan, status, kelas, unit,  bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }
        }elseif ($tes1 == $id){
            if ($cek1[0] != $bulan1){
                DB::insert('insert into hasil(student_id, skor,  nilai, kesimpulan, keterangan, status, kelas, unit,  bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into hasil(student_id, skor,  nilai, kesimpulan, keterangan, status, kelas, unit,  bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

                DB::table('hasil')
                    ->where('bulan', $bulan1)
                    ->where('student_id', $id)
                    ->delete();

                DB::insert('insert into hasil(student_id, skor,  nilai, kesimpulan, keterangan, status, kelas, unit,  bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$kesimpulan.'","'.$hasil.'","'.$ket.'","'.$status.'","'.$kelas.'","'.$unit.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }
        }

        return redirect('siswa/hasil-kuesioner');
    }

    public function create_prestasi(Student $student)
    {
        return view('siswa.form-prestasi', compact('student'));
    }

    public function store_prestasi(Request $request, Student $student)
    {
        //
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $bulan1 = date('m');
        $bulan1 = $bulan[$bulan1];
        $tahun = date('Y');
        $id = $student->id;
        $nama = $student->nama;
        $create = now();
        $update = now();
        $cek = DB::table('prestasi')
            ->select('bulan')
            ->latest()
            ->limit(1)
            ->get();

        $tes = Prestasi::all()
            ->find($id);

        if ($tes == null){
            $tes1 = 0;
        }else {
            $tes1 = $tes->student_id;
        }

        $cek1 = [];

        foreach ($cek as $c){
            $cek1[] = $c->bulan;
        }

        $request->validate([
            'ipa' => 'required|max:3',
            'matematika' => 'required|max:3',
            'bhsind' => 'required|max:3',
            'bhsing' => 'required|max:3',
        ],
            [
                'ipa.required' => 'field harus diisi',
                'ipa.size' => 'field maksimal berisi 3 karakter',
                'matematika.required' => 'field harus diisi',
                'matematika.size' => 'field maksimal berisi 3 karakter',
                'bhsind.required' => 'field harus diisi',
                'bhsind.size' => 'field maksimal berisi 3 karakter',
                'bhsing.required' => 'field harus diisi',
                'bhsing.size' => 'field maksimal berisi 3 karakter',
            ]);

        $ipa = $request->ipa;
        $matematika = $request->matematika;
        $bhsind = $request->bhsind;
        $bhsing = $request->bhsing;

        $rata = collect([$ipa, $matematika, $bhsind, $bhsing])->avg();

        if($rata == null){
            $kesimpulan = 0;
        } elseif($rata < 60){
            $kesimpulan = 1;
        } elseif ($rata >= 60 && $rata < 80){
            $kesimpulan = 2;
        } else if ($rata >= 80){
            $kesimpulan = 3;
        }

        if($kesimpulan == 0){
            $ket = 'Tidak ada isi';
        } elseif($kesimpulan == 1){
            $ket = 'Rendah';
        } elseif ($kesimpulan == 2){
            $ket = 'Sedang';
        } else if ($kesimpulan == 3){
            $ket = 'Tinggi';
        }

        if($ket == 'Tinggi'){
            $status = 'Status prestasi belajar baik';
        } elseif($ket == 'Sedang'){
            $status = 'Status prestasi belajar cukup baik';
        } elseif ($ket == 'Rendah') {
            $status = 'Disarankan untuk berkonsultasi dengan walikelas';
        }

        if ($tes1 == 0){
            DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

        }elseif($tes1 != $id){
            if ($cek1[0] != $bulan1){

                DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }elseif ($cek1[0] == $bulan1){

                DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }
        }elseif ($tes1 == $id){
            if ($cek1[0] != $bulan1){

                DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }elseif ($cek1[0] == $bulan1){

                DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

                DB::table('prestasi')
                    ->where('bulan', $bulan1)
                    ->where('student_id', $id)
                    ->delete();

                DB::insert('insert into prestasi(student_id, ipa, matematika, bhsind, bhsing, rata, kesimpulan, keterangan, status, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$ipa.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$kesimpulan.'","'.$ket.'","'.$status.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }
        }

        return redirect('admin/form-prestasi')->with('status', 'Nilai '.($nama).' berhasil diisi');
    }

    public function daftarhasil()
    {
        $bulan = DB::table('hasil')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $ket = DB::table('hasil')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        $hasil = DB::table('students')->where('student_id', Auth::id())
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.kelas','hasil.*')
            ->paginate(10);

        //validate
        if($hasil == null)
        {
            $hasil = 'Tidak ada data';
        }

        return view('siswa.daftar-survey', compact('hasil', 'bulan', 'tahun', 'ket'));
    }

    public function filterdaftarhasil(Request $request)
    {
        $getbulan = $request->bulan;
        $gettahun = $request->tahun;
        $getket = $request->keterangan;

        $bulan = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $ket = DB::table('hasil')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        if ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil'){
            $hasil = DB::table('students')->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->where('student_id', Auth::id())
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.kelas','hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        }

        return view('siswa.daftar-survey', compact('hasil', 'bulan', 'tahun', 'ket'));
    }

    public function showhasil(Hasil $hasil)
    {
        return view('siswa.detail-hasil', compact('hasil'));
    }

    public function hasil_prestasi()
    {
        $id = Auth::id();
        $prestasi = DB::table('prestasi')
            ->where('student_id', $id)
            ->paginate(10);

        return view('siswa.daftar-prestasi', compact('prestasi'));
    }

    public function psswrd()
    {
        return view('siswa.ganti-password');
    }

    public function ganti_psswrd(Request $request, Student $student)
    {
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|min:6|confirmed',
        ],
            [
                'current-password.required' => 'Password harus diisi',
                'new-password.required' => 'Password harus diisi',
                'new-password.min' => 'Password minimal harus berisi 6 karakter',
            ]);

        $request_data = $request->all();
        $current_password = auth()->user()->password;

        $now = bcrypt($request_data['current-password']);

        if (Hash::check($request_data['current-password'], $current_password)) {
            $user = Auth::user();
            $user->password = $request->get('new-password');
            $user->save();
        } else {
            return back()->with('failed', 'Password tidak cocok!');
        };

        return redirect()->back()->with('status', 'Password berhasil diganti!');
    }
}
