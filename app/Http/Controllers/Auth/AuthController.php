<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use File;
use App\UserTemplate;
use App\Template;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/mytemplates';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'username' => 'required|unique:users|min:5',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
        ]);
        return $user;
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

    public function login(Request $request)
    {
         $v=$validator= Validator::make(
        [
            'email' => $request->email,
            'password' => $request->password
        ],
        [
            'email' => 'required',
            'password' => 'required'
        ]
        );

        $email=$request->email;
        $password=$request->password;

       if($v->fails())
       {
            return redirect()->back()->withErrors($v->errors());
       }

       $session_id = Session::getId();
       
       if (Auth::attempt(['email' => $email, 'password' => $password, 'is_delete' => 0]) OR Auth::attempt(['username' => $email, 'password' => $password, 'is_delete' => 0]))
        {   
            $user_id = Auth::user()->id;
            $username = Auth::user()->username;
            $check = UserTemplate::where('session_id', $session_id)->get(); 
            
            if($check)
            {
                $path = public_path()."/images/".$username;
                
                if(!File::exists($path))
                { 
                    File::makeDirectory($path);
                }   
               
                $files = glob(public_path()."/images/".$session_id."/*");   
               
                foreach($files as $file)
                {   
                    $file_to_go = str_replace(public_path()."/images/".$session_id."/",public_path()."/images/".$username."/",$file);         
                    copy($file, $file_to_go);
                    @unlink($file);   
                }
                rmdir(public_path()."/images/".$session_id);
                foreach ($check as $value) {

                    $url = AuthController::get_unique_url($value->template_id, $user_id);
                    UserTemplate::where('id', $value->id)->update(['url' => $url]);
                }
                

            }
            UserTemplate::where('session_id', $session_id)->update(['user_id' => $user_id]);
            Session::flash('flash_message','Successfully Login');
            return redirect('/mytemplates');
        }
        else
        {
            Session::flash('flash_message','Wrong Email or Password..');
            return redirect('login');   
        }
    }
}
