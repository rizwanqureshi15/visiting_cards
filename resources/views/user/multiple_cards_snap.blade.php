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

                             @if($template->type == 'horizontal')
                                <div class="col-md-7" style="margin-top:20px;">
                                    <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                                    <canvas id="canvas_id" width="680" height="419">
                                    </canvas>
                            @else
                                <div class="col-md-7" style="margin-top:20px;">
                                    <div id="multiple_user_card_snap" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:648px;width:400px;">
                                    <canvas id="canvas_id" width="400" height="648">
                                    </canvas>
                            @endif
                                    <div id="card_body">
                                           <!--  @if($objects)

                                                @foreach($objects as $object) 
                                                  <?php
                                                    $id = $object->name;
                                                    $id = str_replace(" ","_",$object->name);
                                                    $id = strtolower($id);
                                                  ?>

                                                  @if($object->type == "line")
                                                      <div class="object object_line_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
                                                          <div id="{{ $id }}" style="{{ $object->css }}" class="object_line">
                                                          </div>
                                                      </div>
                                                  @elseif($object->type == "square")
                                                      <div id="{{ $id }}" class="object object_square" style="{{ $object->css }}">
                                                      </div>
                                                  @elseif($object->type == "circle")
                                                      <div id="{{ $id }}" class="object object_circle" style="{{ $object->css }}">
                                                      </div>
                                                  @endif
                                                @endforeach

                                              @endif -->

                                        @if($objects)

                                          @foreach($objects as $object) 
                                            <?php
                                              $id = $object->name;
                                              $id = str_replace(" ","_",$object->name);
                                              $id = strtolower($id);
                                            ?>

                                            @if($object->type == "line")
                                                <div class="object object_line_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
                                                    <div id="{{ $id }}" style="{{ $object->css }}" class="object_line">
                                                    </div>
                                                </div>
                                            @elseif($object->type == "square")
                                                <div id="{{ $id }}" class="object object_square" style="{{ $object->css }}">
                                                </div>
                                            @elseif($object->type == "circle")
                                               <div class="object object_circle_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
                                                    <div id="{{ $id }}" style="{{ $object->css }}" class="object_circle">
                                                    </div>
                                                </div>
                                            @endif
                                          @endforeach

                                        @endif

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
                                                        <img style="{{ $css }}" class="template_image" data-id="{{ $id }}" id="image_{{ $id }}">
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
    $('#user_overlay').css('opacity','1.9');

    var site_url = "{{url('')}}";
    var page_no = 1;
    var last_page = false;
    var element = $("#multiple_user_card_snap");
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var username = "{{ Auth::user()->username }}";
    var i = 0;
    var count = 1;

    var img_name = {!! json_encode($image_feilds_name) !!};

    var multiple_cards = {!! json_encode($cards_data) !!};
    var array_length = multiple_cards.length;

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

            var miliseconds = 2000;
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
                    data: {"_token": token ,"image": imgageData},
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
      
       
    });

</script>

@endsection