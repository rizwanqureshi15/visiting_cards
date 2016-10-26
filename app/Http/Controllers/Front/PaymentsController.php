<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;	
use Session;
use App\Employee;
use Hash;
use Form;
use Validator;
use App\User;
use Config;
use Datatables;
use App\Order;

class PaymentsController extends Controller
{

    public function index()
    {
        return view('payment.billingandshipping');
    }

    public function payment(Request $request)
    {
        $order_id = 1;
        $validator = Validator::make($request->all(), [
                        "address_1" => 'required',
                        "address_2" => 'required',
                        "city" => 'required',
                        "state" => 'required',
                        "country" => 'required',
                        "zipcode" => 'required',
                        "ship_address_1" => 'required',
                        "ship_address_2" => 'required',
                        "ship_city" => 'required',
                        "ship_state" => 'required',
                        "ship_country" => 'required',
                        "ship_zipcode" => 'required',
                    ]);
                    
                      
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $data = [
                "address_line_1" => $request->address_1,
                "address_line_2" => $request->address_2,
                "city" => $request->city,
                "state" => $request->state,
                "country" => $request->country,
                "zipcode" => $request->zipcode,
                "shipping_address_line_1" => $request->ship_address_1,
                "shipping_address_line_2" => $request->ship_address_2,
                "shipping_city" => $request->ship_city,
                "shipping_state" => $request->ship_state,
                "shipping_country" => $request->ship_country,
                "shipping_zipcode" => $request->ship_zipcode,
            ];

            Order::where("id", $order_id)->update($data);
           
                 
        }

    }  

    public function payment_success(Request $request)
    {
        dd($request->all());
        return redirect('myorders');
    } 

    public function test()
    {
        $data['details'] = [
            'key'=>'rjQUPktU', 
            'txnid'=>'1', 
            'amount' => '100',
            'productinfo' => 'cards', 
            'firstname' => 'rizwan', 
            'email' => 'amrin.umar.khatri@gmail.com', 
            'phone' => '9979557690', 
            'surl' => url('payment/myorders'), 
            'furl' => url('payment'), 
            'service_provider' => 'payu_paisa',
            'hash' => strtolower(hash('sha512','rjQUPktU|1|100|cards|rizwan|amrin.umar.khatri@gmail.com|||||||||||e5iIg1jwi8'))
            ];

        return view('payment.payment',$data);
    }
    
}
