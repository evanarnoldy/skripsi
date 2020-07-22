<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Student;
use App\Teacher;
use App\Question;
use App\Korelasi;
use App\Hasil;
use App\WaliKelas;
use App\Notifications\Konsultasi;
use Illuminate\Support\Facades\Hash;
use App\Answer;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

        $bulan1 = date('m');
        $bulan1 = $bulan[$bulan1];

        $tinggi = DB::table('hasil')
            ->where('kesimpulan', 3)
            ->get();

        $sedang = DB::table('hasil')
            ->where('kesimpulan', 2)
            ->get();

        $rendah = DB::table('hasil')
            ->where('kesimpulan', 1)
            ->get();

        $siswa = Hasil::all();

        $t = count($tinggi);
        $s = count($sedang);
        $r = count($rendah);
        $jmlsiswa = count($siswa);

        return view('admin.index', compact('bulan1', 't','s','r','jmlsiswa'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    public function edit_profil(Admin $admin)
    {
        return view('admin.edit-profil', compact('admin'));
    }

    public function update_profil(Request $request, Admin $admin)
    {

        $request->validate([
            'nama' => 'required|unique:teachers|max:255',
            'NIP' => 'required|size:9|unique:teachers',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:teachers',
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
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
            ]);

        Admin::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);
        return redirect('admin/profil')->with('status', 'Data berhasil diubah!');
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
        return redirect('admin/profil')->with('status', 'Gambar berhasil diubah!');
    }

    public function psswrd()
    {
        return view('admin.ganti-password');
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
    public function index_student()
    {
        //
        $siswa = Student::paginate(10);
        $kelas = DB::table('students')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('students')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        return view('admin.data-siswa', compact('siswa', 'kelas', 'unit'));
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

        return view('admin.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit'));
    }

    public function filterbulan(Request $request)
    {
        $getbulan = $request->bulan;
        $gettahun = $request->tahun;
        $getkelas = $request->kelas;
        $getunit = $request->unit;

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

        if ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas'){
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->paginate(10);

        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->paginate(10);

        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->where('hasil.tahun', $gettahun)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.unit', $getunit)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        } elseif ($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun' && $getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.tahun', $gettahun)
                ->where('hasil.unit', $getunit)
                ->paginate(10);
        } elseif ($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun' && $getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->join('hasil', 'students.id', '=', 'hasil.student_id')
                ->select('students.nama','students.NISN', 'hasil.*')
                ->where('hasil.bulan', $getbulan)
                ->where('hasil.kelas', $getkelas)
                ->paginate(10);
        }

            return view('admin.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit'));
    }

    public function cari(Request $request)
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

        $cari = $request->cari;

        $siswa = DB::table('students')
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->select('students.nama','students.NISN', 'hasil.*')
            ->where('students.nama','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('admin.hasil-survey', compact('siswa', 'bulan', 'tahun', 'kelas', 'unit'));
    }

    public function filterdatasiswa(Request $request)
    {
        $getkelas = $request->kelas;
        $getunit = $request->unit;

        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        if ($getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('kelas', $getkelas)
                ->where('unit', $getunit)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas'){
            $siswa = DB::table('students')
                ->paginate(10);

        } elseif ($getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('kelas', $getkelas)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('unit', $getunit)
                ->paginate(10);
        }

        return view('admin.data-siswa', compact('siswa', 'kelas', 'unit'));
    }

    public function caridatasiswa(Request $request)
    {
        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $cari = $request->cari;

        $siswa = DB::table('students')
            ->where('nama','LIKE','%'.$cari.'%')
            ->orWhere('NISN','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('admin.data-siswa', compact('siswa','kelas', 'unit'));
    }

    public function caridataguru(Request $request)
    {
        $cari = $request->cari;

        $guru = DB::table('teachers')
            ->where('nama','LIKE','%'.$cari.'%')
            ->orWhere('NIP','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('admin.data-guru', compact('guru'));
    }

    public function filterprestasi(Request $request)
    {
        $getkelas = $request->kelas;
        $getunit = $request->unit;

        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        if ($getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('kelas', $getkelas)
                ->where('unit', $getunit)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas'){
            $siswa = DB::table('students')
                ->paginate(10);

        } elseif ($getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('kelas', $getkelas)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $siswa = DB::table('students')
                ->where('unit', $getunit)
                ->paginate(10);
        }

        return view('admin.daftar-prestasi', compact('siswa', 'kelas', 'unit'));
    }

    public function cariprestasi(Request $request)
    {
        $kelas = DB::table('hasil')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $cari = $request->cari;

        $siswa = DB::table('students')
            ->where('nama','LIKE','%'.$cari.'%')
            ->orWhere('NISN','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('admin.daftar-prestasi', compact('siswa','kelas', 'unit'));
    }

    public function filterdatawali(Request $request)
    {
        $getkelas = $request->kelas;
        $getunit = $request->unit;

        $kelas = DB::table('wali_kelas')
            ->select('kelas_diampu')
            ->groupBy('kelas_diampu')
            ->get();

        $unit = DB::table('wali_kelas')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        if ($getkelas != 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $wali = DB::table('wali_kelas')
                ->where('kelas_diampu', $getkelas)
                ->where('unit', $getunit)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit == 'Pilih unit kelas'){
            $wali = DB::table('wali_kelas')
                ->paginate(10);

        } elseif ($getkelas != 'Pilih kelas' && $getunit == 'Pilih unit kelas') {
            $wali = DB::table('wali_kelas')
                ->where('kelas_diampu', $getkelas)
                ->paginate(10);

        } elseif ($getkelas == 'Pilih kelas' && $getunit != 'Pilih unit kelas') {
            $wali = DB::table('wali_kelas')
                ->where('unit', $getunit)
                ->paginate(10);
        }

        return view('admin.data-wali', compact('wali', 'kelas', 'unit'));
    }

    public function caridatawali(Request $request)
    {
        $kelas = DB::table('wali_kelas')
            ->select('kelas_diampu')
            ->groupBy('kelas_diampu')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $cari = $request->cari;

        $wali = DB::table('wali_kelas')
            ->where('nama','LIKE','%'.$cari.'%')
            ->paginate(10);

        return view('admin.data-wali', compact('wali','kelas', 'unit'));
    }

    public function create_student()
    {
        //
        return view('admin.tambah-siswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_student(Request $request)
    {

        $request->validate([
            'nama' => 'required|unique:students|max:255',
            'NISN' => 'required|size:6|unique:students',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
            'unit' => 'required',
            'avatar' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NISN.required' => 'NISN harus diisi',
                'NISN.size' => 'NISN harus berisi 6 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'unit.required' => 'Unit kelas harus diisi',
                'avatar.required' => 'Foto harus diisi'
            ]);

        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/' . $filename));

            Student::create([
                'nama' => $request->nama,
                'NISN' => $request->NISN,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'kelas' => $request->kelas,
                'unit' => $request->unit,
                'avatar' => $filename
            ]);
        };

        return redirect('admin/data-siswa')->with('status', 'Data berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_student(Student $student)
    {
        return view('admin.detail-siswa', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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

        return view('admin.detail-jawaban', compact('student', 'hasil'));
    }
    public function edit_student(Student $student)
    {
        return view('admin.edit-siswa', compact('student'));
    }

    public function update_student(Request $request, Student $student)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'NISN' => 'required|size:6',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
            'unit' => 'required',
            'passsword' => 'nullable',
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'NISN.size' => 'NISN harus berisi 6 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'unit.required' => 'Unit kelas harus diisi',
            ]);

        Student::where('id', $student->id)
            ->update([
                'nama'=> $request->nama,
                'NISN'=> $request->NISN,
                'kelas'=> $request->kelas,
                'unit'=> $request->unit,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            $user = $student;
            $user->avatar = $filename;
            $user->save();
        };

        return redirect('admin/data-siswa')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Student
     */
    public function destroy_student(Student $student)
    {
        //
        Student::destroy($student->id);
        return redirect('admin/data-siswa')->with('status', 'Data berhasil dihapus!');
    }

    public function index_teacher()
    {
        //
        $guru = Teacher::paginate(10);
        return view('admin.data-guru', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_teacher()
    {
        //
        return view('admin.tambah-guru');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_teacher(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required|unique:teachers|max:255',
            'NIP' => 'required|size:9|unique:teachers',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:teachers',
            'passsword' => 'nullable',
            'avatar' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
                'avatar.required' => 'Foto harus diisi'
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            Teacher::create([
                'nama' => $request->nama,
                'NIP' => $request->NIP,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'avatar' => $filename
            ]);
        };

        return redirect('admin/data-guru')->with('status', 'Data berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_teacher(Teacher $teacher)
    {
        //
        return view('admin.detail-guru', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_teacher(Teacher $teacher)
    {
        //
        return view('admin.edit-guru', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_teacher(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'NIP' => 'required|size:9',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'passsword' => 'nullable',
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
            ]);

        Teacher::where('id', $teacher->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            $user = $teacher;
            $user->avatar = $filename;
            $user->save();
        };

        return redirect('admin/data-guru')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Student
     */
    public function destroy_teacher(Teacher $teacher)
    {
        //
        Teacher::destroy($teacher->id);
        return redirect('data-guru')->with('status', 'Data berhasil dihapus!');
    }

    //walikelas
    public function index_wali()
    {
        $kelas = DB::table('wali_kelas')
            ->select('kelas_diampu')
            ->groupBy('kelas_diampu')
            ->get();

        $unit = DB::table('hasil')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        $wali = WaliKelas::paginate(10);
        return view('admin.data-wali', compact('wali', 'kelas', 'unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_wali()
    {
        //
        return view('admin.tambah-wali');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_wali(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required|unique:teachers|max:255',
            'NIP' => 'required|size:9|unique:teachers',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas_diampu' => 'required',
            'unit' => 'required',
            'email' => 'required|email|unique:teachers',
            'passsword' => 'nullable',
            'avatar' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas_diampu.required' => 'Kelas harus diisi',
                'unit.required' => 'Unit kelas harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
                'avatar.required' => 'Foto harus diisi'
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            WaliKelas::create([
                'nama' => $request->nama,
                'NIP' => $request->NIP,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'kelas_diampu' => $request->kelas_diampu,
                'unit' => $request->unit,
                'email' => $request->email,
                'avatar' => $filename
            ]);
        };

        return redirect('admin/data-wali')->with('status', 'Data berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_wali(WaliKelas $waliKelas)
    {
        //
        return view('admin.detail-wali', compact('waliKelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_wali(WaliKelas $waliKelas)
    {
        //
        return view('admin.edit-wali', compact('waliKelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_wali(Request $request, WaliKelas $waliKelas)
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
            'passsword' => 'nullable',
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas_diampu.required' => 'Kelas harus diisi',
                'unit.required' => 'Unit harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
            ]);

        WaliKelas::where('id', $waliKelas->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'kelas_diampu' => $request->kelas_diampu,
                'unit' => $request->unit,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            $user = $waliKelas;
            $user->avatar = $filename;
            $user->save();
        };

        return redirect('admin/data-wali')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Student
     */
    public function destroy_wali(WaliKelas $waliKelas)
    {
        //
        WaliKelas::destroy($waliKelas->id);
        return redirect('data-wali')->with('status', 'Data berhasil dihapus!');
    }

    //pertanyaan
    public function list_pertanyaan()
    {
        $pertanyaan = Question::paginate(10);
        return view('admin.daftar-pertanyaan', compact('pertanyaan'));
    }

    public function create_question()
    {
        //
        return view('admin.tambah-pertanyaan');
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

        return redirect('admin/daftar-pertanyaan')->with('status', 'Pertanyaan berhasil ditambahkan!');

    }

    public function destroy_question(Question $question)
    {
        //
        Question::destroy($question->id);
        return redirect('admin/daftar-pertanyaan')->with('status', 'Pertanyaan berhasil dihapus!');
    }

    public function edit_question(Question $question)
    {
        //
        return view('admin.edit-pertanyaan', compact('question'));
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

        return redirect('admin/daftar-pertanyaan')->with('status', 'Pertanyaan berhasil diubah!');
    }

    public function daftar_prestasi()
    {
        $siswa = Student::paginate(10);
        $kelas = DB::table('students')
            ->select('kelas')
            ->groupBy('kelas')
            ->get();

        $unit = DB::table('students')
            ->select('unit')
            ->groupBy('unit')
            ->get();

        return view('admin.daftar-prestasi', compact('siswa', 'kelas', 'unit'));
    }
}
