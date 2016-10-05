<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;   
use App\UserTemplate;
use App\Order;
use App\OrderItem;
use App\Material;


class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function order_multiple_cards($url)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $username = $user->username;

        $directory = public_path().'/temp/'.$username;
        $files = scandir($directory);
        $quantity = count($files)-2;

        $card_price = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();

        $material_price = Material::where('id','1')->first();

        $amount = $card_price->price * $material_price->price * $quantity; 

        $count = Order::get();
        if(count($count) == 0)
        {
            $order_no = '000001';
        }
        else
        {
            $order = Order::orderBy('id','desc')->first();
            $order->order_no = $order->order_no + 1;

            $count = (string) $order->order_no;
            
            if(strlen($count) == 1)
            {
                $order_no = '00000'.$count; 
            }
            if(strlen($count) == 2)
            {
                $order_no = '0000'.$count; 
            }
            if(strlen($count) == 3)
            {
                $order_no = '000'.$count; 
            }
            if(strlen($count) == 4)
            {
                $order_no = '00'.$count; 
            }
            if(strlen($count) == 5)
            {
                $order_no = '0'.$count; 
            }
            if(strlen($count) == 6)
            {
                $order_no = $count; 
            }
        }
            
        Order::create([
                'user_id' => $user_id,
                'material_id' => '1',
                'amount' => $amount,
                'quantity' => $quantity,
                'order_no' => $order_no,
                'status' => 'new'
        ]);

        $directory = public_path().'/temp/'.$username.'/';
        $images = scandir(public_path().'/temp/'.$username.'/');

        $order_id = Order::where('order_no',$order_no)->first();

        foreach($images as $image)
        {   
            unset($images[0]);
            unset($images[1]);

            if($image=="." || $image=="..")
            { 
                //this will not display specified files
            }
            else
            {
                OrderItem::create([
                    'order_id' => $order_id->id,
                    'front_snap' => $image
                ]);
            }
        }

        dd($directory);
    }

}
