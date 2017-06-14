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
Route::get('/reception', 'SysController@visitor_log');
Route::get('/databank', 'SysController@databank');


Route::post('/add', 'SysController@add');


Route::post('/delete', 'AjaxController@delete');
Route::post('/quick_add','AjaxController@quick_add');
Route::post('/quick_edit','AjaxController@quick_edit');
Route::post('/visaprocess','AjaxController@visaprocess');
