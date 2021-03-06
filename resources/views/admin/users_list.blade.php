@extends('master')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Users</h3>
  </div>
  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Users</li>
          <li class="active">List</li>
        </ol>
    </div>
  </div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            	<table class="table table-hover datatable">
					<thead>
						<tr>
							<th> Name </th>
							<th> Username </th>
							<th> E-mail</th>
						</tr>
					</thead>
					<tbody>
		 			</tbody>
				</table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
	var site_url = "{{ url('') }}";
	var token = "{{ csrf_token() }}";
	      
	$('.datatable').DataTable({
        processing: true,
	    serverSide: true,
	    ajax: '{{ url("admin/users-datatable") }}',
	    columns:[
	       	{data: 'first_name', name: 'first_name' , orderable: true, searchable: true},
	        {data: 'username', name: 'username', orderable: true, searchable: true},
	        {data: 'email', name: 'email', orderable: true, searchable: true}     	
	        ],
	    "aoColumnDefs": [
	        { "sClass": "text-center", "aTargets": [ 0,1,2 ] },
	        ]
	    });
	  });
</script>
@endsection

	