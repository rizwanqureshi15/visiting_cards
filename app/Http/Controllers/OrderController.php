<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;   
use App\UserTemplate;
use App\Order;
use App\OrderItem;
use App\Material;
use File;
use Config;
use Session;


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

        $directory = public_path().'/temp/'.$username.'/front';
        $files = scandir($directory);
        $quantity = count($files)-2;

        $material_id = Session::get('material_id'); 

        $card_price = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();

        $template = $card_price;

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
                'material_id' => $material_id,
                'amount' => $amount,
                'quantity' => $quantity,
                'order_no' => $order_no,
                'user_template_id' => $template->id,
                'status' => 'new'
        ]);

        $front_images;
        $back_images;
        $order_id = Order::where('order_no',$order_no)->first();
        $front_images = scandir(public_path().'/temp/'.$username.'/front/');
        unset($front_images[0]);
        unset($front_images[1]);
        if($template->is_both_side == 0)
        {

            foreach($front_images as $image)
            {   
                unset($front_images[0]);
                unset($front_images[1]);

                OrderItem::create([
                        'order_id' => $order_id->id,
                        'front_snap' => $image
                    ]);
            }

        }
        else
        {
            $filecount;
            $back_images = scandir(public_path().'/temp/'.$username.'/back/');

            $filecount = count($front_images);

            for($i=1;$i<=$filecount;$i++)
            {
                OrderItem::create([
                        'order_id' => $order_id->id,
                        'front_snap' => $i.".png",
                        'back_snap' => $i.".png"
                    ]);
            }
        }
       
       
         $directory = public_path().'/order/'.$username;
            if(!File::exists($directory))
            {
                File::makeDirectory($directory);
            }

            $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

            if(!File::exists($directory))
            {
               File::makeDirectory($directory);
            }
            $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/front';
            if(!File::exists($directory))
            {
                File::makeDirectory($directory);
            }

            foreach($front_images as $image)
            {   
                $source = public_path().'/temp/'.$username.'/front/'.$image;
                $destination = $directory.'/'.$image;
                copy($source, $destination);
                @unlink($source);
            }
                

            if($template->is_both_side == 1)
            {
                $back_images = scandir(public_path().'/temp/'.$username.'/back/');
                unset($back_images[0]);
                unset($back_images[1]);
                $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/back';
                if(!File::exists($directory))
                {
                    File::makeDirectory($directory);
                }

                foreach($back_images as $image)
                {   
                    

                    $source = public_path().'/temp/'.$username.'/back/'.$image;
                    $destination = $directory.'/'.$image;

                    copy($source, $destination);
                    @unlink($source);
                }

            }

        // $front_images = scandir(public_path().'/temp/'.$username.'/front/');

        // $order_id = Order::where('order_no',$order_no)->first();

        // foreach($front_images as $image)
        // {   
        //     unset($front_images[0]);
        //     unset($front_images[1]);

        //     if($image=="." || $image=="..")
        //     { 
        //         //this will not display specified files
        //     }
        //     else
        //     {
        //         OrderItem::create([
        //             'order_id' => $order_id->id,
        //             'front_snap' => $image
        //         ]);

        //         $directory = public_path().'/order/'.$username;
        //         if(!File::exists($directory))
        //         {
        //             File::makeDirectory($directory);
        //         }

        //         $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

        //         if(!File::exists($directory))
        //         {
        //             File::makeDirectory($directory);
        //         }
        //         $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/front';
        //         if(!File::exists($directory))
        //         {
        //             File::makeDirectory($directory);
        //         }

        //         $source = public_path().'/temp/'.$username.'/front/'.$image;
        //         $destination = $directory.'/'.$image;

        //         copy($source, $destination);
        //         @unlink($source);
        //     }
        // }
        // rmdir(public_path().'/temp/'.$username.'/front');

        // $path = public_path().'/temp/'.$username.'/back';

        // if(File::exists($path))
        // {
        //     $back_images = scandir(public_path().'/temp/'.$username.'/back/');

        //     $order_id = Order::where('order_no',$order_no)->first();

        //     foreach($back_images as $image)
        //     {   
        //         unset($back_images[0]);
        //         unset($back_images[1]);

        //         if($image=="." || $image=="..")
        //         { 
        //             //this will not display specified files
        //         }
        //         else
        //         {
        //             OrderItem::where('order_id',$order_id->id)
        //                         ->update(['back_snap' => $image]);

        //             $directory = public_path().'/order/'.$username;

        //             if(!File::exists($directory))
        //             {
        //                 File::makeDirectory($directory);
        //             }

        //             $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

        //             if(!File::exists($directory))
        //             {
        //                 File::makeDirectory($directory);
        //             }

        //             $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/back';
        //             if(!File::exists($directory))
        //             {
        //                 File::makeDirectory($directory);
        //             }

        //             $source = public_path().'/temp/'.$username.'/back/'.$image;
        //             $destination = $directory.'/'.$image;

        //             copy($source, $destination);
        //             @unlink($source);
        //         }
        //     }
        //     rmdir(public_path().'/temp/'.$username.'/back');
        // }

            //site_url+'/order/'+order_no+'/payment'

        return redirect('/order/'.$order_no.'/payment');

    }


    public function show_user_order()
    {
        $user_id = Auth::user()->id;

        $data['user_orders'] = Order::where('user_id',$user_id)->orderBy('id','desc')->paginate(Config::get('settings.number_of_rows'));

        return view('user.show_order_list',$data);
    }


    public function view_user_order($order_id)
    {
        $username = Auth::user()->username;;

        $data['user_cards'] = OrderItem::where('order_id',$order_id)->take(Config::get('settings.number_of_cards'))->get();
        $user_order = Order::where('id',$order_id)->first(); 
        $data['order_no'] = $user_order->order_no;
        $data['username'] = $username;
        $data['is_back'] = false;

        $directory = public_path().'/order/'.$username.'/'.$user_order->order_no.'/back';

        if(File::exists($directory))
        {
            $data['user_cards'] = OrderItem::where('order_id',$order_id)->take(Config::get('settings.number_of_cards')/2)->get();
            $data['is_back'] = true;
        }

        return view('user.show_order',$data);

    }


    public function ajax_pagination(Request $request)
    {   
        $order = Order::where('order_no',$request->order_no)->first();

        if($request->is_back == true)
        {
            $order_items = OrderItem::where('order_id',$order->id)
                                ->skip($request->page_no*Config::get('settings.number_of_cards')/2)
                                ->take(Config::get('settings.number_of_cards')/2);
        }
        else
        {
            $order_items = OrderItem::where('order_id',$order->id)
                                ->skip($request->page_no*Config::get('settings.number_of_cards'))
                                ->take(Config::get('settings.number_of_cards'));
        }
        $data = $order_items->get();
        return response()->json($data);

    }

    public function order_single_card(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $username = $user->username;
        $order_no = "";

        $url = $request->url;

        $card_price = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();

        $template = $card_price;

        $material_price = Material::where('id','1')->first();

        $directory = public_path().'/temp/'.$username.'/front';
        $files = scandir($directory);
        $quantity = 1;

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

        $img = $request->image; 
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40).".png"; 

        $material_id = Session::get('material_id'); 

        if($template->is_both_side == 0)
        {
            $order = Order::create([
                'user_id' => $user_id,
                'material_id' => $material_id,
                'amount' => $amount,
                'quantity' => $quantity,
                'order_no' => $order_no,
                'user_template_id' => $template->id,
                'status' => 'new'
            ]);

            $order_id = Order::where('order_no',$order_no)->first();

            OrderItem::create([
                'order_id' => $order_id->id,
                'front_snap' => $name
             ]);

            $directory = public_path().'/order/'.$username;
            if(!File::exists($directory))
            {
                File::makeDirectory($directory);
            }

            $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

            if(!File::exists($directory))
            {
               File::makeDirectory($directory);
            }
            $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/front';
            if(!File::exists($directory))
            {
                File::makeDirectory($directory);
            }

            
            
            if(!File::exists($directory))
            { 
                File::makeDirectory($directory);
            } 
            file_put_contents('order/'. $username.'/'.$order_id->order_no.'/front/'.$name, $data);

        }
        else
        {
            if($request->is_back == 0)
            {
                 Order::create([
                    'user_id' => $user_id,
                    'material_id' => $material_id,
                    'amount' => $amount,
                    'quantity' => $quantity,
                    'order_no' => $order_no,
                    'user_template_id' => $card_price->id,
                    'status' => 'new'
                ]);

                $order_id = Order::where('order_no',$order_no)->first();

                OrderItem::create([
                    'order_id' => $order_id->id,
                    'front_snap' => $name
                 ]);

                $directory = public_path().'/order/'.$username;
                if(!File::exists($directory))
                {
                    File::makeDirectory($directory);
                }

                $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

                if(!File::exists($directory))
                {
                   File::makeDirectory($directory);
                }
                $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/front';
                if(!File::exists($directory))
                {
                    File::makeDirectory($directory);
                }
                
                if(!File::exists($directory))
                { 
                    File::makeDirectory($directory);
                } 
                file_put_contents('order/'. $username.'/'.$order_id->order_no.'/front/'.$name, $data);
            }
            else
            { 
                $order_no = $request->order_no; 

                $order_id = Order::where('order_no',$order_no)->first();
               
                OrderItem::where('order_id',$order_id->id)
                    ->update(['back_snap' => $name]);

                $directory = public_path().'/order/'.$username;
                if(!File::exists($directory))
                {
                    File::makeDirectory($directory);
                }

                $directory = public_path().'/order/'.$username.'/'.$order_id->order_no;

                if(!File::exists($directory))
                {
                   File::makeDirectory($directory);
                }
                $directory = public_path().'/order/'.$username.'/'.$order_id->order_no.'/back';
                if(!File::exists($directory))
                {
                    File::makeDirectory($directory);
                }
                
                if(!File::exists($directory))
                { 
                    File::makeDirectory($directory);
                } 
                file_put_contents('order/'. $username.'/'.$order_id->order_no.'/back/'.$name, $data);
            }

        }

        return response()->json($order_no);

    }

}
