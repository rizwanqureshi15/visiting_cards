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

Route::get('/', 'HomeController@index');

Route::auth();

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

Route::get('cards/{category_name?}','Front\TemplatesController@index');
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

Route::get('download_file',['middleware' => 'auth','uses' => 'Front\TemplatesController@download_file']);

Route::post('user_template_save','Front\TemplatesController@save_user_template');

Route::get('mytemplates',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_user_gallery']);

Route::get('mytemplates/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_user_template']);
Route::post('upload_template_image','CardController@upload_image');

// Route::post('save_single_card','Front\TemplatesController@save_card');

Route::get('mytemplates/{url}/edit',['middleware' => 'auth','uses' => 'Front\TemplatesController@edit_user_template']);
Route::post('user_template_edit',['middleware' => 'auth','uses' => 'Front\TemplatesController@edit_user_template_post']);
Route::post('user_template_edit_back',['middleware' => 'auth','uses' => 'Front\TemplatesController@edit_user_template_back_post']);

Route::get('single_card/{url}/create', ['middleware' => 'auth','uses' => 'Front\TemplatesController@create_single_card']);

Route::get('multiple_cards/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_multiple_cards']);
Route::get('download_file/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@download_excel_file']);

Route::post('upload_file/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@upload_excel_file']);

Route::post('multiple_save_cards','Front\TemplatesController@multiple_image_save');

Route::get('mytemplates/{url}/delete', ['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_user_template']);

Route::get('multiple_card_preview',['middleware' => 'auth','uses' => 'Front\TemplatesController@show_multiple_image_preview']);

Route::post('delete_image',['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_image_from_multiple_preview']);

Route::get('delete_folder/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_multiple_preview_folder']);
Route::post('admin/templates/save_back_cards','CardController@back_card_save');

Route::post('upload_images/{url}',['middleware' => 'auth','uses' => 'Front\TemplatesController@upload_images']);

Route::get('delete_folder', ['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_multiple_preview_folder']);

Route::post('user_template_back_save', 'Front\TemplatesController@back_save_user_template');

Route::get('admin/materials/create', 'MaterialController@create');
Route::post('admin/materials/create', 'MaterialController@create_post');

Route::get('admin/materials/edit/{id}', 'MaterialController@edit');
Route::post('admin/materials/edit/{id}', 'MaterialController@edit_post');

Route::post('admin/materials/delete', 'MaterialController@delete');

Route::get('admin/materials/list', 'MaterialController@materials_list');

Route::get('order_multiple_cards/{url}',['middleware' => 'auth','uses' => 'OrderController@order_multiple_cards']);

Route::post('delete_back_image',['middleware' => 'auth','uses' => 'Front\TemplatesController@delete_back_image_from_multiple_preview']);

Route::get('admin/order-datatable', 'EmployeeController@datatable');
Route::get('admin/new-order-datatable', 'EmployeeController@new_order_datatable');

Route::get('admin/orders/{id}/list', 'EmployeeController@list_cards');
Route::get('admin/new_orders/{id}/list', 'EmployeeController@new_list_cards');

Route::post('card_list_snap', 'EmployeeController@save_list_snap');
Route::get('admin/orders/final/{id}/list', 'EmployeeController@order_snap_list');

Route::get('order/confirm/{id}', 'EmployeeController@confirm_order');
Route:: get('cancel_orders/list', 'EmployeeController@cancel_order_list');

Route::get('admin/cancel-order-datatable', 'EmployeeController@cancel_order_datatable');
Route::post('cancel_order', 'Front\PaymentsController@refund');


Route::get('myorders',['middleware' => 'auth','uses' => 'OrderController@show_user_order']);
Route::post('payment/myorders',['middleware' => 'auth','uses' => 'Front\PaymentsController@payment_success']);

Route::get('view_order/{order_id}',['middleware' => 'auth','uses' => 'OrderController@view_user_order']);

Route::post('scroll_pagination','OrderController@ajax_pagination');

Route::get('orders/done/{id}', 'EmployeeController@done_order');

Route::get('orders/history/list', 'EmployeeController@order_history_list');

Route::get('order-history-datatable', 'EmployeeController@order_history_datatable');

Route::get('terms_condition','HomeController@show_terms_condition');

Route::get('faqs','HomeController@show_faqs');

Route::get('privacy_policy','HomeController@show_privacy_policy');

Route::get('about','HomeController@show_about');

Route::post('save_single_card',['middleware' => 'auth','uses' => 'OrderController@order_single_card']);

Route::get('order-history-datatable', 'EmployeeController@order_history_datatable');
Route::get('admin/employees-datatable', 'AdminController@employee_datatable');
Route::get('admin/users-datatable', 'AdminController@users_datatable');
Route::get('admin/templates-datatable', 'TemplateController@templates_datatable');
Route::get('admin/category-datatable', 'CategoryController@category_datatable');
Route::get('admin/material-datatable', 'MaterialController@material_datatable');
Route::get('admin/faqs-datatable', 'FAQController@faq_datatable');
Route::get('admin/faqs/list', 'FAQController@faqs_list');
Route::get('admin/faq/create', 'FAQController@create');	
Route::post('admin/faqs/create', 'FAQController@create_post');
Route::get('admin/faq/edit/{id}', 'FAQController@edit');	
Route::post('admin/faq/edit/{id}', 'FAQController@edit_post');
Route::post('admin/faq/delete', 'FAQController@delete');

Route::resource('admin/contacts', 'ContactController' , ['only' => ['show','index']]);
Route::get('admin/contact-datatable', 'ContactController@contact_datatable');
Route::post('admin/contacts/delete', 'ContactController@destroy');

Route::get('order/{order_no}/payment','Front\PaymentsController@index');
Route::post('payment','Front\PaymentsController@payment');

Route::get('test','Front\PaymentsController@test');

Route::get('contact','HomeController@show_contact_page');
Route::post('submit_contact','HomeController@submit_contact');

Route::get('material/{material_id}','Front\TemplatesController@get_material_id');

Route::get('order/refund/{id}', 'PaymentsController@refund');

Route::get('cancel_order/{order_id}','OrderController@cancel_order');

Route::post('upload_image', 'CardController@upload_normal_image');
Route::post('save_material_id','Front\TemplatesController@save_material_id');
Route::post('change_status', 'EmployeeController@change_status');
