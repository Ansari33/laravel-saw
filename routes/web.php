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
    return view('index');
});
Route::get('/kriteria','KriteriaController@index');
Route::get('/tambah_k','KriteriaController@create');
Route::post('/add_k','KriteriaController@store');
Route::get('/edit_k/{kode}','KriteriaController@edit');
Route::post('/update_k','KriteriaController@update');
Route::get('/hapus_k/{kode}','KriteriaController@destroy');
Route::get('/alternatif','AlternatifController@index');
Route::get('/tambah_a','AlternatifController@create');
Route::post('/add_a','AlternatifController@store');
Route::get('/edit_a/{id}','AlternatifController@edit');
Route::post('/update_a','AlternatifController@update');
Route::get('/hapus_a/{id}','AlternatifController@destroy');
Route::get('/tampil','NilaiController@tampil');
Route::get('/normal','NilaiController@normal');
Route::get('/vektor','NilaiController@vektor');
Route::get('/hasil','NilaiController@hasil');