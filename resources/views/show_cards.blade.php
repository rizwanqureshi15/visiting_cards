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
        <!--Toolebasr start-->
        <div id="myToolbar" class="popup-toolbar row" style="display:none;position:absolute;">

        <!--Font Style Selector-->
            <div class="toolbar-fontbox col-md-5">
                <input id="font" type="text" />
            </div><!--Font Style Selector end-->
        
        <!--Font Size Selector-->
            <div class="col-md-2" style="margin-top:10px;margin-left:15px;">
                <select id="size-font" style="height:30px;color:black;width:74px">
                    <option value="8">8px</option>
                    <option value="10">10px</option>
                    <option value="12">12px</option>
                    <option value="14">14px</option>
                    <option value="18">18px</option>
                    <option value="20">20px</option>
                    <option value="24">24px</option>
                    <option value="28">28px</option>
                    <option value="30">30px</option>
                    <option value="32">32px</option>
                </select>
            </div><!--Font Size Selector end-->

        <!--Toolbar colorpicker-->
        <div class="col-md-1">
            <div id="colorSelector" style="margin-top:5px;"><div style="background-color: #0000ff"></div></div>
        </div>
        <!--Toolbar colorpicker end-->
            
        <!--Toolbar Delete Button-->
        <div class="col-md-2">
            <img src="{{ url('assets/images/delete.png') }}" style="width:20px;margin-top:14px;" id="toolbardelete">
        </div>
        <!--Toolbar Delete Button end-->

        <!--Toolbar Textbox-->
            <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        <!--Toolbar Textbox end-->

        </div><!--Toolbar end-->
        <div id="company_name" class="ui-widget-content textbox-size" style="position: absolute;top:30px;left:250px;height:25px;">
            <span id="span_company_name">Enter your Name</span>
        </div>

    	</div>
       
    </div>
</div>

@endsection

@section('js')
	<script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/myjs.js') }}"></script>
    
    
    
@endsection
