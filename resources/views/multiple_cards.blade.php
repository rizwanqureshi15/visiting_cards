@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			 @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
		</div>
		<a class="btn btn-primary" href="{{ url('download_file',$template_url) }}">
			Download Excel File
		</a>

		<form method="post" action="{{ url('upload_file',$template_url) }}" enctype='multipart/form-data'>
			{{ Form::token() }}

			<div class="form-group">
		    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label">Upload Excel File</label>
			    <div class="col-sm-5">
			      <input type="file" class="form-control" id="inputEmail3" name="excel_file">
			    
				    @if ($errors->has('excel_file'))
	                    <span class="help-block" style="color:red;">
	                        <strong>{{ $errors->first('excel_file') }}</strong>
	                    </span>
	                @endif
			    </div>
		    </div>
		    
		    @foreach($image_feilds_name as $feild_name)

			    <div class="form-group">
			    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label" style="margin-top:10px;">Upload {{ $feild_name->content }}</label>
				    <div class="col-sm-5">
				      <input type="file" class="form-control" id="inputEmail3" name="{{ $feild_name->content }}[]" multiple="multiple" style="margin-top:10px;">
				    </div>
			    </div>
			@endforeach

			<div class="form-group">
			    <div class="col-sm-10">
			      <input type="submit" class="btn btn-primary" id="inputEmail3" name="submit" Value="Upload" style="float:right;margin-top:10px;">
                </div>
		    </div>	    

		</form>

	</div>
</div>
@endsection