@extends('master')
@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Orders</h3>
  </div>
  <div class="title_right">
    <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
      <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Orders</li>
          <li>New Orders</li>
          <li class="active">Snaps</li>
      </ol>
      <div class="input-group">
        
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
	            <h2>Order Snaps</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                     
	            </ul>
	            <div class="clearfix"></div>
	            </div>
	        <div class="x_content">
	        	@foreach($cards as $card)
					<?php $url = url('order/'.$username); ?>
						<div class="col-md-3" style="margin-top:10px;">
							<img src="{{ $url.'/'.$order_no.'/front/'.$card->front_snap }}" style="height:100%;width:100%;border: 2px #ddd solid;">
						</div>
						@if($card->back_snap)
							<div class="col-md-3" style="margin-top:10px;">
								<img src="{{ $url.'/'.$order_no.'/back/'.$card->back_snap }}" style="height:100%;width:100%;border: 2px #ddd solid;">
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
	    </div>
	</div>
</div>

@endsection