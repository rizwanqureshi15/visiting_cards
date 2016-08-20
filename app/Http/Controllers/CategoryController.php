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
use App\Template;
use App\Category;

class CategoryController extends Controller
{
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
    //Category
    public function display_category()
    {
        if(CategoryController::authenticate_admin())
        {
               
               $data['categories'] = Category::where('is_delete', 0)->paginate(Config::get('settings.number_of_rows'));
                return view('admin.categories.list', $data);     
        }
        else
        {
                return redirect()->back();
        }
    }

    public function create_category()
    {
          if(CategoryController::authenticate_admin())
            {
                return view('admin.categories.create');       
                 
            }
            else
            {
                    return redirect()->back();
            }
    }

    public function create_category_post(Request $request)
    {
        if(CategoryController::authenticate_admin())
            {
                   $validator = Validator::make($request->all(), [
                        'name' => 'required'
                        
                    ]);
                    
                      
                    if ($validator->fails()) {
                        return redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                    else
                    {     
                        Category::create(['name' => $request->name, 'is_delete' => 0]);
                        Session::flash('succ_msg', 'New Category is created Successfully..!');
                        return redirect('admin/categories/list');
                    } 
            }
            else
            {
                    return redirect()->back();
            }
    }

    public function edit_category($id)
    {
          if(CategoryController::authenticate_admin())
            {
                $data['category'] = Category::where('id', $id)->first();
                return view('admin.categories.edit', $data);       
                 
            }
            else
            {
                    return redirect()->back();
            }
    }

    public function edit_category_post(Request $request,$id)
    {
        if(CategoryController::authenticate_admin())
            {
                   $validator = Validator::make($request->all(), [
                        'name' => 'required'
                        
                    ]);
                    
                      
                    if ($validator->fails()) {
                        return redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                    else
                    {     
                        Category::where('id', $id)->update(['name' => $request->name, 'is_delete' => 0]);
                        Session::flash('succ_msg', 'Category is Edited Successfully..!');
                        return redirect('admin/categories/list');
                    } 
            }
            else
            {
                    return redirect()->back();
            }
    }

     public function delete_category(Request $request)
    {
        $id=$request->delete_id;

        if(CategoryController::authenticate_admin())
        {
            Category::where('id',$id)->update(['is_delete' => 1]);
            Session::flash('succ_msg','Successfully deleted..!!');
            return redirect('admin/categories/list');
        }
        else
        {
                return redirect()->back();
        }
    }
}