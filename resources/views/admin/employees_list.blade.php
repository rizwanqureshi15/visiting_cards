@extends('master')
@section('content')

	<div class="row">
		<div class="col-md-3"><h2>Employees</h2></div>
		<div class="" style="margin-top:30px;">
			<a href="{{ url('admin/create_employee') }}" class="btn btn-primary pull-right">Add Employee</a>
		</div>
		<div class="col-md-12" style="margin-top:20px;">
			@if(Session::get('reset_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('reset_msg') }}</a>
				</div>
			@endif
			@if(Session::get('dlt_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('dlt_msg') }}</a>
				</div>
			@endif
			@if(Session::get('edit_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('edit_msg') }}</a>
				</div>
			@endif
			@if(Session::get('create_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('create_msg') }}</a>
				</div>
			@endif
			<table class="table table-condensed">
			<thead>
				<tr>
					<th> Name </th>
					<th> Username </th>
					<th> Action </th>
				</tr>
			</thead>
			<tbody>
				@if(!count($employees))
				<tr>
					<td>Data Not Found..!</td>
				</tr>
				@endif
 				@foreach($employees as $employee)
 				<tr>
 					<td> {{ $employee->first_name }} {{ $employee->last_name }}</td>
 					<td> {{ $employee->username }}</td>
 					<td> 
 						<a href="{{ url('admin/edit_profile', $employee->id) }}">Edit</a> | 
 						<a  href="{{ url('admin/delete_employee', $employee->id) }}">Delete</a> | 
 						<button type="button" class="btn btn-default reset_password" data-toggle="modal" data-target="#myModal" data-id="{{ $employee->id }}">
						  Reset Password
						</button>
 				</tr>
 				@endforeach
 			</tbody>
 			
			</table>

		</div>
		<div class="col-md-8 col-md-offset-4">
			{{ $employees->links() }}
		</div>
		</div>
	
		
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    {{ Form::open(array('method' => 'post', 'url' => url('admin/reset_password'), 'class' =>"form-horizontal")) }}
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
			      </div>
			      <div class="modal-body">

			        <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-sm-6">
					    	{{ Form::hidden('id', null, ['id' => 'employee_id']) }}
					       {{ Form::text('password',null, ['class' => 'form-control','placeholder' => 'Password', 'id' => 'new_password']) }}
					       @if ($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
					    </div>
					    <div class="col-sm-4">
					    	<a class="btn btn-primary" id="random_password">Generate password</a>
					    </div>
					  </div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       <!--  <button type="button" class="btn btn-primary" >Generate Password</button> -->
			        <input type="submit" class="btn btn-primary" value="Save">
			        
			      </div>
			      {{ Form::close() }}
			    </div>
			  </div>
			</div>
			
</div>
	@endsection

	@section('js')

	<script type="text/javascript">
		var err = "{{ $errors->first('password') }}";
		$('.reset_password').click(function(){
				//$('#employee_id').val($('.reset_password').data('id'));
				var id = $(this).data('id');
				$('#employee_id').val(id);

			});
		$('#random_password').click(function(){
			var str = Math.floor((Math.random() * 1000000) + 1);
			$('#new_password').val(str);
		});

		if(err)
		{

	    	$('#myModal').modal('show');
		}
	</script>
	@endsection
