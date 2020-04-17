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

//dashboard guru
Route::get('/data-siswa', 'AdminController@index_student')->name('data-siswa')->middleware('auth:teachers');
Route::get('/detail-siswa/{student}', 'AdminController@show_student')->middleware('auth:teachers');
Route::get('/tambah-siswa/', 'AdminController@create_student')->middleware('auth:teachers');
Route::post('/data-siswa', 'AdminController@store_student')->middleware('auth:teachers');
Route::delete('/data-siswa/{student}', 'AdminController@destroy_student')->middleware('auth:teachers');
Route::get('/data-siswa/{student}/edit-siswa', 'AdminController@edit_student')->middleware('auth:teachers');
Route::patch('/data-siswa/{student}', 'AdminController@update_student')->middleware('auth:teachers');
Route::get('/detail-jawaban/{student}', 'AdminController@show_answer')->middleware('auth:teachers');
Route::get('/data-guru', 'AdminController@index_teacher')->name('data-guru')->middleware('auth:teachers');
Route::get('/detail-guru/{teacher}', 'AdminController@show_teacher')->middleware('auth:teachers');
Route::get('/tambah-guru/', 'AdminController@create_teacher')->middleware('auth:teachers');
Route::post('/data-guru', 'AdminController@store_teacher')->middleware('auth:teachers');
Route::delete('/data-guru/{teacher}', 'AdminController@destroy_teacher')->middleware('auth:teachers');
Route::get('/data-guru/{teacher}/edit-guru', 'AdminController@edit_teacher')->middleware('auth:teachers');
Route::patch('/data-guru/{teacher}', 'AdminController@update_teacher')->middleware('auth:teachers');
Route::get('/hasil-survey', 'AdminController@hasil_survey')->name('survey')->middleware('auth:teachers');
Route::get('/korelasi', 'AdminController@korelasi')->name('korelasi')->middleware('auth:teachers');
Route::get('/list-keluhan', 'KeluhanController@list_keluhan')->name('daftar.keluhan')->middleware('auth:teachers');
Route::get('/detail-keluhan/{keluhan}', 'KeluhanController@show_keluhan')->name('detail.keluhan')->middleware('auth:teachers');
Route::get('/profil', 'AdminController@profil')->name('profil')->middleware('auth:teachers');
Route::get('/profil/{teacher}/edit-profil', 'AdminController@edit_profil')->middleware('auth:teachers');
Route::patch('/profil/{teacher}', 'AdminController@update_profil')->name('profil.update')->middleware('auth:teachers');
Route::post('/profil', 'AdminController@update_avatar')->name('update.avatar')->middleware('auth:teachers');
Route::get('/markAsRead', function (){
});

//pertanyaan
Route::get('/daftar-pertanyaan', 'AdminController@list_pertanyaan')->name('daftar-pertanyaan')->middleware('auth:teachers');
Route::get('/tambah-pertanyaan', 'AdminController@create_question')->middleware('auth:teachers');
Route::post('/daftar-pertanyaan', 'AdminController@store_question')->middleware('auth:teachers');
Route::delete('/daftar-pertanyaan/{question}', 'AdminController@destroy_question')->middleware('auth:teachers');
Route::get('/daftar-pertanyaan/{question}/edit-pertanyaan', 'AdminController@edit_question')->middleware('auth:teachers');
Route::patch('/daftar-pertanyaan/{question}', 'AdminController@update_question')->middleware('auth:teachers');

//dashboard siswa
Route::get('/konsultasi', 'KeluhanController@konsultasi')->name('konsultasi')->middleware('auth:students');
Route::post('/konsultasi', 'KeluhanController@send_konsultasi')->middleware('auth:students');
Route::get('/profil-siswa', 'SiswaController@profil')->name('profil-siswa')->middleware('auth:students');
Route::get('/profil-siswa/{student}/edit-profil', 'SiswaController@edit_profil')->middleware('auth:students');
Route::patch('/profil-siswa/{student}', 'SiswaController@update_profil')->name('profil.update')->middleware('auth:students');
Route::post('/profil-siswa', 'SiswaController@update_avatar')->name('update.avatar')->middleware('auth:students');


//kuesioner
Route::get('/pengisian-kuesioner', 'SiswaController@pertanyaan')->name('kuesioner')->middleware('auth:students');
Route::post('/store-kuesioner', 'SiswaController@store_jawaban')->middleware('auth:students');
Route::get('/hasil-kuesioner', 'SiswaController@hasil')->name('hasil')->middleware('auth:students');
Route::get('/form-prestasi', 'SiswaController@create_prestasi')->name('prestasi')->middleware('auth:students');
Route::post('/store-prestasi', 'SiswaController@store_prestasi')->middleware('auth:students');
