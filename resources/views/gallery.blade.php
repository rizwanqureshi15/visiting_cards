@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row block">
        <div class="col-md-3">
            	 <table class="table mytable" border="1" style="margin-top:20px;">
                    <thead>
                        <tr class="mytheadtr">
                            <th class="headtext" id="orientation-flip">Orientation</th>
                        </tr>
                    </thead>
                    <tbody id="orientation" class="panel-body">
                        <div class="orientation">  
                            <tr>
                                <th><input class="toolbar-elements" rel="horizontal" id="horizontal" type="checkbox" name="orientation" class="chk" value="horizontal"> <span>Horizontal</span></th>
                            </tr>
                            <tr>
                                <th><input class="toolbar-elements" rel="vertical" id="vertical" type="checkbox" name="orientation" class="chk" value="vertical"> <span>Vertical</span></th>
                            </tr>
                        </div>
                    </tbody>
                    <thead>
                        <tr class="mytheadtr">
                            <th class="headtext" id="category-flip">Category</th>
                        </tr>
                    </thead>
                    <tbody id="category" style="display:none;" class="panel-body">
                        <div class="category">
                            @foreach($categories as $category)
                                <tr>
                                    <th><input class="category" id="{{ $category->id }}" type="checkbox" name="category" value="{{ $category->id }}"> <span>{{ $category->name }}</span></th>
                                </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
        </div>
        <div class="col-md-9" >
        	<div class="col-md-12" id="posts">
	        	@foreach ($templates as $template) 
	        		<div class="col-sm-4 col-xs-12">
	        			<a href="{{ url('mytemplates/'.$template->url.'/create') }}">
		        			@if($template->type=="horizontal")
                                <img class="image" src="{{ url('templates/snaps/'.$template->snap) }}" style="margin-top:20px;width:100%;height:175.16px;"> 
                                <span class="cards-data">{{ $template->name }}</span><br>
                                <span class="cards-data"><h3>Rs. {{ $template->price }}</h3></span>
                            @else
                                <img class="image" src="{{ url('templates/snaps/'.$template->snap) }}" style="margin-top:20px;margin-left:60px;width:50%;height:175.16px">
                                <span class="cards-data col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">{{ $template->name }}</span><br>
                                <span class="cards-data col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12"><h3 class='vertical-price'>Rs. {{ $template->price }}</h3></span>
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

    var category_id = "{{ $category_id }}"; 

    if(!category_id.trim())
    {
      
    }
    else
    {
        $('#'+category_id).attr('checked', true);

        $("#category").slideToggle("slow");
        $("#orientation").hide();
    }
    
    
    $(document).ready(function(){

        $("#orientation-flip").click(function(){
            $("#orientation").slideToggle("slow");
            $("#category").hide();
        });

        $("#category-flip").click(function(){
            $("#category").slideToggle("slow");
            $("#orientation").hide();
        });

    });

    var site_url = "{{url('')}}";
    var page_no=1;
    var last_page=false;
    var lp=false;
    
    var horizontal;
    var vertical;

$("input[type='checkbox']").on("click",function(){

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

                    if(val.type == "horizontal")
                                {
                                    html+="<div class='col-md-4'><a href="+site_url+"/mytemplates/"+val.url +"/create>";
                                    html+="<img src='"+site_url+"/templates/snaps/"+ val.snap+"' style='margin-top:20px;width:100%;height:175.16px;'>";
                                    html+="</a>";
                                    html+="<span class='cards-data'>"+val.name+"</span><br>";
                                    html+="<span class='cards-data'><h3>Rs. "+val.price+"</h3></span>";
                                    html+="</div>";
                                }
                                else
                                { 
                                    html+="<div class='col-md-4'><a href="+site_url+"/mytemplates/"+val.url +"/create>";
                                    html+="<img src='"+site_url+"/templates/snaps/"+ val.snap+"' style='margin-top:20px;margin-left:60px;width:50%;height:175.16px'>";
                                    html+="</a>";
                                    html+="<span class='cards-data col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12'>"+val.name+"</span><br>";
                                    html+="<span class='cards-data col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12'><h3 class='vertical-price'>Rs. "+val.price+"</h3></span>";
                                    html+="</div>";
                                }
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
                                html+="<img src='"+site_url+"/templates/snaps/"+ val.snap+"' style='margin-top:20px;width:100%;'>";
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