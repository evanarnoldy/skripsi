<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function pertanyaan()
    {
        $pertanyaan = Question::all();
        return view('siswa.pengisian-kuesioner', compact('pertanyaan'));
    }
}
