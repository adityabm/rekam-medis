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
    return redirect('login');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/tambah-pasien', 'PasienController@tambah')->name('tambah-pasien');
Route::get('/edit-pasien/{id}', 'PasienController@edit')->name('edit-pasien');
Route::get('/data-pasien', 'PasienController@data')->name('data-pasien');
Route::get('/get-data-pasien', 'PasienController@getData')->name('get-data-pasien');
Route::post('/proses-pasien', 'PasienController@proses')->name('proses-pasien');
Route::post('/hapus-pasien', 'PasienController@hapus')->name('hapus-pasien');
Route::post('/hapus-riwayat', 'PasienController@hapusRiwayat')->name('hapus-riwayat');
Route::get('/jenjang', 'PasienController@jenjang')->name('jenjang');
Route::get('/get-data-jenjang', 'PasienController@getDataJenjang')->name('get-data-jenjang');
Route::post('/tambah-jenjang', 'PasienController@tambahJenjang')->name('tambah-jenjang');
Route::post('/hapus-jenjang', 'PasienController@hapusJenjang')->name('hapus-jenjang');
