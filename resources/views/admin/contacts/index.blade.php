@extends('master')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">	
			@if(Session::get('succ_msg'))
			<div class="alert alert-success" role="alert">
			  <a class="alert-link">{{ Session::get('succ_msg') }}</a>
			</div>
			@endif
			<div class="x_panel">
				<div class="x_title">
					<h2>Contacts</h2>
					<ul class="nav navbar-right panel_toolbox">
	                </ul>
	                <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-hover datatable">
						<thead>
							<tr>
								<th> Name </th>
								<th> Email </th>
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
</div>
<div class="modal fade" id="onDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			{{ Form::open(array('method' => 'post', 'url' => url('admin/contacts/delete'), 'class' =>"form-horizontal")) }}
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Delete Contact</h4>
			</div>
			<div class="modal-body">
			    <div class="form-group">
				    <label for="inputPassword3" class="col-sm-6 control-label">Are you sure want to delete ?</label>
					<div class="col-sm-6">
			    		{{ Form::hidden('delete_id', null, ['id' => 'contact_delete_id']) }}
					</div>
				</div>
			</div>
			<div class="modal-footer">
			   	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    <input type="submit" class="btn btn-primary" value="Delete">
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

@endsection

@section('js')

<script type="text/javascript">	
	$(document).ready(function(){
	    var site_url = "{{ url('') }}";
    	var token = "{{ csrf_token() }}";
    	  $(document).on('click','.delete_contact', function(){
				var delete_id = $(this).data('delete');
				$('#contact_delete_id').val(delete_id);

			});
	      $('.datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: '{{ url("admin/contact-datatable") }}',
	            columns:[
	            	{data: 'name', name: 'name' , orderable: true, searchable: true},
	            	{data: 'email', name: 'email', orderable: true, searchable: true},
	            	{data: 'action', name: 'action', orderable: false, searchable: false}
	            	
	            ],
	            "aoColumnDefs": [
	                { "sClass": "text-center", "aTargets": [ 0,1,2 ] },
	              ]
	        });
	  });
</script>
@endsection