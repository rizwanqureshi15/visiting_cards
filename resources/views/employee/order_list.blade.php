@extends('master')
@section('content')

	<div class="row">
		<div class="col-md-3"><h2>Orders</h2></div>
		<div class="col-md-12" style="margin-top:20px;">
			@if(Session::get('succ_msg'))
				<div class="alert alert-success" role="alert">
				  <a class="alert-link">{{ Session::get('succ_msg') }}</a>
				</div>
			@endif
			
			<table id="order_table" class="table table-condensed datatable" style="width:100%;">
				<thead>
					<tr>
						<th> Order No. </th>
						<th> Username </th>
						<th> Quantity </th>
						<th> Amount </th>
						<th> Status </th>
						<th> Action </th>
					</tr>
				</thead>
				<tbody>
	 			</tbody>
	 			
			</table>

		</div>
	</div>
@endsection

@section('js')
	<script>
    $(document).ready(function(){
      $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/order-datatable") }}',
            columns:[
            	{data: 'order_no', name: 'order_no' , orderable: true, searchable: true},
            	{data: 'user_id', name: 'user_id', orderable: true, searchable: true},
            	{data: 'quantity', name: 'quantity', orderable: true, searchable: false},
            	{data: 'amount', name: 'amount', orderable: true, searchable: false},
            	{data: 'status', name: 'status', orderable: true, searchable: false},
            	{data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "aoColumnDefs": [
                { "sClass": "text-center", "aTargets": [ 0,1,2,3,4,5 ] },
              ]
        });
    });
  </script>
	
@endsection
