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
use Datatables;


/**
 * Controlls admin functionalities
 *
 * @package   AdminController
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class AdminController extends Controller
{
    //
    protected $guard = 'employee';


    /**
     * Authenticate the admin
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
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


    /**
     * show dashboard page of employee
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function dashboard_display()
    {
        if(AdminController::authenticate_admin())
        {

                return redirect('admin/employees_list');        
        }
        else
        {
                return redirect()->back();
        }
    
    }
    

    /**
     * admin logout
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return    view
     */
    public function logout()
    {
        
        Auth::guard('employee')->logout();
        return redirect('employees/login');
    }


    /**
     * Show employee list
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function employees_list()
    {
        if(AdminController::authenticate_admin())
        {
                return view('admin.employees_list');        
        }
        else
        {
                return redirect()->back();
        }
    }


    /**
     * Get the data of the employee and returns it to datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function employee_datatable()
    {
         $employees = Employee::where('is_delete', 0)->where('is_admin', 0)->get();
         return Datatables::of($employees)
                    ->addColumn('action', function ($data) {
                        $links = '<a href="'.url('admin/employees/edit', $data->id).'">Edit</a> | 
                            <a data-toggle="modal"  style="cursor: pointer" class="delete_password" data-target="#onDelete" data-delete="'. $data->id .'" >Delete</a> | 
                            <button type="button" class="btn btn-default reset_password" data-toggle="modal" data-target="#myModal" data-id="'. $data->id .'">
                              Reset Password
                            </button>'; 

                            return $links;
                        })
                    ->editColumn('first_name', function ($data) {
                            $username = $data->first_name . " " . $data->last_name;
                            return $username;
                        })
                    ->make(true);
    }


    /**
     * Show create employee page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function create_employee()
    {
        if(AdminController::authenticate_admin())
        {
               return view('admin.create_employee');       
        }
        else
        {
                return redirect()->back();
        }

    }


    /**
     * Validate the form
     * If validations are false than redirect back to the view
     * If validations are true than stores the value in database and return the view
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array first_name,last_name,username,email,password,password_confirmation
     * @return   view
     */
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


    /**
     * Validate the form
     * If validations are false than redirect back to the view
     * If validations are true than reset the password
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param     int product_id
     * @return     array product_info
     */
    public function reset_password(Request $request)
    {
        if(AdminController::authenticate_admin())
        {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8'
                
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


    /**
     * Delete the employee
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int delete_id
     * @return   redirect back on view
     */
    public function delete_employee(Request $request)
    {
        $id=$request->delete_id;
        if(AdminController::authenticate_admin())
        {
            Employee::where('id',$id)->update(['is_delete' => 1]);
            Session::flash('dlt_msg','Successfully deleted employee..!!');
            return redirect('admin/employees_list');
        }
        else
        {
                return redirect()->back();
        }
    }


    /**
     * admin can edit the profile of employee
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   array product_info
     */
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


    /**
     * Validate the form
     * If validations are true than update the profile of employee
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array first_name,last_name,email,int id
     * @return   view
     */
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


    /**
     * Show users list
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function users_list()
    {
         if(AdminController::authenticate_admin())
        {   
            return view('admin.users_list');
        }
        else
        {
                return redirect()->back();
        }
    }


    /**
     * Get the data of users and return it to datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   array product_info
     */
    public function users_datatable()
    {
        $users = User::where('is_delete',0)->get();
        return Datatables::of($users)
                    ->editColumn('first_name', function ($data) {
                            $username = $data->first_name . " " . $data->last_name;
                            return $username;
                        })
                    ->make(true);
    }


    /**
     * Check employeename
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String username
     * @return   json employeename
     */
    public function check_employeename(Request $request)
    {
        $employeename=Employee::where('username', $request->username)->first();
        return response()->json($employeename);
    }
}
