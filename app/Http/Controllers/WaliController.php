<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Student;
use App\Teacher;
use App\Question;
use App\Korelasi;
use App\Hasil;
use App\WaliKelas;
use Illuminate\Support\Facades\Hash;
use App\Answer;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WaliController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
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

        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('bulan')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }
        $tahun = date('Y');
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;

        $bln = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        $thn = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $tinggi = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 3)
                ->get();

        $sedang = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 2)
                ->get();

        $rendah = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 1)
                ->get();

        $tinggipb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->where('kesimpulan', 3)
            ->get();

        $sedangpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->where('kesimpulan', 2)
            ->get();

        $rendahpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->where('kesimpulan', 1)
            ->get();

        $ipa = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

        $mm = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->get();

        foreach ($mm as $i)
        {
            $nilaimm[] = $i->matematika;
        }

        $bind = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->get();
        foreach ($bind as $i)
        {
            $nilaibind[] = $i->bhsind;
        }

        $bing = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun)
            ->get();
        foreach ($bing as $i)
        {
            $nilaibing[] = $i->bhsing;
        }

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);
        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);
        $rataipa = collect($nilaiipa)->avg();
        $ratamm = collect($nilaimm)->avg();
        $ratabind = collect($nilaibind)->avg();
        $ratabing = collect($nilaibing)->avg();



        return view('walikelas.index',
            compact('bulan1', 't','s','r','tahun', "tpb", 'spb', 'rpb', 'bln', 'thn', 'rataipa', 'ratabind', 'ratabing','ratamm'));
    }

    public function filterindexwali(Request $request)
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

        $tahun = date('Y');
        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('bulan')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;

        $bln = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        $thn = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $getbulan = $request->bulan;
        $gettahun = $request->tahun;

        if ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
        {
            $tinggi = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun'){
            $tinggi = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun'){
            $tinggi = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $tahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun'){
            $tes = 'a';
            $tinggi = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('bulan', $bulan1)
                ->where('tahun', $gettahun)
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }
        }

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);
        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);
        $rataipa = collect($nilaiipa)->avg();
        $ratamm = collect($nilaimm)->avg();
        $ratabind = collect($nilaibind)->avg();
        $ratabing = collect($nilaibing)->avg();


        return view('walikelas.filterindex',
            compact('bulan1', 't','s','r','tahun', "tpb", 'spb', 'rpb', 'bln', 'thn', 'rataipa', 'ratabind', 'ratabing','ratamm', 'getbulan', 'gettahun'));
    }

    public function korelasikelas()
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
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;
        $tahun = date('Y');
        if(date('m') <= 06){
            $semester = "Genap";
        }elseif(date('m') > 06){
            $semester = "Ganjil";
        }

        $dataks = DB::table('students')
            ->join('hasil','students.id', '=', 'hasil.student_id')
            ->select('students.*', 'hasil.*')
            ->where('hasil.tahun', $tahun)
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->orderBy('student_id')
            ->get();

        $datapb = DB::table('students')
            ->join('prestasi','students.id', '=', 'prestasi.student_id')
            ->select('students.*', 'prestasi.*')
            ->where('prestasi.tahun', $tahun)
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->get();

        $jmldata = count($datapb);

        foreach ($dataks as $d){
            $skor[] = $d->nilai;
        }

        foreach ($datapb as $d){
            $rata[] = $d->rata;
        }

        for($i=0; $i<$jmldata; $i++){
            $xy[$i] = $skor[$i] * $rata[$i];
        }

        foreach ($dataks as $d){
            $x2[] = pow($d->nilai,2);
        }

        foreach ($datapb as $d){
            $y2[] = pow($d->rata, 2);
        }


        $jumlahx = array_sum($skor);
        $jumlahy = array_sum($rata);
        $jumlahx2 = array_sum($x2);
        $jumlahy2 = array_sum($y2);
        $jumlahxy = array_sum($xy);
        $njumlahxy = $jumlahxy*$jmldata;
        $kalixy = $jumlahx*$jumlahy;
        $njumlahx2 = $jmldata*$jumlahx2;
        $totkiri = $njumlahx2-pow($jumlahx,2);
        $njumlahy2 = $jmldata*$jumlahy2;
        $totkanan= $njumlahy2-pow($jumlahy,2);
        $kalitotbwh = $totkiri*$totkanan;
        $hsltotbwh = sqrt($kalitotbwh);
        $hslatas = $njumlahxy-$kalixy;
        $korelasi = $hslatas/$hsltotbwh;

        $tes = DB::table('tabelsig')
            ->select('df', 'taraf_sig')
            ->where('df', $jmldata)
            ->get();

        $df = [];
        $ts = [];

        foreach ($tes as $t){
            $df[] = $t->df;
            $ts[] = $t->taraf_sig;
        }

        $data = implode(',',$ts);

        if($korelasi >= $data){
            $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat positif dan signifikan artinya semakin tinggi Kesehatan Mental siswa maka semakin tinggi prestasi belajarnya';
        }elseif ($korelasi < 0) {
            $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat negatif';
        }elseif ($korelasi < $data){
            $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat positif dan tidak signifikan artinya ada korelasi antara kesehatan mental dengan prestasi belajar tetapi tidak terlalu berpengaruh';
        }elseif ($korelasi == 0){
            $hasil = 'Tidak ada korelasi';
        }

        DB::table('korelasikelas')
            ->insert([
                'korelasi' => $korelasi,
                'tahun' =>$tahun,
                'bulan' =>$bulan1,
                'kelas' =>$kelas,
                'unit' =>$unit,
                'semester' => $semester,
                'ket' => $hasil
            ]);

        return view('walikelas.korelasi', compact('hasil', 'korelasi', 'semester'));
    }

    public function hasilkorelasi()
    {
        $tahun = DB::table('korelasi')
            ->groupBy('tahun')
            ->get();

        $semester = DB::table('korelasi')
            ->groupBy('semester')
            ->get();

        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;

        $hasil = DB::table('korelasikelas')
            ->where('kelas', $kelas)
            ->where('unit', $unit)
            ->orderByDesc('id')
            ->limit(1)
            ->get();

        return view('walikelas.hasil-korelasi', compact('hasil', 'tahun', 'semester'));
    }

    public function filterkorelasiwali(Request $request)
    {
        $tahun = DB::table('korelasi')
            ->groupBy('tahun')
            ->get();

        $semester = DB::table('korelasi')
            ->groupBy('semester')
            ->get();

        $gettahun = $request->tahun;
        $getsemester = $request->semester;
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;

        if ($gettahun == 'Pilih tahun' && $getsemester == 'Pilih semester'){
            $hasil = DB::table('korelasikelas')
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun != 'Pilih tahun' && $getsemester != 'Pilih semester'){
            $hasil = DB::table('korelasikelas')
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('tahun', $gettahun)
                ->where('semester', $getsemester)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun != 'Pilih tahun' && $getsemester == 'Pilih semester'){
            $hasil = DB::table('korelasikelas')
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('tahun', $gettahun)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun == 'Pilih tahun' && $getsemester != 'Pilih semester'){
            $hasil = DB::table('korelasikelas')
                ->where('kelas', $kelas)
                ->where('unit', $unit)
                ->where('semester', $getsemester)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        }

        return view('walikelas.hasil-korelasi', compact('hasil', 'tahun', 'semester'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('walikelas.profil', compact('user'));
    }

    public function edit_profil(WaliKelas $waliKelas)
    {
        return view('walikelas.edit-profil', compact('waliKelas'));
    }

    public function update_profil(Request $request, WaliKelas $waliKelas)
    {

        $request->validate([
            'nama' => 'required|max:255',
            'NIP' => 'required|size:9',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas_diampu' => 'required',
            'unit' => 'required',
            'email' => 'required|email',
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'NIP.unique' => 'NIP telah dipakai',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas_diampu.required' => 'Email harus diisi',
                'unit.required' => 'Email harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
            ]);

        WaliKelas::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'kelas_diampu'=> $request->kelas_diampu,
                'unit'=> $request->unit,
                'email'=> $request->email
            ]);
        return redirect('wali/profil-wali')->with('status', 'Data berhasil diubah!');
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
        return redirect('wali/profil-wali')->with('status', 'Gambar berhasil diubah!');
    }

    public function psswrd()
    {
        return view('walikelas.ganti-password');
    }

    public function ganti_psswrd(Request $request, Admin $admin)
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

    //siswa
    public function hasil_survey()
    {
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;
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

        $siswa = DB::table('students')
            ->join('hasil','students.id', '=', 'hasil.student_id')
            ->select('students.*', 'hasil.*')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->paginate(10);

        return view('walikelas.hasil-survey', compact('siswa', 'bulan', 'tahun', 'ket'));
    }

    public function show_answer(Student $student)
    {
        $jmlpertanyaan = Question::select('id')->get();

        $id = $student->id;

        $hasil = DB::table('questions')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->select('questions.id','questions.pertanyaan','questions.jenis','questions.kategori','answers.*')
            ->where('answers.student_id',$id)
            ->latest()
            ->limit(count($jmlpertanyaan))
            ->get();

        return view('walikelas.detail-jawaban', compact('student', 'hasil'));
    }

    public function hasil_prestasi()
    {
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;
        $bulan = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $ket = DB::table('prestasi')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        $hasil = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->paginate(10);

        return view('walikelas.hasil-prestasi', compact('hasil', 'bulan', 'tahun', 'ket'));
    }

    public function filtersurveywali(Request $request)
    {
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;
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
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil'){
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.*','hasil.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        }

        return view('walikelas.hasil-survey', compact('siswa', 'bulan', 'tahun', 'ket'));
    }

    public function carisurveywali(Request $request)
    {
        $bulan = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $cari = $request->cari;

        $siswa = DB::table('students')
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.*','hasil.*')
            ->where('students.nama','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('walikelas.hasil-survey', compact('siswa','bulan', 'tahun'));
    }

    public function filterprestasiwali(Request $request)
    {
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;
        $getbulan = $request->bulan;
        $gettahun = $request->tahun;
        $getket = $request->keterangan;

        $bulan = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $ket = DB::table('prestasi')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        if ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil'){
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.tahun', $gettahun)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('students.kelas', $kelas)
                ->where('students.unit', $unit)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->paginate(10);
        }

        return view('walikelas.hasil-prestasi', compact('hasil', 'bulan', 'tahun', 'ket'));
    }

    public function cariprestasiwali(Request $request)
    {
        $bulan = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $cari = $request->cari;

        $hasil = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('students.nama','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('walikelas.hasil-prestasi', compact('hasil','bulan', 'tahun'));
    }
}
