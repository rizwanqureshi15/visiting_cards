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
use App\TemplateFeild;
use App\Category;
use Illuminate\Support\Facades\Input;
use File;
use App\TemplateImage;

class CardController extends Controller
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

    public function card_display($name)
    {
        if(CardController::authenticate_admin())
        {

                $data['templates'] = Template::where('is_delete', 0)->where('url', $name)->first();
                $data['feilds'] = TemplateFeild::where('template_id',$data['templates']->id)->get();
                $data['images'] = TemplateImage::where('template_id',$data['templates']->id)->get();

                
                $names = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($names, $feild->name);
                }
                $template_images = array();

                foreach($data['images'] as $image)
                {
                  array_push($template_images, $image->id);
                }

                $data['names']= json_encode($names);
                $data['template_images'] = $template_images;
                
                return view('admin.cards.create', $data);

        }
        else
        {
                return redirect()->back();
        }
        
    }


    public function card_save(Request $request)
    {
        if(CardController::authenticate_admin())
        {
           
            $feild_names = TemplateFeild::where('template_id', $request->template_id)->pluck('name','id');
           
            foreach ($request->feilds as $feild) {

                $update = 0;
                $feild['template_id'] = $request->template_id;
                 foreach ($feild_names as $key => $value) {
                        if($value == $feild['name'])
                        {
                            $id = $key;
                            $update = 1;

                        }
                }
                if($update == 1)
                {
                     TemplateFeild::where('id', $id)->update($feild);
                }
                else
                {
                    TemplateFeild::create($feild);
                }
               
            }
            if($request->images!=null)
            {
                foreach ($request->images as $image) {

                    TemplateImage::where('id',$image['id'])->update(['css' => $image['css'], 'div_css' => $image['div_css']]);
                }
            }
            if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {
                    $image_name = TemplateImage::where('id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    TemplateImage::where('id',$value)->delete();
                }
            }
            if($request->deleted_feilds!=null)
            {
                foreach ($request->deleted_feilds as $value) {
                    TemplateFeild::where('name',$value)->where('template_id',$request->template_id)->delete();
                }
            }
            $image = Template::where('id', $request->template_id)->pluck('snap');
            Template::where('id', $request->template_id)->update(["snap" => $request->snap]);
            @unlink(public_path("templates/snaps/".$image[0]));
    
            return json_encode("Successfully Saved..!");
              
        }
        else
        {
                return redirect()->back();
        }
        
    }
     public function save_image(Request $request)
    {

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $name = str_random(40);
            $path = public_path() .'/templates/snaps';   

            if(!File::exists($path))
            { 
                File::makeDirectory($path);
            } 
            file_put_contents($path .'/'. $name .'.png', $data);  
      
        return json_encode($name .'.png');

    }
        public function upload_image(Request $request)
        {
          

            $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $name = str_random(40);
            $path = public_path() .'/templates/images';   
            
            if(!File::exists($path))
            { 
                File::makeDirectory($path);
            } 
            file_put_contents($path .'/'. $name .'.png', $data);
            
           $image_id = TemplateImage::insertGetId(['src' => $name.'.png','css'=> $request->css ,'div_css' => $request->div_css, 'template_id' => $request->template_id]);
            
            return json_encode(['name' => $name .'.png','id' => $image_id]);

        }
    
   
}