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
	            <h2>Confirmed Orders</h2>
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
							<th> Status </th>
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
@endsection

@section('js')
	<script>
    $(document).ready(function(){
    	var site_url = "{{ url('') }}";
    	var token = "{{ csrf_token() }}";
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
    var table = $('#order_table').DataTable();
    $('#order_table tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    $(document).on("click",'.cancel_order', function(){
    	
    	var order_id = $(this).data('id');
    	var val = confirm("Are you sure you want to Cancel Order ?");
		if(val)
		{
			$(this).closest("tr").hide();
			$.ajax({
            type: "POST",
            url: site_url+'/cancel_order',
            dataType: 'json',
            async: false,
            data: {"_token": token ,"order_id":order_id},
            success : function(image)
            {
            }})	
            table.draw();
		}
		else
		{

		}
		});
    	$(document).on('click', '.done_order', function(){

    		var order_id = $(this).data('id');
    		var val = confirm("Are you sure Order is Complate ?");
			if(val)
			{
				$.ajax({
	            type: "POST",
	            url: site_url+'/done_order',
	            dataType: 'json',
	            async: false,
	            data: {"_token": token ,"order_id":order_id},
	            success : function(image)
	            {
	            }})	
	            table.draw();
			}
			else
			{
			}
    	});
    });
  </script>
	
@endsection
