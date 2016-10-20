<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Template;
use App\TemplateFeild;
use View;
use App\UserCard;
use Auth;
use App\UserTemplate;
use Config;
use App\Material;
use Validator;
use Session;
use Datatables;
use Illuminate\Support\Facades\Input;

class MaterialController extends Controller
{
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

    public function create()
    {
        if(MaterialController::authenticate_admin())
        {

            return view('admin.materials.create');        
        }
        else
        {
            return redirect()->back();
        }
    }

    public function create_post(Request $request)
    {
        if(MaterialController::authenticate_admin())
        {
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'price' => 'required',
                        'description' => 'required',
                        'image' => 'required'
                    ]);
                              
            if($validator->fails()){

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            
            }
            else
            {
                $file = Input::file('image');               
                $destinationPath = public_path() .'/materials';
                $extension = $file->getClientOriginalExtension();
                $fileName = str_random(40) . '.' . $extension;
                $upload_success = $file->move($destinationPath, $fileName); 
                $image = $fileName;

                Material::create(['name' => $request->name, 'price' => $request->price, 'description' => $request->description, 'is_delete' => 0, 'image' => $image]);

                Session::flash('succ_msg', 'New type of Material is added Successfully..!');
                return redirect('admin/materials/list');
            
            } 
                   
        }
        else
        {
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(MaterialController::authenticate_admin())
        {
            $data['materials'] = Material::where('is_delete',0)->where('id', $id)->first();
            return view('admin.materials.edit', $data);        
        }
        else
        {
            return redirect()->back();
        }
    }

    public function edit_post(Request $request, $id)
    {
        if(MaterialController::authenticate_admin())
        {
            $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        'price' => 'required',
                        'description' => 'required'
                    ]);
                              
            if($validator->fails()){

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            
            }else{
                $data = [
                    'name' => $request->name, 
                    'price' => $request->price, 
                    'description' => $request->description, 
                    'is_delete' => 0
                    ];

                if($request->image)
                {
                    $material = Material::where('id', $id)->first();
                    @unlink(public_path("materials\\".$material->image));
                    $file = Input::file('image');               
                    $destinationPath = public_path() .'/materials';
                    $extension = $file->getClientOriginalExtension();
                    $fileName = str_random(40) . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName); 
                    $data['image'] = $fileName;
                }

                Material::where('id', $id)->update($data);
                Session::flash('succ_msg', 'Material is Edited Successfully..!');
                return redirect('admin/materials/list');
            
            } 
                   
        }
        else
        {
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        if(MaterialController::authenticate_admin())
        {
            Material::where('id', $request->delete_id)->update(['is_delete' => 1]);
            Session::flash('succ_msg', 'Material is deleted Successfully..!');       
            return redirect('admin/materials/list');        
        }
        else
        {
            return redirect()->back();
        } 
    }

    public function materials_list()
    {
        if(MaterialController::authenticate_admin())
        {
            $data['materials'] = Material::where('is_delete', 0)->paginate(Config::get('settings.number_of_rows'));
                                        

            return view('admin.materials.list', $data);        
        }
        else
        {
            return redirect()->back();
        }
    }

    public function material_datatable()
    {

         $materials = Material::where('is_delete', 0)->get();

         return Datatables::of($materials)
                    ->addColumn('action', function ($data) {
                           
                            $button = '<a href="'. url('admin/materials/edit/'.$data->id) .'">Edit</a> | <a data-toggle="modal"  style="cursor: pointer" class="delete_material" data-target="#onDelete" data-delete="'. $data->id .'" >Delete</a> ';
                            return $button;
                        })
                    ->make(true);
    }
}
