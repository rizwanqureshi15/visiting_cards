@extends('master')
@section('content')

	<div class="row">
		<div class="col-md-5"><h2>Template Categories</h2></div>
		<div class="" style="margin-top:30px;">
			<a href="{{ url('admin/categories/create') }}" class="btn btn-primary pull-right">Add Category</a>
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
					<th> Action </th>
				</tr>
			</thead>
			<tbody>
				@if($categories->count() == 0)
				<tr>
					<td>Data Not Found..!</td>
				</tr>
				@else
 				@foreach($categories as $category)
 				<tr>
 					<td> {{ $category->name }} </td>
 					<td> 
 						<a href="{{ url('admin/categories/edit', $category->id) }}">Edit</a> | 
 						<a data-toggle="modal"  style="cursor: pointer" class="delete_category" data-target="#onDelete" data-delete="{{ $category->id }}" >Delete</a>
 				</tr>
 				@endforeach
 				@endif
 			</tbody>
 			
			</table>

		</div>
		<div class="col-md-8 col-md-offset-4">
			{{ $categories->links() }}
		</div>
		</div>
	
		
			<div class="modal fade" id="onDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    {{ Form::open(array('method' => 'post', 'url' => url('admin/categories/delete'), 'class' =>"form-horizontal")) }}
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
			      </div>
			      <div class="modal-body">

			        <div class="form-group">
					     <label for="inputPassword3" class="col-sm-6 control-label">Are you sure want to delete ?</label>
					    <div class="col-sm-6">
					    	{{ Form::hidden('delete_id', null, ['id' => 'category_delete_id']) }}
					       
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
	@endsection

	@section('js')
	<script type="text/javascript">
	$('.delete_category').click(function(){
				var delete_id = $(this).data('delete');
				$('#category_delete_id').val(delete_id);

			});
		</script>
	@endsection
