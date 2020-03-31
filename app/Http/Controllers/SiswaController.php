<?php

namespace App\Http\Controllers;

use App\Question;
use App\Answer;
use App\Hasil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function pertanyaan()
    {
        $pertanyaan = Question::all();
        return view('siswa.pengisian-kuesioner', compact('pertanyaan'));
    }

    public function store_jawaban(Request $request, Question $question)
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

        $kesimpulan = ($jumlah/(4*count($jawaban)));
        if($kesimpulan <= 0.3334){
            $hasil = 'rendah';
        } elseif ($kesimpulan > 0.3334 && $kesimpulan <= 0.6666){
            $hasil = 'sedang';
        } else if ($kesimpulan > 0.6666){
            $hasil = 'tinggi';
        }

        DB::insert('insert into answers(question_id, jawaban, student_id, created_at, updated_at, bulan, tahun) values '.$data.' ');
        DB::insert('insert into hasil(student_id, skor, kesimpulan, bulan, tahun, created_at, updated_at) values ("'.$id.'","'.$jumlah.'","'.$hasil.'","'.$bulan1.'","'.$tahun.'","'.$create.'","'.$update.'")');

        return redirect('/hasil-kuesioner');
    }

    public function hasil()
    {
        $hasil = DB::table('students')->where('student_id', Auth::id())
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.kelas','students.email','hasil.skor', 'hasil.kesimpulan', 'hasil.bulan', 'hasil.created_at')
            ->latest()
            ->limit('1')
            ->get();

        return view('siswa.hasil', compact('hasil'));
    }
}
