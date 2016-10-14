@extends('master')
@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		@if(Session::get('succ_msg'))
			<div class="alert alert-success" role="alert">
				<a class="alert-link">{{ Session::get('succ_msg') }}</a>
			</div>
		@endif
        <div class="x_panel">
            <div class="x_title">
            	<h2>Templates</h2>
             	<ul class="nav navbar-right panel_toolbox">
             		<a href="{{ url('admin/templates/create') }}" class="btn btn-primary pull-right">Add Template</a>
                </ul>
                <div class="clearfix"></div>
            </div>
         	<div class="x_content">
         		<table class="table table-hover datatable">
					<thead>
						<tr>
							<th> Name </th>
							<th> Type </th>
							<th> Category </th>
							<th> Action </th>
							<th> Feilds </th>
						</tr>
					</thead>
					<tbody>
		 			</tbody>	
				</table>
	        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="onDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			{{ Form::open(array('method' => 'post', 'url' => url('admin/templates/delete'), 'class' =>"form-horizontal")) }}
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Delete Templates</h4>
			</div>
			<div class="modal-body">
			   	<div class="form-group">
					<label for="inputPassword3" class="col-sm-6 control-label">Are you sure want to delete ?</label>
					<div class="col-sm-6">
					   	{{ Form::hidden('delete_id', null, ['id' => 'template_delete_id']) }}
					       
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
		var err = "{{ $errors->first('password') }}";
		$('.reset_password').click(function(){
				//$('#employee_id').val($('.reset_password').data('id'));
				var id = $(this).data('id');
				$('#employee_id').val(id);

			});

		$('.delete_password').click(function(){
				var delete_id = $(this).data('delete');
				$('#template_delete_id').val(delete_id);

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
	            ajax: '{{ url("admin/templates-datatable") }}',
	            columns:[
	            	{data: 'name', name: 'name' , orderable: true, searchable: true},
	            	{data: 'type', name: 'type', orderable: true, searchable: true},
	            	{data: 'category_id', name: 'category_id', orderable: true, searchable: true},
	            	{data: 'action', name: 'action', orderable: false, searchable: false},
	            	{data: 'feilds', name: 'feilds', orderable: false, searchable: false}
	            	
	            ],
	            "aoColumnDefs": [
	                { "sClass": "text-center", "aTargets": [ 0,1,2,3,4 ] },
	              ]
	        });
	  });
	</script>
	@endsection
