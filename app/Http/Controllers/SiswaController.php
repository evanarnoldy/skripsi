<?php

namespace App\Http\Controllers;

use App\Prestasi;
use App\Question;
use App\Answer;
use App\Hasil;
use App\Student;
use App\Keluhan;
use Carbon\Carbon;
use App\Notifications\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SiswaController extends Controller
{
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
            'nama' => 'required|unique:students|max:255',
            'NISN' => 'required|size:9|unique:students',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|size:2',
            'email' => 'required|email|unique:students',
            'passsword' => 'nullable'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NISN.required' => 'NISN harus diisi',
                'NISN.size' => 'NISN harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'kelas.size' => 'Kelas harus berisi 2 karakter',
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
            ]);

        Student::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NISN'=> $request->NISN,
                'kelas'=> $request->kelas,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);
        return redirect('profil-siswa')->with('status', 'Data berhasil diubah!');
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
        return redirect('profil-siswa')->with('status', 'Gambar berhasil diubah!');
    }
    public function index()
    {
        $data = DB::table('hasil')
            ->where('student_id', Auth::id())
            ->select('kesimpulan', 'bulan')
            ->groupBy('bulan')
            ->whereRaw('id = (select max(id) from hasil)')
            ->get();

        $bulan = [];
        $nilai = [];

        foreach ($data as $d)
        {
            $bulan[] = $d->bulan;
            $nilai[] = $d->kesimpulan;
        }

        if($data == null){
           $data = "Data tidak ada";
        }elseif ($bulan == null){
            $bulan = 'Data tidak ada';
        }elseif ($nilai == null){
            $nilai = 'Data tidak ada';
        }

        return view('siswa.index', compact('data', 'bulan','nilai'));
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

        $cek = DB::table('answers')
            ->select('bulan')
            ->latest()
            ->limit(1)
            ->get();

        $tes = Answer::all()
        ->find($id);

        $tes1 = $tes->student_id;

        $cek1 = [];

        foreach ($cek as $c){
            $cek1[] = $c->bulan;
        }

    //Jawaban
        if($tes1 !== $id){
            if ($cek1[0] !== $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values ' . $data . ' ');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values ' . $data . ' ');
            }
        }elseif ($tes1 == $id){
            if ($cek1[0] !== $bulan1){
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
        if($tes1 !== $id){
            if ($cek1[0] !== $bulan1){
                DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }
        }elseif ($tes1 == $id){
            if ($cek1[0] !== $bulan1){
                DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }elseif ($cek1[0] == $bulan1){
                DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

                DB::table('hasil')
                    ->where('bulan', $bulan1)
                    ->where('student_id', $id)
                    ->delete();

                DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }
        }

        return redirect('/hasil-kuesioner');
    }

    public function create_prestasi()
    {
        return view('siswa.form-prestasi');
    }

    public function store_prestasi(Request $request)
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
        $id = Auth::id();
        $create = now();
        $update = now();
        $cek = DB::table('answers')
            ->select('bulan')
            ->latest()
            ->limit(1)
            ->get();

        $tes = Answer::all()
            ->find($id);

        $tes1 = $tes->student_id;

        $cek1 = [];

        foreach ($cek as $c){
            $cek1[] = $c->bulan;
        }

        $request->validate([
            'biologi' => 'required|max:3',
            'kimia' => 'required|max:3',
            'fisika' => 'required|max:3',
            'matematika' => 'required|max:3',
            'bhsind' => 'required|max:3',
            'bhsing' => 'required|max:3',
        ],
            [
                'biologi.required' => 'field harus diisi',
                'biologi.size' => 'field maksimal berisi 3 karakter',
                'kimia.required' => 'field harus diisi',
                'kimia.size' => 'field maksimal berisi 3 karakter',
                'fisika.required' => 'field harus diisi',
                'fisika.size' => 'field maksimal berisi 3 karakter',
                'matematika.required' => 'field harus diisi',
                'matematika.size' => 'field maksimal berisi 3 karakter',
                'bhsind.required' => 'field harus diisi',
                'bhsind.size' => 'field maksimal berisi 3 karakter',
                'bhsing.required' => 'field harus diisi',
                'bhsing.size' => 'field maksimal berisi 3 karakter',
            ]);

        $biologi = $request->biologi;
        $kimia = $request->kimia;
        $fisika = $request->fisika;
        $matematika = $request->matematika;
        $bhsind = $request->bhsind;
        $bhsing = $request->bhsing;

        $rata = collect([$biologi, $kimia, $fisika, $matematika, $bhsind, $bhsing])->avg();

        if($tes1 !== $id){
            if ($cek1[0] !== $bulan1){

                DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }elseif ($cek1[0] == $bulan1){

                DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }
        }elseif ($tes1 == $id){
            if ($cek1[0] !== $bulan1){

                DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

            }elseif ($cek1[0] == $bulan1){

                DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

                DB::table('prestasi')
                    ->where('bulan', $bulan1)
                    ->where('student_id', $id)
                    ->delete();

                DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');
            }
        }

        return redirect('/hasil-kuesioner');
    }

    public function hasil()
    {
        $hasil = DB::table('students')->where('student_id', Auth::id())
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.kelas','students.email','hasil.skor', 'hasil.kesimpulan', 'hasil.bulan', 'hasil.created_at', 'hasil.keterangan')
            ->latest()
            ->limit('1')
            ->get();

        //validate
        if($hasil == null)
        {
            $hasil = 'Tidak ada data';
        }

        return view('siswa.hasil', compact('hasil'));
    }
}
