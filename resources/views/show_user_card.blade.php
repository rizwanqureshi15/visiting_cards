@extends('layouts.app')

@section('content')

<div class="container">
<div class="row">
        <div class="col-md-3">
            <table class="table mytable" border="1" >
                <thead>
                    <tr class="mytheadtr">
                        <th class="headtext">Add New Feilds</th>
                    </tr>
                </thead>
               <tbody id="table_body">
                
                    <tr>
                        <td>
                        <div class="row">
                            <div class="col-md-8" style="padding-right:0px">
                            <input type="text" class="form-control" id="newFeildName" placeholder="Enter New Feild"></div>
                            <div class="col-md-4"><a role="button" id="newFeildBtn" class="btn btn-primary" style="background-color:#38454f;float:right">OK</a>
                            </div>
                            <div id="error"></div> 
                        </div>
                        </td>
                    </tr>

                    @if($template->template_feilds)
                    @foreach($template->template_feilds as $feild)
                    <?php
                         $id = $feild->name;

                        $id = str_replace(" ","_",$feild->name);
                        $id = strtolower($id);
                        
                    ?>
                        <tr>
                            <td>
                                <input type="text" id="sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $feild->name }}" name="{{ $feild->name }}">
                            </td>
                        </tr>
                    @endforeach
                    @endif    
                       
                </tbody>  
            
            </table>
        </div>  


        <div class="col-md-8">
            @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
            @endif
            <!--<canvas id="canvas" width="800" height="500"><img src="{{ url('images/card.png') }}" width="100%"></canvas>
            -->

        

                <div id="div1" class="myBorder canvas-div" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');">

                <canvas id="canvas1">
                </canvas>
                
                <input type="hidden" id="template_id" value="{{ $template->id }}"/>
        
                <div id="card_body">

                    @if($template->template_feilds)
                        @foreach($template->template_feilds as $f)
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
                </div>

        <!--Toolebasr start-->
        <div id="myToolbar" class="popup-toolbar row col-md-12" style="display:none;position:absolute;padding:0px;">
        <div class="col-md-12" style="padding:0px;">
            <div id="panel_1" class="col-md-6 col-md-offset-8" style="padding:0px;">
               <div class="col-md-4" style="padding:10px;" id="under_line">
                    <u class="myFont" >U</u>
               </div>
               <div class="col-md-4" id="bold" style="padding:10px;border-left: 1px solid #b5babf;border-right: 1px solid #b5babf;">
                    <b class="myFont" >B</b>
               </div>
               <div class="col-md-4"  id="italic" style="padding:10px;">
                    <b class="myFont">I</b>
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
                <a href="#" style="font-size: 20px;" id="flip_1">More</a>
            </div>
        </div>
        <!--Toolbar Delete Button end-->

        <!--Toolbar Textbox-->

        <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        <!--Toolbar Textbox end-->

        </div><!--Toolbar end-->
        
        <!-- Large modal -->
        <button class="btn btn-primary btn-lg mybtn" data-toggle="modal" data-target="#myModal" id="Previewuser">
            Preview 
        </button>   
        <button class="btn btn-primary btn-lg" id="btn-template-formate" style="margin-top:20px;">  
            Download Excel file 
        </button>

        </div>
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content" style="width:745px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview</h4>
              </div>
              <div class="modal-body">
                <div id="previewuserImage" >
                    
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="save_user_card" type="submit" class="btn btn-primary"  >
                    Save
                </button>
              </div>
            </div>
          </div>
        </div>
    

   
</div>
</div>

@endsection

@section('js')
    

<script>
    var field_names = {!! json_encode($field_names) !!}; 
    field_names = field_names.replace(/\[/g, '');
    field_names = field_names.replace(/\]/g, '');
    field_names = field_names.replace(/\"/g, '');
    field_names = field_names.split(',');

   $(document).ready(function(){

        $("#flip_1").click(function(){
            $("#panel_1").slideToggle("slow");
        });


        $("#btn-template-formate").on('click', function () {

                $.ajax({
                type: "POST",
                url: "{{ url('download-template-formate') }}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}","field_names": field_names},
                success : function(file_download){

                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });

        });

        $("#save_user_card").on('click', function () {
            var i=0;
            feilds=[];

            var template_id = $("#template_id").val();

            $.each(field_names, function(key,  value){

                var id1  = value.toLowerCase();
                var id = id1.replace(/\ /g, '_');
                var css = $('#'+id).attr('style');
                var font_css = $('#span_'+id).attr('style');
                var content = $('#span_'+id).text();
                var values = { name: value, css: css, font_css: font_css, content: content};
                feilds[i] = values;
                i++; 
            });


         html2canvas(element, {
         onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");

                $.ajax({
                type: "POST",
                url: "{{ url('card_image_save') }}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}","image": imgageData},
                success : function(image){

                    $.ajax({
                            url: "{{ url('user_template_save') }}",
                            type: "post",
                            data: { "_token": "{{ csrf_token() }}" ,"feilds": feilds, "deleted_feilds": delete_feilds, "template_id": template_id, "snap": image },
                            dataType: 'json',
                            success: function(msg) {
                                window.location.href = "{{ url('mytemplates') }}"; 
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                               console.log(textStatus, errorThrown);
                            }
                            
                        });

                    

                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });


                 }
             });
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