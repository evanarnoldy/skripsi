<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Keluhan;
use App\Notifications\Konsultasi;
use App\Teacher;
use App\WaliKelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class KeluhanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list_keluhan(Keluhan $keluhan)
    {
        $kelas = Auth::user()->kelas_diampu;
        $unit = Auth::user()->unit;

        $list = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.penerima', '=', 'Wali kelas')
            ->where('students.kelas', $kelas)
            ->where('students.unit', $unit)
            ->paginate(10);

        return view('walikelas.daftar-keluhan', compact('keluhan', 'list'));
    }

    public function show_keluhan(Keluhan $keluhan)
    {
        $id = $keluhan->id;
        $data = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.id', $id)
            ->get();

        return view('walikelas.show-keluhan', compact('keluhan', 'data'));
    }

    public function list_keluhan_guru(Keluhan $keluhan)
    {
        $list = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.penerima', '=', 'Guru BK')
            ->paginate(10);

        return view('guru.daftar-keluhan', compact('keluhan', 'list'));
    }

    public function show_keluhan_guru(Keluhan $keluhan)
    {
        $id = $keluhan->id;
        $data = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.id', $id)
            ->get();

        return view('guru.show-keluhan', compact('keluhan', 'data'));
    }

    public function konsultasi()
    {
        return view('siswa.konsultasi');
    }

    public function send_konsultasi(Request $request, Keluhan $keluhan)
    {
        $this->validate($request, [
            'konsultasi' => 'required'
        ],
            [
                'konsultasi.required' => 'Field ini harus diisi'
            ]
        );

        $id = Auth::id();
        $kelas = Auth::user()->kelas;
        $unit = Auth::user()->unit;
        $isi = $request->konsultasi;
        $penerima = $request->penerima;
        $create = Carbon::now();
        $update = Carbon::now();

        $guru = Teacher::all();
        $wali = WaliKelas::where('kelas_diampu', $kelas)->where('unit', $unit)->first();

        DB::insert('insert into konsultasi(student_id, isi, penerima, created_at, updated_at) values ("'.$id.'","'.$isi.'","'.$penerima.'","'.$create.'","'.$update.'")');

        $keluhan = DB::table('konsultasi')
            ->select('*')
            ->latest()
            ->limit(1)
            ->get();

        if ($penerima == 'Guru BK')
        {
            Notification::send($guru, new Konsultasi($keluhan));
        }elseif ($penerima == 'Wali kelas')
        {
            Notification::send($wali, new Konsultasi($keluhan));

        }

        return back()->with('status', 'Keluhan berhasil dikirim!');
    }

}
