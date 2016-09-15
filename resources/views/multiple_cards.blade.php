@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">

		<a class="btn btn-primary" href="{{ url('download_file',$template_url) }}">
			Download Excel File
		</a>

		<form method="post" action="{{ url('upload_file',$template_url) }}" enctype='multipart/form-data'>
			{{ Form::token() }}

			<div class="form-group">
		    	<label for="inputEmail3" class="col-sm-2 col-md-offset-3 control-label">Upload Excel File</label>
			    <div class="col-sm-5">
			      <input type="file" class="form-control" id="inputEmail3" name="excel_file">
			    </div>
		    </div>

			<div class="form-group">
			    <div class="col-sm-10">
			      <input type="submit" class="btn btn-primary" id="inputEmail3" name="submit" Value="Upload" style="float:right;margin-top:10px;">
			    </div>
		    </div>		    

		</form>

	</div>
</div>
@endsection