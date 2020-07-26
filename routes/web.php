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


//auth
Route::get('/login', 'AuthController@login')->middleware('guest')->name('login');
Route::post('/login', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::get('/register', function () {
    return view('register');
});

//auth siswa
Route::get('/register-siswa', 'AuthController@registersiswa')->name('registersiswa');
Route::post('/register-siswa', 'AuthController@postregistersiswa')->name('postregistersiswa');

//auth guru
Route::get('/register-guru', 'AuthController@registerguru')->name('registerguru');
Route::post('/register-guru', 'AuthController@postregisterguru')->name('postregisterguru');

//auth walikelas
Route::get('/register-wali', 'AuthController@registerwali')->name('registerwali');
Route::post('/register-wali', 'AuthController@postregisterwali')->name('postregisterwali');

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/index', 'AdminController@index')->name('admin');
    Route::get('/data-siswa', 'AdminController@index_student')->name('data-siswa');
    Route::get('/detail-siswa/{student}', 'AdminController@show_student');
    Route::get('/tambah-siswa/', 'AdminController@create_student');
    Route::post('/data-siswa', 'AdminController@store_student');
    Route::delete('/data-siswa/{student}', 'AdminController@destroy_student');
    Route::get('/data-siswa/{student}/edit-siswa', 'AdminController@edit_student');
    Route::patch('/data-siswa/{student}', 'AdminController@update_student');
    Route::get('/detail-jawaban/{student}', 'AdminController@show_answer');
    Route::get('/data-guru', 'AdminController@index_teacher')->name('data-guru');
    Route::get('/detail-guru/{teacher}', 'AdminController@show_teacher');
    Route::get('/tambah-guru/', 'AdminController@create_teacher');
    Route::post('/data-guru', 'AdminController@store_teacher');
    Route::delete('/data-guru/{teacher}', 'AdminController@destroy_teacher');
    Route::get('/data-guru/{teacher}/edit-guru', 'AdminController@edit_teacher');
    Route::patch('/data-guru/{teacher}', 'AdminController@update_teacher');
    Route::get('/data-wali', 'AdminController@index_wali')->name('data-wali');
    Route::get('/detail-wali/{waliKelas}', 'AdminController@show_wali');
    Route::get('/tambah-wali/', 'AdminController@create_wali');
    Route::post('/data-wali', 'AdminController@store_wali');
    Route::delete('/data-wali/{waliKelas}', 'AdminController@destroy_wali');
    Route::get('/data-wali/{waliKelas}/edit-wali', 'AdminController@edit_wali');
    Route::patch('/data-wali/{waliKelas}', 'AdminController@update_wali');
    Route::get('/hasil-survey', 'AdminController@hasil_survey')->name('survey');
    Route::get('/profil', 'AdminController@profil')->name('profil.admin');
    Route::get('/profil/{admin}/edit-profil', 'AdminController@edit_profil');
    Route::patch('/profil/{admin}', 'AdminController@update_profil')->name('profil.update');
    Route::post('/profil', 'AdminController@update_avatar')->name('update.avatar');
    Route::get('/password', 'AdminController@psswrd')->name('psswrd.admin');
    Route::post('/psswrd', 'AdminController@ganti_psswrd')->name('psswrd.update');
    Route::get('/daftar-pertanyaan', 'AdminController@list_pertanyaan')->name('daftar-pertanyaan');
    Route::get('/tambah-pertanyaan', 'AdminController@create_question');
    Route::post('/daftar-pertanyaan', 'AdminController@store_question');
    Route::delete('/daftar-pertanyaan/{question}', 'AdminController@destroy_question');
    Route::get('/daftar-pertanyaan/{question}/edit-pertanyaan', 'AdminController@edit_question');
    Route::patch('/daftar-pertanyaan/{question}', 'AdminController@update_question');
    Route::get('/form-prestasi/', 'AdminController@daftar_prestasi')->name('daftar.prestasi');
    Route::get('/form-prestasi/{student}/form', 'SiswaController@create_prestasi')->name('prestasi');
    Route::post('/store-prestasi/{student}', 'SiswaController@store_prestasi');
    Route::get('/filter-bulan', 'AdminController@filterbulan');
    Route::get('/cari', 'AdminController@cari');
    Route::get('/filter-datasiswa', 'AdminController@filterdatasiswa');
    Route::get('/cari-datasiswa', 'AdminController@caridatasiswa');
    Route::get('/cari-dataguru', 'AdminController@caridataguru');
    Route::get('/filter-prestasi', 'AdminController@filterprestasi');
    Route::get('/cari-prestasi', 'AdminController@cariprestasi');
    Route::get('/filter-wali', 'AdminController@filterdatawali');
    Route::get('/cari-wali', 'AdminController@caridatawali');
});

Route::get('/markAsRead', function (){
});

//dashboard guru
Route::prefix('guru')->middleware(['auth:teachers'])->group(function () {
    Route::get('/index', 'GuruController@index')->name('guru');
    Route::get('/detail-jawaban-guru/{student}', 'GuruController@show_answer');
    Route::get('/hasil-survey-guru', 'GuruController@hasil_survey')->name('survey-guru');
    Route::get('/korelasi', 'GuruController@korelasi')->name('korelasi');
    Route::get('/korelasi-guru', 'GuruController@hasilkorelasi')->name('korelasi-guru');
    Route::get('/hitung-korelasi-guru', 'GuruController@hitung_korelasi')->name('hitung-korelasi-guru');
    Route::get('/list-keluhan-guru', 'KeluhanController@list_keluhan_guru')->name('daftar.keluhanguru');
    Route::get('/detail-keluhan-guru/{keluhan}', 'KeluhanController@show_keluhan_guru')->name('detail.keluhanguru');
    Route::get('/profil-guru', 'GuruController@profil')->name('profil-guru');
    Route::get('/profil-guru/{teacher}/edit-profil', 'GuruController@edit_profil');
    Route::patch('/profil-guru/{teacher}', 'GuruController@update_profil')->name('profil-guru.update');
    Route::post('/profil-guru', 'GuruController@update_avatar')->name('update-guru.avatar');
    Route::get('/password-guru', 'GuruController@psswrd')->name('psswrd-guru');
    Route::post('/ganti-password-guru', 'GuruController@ganti_psswrd')->name('psswrd-guru.update');
    Route::get('/daftar-pertanyaan-guru', 'GuruController@list_pertanyaan')->name('daftar-pertanyaan-guru');
    Route::get('/tambah-pertanyaan-guru', 'GuruController@create_question');
    Route::post('/daftar-pertanyaan-guru', 'GuruController@store_question');
    Route::delete('/daftar-pertanyaan-guru/{question}', 'GuruController@destroy_question');
    Route::get('/daftar-pertanyaan-guru/{question}/edit-pertanyaan', 'GuruController@edit_question');
    Route::patch('/daftar-pertanyaan-guru/{question}', 'GuruController@update_question');
    Route::get('/hasil-prestasi-guru', 'GuruController@hasil_prestasi')->name('guru.prestasi');
    Route::get('/filter-surveyguru', 'GuruController@filtersurveyguru');
    Route::get('/cari-surveyguru', 'GuruController@carisurveyguru');
    Route::get('/filter-prestasiguru', 'GuruController@filterprestasiguru');
    Route::get('/cari-prestasiguru', 'GuruController@cariprestasiguru');
    Route::get('/filter-korelasiguru', 'GuruController@filterkorelasiguru');
    Route::get('/tanggapanguru/{keluhan}', 'TanggapanController@tanggapanguru')->name('tanggapan.guru');
    Route::post('/send-tanggapanguru/{keluhan}', 'TanggapanController@send_tanggapanguru');
    Route::get('/filter-indexguru', 'GuruController@filterindexguru');

});

//dashboard siswa
Route::prefix('siswa')->middleware(['auth:students'])->group(function () {
    Route::get('/index', 'SiswaController@index')->name('siswa.index');
    Route::get('/konsultasi', 'KeluhanController@konsultasi')->name('konsultasi');
    Route::post('/konsultasi', 'KeluhanController@send_konsultasi');
    Route::get('/profil-siswa', 'SiswaController@profil')->name('profil-siswa');
    Route::get('/profil-siswa/{student}/edit-profil', 'SiswaController@edit_profil');
    Route::patch('/profil-siswa/{student}', 'SiswaController@update_profil')->name('profil.update');
    Route::post('/profil-siswa', 'SiswaController@update_avatar')->name('update.avatar');
    Route::get('/password-siswa', 'SiswaController@psswrd')->name('psswrd.siswa');
    Route::post('/password-update-siswa', 'SiswaController@ganti_psswrd')->name('psswrd.update.siswa');
    Route::get('/pengisian-kuesioner', 'SiswaController@pertanyaan')->name('kuesioner');
    Route::post('/store-kuesioner', 'SiswaController@store_jawaban');
    Route::get('/hasil-kuesioner', 'SiswaController@daftarhasil')->name('hasil');
    Route::get('/detail-hasil/{hasil}', 'SiswaController@showhasil');
    Route::get('/detail-tanggapan/{tanggapan}', 'TanggapanController@show_tanggapan')->name('detail.tanggapan');
    Route::get('/daftar-tanggapan', 'TanggapanController@daftartanggapan')->name('daftar.tanggapan');
    Route::get('/hasil-prestasi', 'SiswaController@hasil_prestasi')->name('prestasi');
});

//dashboard wali
Route::prefix('wali')->middleware(['auth:wali'])->group(function () {
    Route::get('/index', 'WaliController@index')->name('wali.index');
    Route::get('/indexksh', 'WaliController@indexksh')->name('wali.indexksh');
    Route::get('/filter-indexksh', 'WaliController@filter_indexksh')->name('wali.filter-indexksh');
    Route::get('/indexpb', 'WaliController@indexpb')->name('wali.indexpb');
    Route::get('/filter-indexpb', 'WaliController@filter_indexpb')->name('wali.filter-indexpb');
    Route::get('/indexkor', 'WaliController@indexkor')->name('wali.indexkor');
    Route::get('/filter-indexkor', 'WaliController@filter_indexkor')->name('wali.filter-indexkor');
    Route::get('/profil-wali', 'WaliController@profil')->name('profil.wali');
    Route::get('/profil-wali/{waliKelas}/edit-profil', 'WaliController@edit_profil');
    Route::patch('/profil-wali/{waliKelas}', 'WaliController@update_profil')->name('profil.update');
    Route::post('/profil-wali', 'WaliController@update_avatar')->name('update-wali.avatar');
    Route::get('/password-wali', 'WaliController@psswrd')->name('psswrd.wali');
    Route::post('/password-update-wali', 'WaliController@ganti_psswrd')->name('psswrd.update.wali');
    Route::get('/detail-jawaban-wali/{student}', 'WaliController@show_answer');
    Route::get('/hasil-survey-wali', 'WaliController@hasil_survey')->name('survey-wali');
    Route::get('/hasil-prestasi-wali', 'WaliController@hasil_prestasi')->name('wali.prestasi');
    Route::get('/filter-surveywali', 'WaliController@filtersurveywali');
    Route::get('/cari-surveywali', 'WaliController@carisurveywali');
    Route::get('/filter-prestasiwali', 'WaliController@filterprestasiwali');
    Route::get('/cari-prestasiwali', 'WaliController@cariprestasiwali');
    Route::get('/list-keluhan', 'KeluhanController@list_keluhan')->name('daftar.keluhan');
    Route::get('/detail-keluhan/{keluhan}', 'KeluhanController@show_keluhan')->name('detail.keluhan');
    Route::get('/tanggapanwali/{keluhan}', 'TanggapanController@tanggapanwali')->name('tanggapan.wali');
    Route::post('/send-tanggapan/{keluhan}', 'TanggapanController@send_tanggapan');
    Route::get('/hitung-korelasi', 'WaliController@hitung_korelasi')->name('hitung-korelasi-kelas');
    Route::get('/korelasi-kelas', 'WaliController@korelasikelas')->name('korelasi-kelas');
    Route::get('/hasil-korelasi', 'WaliController@hasilkorelasi')->name('hasil-korelasi');
    Route::get('/filter-korelasiwali', 'WaliController@filterkorelasiwali');
});


