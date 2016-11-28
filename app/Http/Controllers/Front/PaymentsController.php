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

    /**
     * Handle payments of users
     *
     * @package   PaymentsController
     * @author    webdesignandsolution15@gmail.com
     * @link      http://www.webdesignandsolution.com/
     */
class PaymentsController extends Controller
{

    /**
     * Load billing page with data
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int order_no
     * @return   view
     */
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

    /**
     * Fetch delievery details and strores it in database
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array request
     * @return   array product_info
     */
    public function payment(Request $request)
    {  
        $user = Auth::user();
        $order = Order::where('id',$request->order_id)->first(); 
        $user_template = UserTemplate::where('id',$order->user_template_id)->first();
        $material = Material::where('id',$request->material_id)->first();

        $final_price = ($user_template->price + $material->price) * $order->quantity;

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

            Order::where("id", $order_id)->update(['status' => Config::get('status.unpaid')]);

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
                 
        }
    }


    /**
     * Update payment status when payment got successed 
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int txnid
     * @return   view
     */
    public function payment_success(Request $request)
    {  
        $order = Order::where('order_no',$request->txnid)->update([ 'status' => Config::get('status.paid'), "payu_money_id" => $request->payuMoneyId ]);
        Session::flash('flash_message','Successfully paid. Your order will be delivered soon');
        return redirect('myorders');
    } 


    /**
     * Send refund request to server when order get cancled
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int cancel_id
     * @return   view
     */
    public function refund(Request $request)
    {
       
        $transaction_id = Order::where('id', $request->cancel_id)->first();

        $url = 'https://www.payumoney.com/payment/merchant/refundPayment?'; 
        $data =array('merchantKey'=> Config::get('settings.key'), 'paymentId'=> $transaction_id->payu_money_id,'refundAmount'=> $transaction_id->amount); 
        $options = array( 
          'http' => array( 
            'header' => "Content-Type: application/x-www-form-urlencoded&Authorization: ".Config::get('settings.authorization'), 
            'method' => 'POST', 
            'Authorization'=> Config::get('settings.authorization'), 
            'content' => http_build_query($data) 
            ), 
          ); 
        $context = stream_context_create($options); 
        $result = file_get_contents($url, false, $context); 
        if ($result === FALSE) { 
            Session::flash('error_msg','There was an error while processing Refund.');
        }
        else{
            Session::flash('succ_msg','Successfully Refunded.');
            Order::where('id', $request->cancel_id)->update(['is_cancel' => 1,'status' => Config::get('status.refunded')]);
        }
        return redirect('new_orders/list');
    }
    
}
