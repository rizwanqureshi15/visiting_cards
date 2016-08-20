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

Route::get('employees/dashboard', 'EmployeeController@dashboard_display');


Route::get('profile','UserController@show_profile');
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


Route::get('idcard', 'HomeController@get_card');
Route::post('admin/check_employeename','AdminController@check_employeename');

Route::post('card_image_save','UserController@save_image');
Route::post('card_image_upload','UserController@upload_image');

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

Route::post('admin/cards/save', 'CardController@card_save');
