<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


/**
 * Handles user's basic functanilities
 *
 * @package   UserController
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class UserController extends Controller
{
    //
    public function __construct()
    {
    }


    /**
     * Show user's profile page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function edit_profile(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }

        $user = Auth::user();
        
        return View::make('auth.profile')->with('user', $user);
    }


    /**
     * Validate the form
     * Update values of user's profile
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array first_name,last_name
     * @return   view
     */
    public function change_profile(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }

        $user_id = Auth::user()->id;

        $v = $validator=Validator::make([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ],
            [
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $data = array(
                    'first_name' =>  $request->first_name,
                    'last_name' => $request->last_name
                );

        if($request->image)
        {
            $file = Input::file('image');
            $destinationPath = public_path().'/images';
            $extension = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName); 

            $data['image'] = $fileName;
        }

            $value = User::where('id', $user_id)->update($data);
            Session::flash('flash_message','Successfully Changed');
            return redirect('profile');
        
    }


    /**
     * Check username is exist or not
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array username
     * @return   json username
     */
    public function check_username(Request $request)
    {
        $username = User::where('username', $request->username)->first();
        return response()->json($username);
    }


    /**
     * Show change password page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_change_password()
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }
        return view('auth.change_password');
    }


    /**
     * Update the value of user's password in user table
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array password,password_confirmation
     * @return   view
     */
    public function change_password(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }

        $user_id = Auth::user()->id;
        $v = Validator::make([
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation
            ],
            [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            ]);

        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $password = bcrypt($request['password']);

        User::where('id',$user_id)
            ->update(array(
                'password' =>  $password
                ));

        Session::flash('flash_message','Password successfully changed.');
        return redirect('/');

    }


    /**
     * Save snap of template
     * Put the image in folder
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image
     * @return   json image
     */    
    public function save_image(Request $request)
    {
        if(Auth::user())
        {
            $username = Auth::user()->username;    
        }
        else
        {
            $username = Session::getId();
        }
        

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
    

        return response()->json($name.'.png');
    }


    /**
     * Ajax pagination on user's card images show page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array page_no
     * @return   json usercards
     */
    public function user_image_pagination(Request $request)
    {
        $user_id=Auth::user()->id;
        $user_cards=UserCard::where('user_id',$user_id)->orderBy('created_at','desc')->skip($request->page_no*9)->take(9)->get();
        return response()->json($user_cards);
    }
}
