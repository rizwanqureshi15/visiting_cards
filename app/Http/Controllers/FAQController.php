<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use Form;
use Datatables;
use App\Faq;

class FAQController extends Controller
{
	protected $guard = 'employee';
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
    
    public function faqs_list()
    {
        if(FAQController::authenticate_admin())
        {
            return view('admin.FAQs.list');     
        }
        else
        {
            return redirect()->back();
        }
    }

    public function faq_datatable()
    {
        $faq = Faq::where('is_delete', 0)->get();

         return Datatables::of($faq)
                    ->editColumn('answer', function ($data) {
                           $button = "<a href=". url('admin/faq/edit/'.$data->id) .">Edit</a> |  <a data-toggle='modal'  style='cursor: pointer' class='delete_question' data-target='#onDelete' data-delete='".$data->id."' >Delete</a>";
                           return $button;
                        })
                    ->make(true);
    }

    public function create()
    {
        if(FAQController::authenticate_admin())
        {
            return view('admin.FAQs.create');
        }
        else
        {
            return redirect()->back();
        }
    }

    public function create_post(Request $request)
    {
      if(FAQController::authenticate_admin())
        {
            $data = [
                'question' => $request->question,
                'answer' => $request->answer,
                'is_delete' => 0
            ];   

            Faq::create($data);
            Session::flash('succ_msg','New FAQ is added Successfully.!');
            return redirect('admin/faqs/list');
        }
        else
        {
            return redirect()->back();
        }  
    }

    public function edit($id)
    {
        if(FAQController::authenticate_admin())
        {
            $data['faq'] = Faq::where('is_delete',0)->where('id',$id)->first();
            return view('admin.FAQs.edit',$data);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function edit_post(Request $request,$id)
    {
      if(FAQController::authenticate_admin())
        {
            $data = [
                'question' => $request->question,
                'answer' => $request->answer,
            ];   
            Faq::where('is_delete',0)->where('id', $id)->update($data);
            Session::flash('succ_msg', 'FAQ is edited Successfully.!');
            return redirect('admin/faqs/list');
        }
        else
        {
            return redirect()->back();
        }  
    }

    public function delete(Request $request)
    {
        if(FAQController::authenticate_admin())
        {
            $data = [
                'is_delete' => 1
            ];   
            Faq::where('id', $request->delete_id)->update($data);
            Session::flash('succ_msg', 'FAQ is deleted Successfully.!');
            return redirect('admin/faqs/list');
        }
        else
        {
            return redirect()->back();
        }  
    }
}