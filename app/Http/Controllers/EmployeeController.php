<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;	
use Session;


class EmployeeController extends Controller
{
    //
    protected $guard = 'employee';
    public function login()
    {
    	return view('employee/login');
    }

    public function login_post(Request $request)
    {
    	//Auth::guard('Newgardname'); [specify guerd name by which you want to authenticate]
    	if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            return redirect()->intended('employees/dashboard');
        }
        else
        {
        	Session::flash('error_msg','Username or Password is incorrect..!');
        	return redirect()->back();
        }
    }

    public function dashboard_display()
    {
    	return view('admin.dashboard');
    }
}
