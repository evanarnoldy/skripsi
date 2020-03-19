<?php

namespace App\Http\Controllers;

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
}
