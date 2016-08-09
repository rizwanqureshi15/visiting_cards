@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-3">
    		<table class="table mytable" border="1" >
    			<thead>
    				<tr class="mytheadtr">
    					<th class="headtext">Enter Text</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<th><button class="btn form-control" style="background-color:rgba(181,186,191,0.47)">Add New Text Field</button></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="sidebar_company_name" name="company_name" placeholder="Enter Company name"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="company_message" name="company_message" placeholder="Company Message"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="full_name" name="full_name" placeholder="Full Name"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="job_title" name="job_title" placeholder="Job Title"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="address1" name="address1" placeholder="Address Line 1"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="address2" name="address2" placeholder="Address Line 2"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="phone" name="phone" placeholder="Phone/Other"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="email" name="email" placeholder="E-mail/Other"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="web" name="web" placeholder="Web/Other"></th>
    				</tr>
    				<tr>
    					<th><input class="col-md-12 form-control" type="text" id="your_text" name="your_text" placeholder="Your Text"></th>
    				</tr>
    			</tbody>
    		</table>
    	</div>	

    	<div class="col-md-8" style="padding-left:90px;padding-right:50px;">
    		
    		<!--<canvas id="canvas" width="800" height="500"><img src="{{ url('images/card.png') }}" width="100%"></canvas>
    		-->



        <canvas id="canvas1" width="700" height="500" style="border-style:dashed;">
        </canvas>
        <div id="myToolbar" class="popup-toolbar" style="display:none;position:absolute;">
            <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        </div>
        <div id="company_name" class="ui-widget-content textbox-size" style="position: absolute;border:none;top:30px;left:250px;height:25px;">Enter your Name</div>

    	</div>

    </div>
</div>

@endsection

@section('js')
	<script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ url('assets/js/myjs.js') }}"></script>

@endsection
