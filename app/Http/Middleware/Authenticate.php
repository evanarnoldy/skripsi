<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
//        if (! $request->expectsJson()) {
//            return route('login');
//        }

        if (Auth::guard('students')->check()) {
            return redirect('/siswa/index');
        } else if (Auth::guard('admin')->check()) {
            return redirect('/admin/data-siswa');
        } else if (Auth::guard('teachers')->check()) {
            return redirect('/guru/index');
        } else if (Auth::guard('wali')->check()) {
            return redirect('/wali/index');
        }
    }
}
