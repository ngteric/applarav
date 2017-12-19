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

Route::get('/',"SpendController@index")->middleware('auth');
Route::get('/dashboard',"SpendController@index")->middleware('auth');
Route::resource('spend', "SpendController")->middleware('auth');
Route::get('/balance',"SpendController@balance")->middleware('auth')->name('balance');
Route::post('/logout', "BackController@logout")->middleware('auth')->name('logout');