<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use Session;
use App\UserTemplate;
use File;
use App\AuthController;
use App\Template;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function get_unique_url($template_id,$user_id)
    {
        $c = UserTemplate::where('template_id',$template_id)->where('user_id',$user_id)->count();
        $url = Template::where('id', $template_id)->pluck('url');
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

    public function boot()
    {
        User::created(function ($user) {
            $session_id = Session::getId();
        $user_id = $user->id;
        $username = $user->username;
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
            @rmdir(public_path()."/images/".$session_id);
            foreach ($check as $value) {
                $url = AppServiceProvider::get_unique_url($value->template_id, $user_id);
                UserTemplate::where('id', $value->id)->update(['url' => $url]);
            }
        }
        UserTemplate::where('session_id', $session_id)->update(['user_id' => $user_id]);
        Session::flash('flash_message','Successfully Register');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
