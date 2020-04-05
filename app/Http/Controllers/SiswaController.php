<?php

namespace App\Http\Controllers;

use App\Prestasi;
use App\Question;
use App\Answer;
use App\Hasil;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $data = DB::table('students')->where('student_id', Auth::id())
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','hasil.kesimpulan', 'hasil.bulan')
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
        $create = now();
        $update = now();

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


        DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values '.$data.' ');
        DB::insert('insert into hasil(student_id, skor, kesimpulan, keterangan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$ket.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

        return redirect('/hasil-kuesioner');
    }

    public function create_prestasi()
    {
        //
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

        DB::insert('insert into prestasi(student_id, biologi, kimia, fisika, matematika, bhsind, bhsing, rata, bulan, tahun, created_at, updated_at) values 
("'.$id.'","'.$biologi.'","'.$kimia.'","'.$fisika.'","'.$matematika.'","'.$bhsind.'","'.$bhsing.'","'.$rata.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');



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

//        foreach ($hasil as $h){
//            $value = $h -> kesimpulan;
//        }
//
//        if ($value == null){
//            $ket = 'Tidak ada';
//        }elseif ($value == 1){
//            $ket = 'Rendah';
//        }elseif ($value == 2){
//            $ket = 'Sedang';
//        }elseif ($value == 3) {
//            $ket = 'Tinggi';
//        }

        //validate
        if($hasil == null)
        {
            $hasil = 'Tidak ada data';
        }

        return view('siswa.hasil', compact('hasil'));
    }
}
