@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-3">
            <table class="table mytable" border="1">
                <thead>
                    <tr class="mytheadtr">
                        <th class="headtext">Enter Text</th>
                    </tr>
                </thead>
               <tbody>
                    <tr>
                        <th><button class="btn form-control" style="background-color:rgba(181,186,191,0.47)">Add New Text Field</button></th>
                    </tr>

                    @foreach($template->template_feilds as $card_field)

                        <tr>
                            <th><input class="col-md-12 form-control toolbar-elements" type="text" id="sidebar_{{ str_replace(" ","_",$card_field->name) }}" id="{{ str_replace(" ","_",$card_field->name) }}" placeholder="Enter {{ $card_field->name }}"></th>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>  

        <div class="col-md-8" style="padding-left:90px;padding-right:50px;">
            @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
            @endif
            <!--<canvas id="canvas" width="800" height="500"><img src="{{ url('images/card.png') }}" width="100%"></canvas>
            -->

        <form id="form1" > 
            @if($template->background_image)                             
                
                <div id="div1" style="height:510px;width:710px;background-color:#fff;">
                    <div width="700" height="500" style="background-image:url('{{ url('images/'.$template->background_image) }}');height:510px;width:710px">
                        <canvas id="canvas1" width="700" height="500">
                        </canvas>
                        
                        @foreach($template->template_feilds as $card_field)
                            <div id="{{ str_replace(" ","_",$card_field->name) }}" class="ui-widget-content textbox-size toolbar-elements" style="{{ $card_field->css }}">
                                <span id="span_{{ str_replace(" ","_",$card_field->name) }}" style="{{ $card_field->font_css }}">{{ $card_field->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($template->background_color)
                <div style="height:175px;width:242px;margin-top:20px;widh:100%;">
                    <div id="div1" style="height:510px;width:710px;background-color:#fff;">
                        <div width="700" height="500" style="background-color:{{$template->background_color}};height:510px;width:710px">


                    <canvas id="canvas1" width="700" height="500" >
                    </canvas>    

                        @foreach($template->template_feilds as $card_field) 
                            <div id="{{ str_replace(" ","_",$card_field->name) }}" class="ui-widget-content textbox-size toolbar-elements" style="{{ $card_field->css }}">
                                <span id="span_{{ str_replace(" ","_",$card_field->name) }}" style="{{ $card_field->font_css }}">{{ $card_field->name }}</span>
                            </div>
                        @endforeach 
                </div>
            @endif
        

        <!--Toolebasr start-->
        <div id="myToolbar" class="popup-toolbar row col-md-12" style="display:none;position:absolute;padding:0px;">
        <div class="col-md-12" style="padding:0px;">
            <div id="panel" class="col-md-6 col-md-offset-8" style="padding:0px;">
               <div class="col-md-4" style="padding:10px;" id="under_line">
                    <u class="myFont" >U</u>
               </div>
               <div class="col-md-4" id="bold" style="padding:10px;border-left: 1px solid #b5babf;border-right: 1px solid #b5babf;">
                    <b class="myFont" >B</b>
               </div>
               <div class="col-md-4"  id="italic" style="padding:10px;">
                    <i class="myFont">I</i>
               </div>
            </div>
        </div>
        <!--Font Style Selector-->
        <div class="col-md-7" style="border-right: 1px solid #b5babf;padding-right:0px;border-bottom: 1px solid #b5babf;padding-bottom: 6px;">
            <div class="toolbar-fontbox col-md-9" style="padding:0px">
                <input id="font" type="text" />
            </div><!--Font Style Selector end-->
        
        <!--Font Size Selector-->
            <div >
                <select id="size-font" class="font-text col-md-3 col-md-offset-1" style="padding-left:7px">
                    <option value="8">8px</option>
                    <option value="10">10px</option>
                    <option value="12">12px</option>
                    <option value="14">14px</option>
                    <option value="18">18px</option>
                    <option value="20">20px</option>
                    <option value="24">24px</option>
                    <option value="28">28px</option>
                    <option value="30">30px</option>
                    <option value="32">32px</option>
                </select>
            </div><!--Font Size Selector end-->
        </div>  

        <div class="col-md-5" style="padding:0px;">
            <!--Toolbar colorpicker-->
            <div class="col-md-4" style="height:51px;padding:0px;width:33.33%;padding-left: 14px;border-right: 1px solid #b5babf;border-bottom: 1px solid #b5babf">
                <div id="colorSelector" style="margin-top:7px;"><div style="background-color: #0000ff"></div></div>
            </div>
            <!--Toolbar colorpicker end-->
                
            <!--Toolbar Delete Button-->
            <div class="col-md-4" style="height:51px;padding:0px;width:33.33%;padding-left: 14px;border-right: 1px solid #b5babf;border-bottom: 1px solid #b5babf">
                <img src="{{ url('assets/images/delete.png') }}" style="width:40px;margin-top:5px;" id="toolbardelete">
            </div>
            <div class="col-md-4" style="height:51px;padding:0px;width:33.33%;padding-left: 14px;border-bottom: 1px solid #b5babf;padding-top:10px;">
                <a href="#" style="font-size: 20px;" id="flip">More</a>
            </div>
        </div>
       
        <!--Toolbar Delete Button end-->

        <!--Toolbar Textbox-->

        <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        <!--Toolbar Textbox end-->

        </div><!--Toolbar end-->
        
        <button id="btnSave" type="submit" class="btn btn-primary" style="float:right;margin-top:20px;background-color:#38454f">
            Save
        </button>

        </div>
    </form>
    <div id="previewImage">
        
    </div>

    </div>
</div>

@endsection

@section('js')
    

    <script>

$(document).ready(function(){
    $("#flip").click(function(){
        $("#panel").slideToggle("slow");
    });
});


   $(document).ready(function(){

    
   var element = $("#div1"); // global variable
    var getCanvas; // global variable
 
    $("#btnSave").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");

                $.ajax({
                type: "POST",
                url: "{{ url('card_image_save') }}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}","image": imgageData},
                success : function(image){
                    alert('image save');
                    } 
                }).fail(function(data){
                    // on an error show us a warning and write errors to console
                    var errors = data.responseJSON;
                });


             }
         });
    });

    $("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
    });

});
    
</script>


    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/myjs.js') }}"></script>
    
    
    
@endsection

