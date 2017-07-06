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
Route::get('/application_form', 'SysController@application_form');
Route::get('/app_forms', 'SysController@app_forms');

Route::get('/databank', 'SysController@databank');
Route::get('/visa', 'SysController@visa');
Route::get('/deployment', 'SysController@deployment');

Route::get('/users', 'SysController@users');
Route::get('/add_user', 'SysController@add_user');

Route::get('/change_pwd', 'SysController@change_pwd');

Route::post('/reception', 'SysController@visitor_log');
Route::post('/application_form', 'SysController@application_form');
Route::post('/app_forms', 'SysController@app_forms');

Route::post('/databank', 'SysController@databank');
Route::post('/visa', 'SysController@visa');
Route::post('/deployment', 'SysController@deployment');

Route::post('/users', 'SysController@users');
Route::post('/add_user', 'SysController@add_user');

Route::post('/add', 'SysController@add');

Route::post('/change_pwd', 'SysController@change_pwd');


Route::post('/delete', 'AjaxController@delete');
Route::post('/quick_add','AjaxController@quick_add');
Route::post('/quick_edit','AjaxController@quick_edit');
Route::post('/visaprocess','AjaxController@visaprocess');
Route::post('/deploy','AjaxController@deploy');
Route::post('/cancel','AjaxController@cancel');
Route::post('/cv_save','AjaxController@cv_save');

Route::get('get_logout', '\App\Http\Controllers\Auth\LoginController@get_logout');


// test routes
Route::get('/check', function()
{
    $img = Image::make(public_path('css/img/login-bg.jpg'));
    $img->text('foo', 500, 500, function($font) {
        $font->file(public_path('img_font/times.ttf'));
        $font->size('500');
        $font->color('#000');
        $font->align('center');
        $font->valign('top');
    });
    return $img->response('jpg');
});

Route::get('/pdf', function()
{
    $pdf = App::make('dompdf.wrapper');
    $asd="<h1>asdasd</h1>";
    $pdf->loadHTML($asd)->save(public_path('/my_stored_file.pdf'));
    return "done";
});


