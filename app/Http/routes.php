<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('employees/login', 'EmployeeController@login');
Route::post('employees/login', 'EmployeeController@login_post');

Route::get('orders/list', 'EmployeeController@order_list');
Route::get('new_orders/list', 'EmployeeController@new_order_list');


Route::get('profile','UserController@edit_profile');
Route::post('profile','UserController@change_profile');

Route::get('change_password','UserController@show_changepasword_page');
Route::post('check_username','UserController@check_username');

Route::get('admin/dashboard', 'AdminController@dashboard_display');

Route::get('admin/logout', 'AdminController@logout');

Route::get('admin/employees_list', 'AdminController@employees_list');

Route::post('admin/reset_password', 'AdminController@reset_password');

Route::post('admin/delete_employee', 'AdminController@delete_employee');

Route::get('admin/employees/edit/{id}', 'AdminController@edit_profile');
Route::post('admin/employees/edit/{id}', 'AdminController@edit_profile_post');


Route::get('admin/employees/create', 'AdminController@create_employee');
Route::post('admin/employees/create', 'AdminController@create_employee_post');

Route::get('change_password','UserController@show_change_password');
Route::post('change_password','UserController@change_password');

Route::get('admin/users_list', 'AdminController@users_list');

Route::get('mytemplates/{url}/create', 'Front\TemplatesController@get_template');
Route::post('admin/check_employeename','AdminController@check_employeename');

Route::post('card_image_save','UserController@save_image');

Route::get('gallery','Front\TemplatesController@index');
Route::post('templates','Front\TemplatesController@ajax_templates');

Route::post('user-images','HomeController@ajax_user_images');

Route::get('admin/categories/list', 'CategoryController@display_category');

Route::get('admin/categories/create', 'CategoryController@create_category');
Route::post('admin/categories/create', 'CategoryController@create_category_post');

Route::get('admin/categories/edit/{id}', 'CategoryController@edit_category');
Route::post('admin/categories/edit/{id}', 'CategoryController@edit_category_post');

Route::post('admin/categories/delete', 'CategoryController@delete_category');

Route::get('admin/templates','TemplateController@template_list');

Route::get('admin/templates/create', 'TemplateController@create_template');
Route::post('admin/templates/create', 'TemplateController@create_template_post');

Route::get('admin/templates/edit/{id}', 'TemplateController@edit_template');
Route::post('admin/templates/edit/{id}', 'TemplateController@edit_template_post');

Route::post('admin/templates/delete', 'TemplateController@delete_template');

Route::get('admin/templates/{name}', 'CardController@card_display');

Route::post('filter','Front\TemplatesController@filter_ajax');

Route::post('admin/templates/save_cards', 'CardController@card_save');

Route::post('template_save','CardController@save_image');

Route::post('download-template-formate','Front\TemplatesController@file_formate_download');

Route::get('download_file','Front\TemplatesController@download_file');

Route::post('user_template_save','Front\TemplatesController@save_user_template');

Route::get('mytemplates',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_user_gallery']);

Route::get('mytemplates/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_user_template']);
Route::post('upload_template_image','CardController@upload_image');

Route::post('save_single_card','Front\TemplatesController@save_card');

Route::get('mytemplates/{url}/edit',['middleware' => 'auth','uses' => 'Front\TemplatesController@edit_user_template']);
Route::post('user_template_edit','Front\TemplatesController@edit_user_template_post');
Route::post('user_template_edit_back','Front\TemplatesController@edit_user_template_back_post');

Route::get('single_card/{url}/create', 'Front\TemplatesController@create_single_card');

Route::get('multiple_cards/{url}','Front\TemplatesController@show_multiple_cards');
Route::get('download_file/{url}','Front\TemplatesController@download_excel_file');

Route::post('upload_file/{url}','Front\TemplatesController@upload_excel_file');

Route::post('multiple_save_cards','Front\TemplatesController@multiple_image_save');

Route::get('mytemplates/{url}/delete', ['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_user_template']);

Route::get('multiple_card_preview','Front\TemplatesController@show_multiple_image_preview');

Route::post('delete_image','Front\TemplatesController@delete_image_from_multiple_preview');

Route::get('delete_folder/{url}','Front\TemplatesController@delete_multiple_preview_folder');
Route::post('admin/templates/save_back_cards', 'CardController@back_card_save');

Route::post('upload_images/{url}','Front\TemplatesController@upload_images');

Route::get('delete_folder','Front\TemplatesController@delete_multiple_preview_folder');
Route::post('admin/templates/save_back_cards', 'CardController@back_card_save');
Route::post('user_template_back_save', 'Front\TemplatesController@back_save_user_template');

Route::get('admin/materials/create', 'MaterialController@create');
Route::post('admin/materials/create', 'MaterialController@create_post');

Route::get('admin/materials/edit/{id}', 'MaterialController@edit');
Route::post('admin/materials/edit/{id}', 'MaterialController@edit_post');

Route::post('admin/materials/delete', 'MaterialController@delete');

Route::get('admin/materials/list', 'MaterialController@materials_list');

Route::get('admin/order-datatable', 'EmployeeController@datatable');
Route::get('admin/new-order-datatable', 'EmployeeController@new_order_datatable');

Route::get('admin/orders/{id}/list', 'EmployeeController@list_cards');
Route::get('admin/new_orders/{id}/list', 'EmployeeController@new_list_cards');

Route::post('card_list_snap', 'EmployeeController@save_list_snap');
Route::get('admin/orders/final/{id}/list', 'EmployeeController@order_snap_list');

Route::get('order/confirm/{id}', 'EmployeeController@confirm_order');
Route:: get('cancel_orders/list', 'EmployeeController@cancel_order_list');

Route::get('admin/cancel-order-datatable', 'EmployeeController@cancel_order_datatable');
Route::post('cancel_order', 'EmployeeController@cancel_order');

Route::get('orders/done/{id}', 'EmployeeController@done_order');

Route::get('orders/history/list', 'EmployeeController@order_history_list');
Route::get('order-history-datatable', 'EmployeeController@order_history_datatable');