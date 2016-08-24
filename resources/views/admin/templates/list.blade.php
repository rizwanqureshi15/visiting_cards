@extends('master')
@section('content')

	<div class="row">
		<div class="col-md-3"><h2>Templates</h2></div>
		<div class="" style="margin-top:30px;">
			<a href="{{ url('admin/templates/create') }}" class="btn btn-primary pull-right">Add Template</a>
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
					<th> Type </th>
					<th> Category </th>
					<th> Action </th>
					<th> Feilds </th>
				</tr>
			</thead>
			<tbody>
				@if($templates->count() == 0)
				<tr>
					<td>Data Not Found..!</td>
				</tr>
				@else
 				@foreach($templates as $template)
 				<tr>
 					<td> {{ $template->name }}</td>
 					<td> {{ $template->type }}</td>
 					<td> {{ $template->category->name }}</td>
 					<td> 
 						<a href="{{ url('admin/templates/edit', $template->id) }}">Edit</a> | 
 						<a data-toggle="modal"  style="cursor: pointer" class="delete_password" data-target="#onDelete" data-delete="{{ $template->id }}" >Delete</a> 
 					</td>
 					<td>
 					<a href='{{ url("admin/templates/$template->url") }}'>View Feilds</a>
 					</td>

 				</tr>
 				@endforeach
 				@endif
 			</tbody>
 			
			</table>

		</div>
		<div class="col-md-8 col-md-offset-4">
			{{ $templates->links() }}
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
	</script>
	@endsection
