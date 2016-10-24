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
use App\Contact;
use Validator;
use Session;
use Mail;
use App\Category;
use App\Material;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
        $data['categories'] = Category::where('is_delete',0)->paginate(Config::get('settings.number_of_categories'));

        $data['materials'] = Material::where('is_delete',0)->paginate(Config::get('settings.number_of_materials'));

        return view('welcome',$data);
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


    public function show_contact_page()
    {
        return view('contact');
    }


    public function submit_contact(Request $request)
    {
        $v=$validator= Validator::make(
        [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->content
        ],
        [
            'email' => 'email|required',
            'name' => 'required',
            'subject' => 'required',
            'content' => 'required'
        ]
        );

        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $data['contact'] = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->content
        ]); 

        $contact = $data['contact'];
        
        Mail::send('contact_email', $data , function ($m) use ($contact) 
        {
            $m->to(Config::get('settings.admin_email'),'Admin')->subject($contact->subject);
        });

       Session::flash('flash_message','Your email successfuly sent');
       return redirect('contact');
    }

}
