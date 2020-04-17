<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use App\Question;
use App\Korelasi;
use App\Hasil;
use App\Answer;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
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

    public function korelasi()
    {
        $siswa = Student::all();

        $data = DB::table('students')
            ->join('hasil', 'students.id', '=', 'hasil.student_id')
            ->join('prestasi', 'students.id', '=', 'prestasi.student_id')
            ->select('students.id', 'hasil.skor', 'prestasi.rata')
            ->get();

        $jmlsiswa = count($siswa);
        $skor = [];
        $rata = [];

        foreach ($data as $d){
            $skor[] = $d->skor;
            $rata[] = $d->rata;
        }

        //variabel x = skor, variabel y = rata
        foreach ($data as $d){
            $x2[] = pow($d->skor,2);
            $y2[] = pow($d->rata, 2);
        }

        foreach ($data as $d){
            $xy[] = $d->skor * $d->rata;
        }

        $jumlahx = array_sum($skor);
        $jumlahy = array_sum($rata);
        $jumlahx2 = array_sum($x2);
        $jumlahy2 = array_sum($y2);
        $jumlahxy = array_sum($xy);
        $njumlahxy = $jumlahxy*$jmlsiswa;
        $kalixy = $jumlahx*$jumlahy;
        $njumlahx2 = $jmlsiswa*$jumlahx2;
        $totkiri = $njumlahx2-pow($jumlahx,2);
        $njumlahy2 = $jmlsiswa*$jumlahy2;
        $totkanan= $njumlahy2-pow($jumlahy,2);
        $kalitotbwh = $totkiri*$totkanan;
        $hsltotbwh = sqrt($kalitotbwh);
        $hslatas = $njumlahxy-$kalixy;
        $korelasi = $hslatas/$hsltotbwh;

        $tes = DB::table('korelasi')
            ->select('df', 'taraf_sig')
            ->where('df', $jmlsiswa)
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
        }elseif ($korelasi < $data){
            $hasil = 'Korelasi antara Kesehatan Mental dan Prestasi Belajar bersifat positif dan tidak signifikan';
        }

        return view('admin.korelasi', compact('hasil', 'korelasi'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    public function edit_profil(Teacher $teacher)
    {
        return view('admin.edit-profil', compact('teacher'));
    }

    public function update_profil(Request $request, Teacher $teacher)
    {

        $request->validate([
            'nama' => 'required|unique:teachers|max:255',
            'NIP' => 'required|size:9|unique:teachers',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:teachers',
            'passsword' => 'nullable'
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

        Teacher::where('id', Auth::user()->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);
        return redirect('profil')->with('status', 'Data berhasil diubah!');
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
        return redirect('profil')->with('status', 'Gambar berhasil diubah!');
    }

    //siswa
    public function index_student()
    {
        //
        $siswa = Student::paginate(10);

        return view('admin.data-siswa', compact('siswa'));
    }

    public function hasil_survey()
    {
        $siswa = DB::table('students')
            ->join('hasil','students.id', '=', 'hasil.student_id')
            ->select('students.*', 'hasil.keterangan')
            ->paginate(10);

        return view('admin.hasil-survey', compact('siswa'));
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
            'NISN' => 'required|size:9|unique:students',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|size:2',
            'email' => 'required|email|unique:students',
            'avatar' => 'required'
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
                'email' => $request->email,
                'avatar' => $filename
            ]);
        };

        return redirect('data-siswa')->with('status', 'Data berhasil ditambahkan!');

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
            'NISN' => 'required|size:9',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|size:2',
            'email' => 'required|email',
            'passsword' => 'nullable',
            'avatar' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'NISN.size' => 'NISN harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'kelas.size' => 'Kelas harus berisi 2 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'avatar.required' => 'Foto harus diisi',
            ]);

        Student::where('id', $student->id)
            ->update([
                'nama'=> $request->nama,
                'NISN'=> $request->NISN,
                'kelas'=> $request->kelas,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save(public_path('uploads/avatar/'.$filename));

            $user = $student;
            $user->avatar = $filename;
            $user->save();
        };

        return redirect('data-siswa')->with('status', 'Data berhasil diubah!');
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
        return redirect('data-siswa')->with('status', 'Data berhasil dihapus!');
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
                'NIP.required' => 'NISN harus diisi',
                'NIP.size' => 'NISN harus berisi 9 karakter',
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

        return redirect('data-guru')->with('status', 'Data berhasil ditambahkan!');

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
            'avatar' => 'required'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NISN harus diisi',
                'NIP.size' => 'NISN harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'emai;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'avatar.required' => 'Foto harus diisi'
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

        return redirect('data-guru')->with('status', 'Data berhasil diubah!');
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

        return redirect('daftar-pertanyaan')->with('status', 'Pertanyaan berhasil ditambahkan!');

    }

    public function destroy_question(Question $question)
    {
        //
        Question::destroy($question->id);
        return redirect('daftar-pertanyaan')->with('status', 'Pertanyaan berhasil dihapus!');
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

        return redirect('daftar-pertanyaan')->with('status', 'Pertanyaan berhasil diubah!');
    }
}
