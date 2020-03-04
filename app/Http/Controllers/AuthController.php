<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postlogin(Request $request)
    {
        if(!\Auth::attempt(['NISN' => $request->NISN, 'password'=> $request->password])){
            return redirect()->back();
        }

        return redirect('admin');
    }

    public function registersiswa()
    {
        return view('registersiswa');
    }

    public function postregister(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:students|max:255',
            'NISN' => 'required|size:9|unique:students',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|size:2',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6|confirmed'
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
                'email;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
                'password.min' => 'Password minimal 6 karakter',
                'password.required' => 'Password harus diisi',
                'password.confirmed' => 'Password harus sama'
            ]);

        Student::create($request->all());

        return redirect('login')->with('status', 'Registrasi berhasil!');
    }

    public function logout()
    {
        \Auth::logout();

        return redirect('login')->with('status', 'Anda telah logout');
    }
}
