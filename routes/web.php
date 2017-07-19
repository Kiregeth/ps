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

/*
 * Auth Routes
 */
Auth::routes();

/*
 * SysController Routes
 */

Route::get('/','SysController@index');
Route::get('/dashboard', 'SysController@dashboard')->name('dash');

Route::get('/users', 'SysController@users');
Route::get('/add_user', 'SysController@add_user');
Route::get('/change_pwd', 'SysController@change_pwd');

Route::post('/users', 'SysController@users');
Route::post('/add_user', 'SysController@add_user');
Route::post('/change_pwd', 'SysController@change_pwd');


/*
 * OperationController Routes
 */

Route::get('/reception', 'OperationController@visitor_log');
Route::get('/application_form', 'OperationController@application_form');
Route::get('/app_forms', 'OperationController@app_forms');

Route::post('/reception', 'OperationController@visitor_log');
Route::post('/application_form', 'OperationController@application_form');
Route::post('/app_forms', 'OperationController@app_forms');

/*
 * OldDbController Routes
 */

Route::get('/databank', 'OldDbController@databank');
Route::get('/visa', 'OldDbController@visa');
Route::get('/deployment', 'OldDbController@deployment');

Route::post('/databank', 'OldDbController@databank');
Route::post('/visa', 'OldDbController@visa');
Route::post('/deployment', 'OldDbController@deployment');


/*
 * FormController Routes
 */

Route::post('/add', 'FormController@add');
Route::post('/add_to_db', 'FormController@add_to_db');
Route::post('/add_to_visa', 'FormController@add_to_visa');
Route::post('/add_to_deployment', 'FormController@add_to_deployment');

/*
 * NewDbController Routes
 */
Route::get('/new_databank', 'NewDbController@new_databank');
Route::get('/new_visa', 'NewDbController@new_visa');
Route::get('/new_deployment', 'NewDbController@new_deployment');

Route::post('/new_databank', 'NewDbController@new_databank');
Route::post('/new_visa', 'NewDbController@new_visa');
Route::post('/new_deployment', 'NewDbController@new_deployment');



/*
 * AjaxController Routes
 */

Route::post('/delete', 'AjaxController@delete');
Route::post('/quick_add','AjaxController@quick_add');
Route::post('/quick_edit','AjaxController@quick_edit');
Route::post('/visaprocess','AjaxController@visaprocess');
Route::post('/deploy','AjaxController@deploy');
Route::post('/cancel','AjaxController@cancel');
Route::post('/cv_save','AjaxController@cv_save');

Route::post('/delete_new','AjaxController@delete_new');
Route::post('/cancel_new','AjaxController@cancel_new');
Route::post('/quick_edit_new','AjaxController@quick_edit_new');





////Route::get('get_logout', '\App\Http\Controllers\Auth\LoginController@get_logout');
//
//
//// test routes
//Route::get('/check', function()
//{
//    $img = Image::make(public_path('css/img/login-bg.jpg'));
//    $img->text('foo', 500, 500, function($font) {
//        $font->file(public_path('img_font/times.ttf'));
//        $font->size('500');
//        $font->color('#000');
//        $font->align('center');
//        $font->valign('top');
//    });
//    return $img->response('jpg');
//});
//
//Route::get('/pdf', function()
//{
//    $pdf = App::make('dompdf.wrapper');
//    $asd="<h1>asdasd</h1>";
//    $pdf->loadHTML($asd)->save(public_path('/my_stored_file.pdf'));
//    return "done";
//});

Route::post('/export','FormController@export_to_excel');

Route::get('/check',function (){

    Excel::create('Databank Export', function($excel) {
        $excel->sheet('Sheet1', function($sheet) {
            $headings = array('check1', 'check2');
            $sheet->setOrientation('landscape');
            $sheet->fromArray(array(
                array('data1', 'data2'),
                array('data3', 'data4')
            ), null, 'A1', false, false);
            $sheet->prependRow(1, $headings);
        });
    })->export('xls');
});
