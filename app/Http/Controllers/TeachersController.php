<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Teacher;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function create()
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
    public function store(Request $request)
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
    public function show(Teacher $teacher)
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
    public function edit(Teacher $teacher)
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
    public function update(Request $request, Teacher $teacher)
    {
        //
        Teacher::where('id', $teacher->id)
            ->update([
                'nama'=> $request->nama,
                'NIP'=> $request->NIP,
                'alamat'=> $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggl_lahir,
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
    public function destroy(Teacher $teacher)
    {
        //
        Teacher::destroy($teacher->id);
        return redirect('data-guru')->with('status', 'Data berhasil dihapus!');
    }
}
