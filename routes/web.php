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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/arquivo/store', 'ArquivosController@store');
Route::post('/arquivo/store-img', 'ArquivosController@storeImg');
Route::get('/perfil', 'ArquivosController@perfil');

Route::get('alert/{AlertType}','ArquivosController@alert')->name('alert');