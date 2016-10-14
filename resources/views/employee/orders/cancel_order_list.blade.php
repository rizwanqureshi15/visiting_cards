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
	            <h2>Cancelled Orders</h2>
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
	var site_url = "{{ url('') }}";
	var token = "{{ csrf_token() }}";
    $(document).ready(function(){
      $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/cancel-order-datatable") }}',
            columns:[
            	{data: 'order_no', name: 'order_no' , orderable: true, searchable: true},
            	{data: 'user_id', name: 'user_id', orderable: true, searchable: true},
            	{data: 'quantity', name: 'quantity', orderable: true, searchable: false},
            	{data: 'amount', name: 'amount', orderable: true, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-center", "aTargets": [ 0,1,2,3] },
              ]
        });
    });
  </script>
		
@endsection
