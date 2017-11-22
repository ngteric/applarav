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



Auth::routes();

Route::get('/',"BackController@index")->middleware('auth');
Route::get('/dashboard', "BackController@index")->middleware('auth');
Route::get('/spend/{id}', "BackController@showSpend")->middleware('auth');
Route::post('/logout', "BackController@logout")->middleware('auth')->name('logout');