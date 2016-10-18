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
use Illuminate\Support\Facades\Input;
use Datatables;

class TemplateController extends Controller
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
	public function template_list()
	{
		if(TemplateController::authenticate_admin())
        {

                $data['categories'] = Template::with('category')->get();
        		$data['templates'] = Template::where('is_delete', 0)->paginate(Config::get('settings.number_of_rows'));
                
                return view('admin.templates.list', $data);      
        }
        else
        {
                return redirect()->back();
        }
		
	}

     public function templates_datatable()
    {

         $template = Template::with('category')->where('is_delete',0)->get();

         return Datatables::of($template)
                    ->addColumn('action', function ($data) {
                           
                            $button = '<a href="'. url('admin/templates/edit', $data->id).'">Edit</a> | 
                        <a data-toggle="modal"  style="cursor: pointer" class="delete_template" data-target="#onDelete" data-delete="'. $data->id .'" >Delete</a> ';
                            return $button;
                        })
                    ->addColumn('feilds', function ($data) {
                           
                            $button = '<a href="'.url("admin/templates/".$data->url) .'">View Feilds</a>';
                            return $button;
                        })
                    ->editColumn('category_id', function ($data) {
                            $category = $data->category->name;
                            return $category;
                        })
                    ->make(true);
    }

    public function create_template()
    {
        if(TemplateController::authenticate_admin())
        {
               $data['categories'] = Category::where('is_delete', 0)->get();
                return view('admin.templates.create', $data);      
        }
        else
        {
                return redirect()->back();
        }
    }

    public function create_template_post(Request $request)
    {
        if(TemplateController::authenticate_admin())
        {
           

             $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'category_id' => 'required',
                        'type' => 'required',
                        'url' => 'required|unique:templates',
                        'background_image' => 'required',
                        'price' => 'required|numeric'
                    ]);
                    
                      
                    if ($validator->fails()) {
                        return redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                    else
                    {     
                        if($request->double_side == 'on')
                        {
                            $is_double = 1;
                        }
                        else
                        {
                            $is_double = 0;
                        }
                        $image;
                        if($request->background_image)
                            {
                                
                                $file = Input::file('background_image');
                               
                                $destinationPath = public_path() .'/templates/background-images';
                                $extension = $file->getClientOriginalExtension();
                                $fileName = str_random(40) . '.' . $extension;
                                $upload_success = $file->move($destinationPath, $fileName); 

                                $image = $fileName;
                            }

                            $data = array(
                            'name' => $request->name, 
                            'background_image' => $image,
                            'price' => $request->price,  
                            'type' => $request->type, 
                            'category_id' => $request->category_id,
                             'url'=> $request->url, 
                             'is_delete' => 0,
                             'is_both_side' => $is_double
                            );

                            if($request->back_background_image)
                            {
                                
                                $file = Input::file('back_background_image');
                               
                                $destinationPath = public_path() .'/templates/background-images';
                                $extension = $file->getClientOriginalExtension();
                                $fileName = str_random(40) . '.' . $extension;
                                $upload_success = $file->move($destinationPath, $fileName); 

                                $back_image = $fileName;
                                $data['background_image_back'] = $back_image;
                            }
                        Template::create($data);
                        Session::flash('succ_msg', 'New Template is created Successfully..!');
                        return redirect('admin/templates');
                    } 
            }
             
        
        else
        {
                return redirect()->back();
        }
    }

     public function edit_template($id)
    {
        if(TemplateController::authenticate_admin())
        {
                $data['template'] = Template::where('id',$id)->where('is_delete', 0)->first();
                $data['categories'] = Category::where('is_delete', 0)->get();
                return view('admin.templates.edit', $data);      
        }
        else
        {
                return redirect()->back();
        }
    }

    public function edit_template_post(Request $request,$id)
    {

        if(TemplateController::authenticate_admin())
        {
           
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'category_id' => 'required',
                        'type' => 'required',
                        'url' => 'required|unique:templates,url,'.$id,
                        'price' => 'required|numeric'
                        //'background_image' => 'required'
                    ]);
            if($request->is_image=="0" && $request->background_image==NULL)
            {
                Session::flash('err_msg', "background image feild is required");
                return redirect()->back();
            }

             if($request->double_side == 'on')
            {
                $is_back_side = 1;
            }
            else
            {
                $is_back_side = 0;
            }

            if($is_back_side == 1)
            {
                if($request->is_back_image=="0" && $request->background_image_back==NULL)
                {
                    Session::flash('err_msg', "background image Back feild is required");
                    return redirect()->back();
                }
            }
                  
            if ($validator->fails()) 
            {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            else
            {   
                $data = array(
                    'name' => $request->name,                             
                    'type' => $request->type, 
                    'category_id' => $request->category_id, 
                    'is_both_side' => $is_back_side,
                    'price' => $request->price
                    );

                if($request->background_image)
                {

                    $file = Input::file('background_image');          
                    $destinationPath = public_path() .'/templates/background-images';
                    $extension = $file->getClientOriginalExtension();
                    $fileName = str_random(40) . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName); 

                    $image = $fileName;
                    $data['background_image'] = $image;

                    $image = Template::where('id', $id)->pluck('background_image');
                    @unlink(public_path("templates/background-images/".$image[0]));
               }
               if($request->background_image_back!=NULL)
                {

                    $file = Input::file('background_image_back');          
                    $destinationPath = public_path() .'/templates/background-images';
                    $extension = $file->getClientOriginalExtension();
                    $fileName = str_random(40) . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName); 

                    $image = $fileName;
                    $data['background_image_back'] = $image;

                    $image = Template::where('id', $id)->pluck('background_image_back');
                    @unlink(public_path("templates/background-images/".$image[0]));
               }
                Template::where('id',$id)->update($data);        
                Session::flash('succ_msg', 'New Template is updated Successfully..!');
                return redirect()->back();
            } 
            
        }
        else
        {
            return redirect()->back();
        }
    }

    public function delete_template(Request $request)
    {
        $id=$request->delete_id;

        if(TemplateController::authenticate_admin())
        {
            Template::where('id',$id)->update(['is_delete' => 1]);
            Session::flash('succ_msg','Successfully deleted..!!');
            return redirect('admin/templates');
        }
        else
        {
                return redirect()->back();
        }
    }
   
}