@extends('master')

@section('content')
<style>
    .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 5px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 350px;
        height: 350px;
        margin-left:110px;
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .cropit-preview-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }
      .export {
        /* Use relative position to prevent from being covered by image background */
        position: relative;
        z-index: 10;
        display: block;
      }

</style>

    <div class="row">
    @if($templates->type == "horizontal")
        <div class="col-md-3">
    @else
        <div class="col-md-3 col-md-offset-2">
    @endif
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
                            <div class="col-md-4"><button id="newFeildBtn" class="btn btn-primary">OK</button>
                            </div> 
                            <div id="error"></div>
                        </div>
                        </td>
                    </tr>
                    @if($feilds)
                    @foreach($feilds as $feild)
                    <?php
                         $id = $feild->name;

                        $id = str_replace(" ","_",$feild->name);
                        $id = strtolower($id);
                       
                    ?>
                        <tr>
                            <td>
                                <input type="text" id="sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $feild->name }}">
                            </td>
                        </tr>
                    @endforeach
                    @endif
                            
                       
                </tbody>
            </table>
        </div>  


        
            <!--<canvas id="canvas" width="800" height="500"><img src="{{ url('images/card.png') }}" width="100%"></canvas>
            -->

            @if($templates->type == 'horizontal')
                <div class="col-md-9">
                <div class="canvasBorder" style="height:421px;width:682px;">
                <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image) }}');background-size:100%;height:419px;width:680px;">
                <canvas id="canvas1" width="680" height="419">
                </canvas>
            @else
                <div class="col-md-6">
                <div class="canvasBorder"  style="height:650px;width:402px;">
                <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image) }}');background-size:100%;height:648px;width:400px;">
                
                <canvas id="canvas1" width="400" height="648">
                </canvas>
             @endif
            
     <!--    <input type="hidden" id="template_id" value="{{ $templates->id }}"/> -->
        
        <div id="card_body">
            @if($feilds)
                @foreach($feilds as $feild)
                     <?php
                         $id = $feild->name;
                        $id = str_replace(" ","_",$feild->name);
                        $id = strtolower($id);
                     ?>
                            <div id="{{ $id }}" data-name="{{ $feild->name }}" class='ui-widget-content textbox-size feild-elements' style="{{ $feild->css }}">
                                 <span id="span_{{ $id }}" style="{{ $feild->font_css }}">
                                    {{ $feild->content }}
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
                            <img src="{{ url('templates/images', $src) }}"  style="{{ $css }}" class="template_image" data-id="{{ $id }}" id = "image_{{ $id }}">
                        </div>
                @endforeach
            @endif
        </div>

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
         
         <!--Image Toolbar Start-->
        <div id="imageToolbar" class="popup-imagetoolbar row col-md-12" style="display:none">
            <!--Image Shape-->
                <div class="col-md-5 imagetoolbar_section" >
                    <div class="squere_shape"></div>
                    <div class="round_shape"></div>
                </div>
            <!--Image Shape End-->
            <!--Image Border-->
                <div class="col-md-4 imagetoolbar_section" >
                    <div id="image_border">Show Border</div>
                </div>
            <!--Image Border End-->
            <!--Image Delete-->
                <div class="col-md-3 imagetoolbar_Section" style="padding:3px;">
                  <img src="{{ url('assets/images/delete.png') }}" style="width:40px;margin-top:3px;border-radius:0px" id="imagetoolbardelete">
                </div>
            <!--Image Delete End-->
        </div>
        <!--Image Toolbar End-->


       



        <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Upload Your Image</h4>
                  </div>
                  <div class="modal-body">
                    <div class="image-editor">
                          <hr>
                          <input type="file" class="cropit-image-input">
                          <label style="position: absolute;margin-top: 14px;margin-left: 6px;">Name </label>
                          <input type="text" class="form-control" style="margin-top:10px;width:400px;margin-left:53px;" name="image_name" id="image_name" placeholder="Enter image Feild Name.." required="required" />
                          <div id="image_error" style="margin-top:10px;"></div>
                          <hr>
                          <div class="cropit-preview"></div>
                          <hr>
                          <input type="range" class="cropit-image-zoom-input" />
                        
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="upload" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary export" style="display:inline-block;">Upload</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- <div id="slider" style="margin-top:20px;"></div> -->
    </div>
    @if($templates->type == "horizontal")
    <div style="margin-right:20px">
    @else
    <div style="margin-right:57px;">
    @endif
        <a id="btnsave" class="btn btn-primary" style="float:right;margin-top:40px;">
            Save
         </a>
          <a id="btnborder" class="btn btn-primary" style="float:right;margin-right:10px;margin-top:40px;">
            Show Borders
         </a>
         <a type="button" class="btn btn-primary" style="float:right;margin-right:10px;margin-top:40px;" data-toggle="modal" data-target="#myModal">
              Upload Image
        </a>
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
        // $( "#slider" ).slider({
        //     value: 100,
        //     slide: function( event, ui ) {
        //         var opacity = $('#slider').slider("value");
        //         opacity = parseInt(opacity)/100;
        //         $('#div1').css('opacity', opacity);
        //         console.log(opacity);
        //     }
        // });
    });
    

    
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var feild_names = {!! json_encode($names) !!};
    var upload_images = {!! json_encode($template_images) !!};
    feild_names = feild_names.replace(/\[/g, '');
    feild_names = feild_names.replace(/\]/g, '');
    feild_names = feild_names.replace(/\"/g, '');
    feild_names = feild_names.split(',');
    var template_id = {{ $templates->id }};

    
</script>


    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/admin.js') }}"></script>

@endsection
