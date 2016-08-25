@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row">
        <div class="col-md-3">
            	 <table class="table mytable" border="1" style="margin-top:20px;">
                    <thead>
                        <tr class="mytheadtr">
                            <th class="headtext" id="flip">Orientation</th>
                        </tr>
                    </thead>
                    <tbody id="orientation">
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
                            <th class="headtext" id="flip1">Category</th>
                        </tr>
                    </thead>
                    <tbody id="category" style="display:none;">
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
		        			<img class="image" src="{{ url('templates/snaps/'.$template->snap) }}" style="margin-top:20px;width:100%;height:175.16px;"> 
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

    $(document).ready(function(){

        $("#flip").click(function(){
            $("#orientation").slideToggle("slow");
        });

        $("#flip1").click(function(){
            $("#category").slideToggle("slow");
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
                    html+="<div class='col-md-4'><a href="+site_url+"/idcard/"+val.url +">";
                    html+="<img  class='image' src='"+site_url+"/templates/snaps/"+ val.snap+"' style='margin-top:20px;width:100%;'>";
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