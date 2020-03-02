<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Student;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $siswa = Student::all();
        return view('admin.data-siswa', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required|unique:students|max:255',
            'NISN' => 'required|size:9|unique:students',
            'kelas' => 'required|size:2',
            'email' => 'required|email'
        ],
        [
            'nama.required' => 'Nama harus diisi',
            'nama.unique' => 'Nama telah dipakai',
            'NISN.required' => 'NISN harus diisi',
            'NISN.size' => 'NISN harus berisi 9 karakter',
            'kelas.required' => 'Kelas harus diisi',
            'kelas.size' => 'Kelas harus berisi 2 karakter',
            'emai;.required' => 'Email harus diisi',
            'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com'
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
    public function show(Student $student)
    {
        //
        return view('admin.detail-siswa', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
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
    public function update(Request $request, Student $student)
    {
        //
        Student::where('id', $student->id)
            ->update([
                'nama'=> $request->nama,
                'NISN'=> $request->nama,
                'kelas'=> $request->kelas,
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
    public function destroy(Student $student)
    {
        //
        Student::destroy($student->id);
        return redirect('data-siswa')->with('status', 'Data berhasil dihapus!');
    }
}
