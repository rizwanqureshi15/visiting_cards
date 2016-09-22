<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;	
use Session;
use Redirect;
use App\User;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use File;
use App\Template;
use App\UserCard;
use Response;
use Config;
use App\Category;
use Excel;
use App\UserTemplate;
use App\UserTemplateFeild;
use App\UserTemplateImage;
use App\TemplateImage;
use App\TemplateFeild;


class TemplatesController extends Controller
{
    //
    public function __construct()
    {
    }


    public function save_image(Request $request)
    {
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/images/'.$username;   
        
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 
        file_put_contents('images/'. $username .'/'.$name.'.png', $data);

        $user_id = Auth::user()->id;

        UserCard::create(array(
            'image' => $name.'.png',
            'user_id' => $user_id
            ));

    }
    

    public function index()
    {
        $data['templates'] = Template::where('is_delete',0)->orderBy('created_at','desc')->take(Config::get('settings.number_of_items'))->get(); 
        $data['categories'] = Category::get();
        
        return view('gallery',$data);
    }


    public function ajax_templates(Request $request)
    {
        $templates = Template::orderBy('created_at','desc')
                                ->skip($request->page_no*Config::get('settings.number_of_items'))
                                ->take(Config::get('settings.number_of_items'));

        if($request->orientations)
        {
            $templates->whereIn('type', $request->orientations);
        }

        if($request->category)
        {
            $templates->whereIn('category_id', $request->category);
        }

        $data = $templates->get();
        return response()->json($data);

    }


    public function get_template($url)
    {

                $data['template'] = Template::where('is_delete', 0)->where('url', $url)->first();
                $data['feilds'] = TemplateFeild::where('template_id',$data['template']->id)->get();
                
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

                $data['feilds'] = TemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = TemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['image_css'] = TemplateFeild::where('template_id', $data['template']->id)->whereIn('id', $imageids)->get();
               
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

                $data['field_names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;

        return view('user.templates.create',$data);
    }


    public function filter_ajax(Request $request)
    {
        $filtered_templates = Template::orderBy('created_at','desc')
                                        ->take(Config::get('settings.number_of_items'));

        if($request->orientations)
        {
            $filtered_templates->whereIn('type', $request->orientations);
        }

        if($request->category)
        {
            $filtered_templates->whereIn('category_id', $request->category);
        }

        $data = $filtered_templates->get();
        return response()->json($data);

    }
    public function get_unique_url($template_id,$user_id)
    {
        $c = userTemplate::where('template_id',$template_id)->where('user_id',$user_id)->count();
        $url = template::where('id', $template_id)->pluck('url');
        if($c > 0)
        {
            $url = $url[0] ."-". $c;

        }
        else
        {
            $url = $url[0];
        }
        return $url;
    }
    public function save_user_template(Request $request)
    { 
        
        $template =  Template::where('id',$request->template_id)->first();
         
         $user_id=Auth::user()->id;
         
         $url = TemplatesController::get_unique_url($request->template_id, $user_id);
            
        $user_fields=array(
                'name' => $template->name,
                'template_id' => $template->id,
                'background_image' => $template->background_image,
                'url' => $url,
                'type' => $template->type,
                'user_id' => $user_id,
                'snap'=> $request->snap,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i')
        );

        $user_template_id = userTemplate::insertGetId($user_fields);
        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $feild["template_id"] = $user_template_id; 
                $feild["user_id"] = $user_id;
                UserTemplateFeild::create($feild);    
            }
        }

        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $label["template_id"] = $user_template_id; 
                $label["user_id"] = $user_id;
                $label["is_label"] = 1;
                UserTemplateFeild::create($label);    
            }
        }

       
       if($request->images)
       {
            foreach ($request->images as $image) {

               $id =  UserTemplateFeild::insertGetId(['user_id' => $user_id,'template_id' => $user_template_id,'css' => $image['div_css'], 'font_css' => $image['css'], 'created_at' => date('Y-m-d H:s:i'), 'updated_at' => date('Y-m-d H:s:i')]);

                $image_data = TemplateImage::where('template_feild_id', $image['id'])->first();   
                UserTemplateImage::create([ 'src' => $image_data->src, 'template_feild_id' => $id]);
                 
           }
        }
            
     
       return json_encode("Template is Saved..!");



    }

    public function show_user_gallery()
    {
        $user = Auth::user();
        $data['username'] = $user->username;
        
        $data['user_cards'] = UserTemplate::where('user_id',$user->id)->orderBy('created_at','desc')->take(Config::get('settings.number_of_items'))->get(); 
        if(count($data['user_cards'])==0)
        {
            $data['user_cards'] = false;
        }
        return view('user.templates.list',$data);
    }


    public function show_user_template($url)
    {

        $data['template'] = UserTemplate::where('url',$url)->first(); 
        $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->get();
        $data['images'] = UserTemplateImage::where('template_id', $data['template']->id)->get();
        $field_names = array();
        foreach($data['feilds'] as $names)
        {
            array_push($field_names, $names->name);
        }
        $template_images = array();
         foreach($data['images'] as $names)
        {
            array_push($template_images, $names->name);
        }
        $data['field_names']= json_encode($field_names);

        $data['template_images']=json_encode($template_images);

        return view('user.templates.create',$data);
    }

    public function edit_user_template($url)
    {
        $data['template'] = UserTemplate::where('is_delete', 0)->where('url', $url)->first();
                $data['feilds'] = userTemplateFeild::where('template_id',$data['template']->id)->get();
                
                $ids = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',1)->get();

                $data['image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereIn('id', $imageids)->get();
               
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

                $data['field_names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;   
        return view('user.templates.edit',$data);
    }
    
    public function edit_user_template_post(Request $request)
    { 

        $template =  Template::where('id',$request->template_id)->first();
         
         $user_id=Auth::user()->id;
       
            
        $user_fields=array(
            
                'snap'=> $request->snap,
        );

        userTemplate::where('id', $request->template_id)->update($user_fields);
        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $exists = UserTemplateFeild::where('template_id',$request->template_id)->where('name',trim($feild['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('template_id',$request->template_id)->where('name',trim($feild['name']))->update(['css' => $feild['css'], 'font_css' => $feild['font_css']]);
                }
                else
                {
                    $feild['template_id'] = $request->template_id;
                    UserTemplateFeild::create($feild);
                } 
            }
        }
        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $exists = UserTemplateFeild::where('template_id',$request->template_id)->where('name',trim($label['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('template_id',$request->template_id)->where('name',trim($label['name']))->update(['css' => $label['css'], 'font_css' => $label['font_css']]);
                }
                else
                {
                    $label['template_id'] = $request->template_id;
                    $label['is_label'] = 1;
                    UserTemplateFeild::create($label);
                } 
        }
    }
        if($request->deleted_feilds)
        {
            foreach ($request->deleted_feilds as  $feild) {
                UserTemplateFeild::where('template_id', $request->template_id)->where('name', trim($feild))->delete();
            }

        }
       

        if($request->deleted_labels)
        {
            foreach ($request->deleted_labels as  $label) {
                UserTemplateFeild::where('name',trim($label))->where('is_label',1)->where('template_id',$request->template_id)->delete();
            }

        }

         if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {

                    $image_name = UserTemplateImage::where('template_feild_id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    UserTemplateImage::where('template_feild_id',$value)->delete();
                    userTemplateFeild::where('id',$value)->delete();
                }
            }
       
       if($request->images)
       {
           foreach ($request->images as $image) {
            UserTemplateFeild::where('id', $image['id'])->update(['css' => $image['div_css'], 'font_css' => $image['css']]);
            }
        }
            
     
       return json_encode("Template is Edited..!");

    

    }

    public function delete_user_template($url)
    {
        $user_template = UserTemplate::where('url', $url)->where('user_id', Auth::user()->id)->first();
        $username = Auth::user()->username;

        @unlink(public_path("images\\".$username."\\".$user_template->snap));
        $feilds = UserTemplateFeild::where('template_id', $user_template->id)->get();
        $ids = array();
        foreach ($feilds as $value) {
            array_push($ids, $value->id); 
        }
        UserTemplateImage::whereIn('template_Feild_id', $ids)->delete();
        UserTemplateFeild::where('template_id', $user_template->id)->delete();
        UserTemplate::where('id', $user_template->id)->delete();
        return Redirect()->back();
    }

    public function create_single_card($url)
    {

                $data['template'] = UserTemplate::where('is_delete', 0)->where('url', $url)->first();
                $data['feilds'] = userTemplateFeild::where('template_id',$data['template']->id)->get();
                
                $ids = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereNotIn('id', $imageids)->where('is_label',1)->get();

                $data['image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->whereIn('id', $imageids)->get();
               
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

                $data['field_names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;
             
        return view('user.cards.single_card_create',$data);
    }

    public function save_card(Request $request)
    
    {
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/images/'.$username;   
        
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 
        file_put_contents('images/'. $username .'/'.$name.'.png', $data);

        $user_id = Auth::user()->id;

        $save = UserCard::create(array(
            'image' => $name.'.png',
            'user_id' => $user_id
            ));

        Session::flash('flash_message','Card successfully saved');
        return response()->json($save);
    }


    public function show_multiple_cards($url)
    {
        $user_id = Auth::user()->id;

        $data['template_url'] = array($url);

        $template_id = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();
        
        $feilds = UserTemplateFeild::where('template_id',$template_id->id)->get();
       
        $user_template_ids = array();
        foreach ($feilds as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $image_feilds = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();
        
        $image_feilds_ids = array();
        foreach ($image_feilds as $feild) {
            $image_feilds_ids[] = $feild->template_feild_id;
        }

        $data['image_feilds_name'] = UserTemplateFeild::whereIn('id',$image_feilds_ids)->get();

        return view('multiple_cards',$data);
    }


    public function download_excel_file($url)
    {
        $user_id = Auth::user()->id;
        $user_template_id = UserTemplate::where('url',$url)->where('user_id',$user_id)->lists('id');
        
        $data = UserTemplateFeild::where('template_id',$user_template_id)->pluck('name'); 

        return Excel::create($url, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function upload_excel_file(Request $request,$url)
    {
        $v = Validator::make([
                'excel_file' => $request->excel_file
            ],
            [
                'excel_file' => 'required'
            ]);
        
        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $username=Auth::user()->username;
        $user_id = Auth::user()->id;

        $data['template_data'] = UserTemplate::where('url',$url)->where('user_id',$user_id)->get();
        
        $data['feilds'] = UserTemplateFeild::where('template_id',$data['template_data'][0]->id)->where('user_id',$user_id)->get();
        
        $user_template_ids = array();
        foreach ($data['feilds'] as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $data['images'] = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();
                 
        $imageids = array();
        foreach ($data['images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }
        
        $data['feilds'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->whereNotIn('id', $imageids)->get();
              
        $data['image_css'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->whereIn('id', $imageids)->get();
      
        
        $template_images = array();

        foreach($data['image_css'] as $image)
        {
            array_push($template_images, $image->id);
        }
        $data['template_images'] = $template_images;
        
        $image_feilds_name = UserTemplateFeild::whereIn('id',$imageids)->lists('name');

        $image_name = UserTemplateFeild::whereIn('id',$imageids)->lists('id','name');
       
        // Getting File Headers 
            $filename = $request->excel_file->getClientOriginalName();
            //$upload_success = $request->excel_file->move('excelfiles/', $filename);
           
            $file_headers = Excel::load('excelfiles/'.$filename, function($reader) { 

            })->first(); 

            $header_names = array();
            foreach($file_headers as $key => $header)
            {
                array_push($header_names, $key);
            }
        //End Getting Headers

        //Get name of database feilds
            $feilds_name = UserTemplateFeild::whereIn('id',$user_template_ids)->get();
            
            $feild_names = array();
            foreach($feilds_name as $name)
            {
                array_push($feild_names,$name->name);
            }
        //End getting

        //Comparing Feilds
            $feild_names = array_map('strtolower', $feild_names);
            $header_names = array_map('strtolower', $header_names);

            $new_feild_names = array();
            foreach ($feild_names as $value) 
            {
                $new_val = str_replace(' ', '_', $value);
                array_push($new_feild_names,$new_val);
            }

            if($new_feild_names != array_intersect($new_feild_names, $header_names)) {
                Session::flash('flash_message','Please upload proper file');
                return redirect()->back();
            } 
        //End Comparing
    
        $data['image_feilds_name'] = $image_name;
        $path = public_path().'/user/'.$username;
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        }

        foreach ($image_feilds_name as $name) 
        {
            $path = public_path().'/user/'.$username.'/'.$name;   

            if(!File::exists($path))
            { 
                File::makeDirectory($path);
            } 

            $files = $request->file($name);
            
            foreach($files as $file)
            {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').$filename;
                $destinationPath = public_path().'/user/'.$username.'/'.$name; 
                $file->move($destinationPath, $picture);
            }
        }

        $data['main_folder'] = public_path().'/user/'.$username;

        $data['image_feilds_name_folders'] = $image_feilds_name;

        $filename = $request->excel_file->getClientOriginalName();
        $upload_success = $request->excel_file->move('excelfiles/', $filename);
        
        
        $data['cards_data'] = Excel::load('excelfiles/'.$filename, function($reader) { 

        })->get(); 



        //$data['cards_data'] = json_encode($data['cards_data']);

        return view('list_multiple_cards_preview',$data);
    }

    public function multiple_image_save(Request $request)
    {
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/temp/'.$username;   
        
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 
        file_put_contents('temp/'. $username .'/'.$name.'.png', $data);

        
        return json_encode($name.".png");
    }


}