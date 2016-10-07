@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>

        <div class="col-md-12">
	        <table class="table table-condensed">

	        	<thead>
	        		<th>Order No.</th>
	        		<th>Material</th>
	        		<th>Amount</th>
	        		<th>Quentity</th>
	        		<th>Status</th>
	        		<th>View</th>
	        	</thead>

	        	<tbody>
	        		@if(count($user_orders) == 0)
	        			<td>No data found...</td>
	        		@endif
	        		@foreach($user_orders as $order)
		        		<tr>
		        			<td>{{ $order->order_no }}</td>
		        			<td>{{ $order->material_id }}</td>
		        			<td>{{ $order->amount }}</td>
		        			<td>{{ $order->quantity }}</td>
		        			<td>{{ $order->status }}</td>
		        			<td><a href="{{ url('view_order',$order->id) }}">
		        				View Cards
		        			</a></td>
		        		</tr>
		        	@endforeach
	        	</tbody>

	        </table>
	    </div>

    </div>
</div>

@endsection