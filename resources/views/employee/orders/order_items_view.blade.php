@extends('master')
@section('content')
	
<div class="row">
	@foreach($cards as $card)
	<?php $url = url('orders/'.$username); ?>
		<div class="col-md-3" style="margin-top:10px;">
			<img src="{{ $url.'/'.$card->front_snap }}" style="height:100%;width:100%;">
		</div>
		@if($card->back_snap)
			<div class="col-md-3" style="margin-top:10px;">
				<img src="{{ $url.'/'.$card->back_snap }}" style="height:100%;width:100%;">
			</div>
		@endif
	@endforeach
	<div class="col-md-8 col-md-offset-4">
			{{ $cards->links() }}
	</div>
	<div class="col-md-8 col-md-offset-4">
			<a href="{{ url('order/confirm/'.$order_id) }}" class="btn btn-primary" id="confirm">CONFIRM ORDER</a>
	</div>
	
</div>

@endsection