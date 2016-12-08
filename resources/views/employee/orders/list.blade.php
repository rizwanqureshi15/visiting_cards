@extends('master')

@section('content')
<div id="user_overlay" style="display:none;">
    <img id="user_loading" src="{{ url('assets\images\loading.gif') }}">
</div>
<div class="row">
	<div class="col-md-12">
			
		@if($card_type == "vertical")
		<canvas style="width:2480px;height:3508px;position:absolute;"></canvas>	
		<div style="width:2480px;height:3508px;border:3px solid black;padding:100px;background-color:white;" id="a5">
			<div class="row">
				<div class="col-md-6 vertical-odd-card-master">
					<div class="vertical-card">	
						<img src="" id="vertical_image_1" class="vertical-card-image">
					</div>
				</div>
					
				<div class="col-md-6 vertical-even-card-master">
					<div class="vertical-card">
						<img src="" id="vertical_image_2" class="vertical-card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 vertical-odd-card-master">
					<div class="vertical-card">	
						<img src="" id="vertical_image_3" class="vertical-card-image">
					</div>
				</div>
					
				<div class="col-md-6 vertical-even-card-master">
					<div class="vertical-card">
						<img src="" id="vertical_image_4" class="vertical-card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 vertical-odd-card-master">
					<div class="vertical-card">	
						<img src="" id="vertical_image_5" class="vertical-card-image">
					</div>
				</div>
					
				<div class="col-md-6 vertical-even-card-master">
					<div class="vertical-card">
						<img src="" id="vertical_image_6" class="vertical-card-image">	
					</div>
				</div>
			</div>
		</div>
		@else
		<canvas style="width:2480px;height:3508px;position:absolute;"></canvas>	
		<div style="width:2480px;height:3508px;border:3px solid black;padding:100px;background-color:white;" id="a4">
			<div class="row">
				<div class="col-md-6 odd-card-master">
					<div class="card">	
						<img src="" id="image_1" class="card-image">
					</div>
				</div>
					
				<div class="col-md-6 even-card-master">
					<div class="card">
						<img src="" id="image_2" class="card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 odd-card-master">
					<div class="card">	
						<img src="" id="image_3" class="card-image">
					</div>
				</div>
					
				<div class="col-md-6 even-card-master">
					<div class="card">
						<img src="" id="image_4" class="card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 odd-card-master">
					<div class="card">	
						<img src="" id="image_5" class="card-image">
					</div>
				</div>
					
				<div class="col-md-6 even-card-master">
					<div class="card">
						<img src="" id="image_6" class="card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 odd-card-master">
					<div class="card">	
						<img src="" id="image_7" class="card-image">
					</div>
				</div>
					
				<div class="col-md-6 even-card-master">
					<div class="card">
						<img src="" id="image_8" class="card-image">	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 odd-card-master">
					<div class="card">	
						<img src="" id="image_9" class="card-image">
					</div>
				</div>
					
				<div class="col-md-6 even-card-master">
					<div class="card">
						<img src="" id="image_10" class="card-image">	
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>	
</div>

@endsection

@section('js')
	<script type="text/javascript">
		var cards = {!! json_encode($cards) !!};
		var site_url = "{{ url('') }}";
		var username = "{{ $username }}";
		var order_no = "{{ $order_no }}";
		var token = "{{ csrf_token() }}";
		var card_type = "{{ $card_type }}";
	</script>
	<script src="{{ url('assets/js/order_snap.js') }}" ></script>

@endsection