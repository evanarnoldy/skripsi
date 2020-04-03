<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use App\Question;
use App\Hasil;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('admin.index')->with(['user' => $user]);
    }

    //siswa
    public function index_student()
    {
        //
        $siswa = Student::all();
        $hasil = DB::table('hasil')
            ->select('student_id','skor', 'kesimpulan', 'bulan', 'created_at')
            ->latest()
            ->limit('1')
            ->get();

        foreach ($hasil as $h){
            $value = $h -> kesimpulan;
        }

        if ($value == null){
            $ket = 'Tidak ada';
        }elseif ($value == 1){
            $ket = 'Rendah';
        }elseif ($value == 2){
            $ket = 'Sedang';
        }else {
            $ket = 'Tinggi';
        }

        return view('admin.data-siswa', compact('siswa', 'hasil', 'ket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
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

        Student::create($request->all());

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
        //
        $hasil = DB::table('hasil')
            ->select('student_id','skor', 'kesimpulan', 'bulan')
            ->orderBy('bulan', 'desc')
            ->limit('1')
            ->get();
        return view('admin.detail-siswa', compact('student','hasil'));
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

        $hasil = DB::table('questions')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->select('questions.id','questions.jenis','questions.kategori','questions.pertanyaan','answers.*')
            ->latest()
            ->limit(count($jmlpertanyaan))
            ->get();
        return view('admin.detail-jawaban', compact('student', 'hasil'));
    }
    public function edit_student(Student $student)
    {
        //
        return view('admin.edit-siswa', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_student(Request $request, Student $student)
    {
        //
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
        $guru = Teacher::all();
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
            'passsword' => 'nullable'
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
            ]);

        Teacher::create($request->all());

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
        //
        Teacher::where('id', $teacher->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'email'=> $request->email
            ]);

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
        $pertanyaan = Question::all();
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
