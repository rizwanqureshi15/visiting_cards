<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;	
use Session;
use App\Order;
use App\OrderItem;
use Config;
use Datatables;
use File;
use App\FinalOrder;
use App\User;
use Mail;


/**
 *  Handles all the function related to employee
 *
 * @package   Class_name
 * @author     webdesignandsolution15@gmail.com
 * @link       http://www.webdesignandsolution.com/
 */
class EmployeeController extends Controller
{
    //
    protected $guard = 'employee';


    /**
     * Show employee loin page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function login()
    {
    	return view('employee/login');
    }


    /**
     * Authenticate the employee
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function authenticate_employee()
    {
       
        if((Auth::guard('employee')->user()->is_admin) == 0)
        {  
                return true;
            
        }
        elseif(Auth::user() != null)
        {
            return false;
        }
        else
        {
            return false;
        }
    }


    /**
     * If employee is exist than show it proper page otherwise show error message
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param     int product_id
     * @return     array product_info
     */
    public function login_post(Request $request)
    {
    	//Auth::guard('Newgardname'); [specify guerd name by which you want to authenticate
        if(Auth::guard('employee')->attempt(['username' => $request->username, 'password' => $request->password]))
    	{
            // Authentication passed...	
    		if(Employeecontroller::authenticate_employee())
    		{
                if(Auth::guard('employee')->user()->is_delete == 0)
                    {   
                       return redirect('orders/list');  
                    }
                    else
                    {

                        Session::flash('dlt_msg', 'Your account is De-activated by Admin');
                        return redirect()->back();
                    }
    			
    		}
            else
            {

            	return redirect('admin/employees_list');
            }
        }
        else
        {
        	Session::flash('error_msg','Username or Password is incorrect..!');
        	return redirect()->back();
        }
    }


    /**
     * Show order list page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function order_list()
    {
        if(Auth::guard('employee')->user())
        {
            return view('employee.order_list');    
        }
        else
        {
            return redirect()->back();
        }
    	
    }


     /**
     * Show new order list page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function new_order_list()
    {
        if(Auth::guard('employee')->user())
        {
            return view('employee.new_orders_list');    
        }
        else
        {
            return redirect()->back();
        }
    }


    /**
     * Get the data from database where status is paid and return it to the datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function new_order_datatable()
    {

         $orders = Order::with('user')->where('status', Config::get('status.paid'))->where('is_delete',0)->where('is_cancel', 0)->where('is_confirmed', 0)->get();

         return Datatables::of($orders)
                    ->addColumn('action', function ($data) {
                           
                            $button = '<a href='.url("admin/new_orders/" . $data->id . "/list").'>View</a> |  
                            <a data-toggle="modal"  style="cursor: pointer" class="cancel_order" data-target="#onDelete" data-id="'. $data->id .'" >Cancel</a>';
                            return $button;
                        })
                    ->editColumn('user_id', function ($data) {
                            $username = $data->user->first_name . " " . $data->user->last_name;
                            return $username;
                        })
                    ->make(true);
    }

    
    /**
     * Get the data from database where status is done and return it to the datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function datatable()
    {

         $orders = Order::with('user')->where('is_cancel', 0)->where('is_delete',0)->where('is_confirmed', 1)->whereNotIn('status' , [Config::get('status.done')])->get();

         return Datatables::of($orders)
                    ->addColumn('action', function ($data) {
                            if($data->status == Config::get("status.confirmed"))
                            {
                                $button = '<a href='.url("admin/orders/" . $data->id . "/list").'>List</a> | <a  id="is_cancel" class="cancel_order" data-id='. $data->id .'> Cancel</a>'; 
                            
                            }else{
                                 $button = '<a href='.url("admin/orders/final/" . $data->id . "/list").'>Final Order</a> 
                                |  <a id="is_cancel" class="cancel_order" data-id='. $data->id .'>Cancel</a> | <a href="'. url("orders/done/".$data->id).'"> Done </a>';
                               
                            }

                            return $button;
                        })
                    ->editColumn('user_id', function ($data) {
                            $username = $data->user->first_name . " " . $data->user->last_name;
                            return $username;
                        })
                    ->make(true);
    }


    /**
     * Get the data of user from database where status is in_process
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
    public function list_cards($id)
    {
        Order::where('id', $id)->update(['status' => Config::get('status.in_process')]);
        $order = Order::with('user')->where('id', $id)->first();
        $data['cards'] = OrderItem::where('order_id',$id)->get();
        $data['username'] = $order->user->username;
        return view('employee.orders.list',$data);
    }


    /**
     * Show users order with pagination
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
    public function new_list_cards($id)
    {
        //Order::where('id', $id)->update(['status' => 'In Process']);
        $order = Order::with('user')->where('id', $id)->first();
        $data['cards'] = OrderItem::where('order_id',$id)->paginate('20');
        $data['username'] = $order->user->username;
        $data['order_id'] = $id;
        return view('employee.orders.order_items_view',$data);
    }


    /**
     * Send confirmation email to the user whoes order is being confirm
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
    public function confirm_order($id)
    {
        $order = Order::where('id', $id)->first();
        
        $data['user'] = User::where('id', $order->user_id)->first();
        $data['order'] = $order;
        $user = $data['user'];

        Mail::send('emails.confirmation_email', $data , function ($m) use ($user) 
        {
            $m->to($user->email, $user->first_name." ".$user->last_name)->subject('Order Confirmation');
        });
        //dd(view('emails.admin_confirmation_email', $data)->render());
        Mail::send('emails.admin_confirmation_email', $data , function ($m) use ($user) 
        {
            $m->to(Config::get('settings.admin_email'),'Admin')->subject('Order Confirmation');
        });

        Order::where('id', $id)->update(['is_confirmed' => '1', 'status' => Config::get('status.confirmed')]);
        return redirect('new_orders/list');
    }


    /**
     * Get the final order of the user send it to the view
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
    public function order_snap_list($id)
    {
        $order = Order::with('user')->where('id', $id)->first();
        $data['cards'] = FinalOrder::where('order_id',$id)->paginate(1);
        $data['username'] = $order->user->username;

        return view('employee.orders.order_snaps',$data);

    }


    /**
     * Save image of order and put it in the folder and update the satus of an order in order table
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image,order_id,is_back,status
     * @return   json image
     */
    public function save_list_snap(Request $request)
    {
        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/orders/snaps';   

        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 

        file_put_contents($path .'/'. $name .'.png', $data);  
        $save = [
            'order_id' => $request->order_id, 
            'snap' => $name.'.png'
        ];

        if($request->is_back)
        {
            $save['is_back'] = 1;
        }
        FinalOrder::create($save);
         if($request->status)
        {
            
            Order::where('id', $request->order_id)->update(['status' => Config::get('status.in_process')]);
        }
        return json_encode($name .'.png');
    }


    /**
     * Show cancel order list page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function cancel_order_list()
    {
         if(Auth::guard('employee')->user())
        {
            return view('employee.orders.cancel_order_list');    
        }
        else
        {
            return redirect()->back();
        }
    }


    /**
     * Get the data of cancel order and return it to the datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function cancel_order_datatable()
    {

         $orders = Order::with('user')->where('is_delete',0)->where('is_cancel', 1)->get();

         return Datatables::of($orders)
                    ->editColumn('user_id', function ($data) {
                            $username = $data->user->first_name . " " . $data->user->last_name;
                            return $username;
                        })
                    ->make(true);
    }


    /**
     * Update status of is_cancel feild in order table
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int order_id
     * @return   void
     */
    public function cancel_order(Request $request)
    {
        if(Auth::guard('employee')->user())
        {
           Order::where('id', $request->order_id)->update(['is_cancel' => 1]);
           return "successfully canceled.!";   
        }
        else
        {
            return redirect()->back();
        }
    }


    /**
     * Update status to done in order table send email to the user
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param     int product_id
     * @return     array product_info
     */
    public function done_order($id)
    {
       if(Auth::guard('employee')->user())
        {
            $data['order'] = Order::with('user')->where('id',$id)->first();
            $user = User::where('id', $data['order']->user_id)->first();
            $data['user'] = $user;

            Mail::send('emails.done_order_email', $data , function ($m) use ($user) 
            {
                $m->to($user->email, $user->first_name." ".$user->last_name)->subject('Order is Delivered');
            });
            
            Mail::send('emails.admin_done_order_email', $data , function ($m) use ($user) 
            {
                $m->to(Config::get('settings.admin_email'),'Admin')->subject('Order is Delivered');
            });
        Order::where('id', $id)->update(['status' => Config::get('status.done')]);  
           return redirect()->back();   
        }
        else
        {
            return redirect()->back();
        } 
    }


    /**
     * Show order history list page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function order_history_list()
    {
        if(Auth::guard('employee')->user())
        {
            return view('employee.orders.history.list');    
        }
        else
        {
            return redirect()->back();
        }
        
    } 


    /**
     * Get the data of order table where status is done and return it to the datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function order_history_datatable()
    {
         $orders = Order::with('user')->whereIn('status', [Config::get('status.done')])->get();

         return Datatables::of($orders)
                    ->editColumn('user_id', function ($data) {
                            $username = $data->user->first_name . " " . $data->user->last_name;
                            return $username;
                        })
                    ->make(true);
    } 

}
