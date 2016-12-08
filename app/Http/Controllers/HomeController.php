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


/**
 * This class show category,material list on home page
 * This class shows about us,terms and conditions,FAQ,privacy and policy,contact us page
 *
 * @package   HomeController
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Get the data of categories and materials and shows on home page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function index()
    {
        $data['categories'] = Category::where('is_delete',0)->paginate(Config::get('settings.number_of_categories'));
        $data['materials'] = Material::where('is_delete',0)->paginate(Config::get('settings.number_of_materials'));

        return view('welcome',$data);
    }

    /**
     * Ajax pagination on user's template images
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int page_no
     * @return   json User Template
     */
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


    /**
     * Show terms and condition page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_terms_condition()
    {
        return view('terms_condition');
    }


    /**
     * Get the data of FAQ and show FAQ page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_faqs()
    {
        $data['faqs'] = Faq::where('is_delete',0)->paginate(Config::get('settings.number_of_rows'));
        
        return view('faqs', $data);
    }


    /**
     * Show privacy and policy page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_privacy_policy()
    {
        return view('privacy_policy');
    }


    /**
     * Show about us page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_about()
    {
        return view('about');
    }


    /**
     * Showcontact us page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_contact_page()
    {
        return view('contact');
    }


    /**
     * Validate the form and stores the data in to database
     * Send Contact us email on behalf of user to admin
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
      * $param   array name,email,subject,content
     * @return   view
     */
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
