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

    public function authenticate_employee()
    {
       
        if((Auth::guard('employee')->user()->is_admin) == 0)
        {
            return true;
        }
        elseif(Auth::user() != null)
        {
            return false;
        }
        else
        {
            return false;
        }
    }

    public function login_post(Request $request)
    {
    	//Auth::guard('Newgardname'); [specify guerd name by which you want to authenticate
        if(Auth::guard('employee')->attempt(['username' => $request->username, 'password' => $request->password]))
    	{
            // Authentication passed...	
    		if(Employeecontroller::authenticate_employee())
    		{
    			return redirect()->intended('employees/dashboard');	
    		}
            else
            {
            	return redirect()->intended('admin/dashboard');
            }
        }
        else
        {
        	Session::flash('error_msg','Username or Password is incorrect..!');
        	return redirect()->back();
        }
    }

    public function dashboard_display()
    {
    	return view('employee.dashboard');
    }
}
