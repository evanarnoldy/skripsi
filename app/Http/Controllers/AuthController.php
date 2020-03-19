<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login()
    {
        return view('login');
    }

    //siswa

    public function postlogin(Request $request)
    {
        if(Auth::guard('students')->attempt(['email' => $request->email, 'password'=> $request->password])){
            return redirect()->intended('siswa');
        } elseif (Auth::guard('teachers')->attempt(['email' => $request->email, 'password'=> $request->password])){
            return redirect()->intended('admin');
        }

        return redirect('login')->with('status', 'Login gagal');
    }

    public function registersiswa()
    {
        return view('registersiswa');
    }

    public function postregistersiswa(Request $request)
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

    //guru

    public function registerguru()
    {
        return view('registerguru');
    }

    public function postregisterguru(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:teachers|max:255',
            'NIP' => 'required|size:9|unique:teachers',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:teachers',
            'password' => 'required|min:6|confirmed'
        ],
            [
                'nama.required' => 'Nama harus diisi',
                'nama.unique' => 'Nama telah dipakai',
                'NIP.required' => 'NIP harus diisi',
                'NIP.size' => 'NIP harus berisi 9 karakter',
                'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'email;.required' => 'Email harus diisi',
                'email.email' => 'Pastikan format email benar contoh: abcdfg@mail.com',
                'email.unique' => 'Email telah digunakan',
                'password.min' => 'Password minimal 6 karakter',
                'password.required' => 'Password harus diisi',
                'password.confirmed' => 'Password harus sama'
            ]);

        Teacher::create($request->all());

        return redirect('login')->with('status', 'Registrasi berhasil!');
    }

    public function logout()
    {
        if (Auth::guard('students')->check()) {
            Auth::guard('students')->logout();
        } elseif (Auth::guard('teachers')->check()) {
            Auth::guard('teachers')->logout();
        }
        return redirect('login')->with('status', 'Anda telah logout');
    }
}
