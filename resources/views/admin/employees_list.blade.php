@extends('master')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
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
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">	
			<div class="x_panel">
				<div class="x_title">
					<h2>Employees</h2>
					<ul class="nav navbar-right panel_toolbox">
						<a href="{{ url('admin/employees/create') }}" class="btn btn-primary pull-right">Add Employee</a>
	                </ul>
	                <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-hover datatable">
						<thead>
							<tr>
								<th> Name </th>
								<th> Username </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
			 			</tbody>
			 		</table>
				</div>
			</div>
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


			<div class="modal fade" id="onDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    {{ Form::open(array('method' => 'post', 'url' => url('admin/delete_employee'), 'class' =>"form-horizontal")) }}
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Delete Employee</h4>
			      </div>
			      <div class="modal-body">

			        <div class="form-group">
					     <label for="inputPassword3" class="col-sm-6 control-label">Are you sure want to delete ?</label>
					    <div class="col-sm-6">
					    	{{ Form::hidden('delete_id', null, ['id' => 'employee_delete_id']) }}
					       
					    </div>
					    
					  </div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       <!--  <button type="button" class="btn btn-primary" >Generate Password</button> -->
			        <input type="submit" class="btn btn-primary" value="Delete">
			        
			      </div>
			      {{ Form::close() }}
			    </div>
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

		$('.delete_password').click(function(){
				var delete_id = $(this).data('delete');
				$('#employee_delete_id').val(delete_id);

			});

		$('#random_password').click(function(){
			var str = Math.floor((Math.random() * 100000000) + 1);
			$('#new_password').val(str);
		});

		if(err)
		{

	    	$('#myModal').modal('show');
		}
		$(document).ready(function(){
	        var site_url = "{{ url('') }}";
	    	var token = "{{ csrf_token() }}";
	      $('.datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: '{{ url("admin/employees-datatable") }}',
	            columns:[
	            	{data: 'first_name', name: 'first_name' , orderable: true, searchable: true},
	            	{data: 'username', name: 'username', orderable: true, searchable: true},
	            	{data: 'action', name: 'action', orderable: false, searchable: false}
	            	
	            ],
	            "aoColumnDefs": [
	                { "sClass": "text-center", "aTargets": [ 0,1,2 ] },
	              ]
	        });
	  });
	</script>
	@endsection
