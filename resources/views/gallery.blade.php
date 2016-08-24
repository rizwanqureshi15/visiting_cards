@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-3">
            	 <table class="table mytable" border="1" style="margin-top:20px;">
                    <thead>
                        <tr class="mytheadtr">
                            <th class="headtext">Orientation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="orientation">
                            <tr>
                                <th><input class="toolbar-elements" rel="horizontal" id="horizontal" type="checkbox" name="orientation" class="chk" value="horizontal"> Horizontal</th>
                            </tr>
                            <tr>
                                <th><input class="toolbar-elements" rel="vertical" id="vertical" type="checkbox" name="orientation" class="chk" value="vertical"> Vertical</th>
                            </tr>
                        </div>
                    </tbody>
                    <thead>
                        <tr class="mytheadtr">
                            <th class="headtext">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="category">
                            @foreach($categories as $category)
                                <tr>
                                    <th><input class="category" id="{{ $category->id }}" type="checkbox" name="category" value="{{ $category->id }}"> {{ $category->name }}</th>
                                </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
        </div>
        <div class="col-md-9" >
        	<div class="col-md-12" id="posts">
	        	@foreach ($templates as $template)
	        		<div class="col-md-4">
	        			<a href="{{ url('idcard/'.$template->url) }}">
		        			@if($template->background_image)
		        					<img src="{{ url('images/'.$template->background_image) }}" style="margin-top:20px;width:100%;height:175.16px;"> 
		        			@elseif($template->background_color)
		        				<div style="background-color:{{$template->background_color}};margin-top:20px;width:100%;height:175.16px;">    
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

    var site_url = "{{url('')}}";
    var page_no=1;
    var last_page=false;
    var lp=false;
    
    var horizontal;
    var vertical;

$("input[type='checkbox']").on("click",function(){

    /*if($('#horizontal').is(':checked'))
    {
        if($.inArray('horizontal', arr) == -1)
        {
            console.log('horizontal add');
            arr.push('horizontal');
            //console.log('horizontal delete');
        }
       
        //var horizontal="horizontal";
    }

     if($('#horizontal').is(':checked') == false)
        {
            console.log('horizontal delete');
            arr.splice($.inArray('horizontal', arr),1);
        }
        else
        {
            arr.push('horizontal');
        }

    if($('#vertical').is(':checked'))
    {
        if($.inArray('vertical', arr) == -1)
        {
            console.log('vertical add');
            arr.push('vertical');
            //console.log('vertical delete')
            //arr.remove('vertical');
        }

        //var vertical="vertical";
    }

    if($('#vertical').is(':checked') == false)
        {
            console.log('vertical delete');
            arr.splice($.inArray('vertical', arr),1);
        }
        else
        {
            arr.push('vertical');
        }

    if(($('#vertical').is(':checked')) && ($('#horizontal').is(':checked')))
    {
        console.log('both');
        arr.length = 0;
        arr.push('horizontal','vertical');       
    }*/

    /*$("input[type=checkbox]").change( function() {
    if($(this).is(":checked")){
       alert( $(this).val() );
    }
  });

    $("input.category[type=checkbox]").change( function() 
    {
        if($(this).is(":checked"))
        {
           console.log($(this).val());
           arr.push($(this).val());
        }
    });*/

    var orientations = [];
    $('input:checkbox[name=orientation]:checked').each(function() {
        orientations.push($(this).val());
    });

    var categories = [];
    $('input:checkbox[name=category]:checked').each(function() {
        categories.push($(this).val());
    });

      $.ajax( {
              type: "POST",
              url: "{{ url('filter') }}",
              dataType: 'json',
              data: {"_token": "{{ csrf_token() }}","category":categories,"orientations":orientations},
              success: function(orientation) {
                last_page = false;
                page_no = 1;
                var html = '';

                $.each(orientation, function( i,val ) {
                html+="<div class='col-md-4'><a href="+site_url+"/idcard/"+val.url +">";
                    if(val.background_image) 
                    {
                        html+="<img src='"+site_url+"/images/"+ val.background_image+"' style='margin-top:20px;width:100%;'>";      
                                        //html+="<div style='background-image:url('"+site_url+"/images/"+ val.background_image+"');margin-top:20px;width:100%;height:175.17px;'></div>";
                    } 
                    else if(val.background_color) 
                    {
                        html+="<div style='background-color:"+ val.background_color+";margin-top:20px;width:100%;height:174.17px;'></div>";
                    }

                    html+="</a></div>";
                    });

                $('#posts').html(html);

              }
            });
});


    $(document).ready(function() {
        var win = $(window);
        
        win.scroll(function() {
            // End of the document reached?
        
            var orientations = [];
            $('input:checkbox[name=orientation]:checked').each(function() {
                orientations.push($(this).val());
            });

            var categories = [];
            $('input:checkbox[name=category]:checked').each(function() {
                categories.push($(this).val());
            });


            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
                $.ajax({
                    type: "POST",
                    url: "{{ url('templates') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","page_no":page_no,"category":categories,"orientations":orientations},
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
                                } 
                                else if(val.background_color) 
                                {
                                     html+="<div style='background-color:"+ val.background_color+";margin-top:20px;width:100%;height:174.17px;'></div>";
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