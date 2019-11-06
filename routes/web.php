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
    return view('welcome');
});
Route::resource('penelitian','AController');
Route::get('/preproses/{id}','AController@pre');

Route::get('/home', 'LoginController@index')->name('home');
Route::resource('kata','KataController');
Route::resource('dok','DokController');
Route::resource('bobot','BobotController');
Route::get('/cluster',  'ClusteringController@index')->name('cluster');
Route::post('/bisec',  'ClusteringController@kel')->name('clustering');
Route::get('/yoyo',  'CekController@alt3');
Route::get('/af',  'clusteringController@cekHasil');
Route::get('/tfidf',  'KataController@hitung_bobot')->name('tfidf');