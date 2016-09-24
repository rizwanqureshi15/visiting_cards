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

        <!--  style="z-index:1;position: absolute;top: 50%;left: 50%;margin-left: -(X/2)px;margin-top: -(Y/2)px;" -->
        <div id="user_overlay">
            <img id="user_loading" src="{{ url('assets\images\loading.gif') }}">
        </div> 

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="col-md-12">

                        @foreach($template_data as $template)

                            <div class="col-md-7" style="margin-top:20px;">
                                <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                                <canvas id="canvas_id" width="680" height="419">
                                </canvas>
                                    <div id="card_body">
                                        
                                        @if($user_feilds)
                                            @foreach($user_feilds as $f)
                                                 <?php
                                                    $id = $f->name;
                                                    $id = str_replace(" ","_",$f->name);
                                                    $id = strtolower($id);
                                                 ?>

                                                  <div id="{{ $id }}" data-name="{{ $f->name }}" class='idcard-transperent ui-widget-content textbox-size feild-elements' style="{{ $f->css }}">
                                                        <span id="span_{{ $id }}" style="{{ $f->font_css }};">
                                                                 {{ $f->content }}
                                                        </span>
                                                  </div>
                                             @endforeach
                                        @endif


                                        @if($images)
                                            @foreach($images as $image)
                                                @foreach($image_css as $img_css)
                                                    @if($img_css->id == $image->template_feild_id )
                                                         <?php
                                                            $id = $img_css->id;
                                                            $src = $image->src;
                                                            $css = $img_css->font_css;
                                                            $div_css = $img_css->css;
                                                            $name = $img_css->name;
                                                        ?>
                                                    @endif
                                                @endforeach

                                                    <div id="div_image_{{ $id }}" name="{{ $name }}" style="{{ $div_css }}" class="template_image_div">
                                                        <img src=""  style="{{ $css }}" class="template_image" data-id="{{ $id }}" id = "image_{{ $id }}">
                                                    </div>
                                            @endforeach
                                        @endif

                                        </div>

                                </div>
                            </div>
                        @endforeach     
    
    </div>
</div>
@endsection

@section('js')

<script>
  

    var site_url = "{{url('')}}";
    var page_no = 1;
    var last_page = false;
    var element = $("#multiple_user_card_snap");
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var username = "{{ Auth::user()->username }}";
    var i = 0;

    var img_name = {!! json_encode($image_feilds_name) !!};

    var multiple_cards = {!! json_encode($cards_data) !!};

    $(document).ready(function(){

        function sleep(miliseconds) {
            var currentTime = new Date().getTime();
            while (currentTime + miliseconds >= new Date().getTime()) {
            }
        }      

        $.each(multiple_cards, function( j,val ) 
        {
            i = i+1;
            $.each(val, function(key, value){
                $('#span_'+key).text(value);
                
                $.each(img_name,function(k, v){
                    
                    var k = k.replace(" ","_");
                    k = k.toLowerCase();
                    
                    if(key == k)
                    {
                        $('#image_'+v).attr('src',site_url+'/user/'+username+'/'+k+'/'+value);
                    }
                });
                

                
            });
            
            sleep(2000);

                html2canvas(element, {
                    onrendered: function (canvas) {
                    getCanvas = canvas;
                    var imgageData = getCanvas.toDataURL("image/png");

                    $.ajax({
                    type: "POST",
                    url: site_url+'/multiple_save_cards',
                    dataType: 'json',
                    async: false,
                    data: {"_token": token ,"image": imgageData},
                    success : function(image)
                        {
                            if(multiple_cards.length == i)
                            { 
                                sleep(3000);    
                                window.location.href = "{{ url('multiple_cards',Request::segment(2)) }}"; 
                                
                            }
                        }
                        }).fail(function(data){
                            var errors = data.responseJSON;
                        });

                     }
                });
            
              
        });
       

       
    });

</script>

@endsection