@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<!--<div class="col-md-12">
			 @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
		</div>-->

		<a class="btn btn-primary" href="{{ url('download_file',$template_url) }}">
			Download Excel File
		</a>

		<form method="post" action="{{ url('upload_file',$template_url) }}" enctype='multipart/form-data'>
			{{ Form::token() }}

			<div class="form-group">
		    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label">Upload Excel File</label>
			    <div class="col-sm-5">
			      <input type="file" class="form-control" id="inputEmail3" name="excel_file" >
			    
				    @if ($errors->has('excel_file'))
	                    <span class="help-block" style="color:red;">
	                        <strong>{{ $errors->first('excel_file') }}</strong>
	                    </span>
	                @endif
			    </div>
		    </div>
		    
		    @foreach($image_feilds_name as $feild_name)

			    <div class="form-group">
			    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label" style="margin-top:10px;">Upload {{ $feild_name->name }}</label>
				    <div class="col-sm-5">
				      <input type="file" class="form-control" id="inputEmail3" name="{{ $feild_name->name }}[]" multiple="multiple" style="margin-top:10px;">
				      
				      @if(Session::has($feild_name->name.'_error_message'))
	                    <span class="help-block" style="color:red;">
	                        <strong> {{ session($feild_name->name.'_error_message') }}</strong>
	                    </span>
	                  @endif

				    </div>
			    </div>
			@endforeach

			<div class="form-group">
			    <div class="col-sm-10">
			      	<input type="submit" class="btn btn-primary" id="inputEmail3" name="submit" Value="Upload" style="float:right;margin-top:10px;">
                </div>
		    </div>	    

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
							            <div class="col-md-4" id="{{ substr($image,0,-4) }}">
							                <img class="preview_image" data-image="{{ $image }}" id="delete_single_image" src="{{ url('assets/images/delete.png') }}" style="height:30px;position:absolute;z-index: 1;margin-top: 22px;margin-left:79%;">
							                <img src="{{ url('temp/'.$username.'/'.$image) }}" style="height:220px;width:100%;margin-top:20px;">
							            </div>
							        @endforeach
							    </div>
						      </div>
						      <div class="modal-footer">
						        <a href="{{ url('delete_folder') }}">
						        	<button type="button" class="btn btn-default" >Close</button>
						       	</a>
						        <button type="button" class="btn btn-primary">Save</button>
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

</script>

@endsection