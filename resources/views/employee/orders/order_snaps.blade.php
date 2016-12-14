@extends('master')
@section('content')

<div class="page-title">
  <div class="title_left">
    <h3>Orders</h3>
  </div>
  <div class="title_right">
    <div class="col-md-7 col-sm-7 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb" style="padding-left:0px;">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Orders</li>
          <li>New Orders</li>
          <li class="active">Snaps</li>
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
	    <div class="x_panel" id="panel1">
	        <div class="x_title">
	            <h2>Order Snaps</h2>
	            <ul class="nav navbar-right panel_toolbox">
	                     
	            </ul>
	            <div class="clearfix"></div>
	        </div>
	        <div class="x_content">
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
	    </div>
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
		 	$('.x_title').hide();
		 	$('#panel1').removeClass('x_panel');
		 	$('.page-title').hide();
		 	$('.top_nav').hide();
		 	$('footer').hide();
		 	$('.x_content').css('padding', '0px');
		// $('#print_div').css('display', 'block');
		 window.print();
		  $('#sidebar').css('display', 'block');
		  $('#print_button').css('display', 'block');
		  $('#links').css('display', 'block');
		  $('#print_image').css('width', '70%');
		  $('#print_image').css('height', '70%');
		  $('.x_title').show();
		 	$('#panel1').addClass('x_panel');
		 	$('.page-title').show();
		 	$('.top_nav').show();
		 	$('footer').show();	
		 	$('.x_content').css('padding', '0 5px 6px');
	});
</script>
@endsection