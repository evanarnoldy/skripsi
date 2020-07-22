<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('students')->check()) {
            return redirect('/siswa/index');
        } else if (Auth::guard('admin')->check()) {
            return redirect('/admin/data-siswa');
        } else if (Auth::guard('teachers')->check()) {
            return redirect('/guru/index');
        } else if (Auth::guard('wali')->check()) {
            return redirect('/wali/index');
        }

        return $next($request);
    }
}
