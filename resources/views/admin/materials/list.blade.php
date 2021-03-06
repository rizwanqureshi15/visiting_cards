@extends('master')

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Materials</h3>
  </div>
  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Materials</li>
          <li class="active">List</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		@if(Session::get('succ_msg'))
			<div class="alert alert-success" role="alert">
				 <a class="alert-link">{{ Session::get('succ_msg') }}</a>
			</div>
		@endif
        <div class="x_panel">
            <div class="x_title">
            	<h2>List</h2>
             	<ul class="nav navbar-right panel_toolbox">
             		<a href="{{ url('admin/materials/create') }}" class="btn btn-primary pull-right">Add Material</a>
                </ul>
                <div class="clearfix"></div>
            </div>
         	<div class="x_content">
         		<table class="table table-hover datatable">
					<thead>
						<tr>
							<th> Name </th>
							<th> Price </th>
							<th> Description </th>
							<th> Actions </th>
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
			{{ Form::open(array('method' => 'post', 'url' => url('admin/materials/delete'), 'class' =>"form-horizontal")) }}    
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			    </button>
			    <h4 class="modal-title" id="myModalLabel">Delete Templates</h4>
			</div>
			<div class="modal-body">
			    <div class="form-group">
				    <label for="inputPassword3" class="col-sm-6 control-label">
				    	Are you sure want to delete ?
				    </label>
			    	<div class="col-sm-6">
				    	{{ Form::hidden('delete_id', null, ['id' => 'material_delete_id']) }}
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
		
		$(document).on('click','.delete_material', function(){
			var id = $(this).data('delete');
			$('#material_delete_id').val(id);
		});
	$(document).ready(function(){
    	var site_url = "{{ url('') }}";
    	var token = "{{ csrf_token() }}";
       $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/material-datatable") }}',
            columns:[
            	
            	{data: 'name', name: 'name' , orderable: true, searchable: true},
            	{data: 'price', name: 'price' , orderable: true, searchable: true},
            	{data: 'description', name: 'description' , orderable: true, searchable: true},
            	{data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-center", "aTargets": [ 0,1 ] },
              ]
        });
   });
	</script>
	
@endsection
