<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use App\Question;
use App\Korelasi;
use App\Hasil;
use App\Answer;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('guru.index');
    }

    public function indexksh()
    {
        $bulann = DB::table('hasil')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

        $thn = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $bln = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $tinggi = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 3)
            ->get();

        $sedang = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 2)
            ->get();

        $rendah = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 1)
            ->get();

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);

        return view('guru.indexksh', compact('t', 's', 'r','thn', 'bln','tahun1', 'bulan1'));
    }

    public function filter_indexksh(Request $request)
    {
        $bulann = DB::table('hasil')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

        $thn = DB::table('hasil')
            ->groupBy('tahun')
            ->get();

        $bln = DB::table('hasil')
            ->groupBy('bulan')
            ->get();

        $getbulan = $request->bulan;
        $gettahun = $request->tahun;

        if ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
        {
            $tinggi = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 1)
                ->get();
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun')
        {
            $tinggi = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 1)
                ->get();
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
        {
            $tinggi = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 1)
                ->get();
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
        {
            $tinggi = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 1)
                ->get();
        }

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);

        return view('guru.filter-indexksh', compact('t', 's', 'r','thn', 'bln','tahun1', 'bulan1','getbulan', 'gettahun'));
    }

    public function indexpb()
    {
        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

        $thn = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $bln = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        if(!isset($data[0])){
            $nilaiipa[] = null;
            $nilaimm[] = null;
            $nilaibind[] = null;
            $nilaibing[] = null;
        }

        $tinggipb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 3)
            ->get();

        $sedangpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 2)
            ->get();

        $rendahpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 1)
            ->get();

        $ipa = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->get();
        foreach ($ipa as $i)
        {
            $nilaiipa[] = $i->ipa;
        }

        $mm = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->get();

        foreach ($mm as $i)
        {
            $nilaimm[] = $i->matematika;
        }

        $bind = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->get();
        foreach ($bind as $i)
        {
            $nilaibind[] = $i->bhsind;
        }

        $bing = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->get();
        foreach ($bing as $i)
        {
            $nilaibing[] = $i->bhsing;
        }

        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);
        $rataipa = collect($nilaiipa)->avg();
        $ratamm = collect($nilaimm)->avg();
        $ratabind = collect($nilaibind)->avg();
        $ratabing = collect($nilaibing)->avg();

        return view('guru.indexpb', compact('tpb', 'spb', 'rpb','thn', 'bln','tahun1', 'bulan1','rataipa', 'ratamm', 'ratabind', 'ratabing'));

    }

    public function filter_indexpb(Request $request)
    {
        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

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
            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun'){
            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
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
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun'){
            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($ipa as $i)
            {
                $nilaiipa[] = $i->ipa;
            }

            $mm = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.matematika')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->get();

            foreach ($mm as $i)
            {
                $nilaimm[] = $i->matematika;
            }

            $bind = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsind')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($bind as $i)
            {
                $nilaibind[] = $i->bhsind;
            }

            $bing = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.bhsing')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }

        }elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun'){
            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();

            $ipa = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.bulan','prestasi.tahun', 'prestasi.ipa')
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
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->get();
            foreach ($bing as $i)
            {
                $nilaibing[] = $i->bhsing;
            }
        }

        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);
        $rataipa = collect($nilaiipa)->avg();
        $ratamm = collect($nilaimm)->avg();
        $ratabind = collect($nilaibind)->avg();
        $ratabing = collect($nilaibing)->avg();


        return view('guru.filter-indexpb',
            compact('tahun1','bulan1', "tpb", 'spb', 'rpb', 'bln', 'thn', 'rataipa', 'ratabind', 'ratabing','ratamm', 'getbulan', 'gettahun'));
    }

    public function indexkor()
    {
        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

        $thn = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $bln = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        $tinggi = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 3)
            ->get();

        $sedang = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 2)
            ->get();

        $rendah = DB::table('hasil')
            ->where('tahun', $tahun1)
            ->where('bulan', $bulan1)
            ->where('kesimpulan', 1)
            ->get();

        $tinggipb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 3)
            ->get();

        $sedangpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 2)
            ->get();

        $rendahpb = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->where('prestasi.bulan', $bulan1)
            ->where('prestasi.tahun', $tahun1)
            ->where('kesimpulan', 1)
            ->get();

        $korelasi = DB::table('korelasi')
            ->where('tahun', $tahun1)
            ->get();

        foreach ($korelasi as $k){
            $nilai[] = $k->korelasi;
            $blnkor[] = $k->bulan;
        }

        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);
        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);

        return view('guru.indexkor', compact('tpb', 'spb', 'rpb', 't', 's', 'r', 'thn', 'bln','tahun1', 'bulan1', 'nilai', 'blnkor'));
    }

    public function filter_indexkor(Request $request)
    {
        $bulann = DB::table('prestasi')
            ->select('bulan')
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        foreach ($bulann as $b){
            $bulan1 = $b->bulan;
        }

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->orderByDesc('tahun')
            ->limit(1)
            ->get();

        foreach ($tahun as $t){
            $tahun1 = $t->tahun;
        }

        $bln = DB::table('prestasi')
            ->groupBy('bulan')
            ->get();

        $thn = DB::table('prestasi')
            ->groupBy('tahun')
            ->get();

        $getbulan = $request->bulan;
        $gettahun = $request->tahun;

        if ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun'){
            $tinggi = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 1)
                ->get();

        }elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun'){
            $tinggi = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();

        }elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun'){
            $tinggi = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $tahun1)
                ->where('bulan', $getbulan)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*','prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $tahun1)
                ->where('kesimpulan', 1)
                ->get();

        }elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun') {
            $tinggi = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 3)
                ->get();

            $sedang = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 2)
                ->get();

            $rendah = DB::table('hasil')
                ->where('tahun', $gettahun)
                ->where('bulan', $bulan1)
                ->where('kesimpulan', 1)
                ->get();

            $tinggipb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 3)
                ->get();

            $sedangpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 2)
                ->get();

            $rendahpb = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $bulan1)
                ->where('prestasi.tahun', $gettahun)
                ->where('kesimpulan', 1)
                ->get();
        }

        if ($gettahun == 'Pilih tahun') {
            $korelasi = DB::table('korelasi')
                ->where('tahun', $tahun1)
                ->get();

            foreach ($korelasi as $k) {
                $nilai[] = $k->korelasi;
                $blnkor[] = $k->bulan;
            }
        }elseif ($gettahun != 'Pilih tahun'){
            $korelasi = DB::table('korelasi')
                ->where('tahun', $gettahun)
                ->get();

            foreach ($korelasi as $k) {
                $nilai[] = $k->korelasi;
                $blnkor[] = $k->bulan;
            }
        }

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);
        $tpb = count($tinggipb);
        $spb = count($sedangpb);
        $rpb = count($rendahpb);

        return view('guru.filter-indexkor', compact('tpb', 'spb', 'rpb', 't', 's', 'r', 'thn', 'bln','tahun1', 'bulan1', 'getbulan', 'gettahun', 'nilai', 'blnkor'));
    }

    public function hasilkorelasi()
    {
        $tahun = DB::table('korelasi')
            ->groupBy('tahun')
            ->get();

        $bulan = DB::table('korelasi')
            ->groupBy('bulan')
            ->get();

        $hasil = DB::table('korelasi')
            ->orderByDesc('id')
            ->limit(1)
            ->get();

        return view('guru.hasil-korelasi', compact('hasil', 'tahun', 'bulan'));
    }

    public function hitung_korelasi()
    {
        $bulan = DB::table('prestasi')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        return view('guru.hitung-korelasi', compact('bulan', 'tahun'));
    }

    public function korelasi(Request $request)
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
        if(date('m') <= 06){
            $semester = "Genap";
        }elseif(date('m') > 06){
            $semester = "Ganjil";
        }
        $create = now();
        $update = now();

        $gettahun = $request->tahun;
        $getbulan = $request->bulan;

        if ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
        {
            $ket = 'Tidak ada data';
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
        {
            $ket = 'Tidak ada data';
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
        {
            $ket = 'Tidak ada data';
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun') {
            $dataks = DB::table('hasil')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->orderBy('student_id')
                ->get();

            $datapb = DB::table('prestasi')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->get();

            $jmldata = count($datapb);

            if($jmldata <= 1){
                return abort(403, 'Data harus lebih dari 1');
            }

            foreach ($dataks as $d) {
                $skor[] = $d->nilai;
            }

            foreach ($datapb as $d) {
                $rata[] = $d->rata;
            }

            for ($i = 0; $i < $jmldata; $i++) {
                $xy[$i] = $skor[$i] * $rata[$i];
            }

            foreach ($dataks as $d) {
                $x2[] = pow($d->nilai, 2);
            }

            foreach ($datapb as $d) {
                $y2[] = pow($d->rata, 2);
            }

            $jumlahx = array_sum($skor);
            $jumlahy = array_sum($rata);
            $jumlahx2 = array_sum($x2);
            $jumlahy2 = array_sum($y2);
            $jumlahxy = array_sum($xy);
            $njumlahxy = $jumlahxy * $jmldata;
            $kalixy = $jumlahx * $jumlahy;
            $njumlahx2 = $jmldata * $jumlahx2;
            $totkiri = $njumlahx2 - pow($jumlahx, 2);
            $njumlahy2 = $jmldata * $jumlahy2;
            $totkanan = $njumlahy2 - pow($jumlahy, 2);
            $kalitotbwh = $totkiri * $totkanan;
            $hsltotbwh = sqrt($kalitotbwh);
            $hslatas = $njumlahxy - $kalixy;
            $korelasi = $hslatas / $hsltotbwh;


            $tes = DB::table('tabelsig')
                ->select('df', 'taraf_sig')
                ->where('df', $jmldata)
                ->get();

            $df = [];
            $ts = [];

            foreach ($tes as $t) {
                $df[] = $t->df;
                $ts[] = $t->taraf_sig;
            }

            $data = implode(',', $ts);

            if ($korelasi >= $data) {
                $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat positif dan signifikan artinya semakin tinggi Kesehatan Mental siswa maka semakin tinggi prestasi belajarnya';
            } elseif ($korelasi < 0) {
                $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat negatif';
            } elseif ($korelasi < $data) {
                $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat positif dan tidak signifikan artinya ada korelasi antara kesehatan mental dengan prestasi belajar tetapi tidak terlalu berpengaruh';
            } elseif ($korelasi == 0) {
                $hasil = 'Tidak ada korelasi';
            }

            $d = DB::table('korelasi')
                ->where('bulan', $getbulan)
                ->where('tahun', $gettahun)
                ->limit(1)
                ->get();

            $bln = 0;
            $thn = 0;

            foreach ($d as $b){
                $bln = $b->bulan;
                $thn = $b->tahun;
            }

            if ($getbulan == $bln && $gettahun == $thn){
                DB::table('korelasi')
                    ->where('bulan', $getbulan)
                    ->where('tahun', $gettahun)
                    ->delete();

                DB::table('korelasi')
                    ->insert([
                        'korelasi' => $korelasi,
                        'tahun' => $tahun,
                        'bulan' => $getbulan,
                        'semester' => $semester,
                        'ket' => $hasil,
                        'created_at' => $create,
                        'updated_at' => $update
                    ]);
            } elseif ($getbulan != $bln && $gettahun == $thn) {
                DB::table('korelasi')
                    ->insert([
                        'korelasi' => $korelasi,
                        'tahun' => $tahun,
                        'bulan' => $getbulan,
                        'semester' => $semester,
                        'ket' => $hasil,
                        'created_at' => $create,
                        'updated_at' => $update
                    ]);
            } elseif ($getbulan == $bln && $gettahun != $thn) {
                DB::table('korelasi')
                    ->insert([
                        'korelasi' => $korelasi,
                        'tahun' => $tahun,
                        'bulan' => $getbulan,
                        'semester' => $semester,
                        'ket' => $hasil,
                        'created_at' => $create,
                        'updated_at' => $update
                    ]);
            } elseif ($getbulan != $bln && $gettahun != $thn){
                DB::table('korelasi')
                    ->insert([
                        'korelasi' => $korelasi,
                        'tahun' => $tahun,
                        'bulan' => $getbulan,
                        'semester' => $semester,
                        'ket' => $hasil,
                        'created_at' => $create,
                        'updated_at' => $update
                    ]);
            }

        }

        return view('guru.korelasi', compact('hasil', 'korelasi', 'bulan1', 'tahun','getbulan', 'gettahun', 'jmldata'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('guru.profil', compact('user'));
    }

    public function edit_profil(Teacher $teacher)
    {
        return view('guru.edit-profil', compact('teacher'));
    }

    public function update_profil(Request $request, Teacher $teacher)
    {

        $request->validate([
            'nama' => 'required|max:255',
            'NIP' => 'required|size:9',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
            ]);

        Teacher::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);
        return redirect('guru/profil-guru')->with('status', 'Data berhasil diubah!');
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
        return redirect('guru/profil-guru')->with('status', 'Gambar berhasil diubah!');
    }

    public function psswrd()
    {
        return view('guru.ganti-password');
    }

    public function ganti_psswrd(Request $request, Teacher $teacher)
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


        return view('guru.detail-jawaban', compact('student', 'hasil'));
    }

    //pertanyaan
    public function list_pertanyaan()
    {
        $pertanyaan = Question::paginate(10);
        return view('guru.daftar-pertanyaan', compact('pertanyaan'));
    }

    public function create_question()
    {
        //
        return view('guru.tambah-pertanyaan');
    }

    public function hasil_survey()
    {
        $siswa = DB::table('students')
            ->join('hasil','students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.NISN', 'hasil.*')
            ->paginate(10);

        $bulan = DB::table('hasil')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $ket = DB::table('hasil')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        return view('guru.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function store_question(Request $request)
    {
        //
        $request->validate([
            'pertanyaan' => 'required|unique:questions|max:255',
            'kategori' => 'required',
            'jenis' => 'required',
        ],
            [
                'pertanyaan.required' => 'Pertanyaan harus diisi',
                'pertanyaan.unique' => 'Pertanyaan telah dipakai',
                'kategori.required' => 'Kategori harus diisi',
                'jenis.required' => 'Kategori harus diisi',

            ]);

        Question::create($request->all());

        return redirect('guru/daftar-pertanyaan-guru')->with('status', 'Pertanyaan berhasil ditambahkan!');

    }

    public function destroy_question(Question $question)
    {
        //
        Question::destroy($question->id);
        return redirect('guru/daftar-pertanyaan-guru')->with('status', 'Pertanyaan berhasil dihapus!');
    }

    public function edit_question(Question $question)
    {
        //
        return view('guru.edit-pertanyaan', compact('question'));
    }

    public function update_question(Request $request, Question $question)
    {
        //
        Question::where('id', $question->id)
            ->update([
                'pertanyaan'=> $request->pertanyaan,
                'jenis'=> $request->jenis,
                'kategori'=> $request->kategori,
            ]);

        return redirect('guru/daftar-pertanyaan-guru')->with('status', 'Pertanyaan berhasil diubah!');
    }

    public function hasil_prestasi()
    {
        $bulan = DB::table('prestasi')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('students')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('students')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $ket = DB::table('prestasi')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        $hasil = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*','prestasi.*')
            ->paginate(10);

        return view('guru.hasil-prestasi', compact('hasil', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function filtersurveyguru(Request $request)
    {
        $getbulan = $request->bulan;
        $gettahun = $request->tahun;
        $getkelas = $request->kelas;
        $getunit = $request->unit;
        $getket = $request->keterangan;

        $bulan = DB::table('hasil')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $ket = DB::table('hasil')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        if ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil'){
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->where('hasil.keterangan', $getket)
                ->paginate(10);
        }

        return view('guru.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function carisurveyguru(Request $request)
    {
        $bulan = DB::table('hasil')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('hasil')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $ket = DB::table('hasil')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        $cari = $request->cari;

        $siswa = DB::table('students')
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.NISN', 'hasil.*')
            ->where('students.nama','LIKE','%'.$cari.'%')
            ->orWhere('students.NISN','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('guru.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function filterprestasiguru(Request $request)
    {
        $getbulan = $request->bulan;
        $gettahun = $request->tahun;
        $getkelas = $request->kelas;
        $getunit = $request->unit;
        $getket = $request->keterangan;

        $bulan = DB::table('prestasi')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.kelas')
            ->groupBy('students.kelas')
            ->get();

        $unit = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.unit')
            ->groupBy('students.unit')
            ->get();

        $ket = DB::table('prestasi')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        if ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil'){
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.unit', $getunit)
                ->where('prestasi.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.unit', $getunit)
                ->where('students.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket == 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN','students.email', 'hasil.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('students.kelas', $getkelas)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.kelas', $getkelas)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.tahun', $gettahun)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('prestasi.tahun', $gettahun)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.kelas', $getkelas)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas' && $getket != 'Pilih hasil') {
            $hasil = DB::table('students')
                ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
                ->select('students.*', 'prestasi.*')
                ->where('prestasi.bulan', $getbulan)
                ->where('students.unit', $getunit)
                ->where('prestasi.keterangan', $getket)
                ->paginate(10);
        }

        return view('guru.hasil-prestasi', compact('hasil', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function cariprestasiguru(Request $request)
    {
        $bulan = DB::table('prestasi')
            ->select('bulan')
            ->groupBy('bulan')
            ->get();

        $tahun = DB::table('prestasi')
            ->select('tahun')
            ->groupBy('tahun')
            ->get();

        $kelas = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.kelas')
            ->groupBy('students.kelas')
            ->get();

        $unit = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.unit')
            ->groupBy('students.unit')
            ->get();

        $ket = DB::table('prestasi')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->get();

        $cari = $request->cari;

        $hasil = DB::table('students')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.*', 'prestasi.*')
            ->where('students.nama','LIKE','%'.$cari.'%')
            ->orWhere('students.NISN','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('guru.hasil-prestasi', compact('hasil', 'bulan', 'tahun', 'kelas', 'unit', 'ket'));
    }

    public function filterkorelasiguru(Request $request)
    {
        $tahun = DB::table('korelasi')
            ->groupBy('tahun')
            ->get();

        $bulan = DB::table('korelasi')
            ->groupBy('bulan')
            ->get();

        $gettahun = $request->tahun;
        $getbulan = $request->bulan;

        if ($gettahun == 'Pilih tahun' && $getbulan == 'Pilih bulan'){
            $hasil = DB::table('korelasi')
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun != 'Pilih tahun' && $getbulan != 'Pilih bulan'){
            $hasil = DB::table('korelasi')
                ->where('tahun', $gettahun)
                ->where('bulan', $getbulan)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun != 'Pilih tahun' && $getbulan == 'Pilih bulan'){
            $hasil = DB::table('korelasi')
                ->where('tahun', $gettahun)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        } elseif ($gettahun == 'Pilih tahun' && $getbulan != 'Pilih bulan'){
            $hasil = DB::table('korelasi')
                ->where('bulan', $getbulan)
                ->orderByDesc('id')
                ->limit(1)
                ->get();
        }

        return view('guru.hasil-korelasi', compact('hasil', 'tahun', 'bulan'));
    }

}
