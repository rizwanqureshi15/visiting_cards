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
        $data['templates'] = Template::orderBy('created_at','desc')->take(Config::get('settings.number_of_items'))->get(); 
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
        $data['template'] = Template::with('template_feilds')->where('url',$url)->first(); 
        
        $field_names = array();
        foreach($data['template']->template_feilds as $names)
        {
            array_push($field_names, $names->name);
        }

        $data['field_names']= json_encode($field_names);

        return view('show_cards',$data);
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

    public function save_user_template(Request $request)
    { dd($request->all());
        $template = Template::where('id',$request->template_id)->first();
        $user_id=Auth::user()->id;

        $user_fields=array(
                'name' => $template->name,
                'template_id' => $template->id,
                'background_image' => $template->background_image,
                'url' => $template->url,
                'type' => $template->type,
                'user_id' => $user_id
        );

        $username=Auth::user()->username;

        $image = UserTemplate::where('template_id', $request->template_id)->pluck('snap');
            //where('template_id', $request->template_id)->update(["snap" => $request->snap['image']]);
        

        $user_fields['snap'] = $request->snap['image'];

        UserTemplate::create($user_fields);
        @unlink(public_path('images\\'. $username .'\\'.$image[0]));

        
        $feild_names = UserTemplateFeild::where('template_id', $template->id)->pluck('name','id');

            foreach ($request->feilds as $feild) 
            {
                $update = 0;
                $feild['user_id'] = $user_id;
                $feild['template_id'] = $template->id;
                 foreach ($feild_names as $key => $value) {
                        if($value == $feild['name'])
                        {
                            $id = $key;
                            $update = 1;

                        }
                }
                if($update == 1)
                {
                     UserTemplateFeild::where('id', $id)->update($feild);
                }
                else
                {
                    UserTemplateFeild::create($feild);
                }
               
            }

            if($request->deleted_feilds != null)
            {
                foreach ($request->deleted_feilds as $value) 
                {
                    UserTemplateFeild::where('name',$value)->where('template_id',$request->template_id)->delete();
                }
            }
            
            Session::flash('flash_message','Card successfully saved');
            return response()->json($image); 
    }

    public function show_user_gallery()
    {
        $user = Auth::user();
        $data['username'] = $user->username;
        $data['user_cards'] = UserTemplate::where('user_id',$user->id)->orderBy('created_at','desc')->take(Config::get('settings.number_of_items'))->get(); 

        return view('user_template_images',$data);
    }


    public function show_user_template($url)
    {
        $data['user_template'] = UserTemplate::with('user_template_feilds')->where('url',$url)->first(); 
        dd($data);
        $field_names = array();
        foreach($data['user_template']->template_feilds as $names)
        {
            array_push($field_names, $names->name);
        }

        $data['field_names']= json_encode($field_names);

        dd($data);
        return view('show_cards',$data);
    }


}