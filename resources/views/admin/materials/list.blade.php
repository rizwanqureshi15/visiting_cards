@extends('master')

@section('content')

	<div class="row">
		<div class="col-md-3">
			<h2>Materials</h2>
		</div>
		<div class="" style="margin-top:30px;">
			<a href="{{ url('admin/materials/create') }}" class="btn btn-primary pull-right">Add Material</a>
		</div>
		<div class="col-md-12" style="margin-top:20px;">
			@if(Session::get('succ_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('succ_msg') }}</a>
				</div>
			@endif
			
			<table class="table table-condensed">
			<thead>
				<tr>
					<th> Name </th>
					<th> Price </th>
					<th> Description </th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
				@if($materials->count() == 0)
					<tr>
						<td>Data Not Found..!</td>
					</tr>
				@else
 					@foreach($materials as $material)
		 				<tr>
		 					<td> {{ $material->name }}</td>
		 					<td> {{ $material->price }}</td>
		 					<td> {{ $material->description }}</td>
		 					<td> 
		 						<a href="{{ url('admin/materials/edit', $material->id) }}">Edit</a> | 
		 						<a data-toggle="modal"  style="cursor: pointer" class="delete_material" data-target="#onDelete" data-delete="{{ $material->id }}" >Delete</a> 
		 					</td>
		 				</tr>
	 				@endforeach
 				@endif
 			</tbody>
 			
		</table>

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
	<div class="col-md-8 col-md-offset-4">
		{{ $materials->links() }}
	</div>
</div>
			
@endsection

@section('js')
	<script type="text/javascript">
		
		$('.delete_material').click(function(){
			var id = $(this).data('delete');
			$('#material_delete_id').val(id);
		});

	</script>
	
@endsection
