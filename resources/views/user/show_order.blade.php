@extends('layouts.app')

@section('content')

</div class="container">
	<div class="row">
		<div class="col-md-12" id="scroll">
			@foreach($user_cards as $card)
				<div class="col-md-3">
					<img class="col-md-12" src="{{ url('order/'.$username.'/'.$order_no.'/front/'.$card->front_snap) }}" style="margin-top:20px;">
				</div>

				@if($is_back == true)
				<div class="col-md-3">
					<img class="col-md-12" src="{{ url('order/'.$username.'/'.$order_no.'/back/'.$card->front_snap) }}" style="margin-top:20px;">
				</div>				
				@endif

			@endforeach
		</div>
	</div>
</div>

@endsection

@section('js')

<script>

	var site_url = "{{url('')}}";
	var page_no=1;
    var last_page=false;
    var username = {!! json_encode($username) !!};
    var order_no = {!! json_encode($order_no) !!};
    var is_back = "{{ $is_back }}";

    $(document).ready(function() {
        var win = $(window);
        
        win.scroll(function() {

            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
	                $.ajax({
	                    type: "POST",
	                    url: "{{ url('scroll_pagination') }}",
	                    dataType: 'json',
	                    data: {"_token": "{{ csrf_token() }}","page_no":page_no,"order_no":order_no,"is_back":is_back},
	                    success: function(cards) {
	                        console.log(cards.length); 
	                        if(cards.length == 0){ 
	                            //last_page=true;
	                        }
	                        
	                        page_no++;
	                        var html = '';

	                            $.each(cards, function( i,val ) {

	                            	if(val.front_snap)
	                                {
	                                	html+="<div class='col-md-3'>";
	                                	html+="<img class='col-md-12' src='"+site_url+"/order/"+username+"/"+order_no+"/front/"+ val.front_snap+"' style='margin-top:20px;'>";
	                                	html+="</div>";
	                                }
	                                
	                                if(val.back_snap.length !=0)
	                                {
	                                	html+="<div class='col-md-3'>";
	                                	html+="<img class='col-md-12' src='"+site_url+"/order/"+username+"/"+order_no+"/back/"+ val.back_snap+"' style='margin-top:20px;'>";
	                                	html+="</div>";
	                                }
    
	                             });

	                        $('#scroll').append(html);
	                    }
	                });
                }
            }
        });
    
});

</script>

@endsection