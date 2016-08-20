<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Template;
use App\TemplateFeild;
use View;
use App\UserCard;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function index()
    {
        $user = Auth::user();
        $data['username'] = $user->username;
        $data['user_cards'] = UserCard::where('user_id',$user->id)->orderBy('created_at','desc')->take(9)->get(); 
        return view('home',$data);
    }


    public function ajax_user_images(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_cards = UserCard::where('user_id',$user_id)
                            ->orderBy('created_at','desc')
                            ->skip($request->page_no*9)
                            ->take(9)
                            ->get();

        return response()->json($user_cards);
    }

}
