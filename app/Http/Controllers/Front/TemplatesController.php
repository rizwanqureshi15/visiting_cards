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

}
