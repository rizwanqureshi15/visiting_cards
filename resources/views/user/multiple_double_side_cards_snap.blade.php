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

        <div id="user_overlay">
            <img id="user_loading" src="{{ url('assets\images\loading.gif') }}">
        </div> 

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="col-md-12">

                        @foreach($template_data as $template)
                            @if($template->type == "horizontal")
                            <div class="col-md-7" style="margin-top:20px;">
                                <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                                <canvas id="canvas_id" width="680" height="419">
                                </canvas>
                            @else
                            <div class="col-md-7" style="margin-top:20px;">
                                <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                                <canvas id="canvas_id" width="400" height="648">
                                </canvas>
                            @endif

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

                             @if($template->type == 'horizontal')
                                <div class="col-md-7" style="margin-top:20px;">
                                    <div id="multiple_user_double_side_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image_back) }}');background-size:100%;height:419px;width:680px;">
                                    <canvas id="canvas_id2" width="680" height="419">
                                    </canvas>
                            @else
                                <div class="col-md-7" style="margin-top:20px;">
                                    <div id="multiple_user_double_side_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image_back) }}');background-size:100%;height:419px;width:680px;">
                                    <canvas id="canvas_id2" width="400" height="648">
                                    <!-- </canvas> -->
                            @endif
                                    <div id="back_card_body">
                                      @if($back_feilds)
                                            @foreach($back_feilds as $feild)
                                              <?php 
                                                $id = $feild->name;
                                                $id = str_replace(" ","_",$feild->name);
                                                $id = strtolower($id);
                                              ?>
                                              <div id="back_{{ $id }}" data-name="{{ $feild->name }}" class='ui-widget-content back-textbox-size feild-elements'  style="{{ $feild->css }}">
                                                  <span id="back_span_{{ $id }}" style="{{ $feild->font_css }}">
                                                    {{ $feild->content }}
                                                  </span>
                                              </div>
                                            @endforeach
                                        @endif

                                          @if($back_labels)
                                            @foreach($back_labels as $label)
                                              <?php
                                                $id = $label->name;
                                                $id = str_replace(" ","_",$label->name);
                                                $id = strtolower($id);
                                            ?>
                                            <div id="back_{{ $id }}" data-type="label" data-name="{{ $label->name }}" class='ui-widget-content back-textbox-size feild-elements' style="{{ $label->css }}">
                                               <span id="back_span_{{ $id }}" style="{{ $label->font_css }}">
                                                {{ $label->content }}
                                              </span>
                                            </div>
                                            @endforeach
                                          @endif
                                          @if($back_images)
                                         
                                            @foreach($back_images as $image)
                                              @foreach($back_image_css as $img_css)
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
                                                      
                                              <div id="div_back_image_{{ $id }}" name="{{ $name }}" style="{{ $div_css }}" class="template_image_div" data-toggle='modal' data-target='#myModal'>
                                                <img src=""  style="{{ $css }}" class="back_template_image" data-id="{{ $id }}" id = "back_image_{{ $id }}">
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

    $('#navbar').css("display","none");  

    var site_url = "{{url('')}}";
    var page_no = 1;
    var last_page = false;
    var element = $("#multiple_user_card_snap");
    var element2 = $("#multiple_user_double_side_card_snap");
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var username = "{{ Auth::user()->username }}";
    var i = 0;
    var front = 1;
    var back = 1;
    var count = 1;
    var i2 = 0;
    var count2 = 1;

    var img_name = {!! json_encode($image_feilds_name) !!};
    var multiple_cards = {!! json_encode($cards_data) !!};
    var array_length = multiple_cards.length;

    var back_template_images = {!! json_encode($back_template_images_name) !!};
    var back_feilds = {!! json_encode($cards_data) !!};
    var array_length2 = back_feilds.length;

    $(document).ready(function(){

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

            var miliseconds = 3000;
            var currentTime = new Date().getTime();
            while (currentTime + miliseconds >= new Date().getTime()) {
            }
            
                html2canvas(element, {
                    onrendered: function (canvas) {
                    getCanvas = canvas;
                    var imgageData = getCanvas.toDataURL("image/png");

                    $.ajax({
                    type: "POST",
                    url: site_url+'/multiple_save_cards',
                    dataType: 'json',
                    async: false,
                    data: {"_token": token ,"image": imgageData ,"image_name": j+1},
                    success : function(image)
                        {

                            if(array_length == count)
                            {   
                                window.location.href = "{{ url('multiple_cards',Request::segment(2)) }}"; 
                            }

                            count = count+1;

                        }
                        }).fail(function(data){
                            var errors = data.responseJSON;
                        });
                       
                     }
                });
            
              
        });


        $.each(multiple_cards, function( j,val ) 
        {
            i2 = i2+1;
            $.each(val, function(key, value){
                $('#back_span_'+key).text(value);
                $.each(back_template_images,function(v, k){
                    var v = v.replace(" ","_");
                    v = v.toLowerCase();
                     
                    if(key == v)
                    {  
                        $('#back_image_'+k).attr('src',site_url+'/user/'+username+'/'+v+'/'+value);
                    }
                });
                
            });

            var miliseconds = 3000;
            var currentTime = new Date().getTime();
            while (currentTime + miliseconds >= new Date().getTime()) {
            }
            
                html2canvas(element2, {
                    onrendered: function (canvas) {
                    getCanvas = canvas;
                    var imgageData = getCanvas.toDataURL("image/png");

                    $.ajax({
                    type: "POST",
                    url: site_url+'/multiple_save_cards',
                    dataType: 'json',
                    async: false,
                    data: {"_token": token ,"image": imgageData,"image_name": j+1,"is_back":"1"},
                    success : function(image)
                        {
                            if(array_length2 == count2)
                            {     
                                //window.location.href = "{{ url('multiple_cards',Request::segment(2)) }}"; 
                            }

                            count2 = count2+1;

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