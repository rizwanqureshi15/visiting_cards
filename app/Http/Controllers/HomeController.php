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
use App\Faq;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function index()
    {
        return view('home');
    }


    public function ajax_user_images(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_cards = UserTemplate::where('user_id',$user_id)
                            ->orderBy('created_at','desc')
                            ->skip($request->page_no * Config::get('settings.number_of_items'))
                            ->take(Config::get('settings.number_of_items'))
                            ->get();

        return response()->json($user_cards);
    }

    public function show_terms_condition()
    {
        return view('terms_condition');
    }

    public function show_faqs()
    {
        $data['faqs'] = Faq::where('is_delete',0)->paginate(Config::get('settings.number_of_rows'));
        
        return view('faqs', $data);
    }

    public function show_privacy_policy()
    {
        return view('privacy_policy');
    }

    public function show_about()
    {
        return view('about');
    }

}
