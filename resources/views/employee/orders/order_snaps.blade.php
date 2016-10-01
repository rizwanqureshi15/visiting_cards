@extends('master')
@section('content')
<style>

</style>
<div class="row">
	<div class="col-md-offset-2 col-md-10"  style="display:block;">
		<img src="{{ url('orders/snaps/'.$cards[0]->snap) }}" id="print_image" style="height:70%;width:70%;">
	</div>
	<div class="col-md-4 col-md-offset-8" id="print_button" style="margin-top:10px;">
		<button class="btn btn-primary" id="print_snap">Print</button>
	</div>
	<div class="col-md-8 col-md-offset-4" id="links">
			{{ $cards->links() }}
	</div>
</div>



@endsection

@section('js')

<script type="text/javascript">
	var site_url = "{{ url('') }}";
	$('#print_snap').click(function(){
		
		 $('#sidebar').css('display', 'none');
		 $('#print_button').css('display', 'none');
		 $('#links').css('display', 'none');
		 $('#print_image').css('width', '100%');
		 $('#print_image').css('height', '100%');
		// $('#print_div').css('display', 'block');
		 window.print();
		 $('#sidebar').css('display', 'block');
		 $('#print_button').css('display', 'block');
		 $('#links').css('display', 'block');
		 $('#print_image').css('width', '70%');
		 $('#print_image').css('height', '70%');
	});
</script>
@endsection