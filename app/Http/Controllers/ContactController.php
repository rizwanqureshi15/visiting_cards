<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use App\User;
use App\Contact;
use Datatables;


/**
 * Handles all the function related to contact
 *
 * @package   ContactController
 * @author    webdesignandsolution15@gmail.com
 * @link      http://www.webdesignandsolution.com/
 */
class ContactController extends Controller
{
	protected $guard = 'employee';


    /**
     * Authenticate the admin
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
	public function authenticate_admin()
    {
       
        if((Auth::guard('employee')->user()->is_admin) == 1)
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
     * Show contact us form
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function index()
    {
        if(ContactController::authenticate_admin())
        {   
            return view('admin.contacts.index');     
        }
        else
        {
            return redirect()->back();
        }
    }


    /**
     * Get the data from contact table and return it to the datatables
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   void
     */
    public function contact_datatable()
    {
         $contact = Contact::where('is_delete', 0)->get();

         return Datatables::of($contact)
                    ->addColumn('action', function ($data) {
                           
                                
                            $button = '<a href="'. url('admin/contacts/'.$data->id) .'">View</a> | <a data-toggle="modal"  style="cursor: pointer" class="delete_contact" data-target="#onDelete" data-delete="'.$data->id.'" >Delete</a>';
                            return $button;
                        })
                    ->make(true);
    }


    /**
     * Show contact us form
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int id
     * @return   view
     */
    public function show($id)
    {
        if(ContactController::authenticate_admin())
        {   
            $data['contact'] = Contact::where('is_delete', 0)->where('id',$id)->first();
            return view('admin.contacts.show',$data);     
        }
        else
        {
            return redirect()->back();
        }   
    }


    /**
     * Update is_delete value from contact table
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int delete_id
     * @return   view
     */
    public function destroy(Request $request)
    {
        if(ContactController::authenticate_admin())
        {   
            Contact::where('is_delete',0)->where('id',$request->delete_id)->update(['is_delete' => 1]);
            Session::flash('succ_msg', 'Contect is Deleted successfully.!');
            return redirect()->back(); 
        }
        else
        {
            return redirect()->back();
        }   
    }
}