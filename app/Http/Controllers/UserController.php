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


class UserController extends Controller
{
    //
    public function __construct()
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }
    }

    public function show_profile(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }

        $user_id=Auth::user()->id;
        $user=User::where('id',$user_id)->first();
        return View::make('auth.profile')->with('user',$user);
    }

    public function change_profile(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }
        $user_id=Auth::user()->id;
        $v=$validator=Validator::make([
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
            $destinationPath = public_path() .'\images';
            $extension = $file->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName); 

            $data['image'] = $fileName;
        }

            $value = User::where('id', $user_id)->update($data);
            Session::flash('flash_message','Successfully Changed');
            return redirect('profile');
        
    }

    public function check_username(Request $request)
    {
        $username=User::where('username', $request->username)->first();
        return response()->json($username);
    }

    public function show_change_password()
    {
         if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }
        return view('auth.change_password');
    }

    public function change_password(Request $request)
    {
        if(Auth::guest())
        {
            Session::flash('flash_message','Please Login First.');
            return redirect('login');
        }

        $user_id=Auth::user()->id;
        $v=$validator=Validator::make([
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
        $password=bcrypt($request['password']);

        User::where('id',$user_id)
            ->update(array(
                'password' =>  $password
                ));

        Session::flash('flash_message','Password successfully changed.');
        return redirect('/');

    }

    public function save_image(Request $request)
    {
        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $data1=file_put_contents('images/cards/'.$name.'.png', $data);

    }
}
