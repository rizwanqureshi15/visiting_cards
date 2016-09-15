@extends('layouts.app')

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
<div class="container">
<div class="row">
    @if($template->type == "horizontal")
        <div class="col-md-3 col-md-offset-1">
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
                            <div class="col-md-4"><a role="button" id="newFeildBtn" class="btn btn-primary" style="background-color:#38454f;float:right">OK</a>
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


         @if($template->type == 'horizontal')
                <div class="col-md-7">
                 <div class="canvasBorder" style="height:421px;width:682px;">
                <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:419px;width:680px;">
                <canvas id="canvas1" width="680" height="419">
                </canvas>
            @else
                <div class="col-md-6">
                 <div class="canvasBorder" style="height:650px;width:402px;">
                <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100%;height:648px;width:400px;">
                <canvas id="canvas1" width="400" height="648">
                </canvas>
             @endif
                
                <input type="hidden" id="template_id" value="{{ $template->id }}"/>
        
                <div id="card_body">

                    @if($feilds)
                @foreach($feilds as $feild)
                     <?php
                         $id = $feild->name;
                        $id = str_replace(" ","_",$feild->name);
                        $id = strtolower($id);
                     ?>
                            <div id="{{ $id }}" data-name="{{ $feild->name }}" class='ui-widget-content textbox-size feild-elements' style="background-color:transparent;{{ $feild->css }}">
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
        
        <!-- Large modal -->
       

        </div>
         </div>
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
                          <hr>
                          <div class="cropit-preview"></div>
                          <hr>
                          <input type="range" class="cropit-image-zoom-input"/>
                        
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary export" style="display:inline-block;">Upload</button>
                  </div>
                </div>
              </div>
            </div>
            <!--Modal End-->
            <!--Modal-->
             <div class="modal fade" id="preview_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content" style="width:745px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Preview</h4>
                      </div>
                      <div class="modal-body">
                        <div id="previewImage" >
                            
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="btnSave" type="submit" class="btn btn-primary"  >
                            Save
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
            <!--Modal End-->
        </div>
         @if($template->type == "horizontal")
          <div style="margin-right:72px">
          @else
          <div style="margin-right:255px;">
          @endif
             <button class="btn btn-primary mybtn" style="float:right;margin-right:10px;margin-top:20px;" id="Preview" data-toggle="modal" data-target="#preview_image">
                Preview
              </button>   
               <a id="btnborder" class="btn btn-primary" style="float:right;margin-right:10px;margin-top:20px;">
                  Show Borders
               </a>
          </div>
</div>

@endsection

@section('js')
    

<script>

    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var field_names = {!! json_encode($field_names) !!}; 
    var upload_images = {!! json_encode($template_images) !!};

    field_names = field_names.replace(/\[/g, '');
    field_names = field_names.replace(/\]/g, '');
    field_names = field_names.replace(/\"/g, '');
    field_names = field_names.split(',');
    
</script>

    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <!-- <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script> -->
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <script src="{{ url('assets/js/card.js') }}"></script>

@endsection