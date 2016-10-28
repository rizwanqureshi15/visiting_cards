@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row block">
        <div class="col-md-12">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>

        <div class="col-md-12">
        	<div class="innerWrapper">
        		<h4>All Orders</h4>
		        <table class="table table-condensed">
		        	<thead>
		        		<tr>
			        		<th>Order No.</th>
			        		<th>Material</th>
			        		<th>Amount</th>
			        		<th>Quentity</th>
			        		<th style="width:25%">View</th>
			        	</tr>
		        	</thead>

		        	<tbody>
		        		@if(count($user_orders) == 0)
			        		<tr>
			        			<td>No data found...</td>
			        		</tr>
		        		@endif
		        		@foreach($user_orders as $order)
			        		<tr>
			        			<td>{{ $order->order_no }}</td>
			        			<td>{{ $order->material_id }}</td>
			        			<td>{{ $order->amount }}</td>
			        			<td>{{ $order->quantity }}</td>
			        			<td >
				        			<a class="model-btn text-center" href="{{ url('view_order',$order->id) }}">
				        				View Cards
				        			</a>
				        			
				        			@if($order->status == "unpaid")
				        				<a href="{{ url('order/'.$order->order_no.'/payment') }}" class="model-btn" > 
				        					Proceed
				        				</a>
				        			@endif

				        			@if($order->status == "new")
				        				<a class="model-btn cancle-btn order" data-order="{{ $order->id }}" data-toggle="modal" data-target="#cancel_order"> 
				        					Cancle
				        				</a>
				        			@endif
			        			</td> 
			        		</tr>
			        	@endforeach
		        	</tbody>

		        </table>
		        <div class="text-center">
		        	{{ $user_orders->links() }}
		        </div>
	    	</div>
	    </div>


	    <!--Modal-->
                <div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Cancel Order</h4>
                          </div>
                          <div class="modal-body">
                          		Are you sure want to cancle ?
                          </div>
                          <div class="modal-footer">
                            <a href="" id="order_cancle">
                                <button type="button" class="model-btn" >Yes</button>
                            </a>
                            <button type="button" class="model-btn" data-dismiss="modal">No</button>
                          </div>
                        </div>
                      </div>
                </div> 
        <!--Modal End--> 


    </div>
</div>

@endsection

@section('js')

<script>

	$(".order").click(function()
    {
        var order_id = $(this).data('order');
        var new_url = '{{ url("cancel_order") }}/'+order_id+'';
                
        $('#order_cancle').attr('href',new_url);

    });

</script>

@endsection