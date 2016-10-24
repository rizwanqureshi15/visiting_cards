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

        public function test()
        {
           
// $url = 'https://www.payumoney.com/payment/op/getPaymentResponse?merchantKey= eM8ZaP&merchantTransactionIds=563445'; 
// $data =array('key'=>'', 'txnid '=>'563445'); 
// $query = http_build_query($data);
// $options = array( 
//   'http' => array( 
//     'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
//                     "Content-Length: ".strlen($query)."\r\n".
//                     "User-Agent:MyAgent/1.0\r\n,Authorization: 0SC8FamYqWnwFzVgYKmiCfSsT96xerU8E+WBUh/KDXc=", 
//     'method' => 'POST', 
//     'Authorization'=> '0SC8FamYqWnwFzVgYKmiCfSsT96xerU8E+WBUh/KDXc=', 
//     'content' =>  $query
//     ), 
//   ); 
// $context = stream_context_create($options); 
// $result = file_get_contents($url, false, $context); 
// if ($result === FALSE) { /* Handle error */ } 
// var_dump($result); 
        // $url = 'https://test.payu.in/_payment'; 
        //     $data =array('key'=>'JBZaLc', 'txnid'=>'1', 'amount' => '100','productinfo' => 'cards', 'firstname' => 'rizwan', 'email' => 'rizwanqureshi15@gmail.com', 'phone' => '9979557690', 'surl' => url('admin/employees/login'), 'furl' => url('admin/employees/list'), 'service_provider' => 'payu_paisa', 'hash' => Hash('sha512','JBZaLc|1|100|cards|rizwan|rizwanqureshi15@gmail.com|||||||||||GQs7yium')); 
        //      $query=http_build_query($data) ;
        //     $options = array( 
        //       'http' => array( 
        //         'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
        //             "Content-Length: ".strlen($query)."\r\n".
        //             "User-Agent:MyAgent/1.0\r\n,Authorization: GQs7yium", 
        //         'method' => 'POST', 
        //         'Authorization'=> 'GQs7yium', 
        //         'content' => $query 
        //         ), 
        //       ); 
        //     $context = stream_context_create($options); 
        //     $result = file_get_contents($url, false, $context, -1 , 40000); 
        //     if ($result === FALSE) { /* Handle error */ } 
            
        //     dd($result);
        $data['details'] = [
            'key'=>'JBZaLc', 
            'txnid'=>'1', 
            'amount' => '100',
            'productinfo' => 'cards', 
            'firstname' => 'rizwan', 
            'email' => 'rizwanqureshi15@gmail.com', 
            'phone' => '9979557690', 
            'surl' => url('admin/employees/login'), 
            'furl' => url('admin/employees/list'), 
            'service_provider' => 'payu_paisa',
            'hash' => strtolower(hash('sha512','JBZaLc|1|100|cards|rizwan|rizwanqureshi15@gmail.com|||||||||||GQs7yium'))
            ];

        return view('payment.payment',$data);
    }
    
}
