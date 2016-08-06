<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;	
use Session;
use App\Employee;
use Hash;
use Form;
use Validator;
use App\User;
use Config;

class AdminController extends Controller
{
    //
    protected $guard = 'employee';

    public function authenticate_admin()
    {
       
        if((Auth::guard('employee')->user()->is_admin) == 1)
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

    public function dashboard_display()
    {
        //dd(AdminController::authenticate_admin());
        if(AdminController::authenticate_admin())
        {

                return redirect('admin/employees_list');        
        }
        else
        {
                return redirect()->back();
        }
    
    }
    
    public function logout()
    {
        
        Auth::guard('employee')->logout();
        return redirect('employees/login');
    }

    public function employees_list()
    {

        if(AdminController::authenticate_admin())
        {
                $data['employees'] = Employee::where('is_delete', 0)->where('is_admin', 0)->paginate(Config::get('settings.number_of_rows'));

                return view('admin.employees_list', $data);        
        }
        else
        {
                return redirect()->back();
        }
    }

    public function create_employee()
    {
        if(AdminController::authenticate_admin())
        {
               return view('admin/create_employee');       
        }
        else
        {
                return redirect()->back();
        }
        

    }

    public function create_employee_post(Request $request)
    {
         if(AdminController::authenticate_admin())
        {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:employees',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required|min:8'
                
            ]);
            
              
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            else
            {     
                Employee::create(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'username' => $request->username, 'email' => $request->email, 'password' => Hash::make($request->password), 'is_admin' => 0]);
                Session::flash('create_msg', 'New employee account is created Successfully..!');
                return redirect('admin/employees_list');
            } 
        }
        else
        {
                return redirect()->back();
        }
    }

    public function reset_password(Request $request)
    {

        if(AdminController::authenticate_admin())
        {
            $validator = Validator::make($request->all(), [
                'password' => 'required'
                
             ]);
        
          
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            else
            {   
                Employee::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
                Session::flash('reset_msg','Password is reset..');
                return redirect()->back();
            }
        }
        else
        {
                return redirect()->back();
        }
    }

    public function delete_employee($id)
    {
        if(AdminController::authenticate_admin())
        {
            Employee::where('id',$id)->update(['is_delete' => 1]);
            Session::flash('dlt_msg','Successfully deleted employee..!!');
            return redirect()->back();
        }
        else
        {
                return redirect()->back();
        }
    }

    public function edit_profile($id)
    {

        if(AdminController::authenticate_admin())
        {

            $data['employee'] = Employee::where('id', $id)->first();
            return view('admin.edit_profile', $data);
        }
        else
        {
                return redirect()->back();
        }
    }

    public function edit_profile_post(Request $request,$id)
    {

        if(AdminController::authenticate_admin())
        {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email'
                
             ]);
        
          
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            else
            {   
                Employee::where('id',$id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email]);
                
                Session::flash('edit_msg','Profile is edited successfully..');
                return redirect('admin/employees_list');
            }
        }
        else
        {
                return redirect()->back();
        }
    }

    public function users_list()
    {
         if(AdminController::authenticate_admin())
        {

            $data['users'] = User::paginate(Config::get('settings.number_of_rows'));
            return view('admin.users_list', $data);
        }
        else
        {
                return redirect()->back();
        }
    }
}
