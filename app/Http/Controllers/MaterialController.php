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


/**
 * Handles all the function related to materials
 *
 * @package   MaterialController
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class MaterialController extends Controller
{

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
     * Show create material form
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
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


    /**
     * Validate the from and stores in the database
     * Put material image to proper folder 
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array name,price,description,image
     * @return   view
     */
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


    /**
     * Get the data from database and send it to the view
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
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


    /**
     * Validate the from update edited data
     * Put new image in proper folder and update image feild  
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array name,price,description,int id
     * @return   view
     */
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


    /**
     * Update is_delete feild in material table 
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array delete_id
     * @return   view
     */
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


    /**
     * Get the data of materials and pagination on material list
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return    view
     */
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


    /**
     * Get the data from material table and return it to the datatable
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
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
