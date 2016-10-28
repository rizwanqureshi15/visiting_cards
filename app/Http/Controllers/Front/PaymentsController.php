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
use App\Material;
use App\UserTemplate;

class PaymentsController extends Controller
{

    public function index($order_no)
    {
        $data['materials'] = Material::where('is_delete',0)->get();
        $data['order'] = Order::where('order_no',$order_no)->first();
        $template = UserTemplate::where('id',$data['order']->user_template_id)->first();
        $material = Material::where('id',$data['order']->material_id)->first();
        $data['material_price'] = $material->price;
        $data['order_no'] = $order_no;
        $data['order_id'] = $data['order']->id; 
        $data['template_price'] = $template->price;
        $data['order_quantity'] = $data['order']->quantity; 
        $data['material_id_and_price'] = Material::where('is_delete',0)->lists('price','id'); 

        return view('payment.billingandshipping',$data);
    }

    public function payment(Request $request)
    {  
        $user = Auth::user();
        $order = Order::where('id',$request->order_id)->first(); 
        $user_template = UserTemplate::where('id',$order->user_template_id)->first();
        $material = Material::where('id',$request->material_id)->first();

        $final_price = $order->quantity * $user_template->price * $material->price;

        $order_id = $request->order_id;
        $validator = Validator::make($request->all(), [
                        "address_1" => 'required',
                        "address_2" => 'required',
                        "city" => 'required',
                        "state" => 'required',
                        "country" => 'required',
                        "zipcode" => 'required',
                        "phone_no" => 'required|numeric|digits:10',
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
                "material_id" => $request->material_id,
                "phone_no" => $request->phone_no,
                "amount" => $final_price
            ];

            $card = UserTemplate::where('id',$order->user_template_id)->first();
           
            Order::where("id", $order_id)->update($data);

            Order::where("id", $order_id)->update(['status' => 'unpaid']);

            $data['details'] = [
                'key'=> Config::get('settings.key'), 
                'txnid'=> $order->order_no, 
                'amount' => $final_price,
                'productinfo' => $card->name, 
                'firstname' => $user->username, 
                'email' => $user->email, 
                'phone' => $request->phone_no, 
                'surl' => url('payment/myorders'), 
                'furl' => url('order/'.$order->order_no.'/payment'), 
                'service_provider' => 'payu_paisa',
                'hash' => strtolower(hash('sha512','rjQUPktU|'.$order->order_no.'|'.$final_price.'|'.$card->name.'|'.$user->username.'|'.$user->email.'|||||||||||'.Config::get('settings.salt')))
                ];

            return view('payment.payment',$data);

            // $query=http_build_query($data) ;
            // $url = 'https://test.payumoney.com/payment/op/getPaymentResponse?merchantKey=xDjfEVwC&merchantTransactionIds=5655765'; 
            // $data =array('merchantKey'=>'xDjfEVwC', 'merchantTransactionIds '=>'5655765', 'amount' => '100','productinfo' => 'cards', 'firstname' => 'Rizwan', 'email' => 'rizwanqureshi15@gmail.com', 'phone' => '9834738393', 'surl' => url('admin/employees/login'), 'furl' => url('admin/employees/list'), 'service_provider' => 'payu_paisa'); 
            // $options = array( 
            //   'http' => array( 
            //     'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
            //         "Content-Length: ".strlen($query)."\r\n".
            //         "User-Agent:MyAgent/1.0\r\n,Authorization: 0SC8FamYqWnwFzVgYKmiCfSsT96xerU8E+WBUh/KDXc=", 
            //     'method' => 'POST', 
            //     'Authorization'=> '0SC8FamYqWnwFzVgYKmiCfSsT96xerU8E+WBUh/KDXc=', 
            //     'content' => $query 
            //     ), 
            //   ); 
            // $context = stream_context_create($options); 
            // $result = file_get_contents($url, false, $context, -1 , 40000); 
            // if ($result === FALSE) { /* Handle error */ } 
            
            // dd($result); 
                 
        }
    }

    public function payment_success(Request $request)
    {   dd($request->all());
        $order = Order::where('order_no',$request->txnid)->update([ 'status' => Config::get('status.paid') ]);
        Session::flash('flash_message','Successfully paid. Your order will be delivered soon');

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
