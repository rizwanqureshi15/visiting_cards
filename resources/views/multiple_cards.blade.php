@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row block">
		<div class="col-md-12">
			 @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
              @if(Session::has('flash_success'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_success') !!}</em>
                    </div>
             @endif
		</div>
		<div class="row">
			<a class="sidebar-btn" href="{{ url('download_file',$template_url) }}" style="float:left">
				Download Excel File
			</a>
		</div>

	   @foreach($image_feilds_name as $feild_name)
		    <?php
		    	$name = $feild_name->name; 
                $name = str_replace(" ","_",$feild_name->name);
                $name = strtolower($name); 
		   	?>
		<form id="form_{{ $name }}" method="post" action="{{ url('upload_images',$template_url) }}" enctype='multipart/form-data'>
			{{ Form::token() }}

				<input type="hidden" value="{{ $name }}" name="{{ $name }}">
			    <div class="form-group">
			    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label" style="margin-top:10px;">Upload {{ $feild_name->name }}</label>
				    <div class="col-sm-5">
					    <div class="col-md-9">
					      <input type="file" class="form-control file-textbox" id="{{ $name }}" name="{{ $name }}[]" multiple="multiple" style="margin-top:10px;">
					      <div id="error_{{ $name }}" style="color:red"></div>
					      @if(Session::has($feild_name->name.'_error_message'))
		                    <span class="help-block" style="color:red;">
		                        <strong> {{ session($feild_name->name.'_error_message') }}</strong>
		                    </span>
		                  @endif
		            	</div>
		            	<div class="col-md-2">
		                  <input type="submit" class="sidebar-btn" data-id="{{ $name }}" name="submit" Value="Upload" style="margin-top:10px;">
		                </div>
				    </div>
			    </div>

		</form>

	   @endforeach

		
		<form  method="post" action="{{ url('upload_file',$template_url) }}" enctype='multipart/form-data'>
			{{ Form::token() }}

			<div class="form-group">
		    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label" style="margin-top:10px;">Upload Excel File</label>
			    <div class="col-sm-5">
				    <div class="col-md-9">
				      <input type="file" class="form-control file-textbox" id="inputEmail3" name="excel_file" style="margin-top:10px;margin-right:10px;">
				    
					    @if ($errors->has('excel_file'))
		                    <span class="help-block" style="color:red;">
		                        <strong>{{ $errors->first('excel_file') }}</strong>
		                    </span>
		                @endif

		            </div>
	                <div class="col-md-2">
		                  <input type="submit" class="sidebar-btn" id="inputEmail3" name="submit" Value="Upload" style="margin-top:10px;">
		            </div>

			    </div>
		    </div>

		</form>


		    @if($user_template_images)

				    <!-- Modal -->
		                <div class="modal fade" id="multiple_images" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Preview Cards</h4>
						      </div>
						      <div class="modal-body">
						      	<div class="row">
						        	@foreach($user_template_images as $image)
						        		
							            <div class="col-md-3" id="{{ substr($image,0,-4) }}">
							                <img class="preview_image" data-image="{{ $image }}" id="delete_single_image" src="{{ url('assets/images/delete.png') }}" style="height:30px;position:absolute;z-index: 1;margin-top: 22px;margin-left:72%;">
							                <img src="{{ url('temp/'.$username.'/front/'.$image) }}" style="height:220px;width:100%;margin-top:20px;">
							            </div>

							        

							        @if($user_template_back_images)
							        	
								        	<div class="col-md-3" id="{{ substr($image,0,-4) }}">
								                <img class="preview_back_image" data-image="{{ $image }}" id="delete_back_image" src="{{ url('assets/images/delete.png') }}" style="height:30px;position:absolute;z-index: 1;margin-top: 22px;margin-left:72%;">
								                <img src="{{ url('temp/'.$username.'/back/'.$image) }}" style="height:220px;width:100%;margin-top:20px;">
								            </div>
								    @endif
								    @endforeach

							        

							    </div>
						      </div>
						      <div class="modal-footer">
						        <a href="{{ url('delete_folder',$template_url) }}">
						        	<button type="button" class="model-btn" >Close</button>
						       	</a> 
						       	<a href="{{ url('order_multiple_cards',$template_url) }}">
						        	<button type="button" class="model-btn">Save</button>
						     	</a>
						      </div>
						    </div>
						  </div>
						</div>
            		<!-- End Model -->
            
		    @endif

		</form>

	</div>
</div>
@endsection

@section('js')

<script>

$(document).ready(function () {

	$('#multiple_images').modal({backdrop: 'static', keyboard: false , show: true}); 

	$(".preview_image").click(function()
    {
                var image_name = $(this).data('image');
                var div = image_name.slice(0,-4);
                $('#'+div).remove();

                $.ajax({
                    type: "POST",
                    url: "{{ url('delete_image') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","image_name": image_name},
                    success: function(image) {
                       
                    }
                });

    });

    $(".preview_back_image").click(function()
    {
                var image_name = $(this).data('image');
                var div = image_name.slice(0,-4);
                $('#'+div).remove();

                $.ajax({
                    type: "POST",
                    url: "{{ url('delete_back_image') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","image_name": image_name},
                    success: function(image) {
                       
                    }
                });

    });

	$(document).ready(function() {
		$('.submit').bind("click",function() 	
		{ 
			$("#error_"+name).text("");
			var name = $(this).data('id'); 
			var form_name = "form_"+name;
			var field_name = $("#"+name).val();
			
			if(field_name=='')
			{ 
				$("#error_"+name).text("This field is required");
				return false; 
			} 
			else
			{
				return true; 
			}

			
		}); 
	});

});

</script>

@endsection