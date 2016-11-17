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
<div id="front_side" style="display:block;"> 
<div class="row">
  @if($template->type == "horizontal")
      <div class="col-md-3 col-md-offset-1">
  @else
      <div class="col-md-3 col-md-offset-2">
  @endif
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class=" panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
             <h3 class="sidebar-heading">Feilds</h3>    
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body" id="feild_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control sidebar-textbox" id="newFeildName" placeholder="Enter New Feild">
              <div class="error"></div>
            </div>
            <div class="col-md-4">
              <button id="newFeildBtn" class="sidebar-btn">OK</button>     
            </div> 
            <div id="error"></div>
          </div>            
        @if($feilds)
          @foreach($feilds as $feild)
            <?php
              $id = $feild->name;
              $id = str_replace(" ","_",$feild->name);
              $id = strtolower($id);  
            ?>        
          <input type="text" id="sidebar_{{ $id }}" class="sidebar-textbox form-control sidebar-elements sidebar-textbox" placeholder="Enter {{ $feild->name }}">  @endforeach
        @endif
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h3 class="sidebar-heading">Labels</h3>                
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body" id="label_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control sidebar-textbox" id="newLabelName" placeholder="Enter New Label">
              <div class="lable-error"></div>
            </div>
            <div class="col-md-4">
              <button id="newLabelBtn" class="sidebar-btn">OK</button>
            </div> 
            <div id="error_label"></div>
          </div>
          @if($labels)
            @foreach($labels as $label)
              <?php
                $id = $label->name;
                $id = str_replace(" ","_",$label->name);
                $id = strtolower($id);   
              ?>        
              <input type="text" id="sidebar_{{ $id }}" class="sidebar-textbox form-control sidebar-elements" placeholder="Enter {{ $label->name }}">               
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>  

@if($template->type == 'horizontal')
  <div class="col-md-8">
    <div class="canvasBorder-horizontal">
      <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100% 100%;height:419px;width:690px;">
        <div id="guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 665px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 679px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 408px; left: 12px; width: 665px; height: 1px;"></div>
        </div>
        <canvas id="canvas1" width="690" height="418">
        </canvas>
@else
  <div class="col-md-6">
    <div class="canvasBorder-verticle">

      <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$template->background_image) }}');background-size:100% 100%;height:648px;width:410px;">
          <div id="guideline_border" class="overlay canvas-element-wrapper">
              <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 626px;"></div>
              <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 378px; height: 1px;"></div>
              <div class="safety-margin-line-fg" style="top: 12px; left: 388px; width: 1px; height: 626px;"></div>
              <div class="safety-margin-line-fg" style="top: 636px; left: 12px; width: 378px; height: 1px;"></div>
          </div>

        <canvas id="canvas1" width="410" height="648">
        </canvas>
@endif
<div id="card_body" style="">
  @if($feilds)
    @foreach($feilds as $feild)
      <?php
        $id = $feild->name;
        $id = str_replace(" ","_",$feild->name);
        $id = strtolower($id);
      ?>
      <div id="{{ $id }}" data-name="{{ $feild->name }}" class='ui-widget-content textbox-size feild-elements'  style="{{ $feild->css }}">
          <span id="span_{{ $id }}" style="{{ $feild->font_css }}">
            {{ $feild->content }}
          </span>
      </div>
    @endforeach
  @endif

  @if($labels)
    @foreach($labels as $label)
      <?php
        $id = $label->name;
        $id = str_replace(" ","_",$label->name);
        $id = strtolower($id);
    ?>
                            <div id="{{ $id }}" data-type="label" data-name="{{ $label->name }}" class='ui-widget-content textbox-size feild-elements' style="{{ $label->css }}">
                                 <span id="span_{{ $id }}" style="{{ $label->font_css }}">
                                    {{ $label->content }}
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
                   
                        <div id="div_image_{{ $id }}" name="{{ $img_css->name }}" style="{{ $div_css }}" class="template_image_div" data-toggle='modal' data-target='#myModal'>
                            <img src="{{ url('templates/images', $src) }}"  style="{{ $css }}" class="template_image" data-id="{{ $id }}" id = "image_{{ $id }}">
                        </div>
                @endforeach
            @endif
        </div>

        
         
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
        </div>
        <!-- <div id="slider" style="margin-top:20px;"></div> -->
    </div>  
    </div>
    </div>
</div>













<div id="back_side" style="display:none;">
  <div class="row">
  @if($template->type == "horizontal")
    <div class="col-md-3 col-md-offset-1" >
  @else
    <div class="col-md-3 col-md-offset-2">
  @endif
  <div class="panel-group" id="accordion_back" role="tablist" aria-multiselectable="true">
    <div class=" panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion_back" href="#collapseOne_back" aria-expanded="true" aria-controls="collapseOne_back">
             <h3 class="sidebar-heading">Feilds </h3>   
          </a>
        </h4>
      </div>
      <div id="collapseOne_back" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body" id="back_feild_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control sidebar-textbox" id="back_newFeildName" placeholder="Enter New Feild">
              <div class="error"></div>
            </div>
            <div class="col-md-4">
              <button id="back_newFeildBtn" class="sidebar-btn">OK</button>     
            </div> 
            <div id="back_error"></div>
          </div>            
        @if($back_feilds)
          @foreach($back_feilds as $feild)
            <?php
              $id = $feild->name;
              $id = str_replace(" ","_",$feild->name);
              $id = strtolower($id);  
            ?>        
          <input type="text" id="back_sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $feild->name }}">  @endforeach
        @endif
        </div>
      </div>
    </div>
    <div class=" panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_back" href="#collapseTwo_back" aria-expanded="false" aria-controls="collapseTwo_back">
              <h3 class="sidebar-heading">Labels </h3>               
          </a>
        </h4>
      </div>
      <div id="collapseTwo_back" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body" id="back_label_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control sidebar-textbox" id="back_newLabelName" placeholder="Enter New Label">
              <div class="lable-error"></div>
            </div>
            <div class="col-md-4">
              <button id="back_newLabelBtn" class="sidebar-btn">OK</button>
            </div> 
            <div id="back_error_label"></div>
          </div>
          @if($back_labels)
            @foreach($back_labels as $label)
              <?php
                $id = $label->name;
                $id = str_replace(" ","_",$label->name);
                $id = strtolower($id);   
              ?>        
              <input type="text" id="back_sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $label->name }}">               
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>  

@if($template->type == 'horizontal')
  <div class="col-md-8">
    <div class="canvasBorder-horizontal">
      <div id="div2" style="background-image:url('{{ url('templates/background-images/'.$template->background_image_back) }}');background-size:100% 100%;height:419px;width:690px;">
        
        <div id="back_guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 665px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 679px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 408px; left: 12px; width: 665px; height: 1px;"></div>
        </div>

        <canvas id="canvas2" width="690" height="419">
        </canvas>
@else
  <div class="col-md-6">
    <div class="canvasBorder-verticle">

      <div id="div2" style="background-image:url('{{ url('templates/background-images/'.$template->background_image_back) }}');background-size:100% 100%;height:648px;width:410px;">
        
          <div id="back_guideline_border" class="overlay canvas-element-wrapper">
              <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 626px;"></div>
              <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 378px; height: 1px;"></div>
              <div class="safety-margin-line-fg" style="top: 12px; left: 388px; width: 1px; height: 626px;"></div>
              <div class="safety-margin-line-fg" style="top: 636px; left: 12px; width: 378px; height: 1px;"></div>
          </div>

        <canvas id="canvas2" width="410" height="648">
        </canvas>
@endif
<div id="back_card_body" style="">
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
             
      <div id="div_image_{{ $id }}" name="{{ $name }}" style="{{ $div_css }}" class="template_image_div" data-toggle='modal' data-target='#myModal'>
        <img src="{{ url('templates/images', $src) }}"  style="{{ $css }}" class="back_template_image" data-id="{{ $id }}" id = "image_{{ $id }}">
      </div>
    @endforeach
  @endif
</div>
         
         <!--Image Toolbar Start-->
        <div id="back_imageToolbar" class="popup-imagetoolbar row col-md-12" style="display:none">
            <!--Image Shape-->
                <div class="col-md-5 imagetoolbar_section" >
                    <div class="squere_shape"></div>
                    <div class="round_shape"></div>
                </div>
            <!--Image Shape End-->
            <!--Image Border-->
                <div class="col-md-4 imagetoolbar_section" >
                    <div id="back_image_border">Show Border</div>
                </div>
            <!--Image Border End-->
            <!--Image Delete-->
                <div class="col-md-3 imagetoolbar_Section" style="padding:3px;">
                  <img src="{{ url('assets/images/delete.png') }}" style="width:40px;margin-top:3px;border-radius:0px" id="back_imagetoolbardelete">
                </div>
            <!--Image Delete End-->
        </div>
        <!--Image Toolbar End-->
        </div>
        <!-- <div id="slider" style="margin-top:20px;"></div> -->
    </div>
    </div>
</div>
</div>

<div class="row">

      @if($template->type == "vertical")
          <div class="col-md-7 col-md-offset-3" style="margin-top:10px;">
      @else
          <div class="col-md-7 col-md-offset-4" style="margin-top:10px;">
      @endif

      <button class="btn-blog" id="Preview" data-toggle="modal" data-target="#preview_image" style="margin-right: 20px;">
        Preview
      </button>
      <a id="btnborder" class="btn-blog" style="margin-right: 20px;">
        Show Borders
      </a>
      <a class="btn-blog" id="guideline" style="margin-right:20px;">Hide Guideline</a>
     
  </div>
   <?php $username = Auth::user()->username; ?>
  <div class="col-md-6 col-md-offset-4">
        <div style="height:180px;padding:20px;">
          <div class="col-md-4 text-center">
            <img src="{{ url('images/'.$username, $template->snap) }}" class="active_image front_back" id="front_side_image" style="">
            <label class="image_fonts">FRONT SIDE</label>
          </div>
          <div class="col-md-4 text-center">
            <img src="{{ url('images/'.$username, $template->back_snap) }}" class="inactive_image front_back" id="back_side_image" style="">
            <label class="image_fonts">BACK SIDE</label>
          </div>
        </div>
</div>
  </div>
  <div class="row">
    <!--Toolebasr start-->

        <div id="myToolbar" class="popup-toolbar row col-md-12" style="display:none;position:absolute;padding:0px;">
        <div class="col-md-12" style="padding:0px;">
            <div id="more_links" class="col-md-6 col-md-offset-8" style="padding:0px;">
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
                <a style="font-size: 20px;color:blue;" id="flip">More</a>
            </div>
        </div>
       
        <!--Toolbar Delete Button end-->

        <!--Toolbar Textbox-->

        <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        <!--Toolbar Textbox end-->

        </div><!--Toolbar end-->
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
                    <button type="button" class="model-btn export" style="display:inline-block;">Upload</button>
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
                        <div id="previewImageFront" style="display:block;">
                            
                        </div>
                        <div id="previewImageBack" style="display:none;">
                            
                        </div>
                        
                      </div>
                      <div class="modal-footer">
                        <button id="preview_front_back" class="model-btn">
                            Back
                        </button>
                        <button id="btnSave" type="submit" class="model-btn">
                            Save
                        </button>
                        
                        <button type="button" class="btn btn-default model-btn" id="close_model" data-dismiss="modal" >Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            <!--Modal End-->

@endsection

@section('js')
 
    <script>

    var template_url = "{{ $template->url }}";
    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var field_names = {!! json_encode($names) !!};
    var upload_images = {!! json_encode($template_images) !!};
    var label_names = {!! json_encode($template_labels) !!};
    var back_feild_names = {!! json_encode($back_names) !!};
    var back_upload_images = {!! json_encode($back_template_images) !!};
    var back_label_names = {!! json_encode($back_template_labels) !!};
    var template_id = {{ $template->id }};
    var template_both_side = {{ $template->is_both_side }};
    var side = "";


      var typingTimer;                
      var doneTypingInterval = 500;

      $('#newFeildName').keyup(function () 
      {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(CheckFeild, doneTypingInterval);
      });

      function CheckFeild() 
      { 
          var a = $('#newFeildName').val();
          if(a.indexOf('.') > -1)
          {
              $('.error').html("<div style='color:red'>You can not use dot(.) as a character</div>");
              $('#newFeildBtn').css('cursor','no-drop');
              $('#newFeildBtn').attr('disabled','disabled');
          }
          else
          { 
              $('.error').html("");
              $('#newFeildBtn').css('cursor','auto');
              document.getElementById("newFeildBtn").disabled=false
          }
      }

        var lableTimer;                
        var doneLableInterval = 500;

        $('#newLabelName').keyup(function () 
        {
            clearTimeout(lableTimer);
            lableTimer = setTimeout(CheckLable, doneLableInterval);
        });

        function CheckLable() 
        { 
            var a = $('#newLabelName').val();
            if(a.indexOf('.') > -1)
            {
                $('.lable-error').html("<div style='color:red'>You can not use dot(.) as a character</div>");
                $('#newLabelBtn').css('cursor','no-drop');
                $('#newLabelBtn').attr('disabled','disabled');
            }
            else
            { 
                $('.lable-error').html("");
                $('#newLabelBtn').css('cursor','auto');
                document.getElementById("newLabelBtn").disabled=false;
            }
        }

        var typingTimer;                
        var doneTypingInterval = 500;

        $('#back_newFeildName').keyup(function () 
        {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(BackCheckFeild, doneTypingInterval);
        });

        function BackCheckFeild() 
        { 
            var a = $('#back_newFeildName').val();
            if(a.indexOf('.') > -1)
            {
                $('.error').html("<div style='color:red'>You can not use dot(.) as a character</div>");
                $('#back_newFeildBtn').css('cursor','no-drop');
                $('#back_newFeildBtn').attr('disabled','disabled');
            }
            else
            { 
                $('.error').html("");
                $('#back_newFeildBtn').css('cursor','auto');
                document.getElementById("back_newFeildBtn").disabled=false
            }
        }

        var lableTimer;                
        var doneLableInterval = 500;

        $('#back_newLabelName').keyup(function () 
        {
            clearTimeout(lableTimer);
            lableTimer = setTimeout(BackCheckLable, doneLableInterval);
        });

        function BackCheckLable() 
        { 
            var a = $('#back_newLabelName').val();
            if(a.indexOf('.') > -1)
            {
                $('.lable-error').html("<div style='color:red'>You can not use dot(.) as a character</div>");
                $('#back_newLabelBtn').css('cursor','no-drop');
                $('#back_newLabelBtn').attr('disabled','disabled');
            }
            else
            { 
                $('.lable-error').html("");
                $('#back_newLabelBtn').css('cursor','auto');
                document.getElementById("back_newLabelBtn").disabled=false;
            }
        }

      $(document).ready(function(){

          $("#guideline").click(function(){
            if($(this).text() == "Show Guideline")
            {
                $('#guideline_border').show();
                $('#back_guideline_border').show();
                $(this).text("Hide Guideline");
            }
            else
            { 
                $('#guideline_border').hide();
                $('#back_guideline_border').hide();
                $(this).text("Show Guideline");
            }
        });
      });


      $(document).ready(function()
      {
          $("#back_guideline").click(function(){
            if($(this).text() == "Show Guideline")
            {
                $('#back_guideline_border').show();
                $(this).text("Hide Guideline");
            }
            else
            { 
                $('#back_guideline_border').hide();
                $(this).text("Show Guideline");
            }
        });
      });


       $(document).ready(function(){
        $('#front_side_image').click(function(){
          $("#front_side").show();
              $("#back_side").hide();
              side = "";
              $('#front_side_image').removeClass('inactive_image').addClass('active_image');
              $('#back_side_image').removeClass('active_image').addClass('inactive_image');
        });
        $('#back_side_image').click(function(){
            $("#back_side").show();
            $("#front_side").hide();
            side = "back_";
            $('#back_side_image').removeClass('inactive_image').addClass('active_image');
            $('#front_side_image').removeClass('active_image').addClass('inactive_image');
        });
    });

      $('#Preview').click(function()
      { 
            $('#guideline_border').hide();
      });

      $('#close_model').click(function()
      { 
            $('#guideline_border').show();
            $("#guideline").text("Hide Guideline");
      });
    
</script>


    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/card.js') }}"></script>
    <script src="{{ url('assets/js/card_backside.js') }}"></script>

@endsection
