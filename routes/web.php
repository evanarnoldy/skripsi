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
Route::get('/data-siswa', 'AdminController@index_student')->name('data-siswa')->middleware('auth:teachers');
Route::get('/detail-siswa/{student}', 'AdminController@show_student')->middleware('auth:teachers');
Route::get('/tambah-siswa/', 'AdminController@create_student')->middleware('auth:teachers');
Route::post('/data-siswa', 'AdminController@store_student')->middleware('auth:teachers');
Route::delete('/data-siswa/{student}', 'AdminController@destroy_student')->middleware('auth:teachers');
Route::get('/data-siswa/{student}/edit-siswa', 'AdminController@edit_student')->middleware('auth:teachers');
Route::patch('/data-siswa/{student}', 'AdminController@update_student')->middleware('auth:teachers');

//guru
Route::get('/data-guru', 'AdminController@index_teacher')->name('data-guru')->middleware('auth:teachers');
Route::get('/detail-guru/{teacher}', 'AdminController@show_teacher')->middleware('auth:teachers');
Route::get('/tambah-guru/', 'AdminController@create_teacher')->middleware('auth:teachers');
Route::post('/data-guru', 'AdminController@store_teacher')->middleware('auth:teachers');
Route::delete('/data-guru/{teacher}', 'AdminController@destroy_teacher')->middleware('auth:teachers');
Route::get('/data-guru/{teacher}/edit-guru', 'AdminController@edit_teacher')->middleware('auth:teachers');
Route::patch('/data-guru/{teacher}', 'AdminController@update_teacher')->middleware('auth:teachers');

//pertanyaan
Route::get('/daftar-pertanyaan', 'AdminController@list_pertanyaan')->name('daftar-pertanyaan')->middleware('auth:teachers');
Route::get('/tambah-pertanyaan', 'AdminController@create_question')->middleware('auth:teachers');
Route::post('/daftar-pertanyaan', 'AdminController@store_question')->middleware('auth:teachers');
Route::delete('/daftar-pertanyaan/{question}', 'AdminController@destroy_question')->middleware('auth:teachers');
Route::get('/daftar-pertanyaan/{question}/edit-pertanyaan', 'AdminController@edit_question')->middleware('auth:teachers');
Route::patch('/daftar-pertanyaan/{question}', 'AdminController@update_question')->middleware('auth:teachers');

//kuesioner
Route::get('/pengisian-kuesioner', 'SiswaController@pertanyaan')->name('kuesioner')->middleware('auth:students');
