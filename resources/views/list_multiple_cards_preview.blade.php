@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>
        
        <!--<div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="col-md-12">-->
                    <div class="col-md-3"></div>   
                        @foreach($template_data as $template)
                            <div class="col-md-7" style="margin-top:20px;">
                                <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                                <canvas id="canvas_id" width="680" height="419">
                                </canvas>
                                    <div id="card_body">

                                        @if($feilds)

                                            @foreach($feilds as $f)
                                                <?php
                                                    
                                                    $id = $f->name; 
                                                    $id = str_replace(" ","_",$f->name);
                                                    $id = strtolower($id);
                                                    
                                                ?>
                                            
                                                <div id="{{ $id }}" data-name="{{ $f->name }}" class='idcard-transperent ui-widget-content textbox-size feild-elements' style="{{ $f->css }}">
                                                    <span id="span_{{ $id }}" style="{{ $f->font_css }};">
                                                         
                                                    </span>
                                                </div>
                                            @endforeach

                                        @endif

                                         @if($images)
                                            @foreach($images as $image)
                                                <?php
                                                    $id = $image->id;
                                                    $src = $image->src;
                                                    $css = $image->css;
                                                    $div_css = $image->div_css;
                                                ?>
                                                    <div id="div_image_{{ $id }}" style="{{ $div_css }}" class="template_image_div">
                                                        <img src="{{ url('templates/images', $src) }}"  style="{{ $css }}" class="template_image" data-id="{{ $id }}" id = "image_{{ $id }}">
                                                    </div>
                                            @endforeach
                                        @endif
                                        </div>

                                </div>
                            </div>
                        @endforeach
        <!--        </div>
            </div>
        </div> -->

    
    
    </div>
</div>
@endsection

@section('js')

<script>
  

    var  site_url = "{{url('')}}";
    var page_no = 1;
    var last_page = false;
    var element = $("#multiple_user_card_snap");
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";

    var multiple_cards = {!! json_encode($cards_data) !!};
    $(document).ready(function(){
        $.each(multiple_cards, function( i,val ) 
        {
            $.each(val, function(key, value){
                $('#span_'+key).text(value);
            });
            
             html2canvas(element, {
                onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");

                $.ajax({
                type: "POST",
                url: site_url+'/multiple_save_cards',
                dataType: 'json',
                data: {"_token": token ,"image": imgageData},
                success : function(image){
                        alert('save');
                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });


                 }
             }); 
              
              
        });
    });
    $(document).ready(function() {
        var win = $(window);
        
        

        win.scroll(function() {
            // End of the document reached?
        
            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
                $.ajax({
                    type: "POST",
                    url: "{{ url('user-images') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","page_no":page_no},
                    success: function(user_cards) {
                        if(user_cards.length == 0){  
                            last_page=true;
                        }
                        
                        page_no++;
                        var html = '';

                            $.each(user_cards, function( i,val ) 
                            {
                                html+="<div class='col-md-4'><img src='"+site_url+"/images/"+ username+"/"+ val.image +"' style='width:100%;padding-top:20px;'></div>";
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