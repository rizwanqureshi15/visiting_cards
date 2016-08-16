@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3">
        	 <table class="table mytable" border="1" >
                <thead>
                    <tr class="mytheadtr">
                        <th class="headtext">Category</th>
                    </tr>
                </thead>
               <tbody>
                    <tr>
                        <th><input class="col-md-12 form-control toolbar-elements" type="text" id="sidebar_company_name" name="company_name" placeholder="Enter Company name"></th>
                    </tr>
                    <tr>
                        <th><input class="col-md-12 form-control toolbar-elements" type="text" id="sidebar_company_message" name="company_message" placeholder="Company Message"></th>
                    </tr>
                    <tr>
                        <th><input class="col-md-12 form-control toolbar-elements" type="text" id="sidebar_full_name" name="full_name" placeholder="Full Name"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-9">
        	
        </div>
    </div>
</div>

@endsection

@section('js')    
    
@endsection

