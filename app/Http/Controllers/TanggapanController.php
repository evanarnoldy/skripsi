<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Keluhan;
use App\Notifications\Tanggapann;
use App\Student;
use App\Tanggapan;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TanggapanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftartanggapan()
    {
        $id = Auth::id();

        $tanggapan = DB::table('konsultasi')
            ->join('tanggapan', 'konsultasi.id', '=', 'tanggapan.konsultasi_id')
            ->select('konsultasi.*', 'tanggapan.*')
            ->where('konsultasi.student_id', $id)
            ->paginate(10);

        return view('siswa.daftar-tanggapan', compact('tanggapan'));
    }

    public function tanggapanwali(Keluhan $keluhan)
    {
        $id = $keluhan->id;
        $data = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.id', $id)
            ->get();

        return view('walikelas.tanggapan', compact('keluhan', 'data'));
    }

    public function send_tanggapan(Request $request, Tanggapan $tanggapan, Keluhan $keluhan)
    {
        $id = $keluhan->student_id;
        $id_keluhan = $keluhan->id;

        $this->validate($request, [
            'tanggapan' => 'required'
        ],
            [
                'tanggapan.required' => 'Field ini harus diisi'
            ]
        );

        $userid = Auth::id();
        $pengirim = Auth::user()->nama;
        $email = Auth::user()->email;
        $isi = $request->tanggapan;
        $create = Carbon::now();
        $update = Carbon::now();

        $user = Student::where('id', $id)->get();

        DB::table('tanggapan')
            ->insert([
                'user_id' => $userid,
                'konsultasi_id' => $id_keluhan,
                'tanggapan' => $isi,
                'pengirim' => $pengirim,
                'email' => $email,
                'created_at' => $create,
                'updated_at' => $update
            ]);

        $tanggapan = DB::table('tanggapan')
            ->select('*')
            ->latest()
            ->limit(1)
            ->get();

        Notification::send($user, new Tanggapann($tanggapan));

        return back()->with('status', 'Tanggapan berhasil dikirim!');
    }

    public function show_tanggapan(Tanggapan $tanggapan)
    {
        $id = $tanggapan->id;
        $id_keluhan = $tanggapan->konsultasi_id;
        $data = DB::table('admins')
            ->join('tanggapan','admins.id', '=', 'tanggapan.user_id')
            ->select('admins.*', 'tanggapan.*')
            ->where('tanggapan.id', $id)
            ->get();

        $keluhan = DB::table('konsultasi')
            ->join('tanggapan', 'konsultasi.id', '=', 'tanggapan.konsultasi_id')
            ->select('tanggapan.tanggapan', 'konsultasi.*')
            ->where('konsultasi.id', $id_keluhan)
            ->latest()
            ->limit(1)
            ->get();

        return view('siswa.show-tanggapan', compact('tanggapan', 'data', 'keluhan'));
    }

    public function tanggapanguru(Keluhan $keluhan)
    {
        $id = $keluhan->id;
        $data = DB::table('students')
            ->join('konsultasi','students.id', '=', 'konsultasi.student_id')
            ->select('students.*', 'konsultasi.*')
            ->where('konsultasi.id', $id)
            ->get();

        return view('guru.tanggapan', compact('keluhan', 'data'));
    }

    public function send_tanggapanguru(Request $request, Tanggapan $tanggapan, Keluhan $keluhan)
    {
        $id = $keluhan->student_id;
        $id_keluhan = $keluhan->id;

        $this->validate($request, [
            'tanggapan' => 'required'
        ],
            [
                'tanggapan.required' => 'Field ini harus diisi'
            ]
        );

        $userid = Auth::id();
        $pengirim = Auth::user()->nama;
        $email = Auth::user()->email;
        $isi = $request->tanggapan;
        $create = Carbon::now();
        $update = Carbon::now();

        $user = Student::where('id', $id)->get();

        DB::table('tanggapan')
            ->insert([
                'user_id' => $userid,
                'konsultasi_id' => $id_keluhan,
                'tanggapan' => $isi,
                'pengirim' => $pengirim,
                'email' => $email,
                'created_at' => $create,
                'updated_at' => $update
            ]);

        $tanggapan = DB::table('tanggapan')
            ->select('*')
            ->latest()
            ->limit(1)
            ->get();

        Notification::send($user, new Tanggapann($tanggapan));

        return back()->with('status', 'Tanggapan berhasil dikirim!');
    }

    public function show_tanggapanguru(Tanggapan $tanggapan)
    {
        $id = $tanggapan->id;
        $data = DB::table('teachers')
            ->join('tanggapan','teachers.id', '=', 'tanggapan.user_id')
            ->select('teachers.*', 'tanggapan.*')
            ->where('tanggapan.id', $id)
            ->get();

        return view('siswa.show-tanggapan', compact('tanggapan', 'data'));
    }

}
