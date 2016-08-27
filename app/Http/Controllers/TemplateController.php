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
                        'background_image' => 'required'
                    ]);
                    
                      
                    if ($validator->fails()) {
                        return redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                    }
                    else
                    {     

                        if($request->background_image)
                            {
                                
                                $file = Input::file('background_image');
                               
                                $destinationPath = public_path() .'/templates/background-images';
                                $extension = $file->getClientOriginalExtension();
                                $fileName = rand(11111, 99999) . '.' . $extension;
                                $upload_success = $file->move($destinationPath, $fileName); 

                                $image = $fileName;
                            }
                        Template::create(['name' => $request->name, 'background_image' => $image, 'type' => $request->type, 'category_id' => $request->category_id, 'url'=> $request->url, 'is_delete' => 0]);
                        Session::flash('succ_msg', 'New Template is created Successfully..!');
                        return redirect('admin/templates');
                    } 
            // if($request->background_image && $request->background_color)
            // { 
            //      Session::flash('err_msg', "You Have to set only one feild Background color or background image");
            // }
            // elseif($request->background_image == "" && $request->background_color == "")
            // {
            //     Session::flash('err_msg', "You Have to set one feild Background color or background image");
               
            // }
            //  $validator = Validator::make($request->all(), [
            //             'name' => 'required',
            //             'category_id' => 'required',
            //             'type' => 'required',
            //             'url' => 'required|unique:templates'
            //         ]);
                    
                      
            //         if ($validator->fails()) {
            //             return redirect()->back()
            //                         ->withErrors($validator)
            //                         ->withInput();
            //         }
            //         else
            //         {     

            //             if($request->background_image)
            //                 {
                                
            //                     $file = Input::file('background_image');
                               
            //                     $destinationPath = public_path() .'\templates\background-images';
            //                     $extension = $file->getClientOriginalExtension();
            //                     $fileName = rand(11111, 99999) . '.' . $extension;
            //                     $upload_success = $file->move($destinationPath, $fileName); 

            //                     $image = $fileName;
            //                 }
            //             Template::create(['name' => $request->name, 'background_image' => $image, 'background_color' => $request->background_color,'type' => $request->type, 'category_id' => $request->category_id, 'url'=> $request->url, 'is_delete' => 0]);
            //             Session::flash('succ_msg', 'New Template is created Successfully..!');
            //             return redirect('admin/templates');
            //         } 
            
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
                        //'background_image' => 'required'
                    ]);
             if($request->is_image=="0" && $request->background_image==NULL)
             {
                 Session::flash('err_msg', "background image feild is required");
                  return redirect()->back();
             }
                    
                      
                    if ($validator->fails()) {
    
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
                        );


                      
                                if($request->background_image!=NULL)
                                {

                                $file = Input::file('background_image');
                               
                                $destinationPath = public_path() .'/templates/background-images';
                                $extension = $file->getClientOriginalExtension();
                                $fileName = rand(11111, 99999) . '.' . $extension;
                                $upload_success = $file->move($destinationPath, $fileName); 

                                $image = $fileName;
                                $data['background_image'] = $image;

                                $image = Template::where('id', $id)->pluck('background_image');
                                
                                @unlink(public_path("templates/background-images/".$image[0]));
                                }

                        Template::where('id',$id)->update($data);
                        
                        Session::flash('succ_msg', 'New Template is updated Successfully..!');
                        return redirect()->back();
                    } 
            
            }
             
            // if($request->is_image == "1" && $request->background_color)
            // { 
            //      Session::flash('err_msg', "You Have to set only one feild Background color or background image");
            //      return redirect()->back();
            // }
            // elseif($request->is_image == "0" && $request->background_color == "")
            // {
            //     Session::flash('err_msg', "You Have to set one feild Background color or background image");
            //     return redirect()->back();
            // }
            //  $validator = Validator::make($request->all(), [
            //             'name' => 'required',
            //             'category_id' => 'required',
            //             'type' => 'required',
            //             'url' => 'required|unique:templates,url,'.$id
            //         ]);
                    
                      
            //         if ($validator->fails()) {
    
            //             return redirect()->back()
            //                         ->withErrors($validator)
            //                         ->withInput();
            //         }
            //         else
            //         {   

            //             $data = array(
            //                 'name' => $request->name,                             
            //                 'background_color' => $request->background_color,
            //                 'type' => $request->type, 
            //                 'category_id' => $request->category_id, 
            //             );


            //             if($request->is_image=="1" && $request->background_color=="")
            //                 {    
            //                     if($request->background_image!=NULL)
            //                     {

            //                     $file = Input::file('background_image');
                               
            //                     $destinationPath = public_path() .'\templates\background-images';
            //                     $extension = $file->getClientOriginalExtension();
            //                     $fileName = rand(11111, 99999) . '.' . $extension;
            //                     $upload_success = $file->move($destinationPath, $fileName); 

            //                     $image = $fileName;
            //                     $data['background_image'] = $image;
            //                     }
            //                 } 
            //                 if($request->is_image=="0")
            //                 {
            //                     $data['background_image'] = NULL;
            //                 }

            //             Template::where('id',$id)->update($data);
            //             Session::flash('succ_msg', 'New Template is updated Successfully..!');
            //             return redirect()->back();
            //         } 
            
            // }
             
        
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