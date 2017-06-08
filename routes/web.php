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

Route::get('/','SysController@index');

Auth::routes();

Route::get('/dashboard', 'SysController@dashboard')->name('dash');
Route::get('/reception', 'SysController@visitor_log')->name('dash');
