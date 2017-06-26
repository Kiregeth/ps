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
Route::get('/visa', 'SysController@visa');
Route::get('/deployment', 'SysController@deployment');
Route::get('/users', 'SysController@users');
Route::get('/add_user', 'SysController@add_user');

Route::post('/reception', 'SysController@visitor_log');
Route::post('/databank', 'SysController@databank');
Route::post('/visa', 'SysController@visa');
Route::post('/deployment', 'SysController@deployment');
Route::post('/users', 'SysController@users');
Route::post('/add_user', 'SysController@add_user');

Route::post('/add', 'SysController@add');


Route::post('/delete', 'AjaxController@delete');
Route::post('/quick_add','AjaxController@quick_add');
Route::post('/quick_add','AjaxController@quick_add');
Route::post('/quick_edit','AjaxController@quick_edit');
Route::post('/visaprocess','AjaxController@visaprocess');
Route::post('/deploy','AjaxController@deploy');
Route::post('/cancel','AjaxController@cancel');

Route::get('get_logout', '\App\Http\Controllers\Auth\LoginController@get_logout');

Route::get('/check', function()
{
    if (!extension_loaded('imagick'))
        return 'imagick not installed';
});
