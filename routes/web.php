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

Route::get('/sess', 'SysController@add_sess');
Route::post('/change_pwd', 'SysController@change_pwd');


/*
 * OperationController Routes
 */

Route::get('/reception', 'OperationController@visitor_log');
Route::get('/application_form', 'OperationController@application_form');
Route::get('/app_forms', 'OperationController@app_forms');

Route::get('/{ref_no}/app_form_regenerate', 'OperationController@app_form_regenerate');

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
Route::post('/add_to_visa_receive', 'FormController@add_to_visa_receive');
Route::post('/add_to_deployment', 'FormController@add_to_deployment');

Route::post('/change_photo', 'FormController@change_photo');
Route::post('/upload_doc', 'FormController@upload_doc');


/*
 * NewDbController Routes
 */
Route::get('/new_databank', 'NewDbController@new_databank');
Route::get('/interview', 'NewDbController@interview');
Route::get('/new_visa', 'NewDbController@new_visa');
Route::get('/new_visa_receive', 'NewDbController@new_visa_receive');
Route::get('/new_deployment', 'NewDbController@new_deployment');

Route::get('/new_preset', 'NewDbController@new_preset');

Route::post('/new_databank', 'NewDbController@new_databank');
Route::post('/interview', 'NewDbController@interview');
Route::post('/new_visa', 'NewDbController@new_visa');
Route::post('/new_visa_receive', 'NewDbController@new_visa_receive');
Route::post('/new_deployment', 'NewDbController@new_deployment');

Route::post('/new_preset', 'NewDbController@new_preset');


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
Route::post('/reject','AjaxController@reject');
Route::post('/quick_edit_new','AjaxController@quick_edit_new');
Route::post('/add_remark', 'AjaxController@add_remark');

Route::post('/transfer_new','AjaxController@transfer_new');

Route::post('/add_preset','AjaxController@add_preset');
Route::post('/edit_preset','AjaxController@edit_preset');
Route::post('/delete_preset','AjaxController@delete_preset');
Route::post('/activate_preset','AjaxController@activate_preset');

Route::post('/add_to_interview', 'AjaxController@add_to_interview');

/*
 * Export Routes
 */

Route::post('/export','FormController@export_to_excel');

/*
 * Online Controller Routes
 */
Route::get('/online_forms', 'OnlineController@online_form');
Route::get('/refresh', 'OnlineController@refresh');


Route::group(['middleware' => ['auth']], function() {

	Route::get('/home', 'HomeController@index');

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

	Route::get('itemCRUD2',['as'=>'itemCRUD2.index','uses'=>'ItemCRUD2Controller@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
	Route::get('itemCRUD2/create',['as'=>'itemCRUD2.create','uses'=>'ItemCRUD2Controller@create','middleware' => ['permission:item-create']]);
	Route::post('itemCRUD2/create',['as'=>'itemCRUD2.store','uses'=>'ItemCRUD2Controller@store','middleware' => ['permission:item-create']]);
	Route::get('itemCRUD2/{id}',['as'=>'itemCRUD2.show','uses'=>'ItemCRUD2Controller@show']);
	Route::get('itemCRUD2/{id}/edit',['as'=>'itemCRUD2.edit','uses'=>'ItemCRUD2Controller@edit','middleware' => ['permission:item-edit']]);
	Route::patch('itemCRUD2/{id}',['as'=>'itemCRUD2.update','uses'=>'ItemCRUD2Controller@update','middleware' => ['permission:item-edit']]);
	Route::delete('itemCRUD2/{id}',['as'=>'itemCRUD2.destroy','uses'=>'ItemCRUD2Controller@destroy','middleware' => ['permission:item-delete']]);

});
