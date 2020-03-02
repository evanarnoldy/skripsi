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

Route::get('/admin', 'AdminController@index')->name('admin');

//siswa
Route::get('/data-siswa', 'StudentsController@index')->name('data-siswa');
Route::get('/detail-siswa/{student}', 'StudentsController@show');
Route::get('/tambah-siswa/', 'StudentsController@create');
Route::post('/data-siswa', 'StudentsController@store');
Route::delete('/data-siswa/{student}', 'StudentsController@destroy');
Route::get('/data-siswa/{student}/edit-siswa', 'StudentsController@edit');
Route::patch('/data-siswa/{student}', 'StudentsController@update');
