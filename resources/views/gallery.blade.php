@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-3">
        	 <table class="table mytable" border="1" style="margin-top:20px;">
                <thead>
                    <tr class="mytheadtr">
                        <th class="headtext">Category</th>
                    </tr>
                </thead>
               <tbody>
                    <tr>
                        <th><input class="form-control toolbar-elements" type="text" id="sidebar_company_name" name="company_name" placeholder="Enter Company name"></th>
                    </tr>
                    <tr>
                        <th><input class="form-control toolbar-elements" type="text" id="sidebar_company_message" name="company_message" placeholder="Company Message"></th>
                    </tr>
                    <tr>
                        <th><input class="form-control toolbar-elements" type="text" id="sidebar_full_name" name="full_name" placeholder="Full Name"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-9" >
        	<div class="col-md-12" id="posts">
	        	@foreach ($cards as $card)
	        		<div class="col-md-4">
	        			<a href="{{ url('idcard/'.$card->url) }}">
		        			@if($card->background_image)
		        					<img src="{{ url('images/'.$card->background_image) }}" style="margin-top:20px;width:100%;"> 
		        			@elseif($card->background_color)
		        				<div style="background-color:{{$card->background_color}};margin-top:20px;width:100%; height:175.16px;">    
		        				</div>
		        			@endif
	        			</a>
	        		</div>
	        	@endforeach
        	</div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
   /* $(window).scroll(function() {
        if($(window).scrollTop()  > $(window).height() / 2)
        {
            
        }
    });*/
    var  site_url = "{{url('')}}";
    var page_no=1;
    var last_page=false;
    $(document).ready(function() {
        var win = $(window);
        
        win.scroll(function() {
            // End of the document reached?
        
            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
                $.ajax({
                    type: "POST",
                    url: "{{ url('templates') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","page_no":page_no},
                    success: function(cards) {
                        console.log(cards.length);
                        if(cards.length == 0){  
                            last_page=true;

                        }
                        
                        page_no++;
                        var html = '';

                            $.each(cards, function( i,val ) {
                                html+="<div class='col-md-4'><a href="+site_url+"/idcard/"+val.url +">";
                                if(val.background_image) 
                                {
                                    html+="<img src='"+site_url+"/images/"+ val.background_image+"' style='margin-top:20px;width:100%;'>";      
                                    //html+="<div style='background-image:url('"+site_url+"/images/"+ val.background_image+"');margin-top:20px;width:100%;height:175.17px;'></div>";
                                } 
                                else if(val.background_color) 
                                {
                                     html+="<div style='background-color:"+ val.background_color+";margin-top:20px;width:100%;height:175.16px;'></div>";
                                }
                                html+="</a></div>";
                             });

                        $('#posts').append(html);
                    }
                });
                }
            }
        });
    
});

</script>

@endsection