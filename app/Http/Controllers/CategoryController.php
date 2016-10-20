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
use Datatables;
use Illuminate\Support\Facades\Input;

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
               
               
                return view('admin.categories.list');     
        }
        else
        {
                return redirect()->back();
        }
    }

     public function category_datatable()
    {

         $category = Category::where('is_delete', 0)->get();

         return Datatables::of($category)
                    ->addColumn('action', function ($data) {
                           
                                
                            $button = '<a href="'. url('admin/categories/edit/'.$data->id) .'">Edit</a> | <a data-toggle="modal"  style="cursor: pointer" class="delete_category" data-target="#onDelete" data-delete="'.$data->id.'" >Delete</a>';
                            return $button;
                        })
                    ->make(true);
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
                        'name' => 'required',
                        'image' => 'required'
                        
                    ]);
                    
                      
                    if ($validator->fails()) {
                        return redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                    else
                    {   

                        $file = Input::file('image');             
                        $destinationPath = public_path() .'/categories';
                        $extension = $file->getClientOriginalExtension();
                        $fileName = str_random(40) . '.' . $extension;
                        $upload_success = $file->move($destinationPath, $fileName); 
                        $image = $fileName;  
                        
                        Category::create(['name' => $request->name,'image' => $image, 'is_delete' => 0]);
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
                        $data = [
                        'name' => $request->name, 
                        'is_delete' => 0
                        ];
                        if($request->image)
                        {
                            $category = Category::where('id', $id)->first();
                            @unlink(public_path("categories\\".$category->image));
                            $file = Input::file('image');                
                            $destinationPath = public_path() .'/categories';
                            $extension = $file->getClientOriginalExtension();
                            $fileName = str_random(40) . '.' . $extension;
                            $upload_success = $file->move($destinationPath, $fileName); 
                            $data['image'] = $fileName;
                        }
                        Category::where('id', $id)->update($data);
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