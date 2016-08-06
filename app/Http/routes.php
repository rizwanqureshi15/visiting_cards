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

Route::get('admin/delete_employee/{id}', 'AdminController@delete_employee');

Route::get('admin/edit_profile/{id}', 'AdminController@edit_profile');
Route::post('admin/edit_profile/{id}', 'AdminController@edit_profile_post');


Route::get('admin/create_employee', 'AdminController@create_employee');
Route::post('admin/create_employee', 'AdminController@create_employee_post');

Route::get('change_password','UserController@show_change_password');
Route::post('change_password','UserController@change_password');

Route::get('admin/users_list', 'AdminController@users_list');

