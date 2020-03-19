<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/admin', 'AdminController@index')->name('admin')->middleware('auth:teachers');

Route::get('/siswa', 'SiswaController@index')->name('siswa')->middleware('auth:students');

//auth siswa
Route::get('/login', 'AuthController@login')->middleware('guest');
Route::post('/loginn', 'AuthController@postlogin')->name('login');
Route::get('/register-siswa', 'AuthController@registersiswa')->name('registersiswa');
Route::post('/register-siswa', 'AuthController@postregistersiswa')->name('postregistersiswa');

//auth guru
Route::get('/register-guru', 'AuthController@registerguru')->name('registerguru');
Route::post('/register-guru', 'AuthController@postregisterguru')->name('postregisterguru');
Route::get('/logout', 'AuthController@logout')->name('logout');

//siswa
Route::get('/data-siswa', 'StudentsController@index')->name('data-siswa')->middleware('auth:teachers');
Route::get('/detail-siswa/{student}', 'StudentsController@show')->middleware('auth:teachers');
Route::get('/tambah-siswa/', 'StudentsController@create')->middleware('auth:teachers');
Route::post('/data-siswa', 'StudentsController@store')->middleware('auth:teachers');
Route::delete('/data-siswa/{student}', 'StudentsController@destroy')->middleware('auth:teachers');
Route::get('/data-siswa/{student}/edit-siswa', 'StudentsController@edit')->middleware('auth:teachers');
Route::patch('/data-siswa/{student}', 'StudentsController@update')->middleware('auth:teachers');

//guru
Route::get('/data-guru', 'TeachersController@index')->name('data-guru')->middleware('auth:teachers');
Route::get('/detail-guru/{teacher}', 'TeachersController@show')->middleware('auth:teachers');
Route::get('/tambah-guru/', 'TeachersController@create')->middleware('auth:teachers');
Route::post('/data-guru', 'TeachersController@store')->middleware('auth:teachers');
Route::delete('/data-guru/{teacher}', 'TeachersController@destroy')->middleware('auth:teachers');
Route::get('/data-guru/{teacher}/edit-guru', 'TeachersController@edit')->middleware('auth:teachers');
Route::patch('/data-guru/{teacher}', 'TeachersController@update')->middleware('auth:teachers');
