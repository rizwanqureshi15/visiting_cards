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
use App\Objects;

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
                $data['feilds'] = TemplateFeild::where('template_id',$data['templates']->id)->where('is_back',0)->get();
                
                $ids = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['images'] = TemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['feilds'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['image_css'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',0)->whereIn('id', $imageids)->get();
               
                $names = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($names, $feild->name);
                }

                $labels = array();
                foreach($data['labels'] as $label)
                {
                  array_push($labels, $label->name);
                }

                $template_images = array();
                foreach($data['image_css'] as $image)
                {
                  array_push($template_images, $image->id);
                }

                $data['names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;


                $data['back_feilds'] = TemplateFeild::where('template_id',$data['templates']->id)->where('is_back',1)->get();
                
                $ids = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['back_images'] = TemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['back_images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['back_feilds'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['back_labels'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['back_image_css'] = TemplateFeild::where('template_id', $data['templates']->id)->where('is_back',1)->whereIn('id', $imageids)->get();
               
                $back_names = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($back_names, $feild->name);
                }

                $back_labels = array();
                foreach($data['back_labels'] as $label)
                {
                  array_push($back_labels, $label->name);
                }

                $back_template_images = array();
                foreach($data['back_image_css'] as $image)
                {
                  array_push($back_template_images, $image->id);
                }

                $data['back_names'] = $back_names;
                $data['back_template_images'] = $back_template_images;
                $data['back_template_labels'] = $back_labels;
                $data['objects'] = Objects::where('is_back',0)->where('template_id',$data['templates']->id)->get();
                $data['circles'] = Objects::where('type','circle')->where('is_back',0)->where('template_id',$data['templates']->id)->pluck('name');
                $data['lines'] = Objects::where('type','line')->where('is_back',0)->where('template_id',$data['templates']->id)->pluck('name');
                $data['squares'] = Objects::where('type','square')->where('is_back',0)->where('template_id',$data['templates']->id)->pluck('name');
                $data['back_objects'] = Objects::where('is_back',1)->where('template_id',$data['templates']->id)->get();
                $data['back_circles'] = Objects::where('type','circle')->where('is_back',1)->where('template_id',$data['templates']->id)->pluck('name');
                $data['back_lines'] = Objects::where('type','line')->where('is_back',1)->where('template_id',$data['templates']->id)->pluck('name');
                $data['back_squares'] = Objects::where('type','square')->where('is_back',1)->where('template_id',$data['templates']->id)->pluck('name');
                
                if($data['templates']->is_both_side == 1)
                {
                    return view('admin.cards.create', $data);
                }
                else
                {
                    return view('admin.cards.one_side_create', $data);
                }

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
           
            $feild_names = TemplateFeild::where('is_back',0)->where('template_id', $request->template_id)->where('is_label', 0)->pluck('name','id');
         if($request->feilds)
         {  
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
        }

             $label_names = TemplateFeild::where('is_back',0)->where('template_id', $request->template_id)->where('is_label', 1)->pluck('name','id');
           if($request->labels)
           {
                foreach ($request->labels as $label) {

                    $update = 0;
                    $label['template_id'] = $request->template_id;
                    $label['is_label'] = 1;
                     foreach ($label_names as $key => $value) {
                            if($value == $label['name'])
                            {
                                $id = $key;
                                $update = 1;

                            }
                    }
                    if($update == 1)
                    {
                         TemplateFeild::where('id', $id)->update($label);
                    }
                    else
                    {
                        TemplateFeild::create($label);
                    }
                   
                }
            }

        $circle_names = Objects::where('is_back',0)->where('type', 'circle')->where('template_id', $request->template_id)->pluck('name');
         if($request->circle_object)
         {  
            foreach ($request->circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $request->template_id;
                 foreach ($circle_names as $key => $value) {

                        if($value == $circle['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $circle['name'])->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 0;
                    Objects::create($circle);
                }
               
            }
        }


        $square_names = Objects::where('is_back',0)->where('type', 'square')->where('template_id', $request->template_id)->pluck('name');
         if($request->square_object)
         {  
            foreach ($request->square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $request->template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $square['name'])->update($square);
                }
                else
                {   
                    $square['is_back'] = 0;
                    Objects::create($square);
                }
               
            }
        }


        $line_names = Objects::where('is_back',0)->where('type', 'line')->where('template_id', $request->template_id)->pluck('name');
         if($request->line_object)
         {  
            foreach ($request->line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $request->template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $line['name'])->update($line);
                }
                else
                {   
                    $line['is_back'] = 0;
                    Objects::create($line);
                }
               
            }
        }

         if($request->deleted_line_object!=null)
            {
                foreach ($request->deleted_line_object as $value) {
                    Objects::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_circle_object!=null)
            {
                foreach ($request->deleted_circle_object as $value) {
                    Objects::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_square_object!=null)
            {
                foreach ($request->deleted_square_object as $value) {
                    Objects::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }

            if($request->deleted_labels!=null)
            {
                foreach ($request->deleted_labels as $value) {
                    TemplateFeild::where('name',$value)->where('is_label',1)->where('template_id',$request->template_id)->delete();
                }
            }
             
            if($request->images!=null)
            {
                foreach ($request->images as $image) {

                    TemplateFeild::where('id',$image['id'])->update(['css' => $image['div_css'], 'font_css' => $image['css']]);

                }
            }
            if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {

                    $image_name = TemplateImage::where('template_feild_id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    TemplateImage::where('template_feild_id',$value)->delete();
                    TemplateFeild::where('id',$value)->delete();
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
     public function back_card_save(Request $request)
    {   
        if(CardController::authenticate_admin())
        {
           
        $feild_names = TemplateFeild::where('is_back',1)->where('template_id', $request->template_id)->where('is_label', 0)->pluck('name','id');
         if($request->feilds)
         {  
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
                $feild['is_back'] = 1;
                if($update == 1)
                {
                     TemplateFeild::where('id', $id)->update($feild);
                }
                else
                {
                    TemplateFeild::create($feild);
                }
               
            }
        }

             $label_names = TemplateFeild::where('is_back',1)->where('template_id', $request->template_id)->where('is_label', 1)->pluck('name','id');
           if($request->labels)
           {
                foreach ($request->labels as $label) {

                    $update = 0;
                    $label['template_id'] = $request->template_id;
                    $label['is_label'] = 1;
                     foreach ($label_names as $key => $value) {
                            if($value == $label['name'])
                            {
                                $id = $key;
                                $update = 1;

                            }
                    }
                    $label['is_back'] = 1;
                    if($update == 1)
                    {
                         TemplateFeild::where('id', $id)->update($label);
                    }
                    else
                    {
                        TemplateFeild::create($label);
                    }
                   
                }
            }

            $circle_names = Objects::where('is_back',1)->where('type', 'circle')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_circle_object)
         {  
            foreach ($request->back_circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $request->template_id;
                 foreach ($circle_names as $key => $value) {

                        if($value == $circle['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $circle['name'])->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 1;
                    Objects::create($circle);
                }
               
            }
        }


        $square_names = Objects::where('is_back',1)->where('type', 'square')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_square_object)
         {  
            foreach ($request->back_square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $request->template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $square['name'])->update($square);
                }
                else
                {   
                    $square['is_back'] = 1;
                    Objects::create($square);
                }
               
            }
        }


        $line_names = Objects::where('is_back',1)->where('type', 'line')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_line_object)
         {  
            foreach ($request->back_line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $request->template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = Objects::where('name', $line['name'])->update($line);
                }
                else
                {   
                    $line['is_back'] = 1;
                    Objects::create($line);
                }
               
            }
        }

        if($request->deleted_line_object!=null)
            {
                foreach ($request->deleted_line_object as $value) {
                    Objects::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_circle_object!=null)
            {
                foreach ($request->deleted_circle_object as $value) {
                    Objects::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_square_object!=null)
            {
                foreach ($request->deleted_square_object as $value) {
                    Objects::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_labels!=null)
            {
                foreach ($request->deleted_labels as $value) {
                    TemplateFeild::where('is_back',1)->where('name',$value)->where('is_label',1)->where('template_id',$request->template_id)->delete();
                }
            }
             
            if($request->images!=null)
            {
                foreach ($request->images as $image) {

                    TemplateFeild::where('id',$image['id'])->update(['css' => $image['div_css'], 'font_css' => $image['css']]);

                }
            }
            if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {
                    
                    $image_name = TemplateImage::where('template_feild_id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    TemplateImage::where('template_feild_id',$value)->delete();
                    TemplateFeild::where('id',$value)->delete();
                }
            }
            if($request->deleted_feilds!=null)
            {
                foreach ($request->deleted_feilds as $value) {
                    TemplateFeild::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            $image = Template::where('id', $request->template_id)->pluck('back_snap');
            Template::where('id', $request->template_id)->update(["back_snap" => $request->snap]);
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

    public function upload_normal_image(Request $request)
    {
        
        $imageTempName = $request->file('image')->getPathname(); 
        $name = str_random(40);
        $path = public_path() .'/templates/images';
        $request->file('image')->move($path , $name.".png");
         $feild_id = TemplateFeild::insertGetId(['name' => $request->name, 'css' => $request->div_css, 'font_css' => $request->css, 'template_id' => $request->template_id,'is_back' => $request->is_back, 'created_at' => date('Y-m-d H:s:i'),'updated_at' => date('Y-m-d H:s:i')]);

            $image_id = TemplateImage::insertGetId(['src' => $name.'.png','template_feild_id' => $feild_id, 'created_at' => date('Y-m-d H:s:i'),'updated_at' => date('Y-m-d H:s:i')]);
            
        return json_encode(['name' => $name .'.png','image_id' => $image_id, 'id' => $feild_id]);

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
            
            $feild_id = TemplateFeild::insertGetId(['name' => $request->name, 'css' => $request->div_css, 'font_css' => $request->css, 'template_id' => $request->template_id,'is_back' => $request->is_back, 'created_at' => date('Y-m-d H:s:i'),'updated_at' => date('Y-m-d H:s:i')]);

           $image_id = TemplateImage::insertGetId(['src' => $name.'.png','template_feild_id' => $feild_id, 'created_at' => date('Y-m-d H:s:i'),'updated_at' => date('Y-m-d H:s:i')]);
            
            return json_encode(['name' => $name .'.png','image_id' => $image_id, 'id' => $feild_id]);

        }
    
   
}