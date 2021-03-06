@extends('master')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Orders</h3>
  </div>
  <div class="title_right">
    <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb" style="width:260px;padding-left:0px;">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Orders</li>
          <li class="active">Order's History</li>
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
	            <h2>Order's History</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                     
	            </ul>
	            <div class="clearfix"></div>
	            </div>
	        <div class="x_content">
	        	<table id="order_table" class="table table-condensed datatable" style="width:100%;">
					<thead>
						<tr>
							<th> Order No. </th>
							<th> Username </th>
							<th> Quantity </th>
							<th> Amount </th>
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
	<script>
    $(document).ready(function(){
      $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("order-history-datatable") }}',
            columns:[
            	{data: 'order_no', name: 'order_no' , orderable: true, searchable: true},
            	{data: 'user_id', name: 'user_id', orderable: true, searchable: true},
            	{data: 'quantity', name: 'quantity', orderable: true, searchable: false},
            	{data: 'amount', name: 'amount', orderable: true, searchable: false},
            ],
            "aoColumnDefs": [
                { "sClass": "text-center", "aTargets": [ 0,1,2,3] },
              ]
        });
    });
  </script>
	
@endsection
