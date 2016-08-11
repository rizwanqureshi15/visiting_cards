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
    		@if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
            @endif
    		<!--<canvas id="canvas" width="800" height="500"><img src="{{ url('images/card.png') }}" width="100%"></canvas>
    		-->


        <form id="form1">
        <div id="div1" style="height:510px;width:710px">
            <div width="700" height="500" style="border-style:dashed;height:510px;width:710px">

            </div>
        
        <div id="myToolbar" class="popup-toolbar" style="display:none;position:absolute;">
            <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        </div>
        <div id="company_name" class="ui-widget-content textbox-size" style="position: absolute;border:none;top:30px;left:250px;height:25px;">Enter your Name</div>
        </div>
        <button id="btnSave" type="submit" class="btn btn-primary" style="float:right">
            Save
         </button>
    	</div>
    </form>
    <div id="previewImage">
        
    </div>
    </div>
</div>

@endsection

@section('js')
    

    <script>

   $(document).ready(function(){

    
   var element = $("#div1"); // global variable
    var getCanvas; // global variable
 
    $("#btnSave").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");
                console.log(imgageData);

                $.ajax({
                type: "POST",
                url: "card_image_save",
                dataType: 'json',
                data: { "_token": "{{ csrf_token() }}","image": imgageData},
                success : function(image){

                    alert('image save');
                    } 
                }).fail(function(data){
                    // on an error show us a warning and write errors to console
                    var errors = data.responseJSON;
                });


             }
         });
    });

    $("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
    });

});
    
</script>

@endsection