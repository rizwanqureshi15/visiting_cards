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
<div id="front_side" style="display:block;"> 
<div class="row">
  @if($templates->type == "horizontal")
    <div class="col-md-3" >
  @else
    <div class="col-md-3 col-md-offset-2">
  @endif
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
             Feilds    
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body" id="feild_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control" id="newFeildName" placeholder="Enter New Feild">
              <div class="error"></div>
            </div>
            <div class="col-md-4">
              <button id="newFeildBtn" class="btn btn-primary">OK</button>     
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
          <input type="text" id="sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $feild->name }}">  @endforeach
        @endif
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Labels                
          </a>
        </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body" id="label_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control" id="newLabelName" placeholder="Enter New Label">
              <div class="error_label"></div>
            </div>
            <div class="col-md-4">
              <button id="newLabelBtn" class="btn btn-primary">OK</button>
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
              <input type="text" id="sidebar_{{ $id }}" class="form-control sidebar-elements" placeholder="Enter {{ $label->name }}">               
            @endforeach
          @endif
        </div>
      </div>
    </div>


      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Objects              
            </a>
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body" id="back_label_body">
            <div class="row">
              <div class="col-md-4" style="padding-left:22px;" id="object_line" >
                <i class="fa fa-pencil-square-o fa-3x" aria-hidden="true" ></i>  
                <br>LINE
              </div>
              
              <div class="col-md-4 text-center" id="object_square">
                <i class="fa fa-square-o fa-3x" aria-hidden="true"></i>
                <br>SQUARE
              </div>

              <div class="col-md-4 text-center" id="object_circle">
                <i class="fa fa-circle-thin fa-3x" aria-hidden="true"></i>
                <br>CIRCLE
              </div>
            </div>
          </div>
        </div>
      </div>


  </div>
</div>  

@if($templates->type == 'horizontal')
  <div class="col-md-9" style="padding-left:0px;">
    <div class="canvasBorder" style="height:421px;width:692px;border:1px black dashed;">
      <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image) }}');background-size:100% 100%;height:419px;width:690px;">
        
        <div id="guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 666px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 679px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 408px; left: 12px; width: 666px; height: 1px;"></div>
        </div>

        <canvas id="canvas1" width="690" height="418">
        </canvas>
@else
  <div class="col-md-6"  style="padding-left:0px;">
    <div class="canvasBorder"  style="height:650px;width:412px;border:1px black dashed;">
      <div id="div1" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image) }}');background-size:100% 100%;height:648px;width:410px;">
        
        <div id="guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 626px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 388px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 398px; width: 1px; height: 626px;"></div>
            <div class="safety-margin-line-fg" style="top: 636px; left: 12px; width: 388px; height: 1px;"></div>
        </div>

        <canvas id="canvas1" width="410" height="648">
        </canvas>
@endif
<div id="card_body" style="">

  @if($objects)

    @foreach($objects as $object) 
      <?php
        $id = $object->name;
        $id = str_replace(" ","_",$object->name);
        $id = strtolower($id);
      ?>

      @if($object->type == "line")
          <div class="object object_line_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
              <div id="{{ $id }}" class="object_line" style="{{ $object->css }}" >
              </div>
          </div>
      @elseif($object->type == "square")
          <div id="{{ $id }}" class="object object_square" style="{{ $object->css }}">
          </div>
      @elseif($object->type == "circle")
          <div class="object object_circle_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
              <div id="{{ $id }}" class="object_circle" style="{{ $object->css }}">
              </div>
          </div>
      @endif
    @endforeach

  @endif
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
                   
                        <div id="div_image_{{ $id }}" name="{{ $name }}" style="{{ $div_css }}" class="template_image_div">
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


        <!--Object Toolbar end-->

        </div>
        <!-- <div id="slider" style="margin-top:20px;"></div> -->
    </div>
    @if($templates->type == "horizontal")
    <div  class="row">
      <a id="guideline" class="btn col-md-3 btn-primary back-card-buttons"  style="margin-left:10px;">
        Hide Guidelines
      </a>
      <a id="btnborder" class="btn btn-primary col-md-3 back-card-buttons">
        Show Borders
      </a>
      <a type="button" class="btn btn-primary col-md-3 back-card-buttons" data-toggle="modal" data-target="#getSize">
        Upload Image
      </a>
      <a id="btnsave" class="btn btn-primary col-md-3 back-card-buttons" style="padding-left:10px;">
        Save
      </a>
    </div>
    <div class="col-md-8" style="padding-left:0px;">
      <button class="btn btn-dark btn-lg card-buttons" style="width:692px;" id="front_button">Back</button>
    </div>
    @else
    <div class="row">
      <a id="btnborder" class="btn btn-primary col-md-3 card-buttons-verticle" style="margin-left:10px;">
          Show Borders
        </a>
        <a type="button" class="btn btn-primary col-md-3 card-buttons-verticle" data-toggle="modal" data-target="#getSize">
          Upload Image
        </a>
        <a id="btnsave" class="btn btn-primary col-md-3 card-buttons-verticle" >
          Save
        </a>

        <a id="guideline" class="btn btn-primary card-buttons  card-buttons-guide-line">
          Hide Guidelines
        </a>

    </div>
    <div class="col-md-4" style="padding-left:0px;">
      <button class="btn btn-dark btn-lg card-buttons" style="width:410px;" id="front_button">Back</button>
    </div>
    @endif
    
        
          
   
    </div>
    
    </div>
</div>












<div id="back_side" style="display:none;">
  <div class="row">
  @if($templates->type == "horizontal")
    <div class="col-md-3" >
  @else
    <div class="col-md-3 col-md-offset-2">
  @endif
  <div class="panel-group" id="accordion_back" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion_back" href="#collapseOne_back" aria-expanded="true" aria-controls="collapseOne_back">
             Feilds    
          </a>
        </h4>
      </div>
      <div id="collapseOne_back" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body" id="back_feild_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control" id="back_newFeildName" placeholder="Enter New Feild">
            </div>
            <div class="col-md-4">
              <button id="back_newFeildBtn" class="btn btn-primary">OK</button>     
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
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_back" href="#collapseTwo_back" aria-expanded="false" aria-controls="collapseTwo_back">
              Labels                
          </a>
        </h4>
      </div>
      <div id="collapseTwo_back" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body" id="label_body">
          <div class="row">
            <div class="col-md-8" style="padding-right:0px">
              <input type="text" class="form-control" id="back_newLabelName" placeholder="Enter New Label">
            </div>
            <div class="col-md-4">
              <button id="back_newLabelBtn" class="btn btn-primary">OK</button>
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


      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_back" href="#collapseThree_back" aria-expanded="false" aria-controls="collapseThree">
              Objects              
            </a>
          </h4>
        </div>
        <div id="collapseThree_back" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
          <div class="panel-body" id="label_body">
            <div class="row">
              <div class="col-md-4" style="padding-left:22px;" id="back_object_line" >
                <i class="fa fa-pencil-square-o fa-3x" aria-hidden="true" ></i>  
                <br>LINE
              </div>
              
              <div class="col-md-4 text-center" id="back_object_square"> 
                <i class="fa fa-square-o fa-3x" aria-hidden="true"></i>
                <br>SQUARE
              </div>

              <div class="col-md-4 text-center" id="back_object_circle">
                <i class="fa fa-circle-thin fa-3x" aria-hidden="true"></i>
                <br>CIRCLE
              </div>
            </div>
          </div>
        </div>
      </div>


  </div>
</div>  

@if($templates->type == 'horizontal')
  <div class="col-md-9" style="padding-left: 0px;">
    <div class="canvasBorder" style="height:421px;width:692px;border:1px black dashed;">
      <div id="div2" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image_back) }}');background-size:100% 100%;height:419px;width:690px;">
        
        <div id="back_guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 666px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 679px; width: 1px; height: 395px;"></div>
            <div class="safety-margin-line-fg" style="top: 408px; left: 12px; width: 666px; height: 1px;"></div>
        </div>

        <canvas id="canvas2" width="690" height="419">
        </canvas>
@else
  <div class="col-md-6" style="padding-left:0px;">
    <div class="canvasBorder"  style="height:650px;width:412px;border:1px black dashed;">
      <div id="div2" style="background-image:url('{{ url('templates/background-images/'.$templates->background_image_back) }}');background-size:100% 100%;height:648px;width:410px;">
        
        <div id="back_guideline_border" class="overlay canvas-element-wrapper">
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 1px; height: 626px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 12px; width: 388px; height: 1px;"></div>
            <div class="safety-margin-line-fg" style="top: 12px; left: 398px; width: 1px; height: 626px;"></div>
            <div class="safety-margin-line-fg" style="top: 636px; left: 12px; width: 388px; height: 1px;"></div>
        </div>

        <canvas id="canvas2" width="400" height="648">
        </canvas>
@endif
<div id="back_card_body" style="">

    @if($back_objects)

        @foreach($back_objects as $object) 
          <?php
            $id = $object->name;
            $id = str_replace(" ","_",$object->name);
            $id = strtolower($id);
          ?>

          @if($object->type == "line")
              <div class="object object_line_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
                  <div id="{{ $id }}" class="object_line" style="{{ $object->css }}">
                  </div>
              </div>
          @elseif($object->type == "square")
              <div id="{{ $id }}" class="object object_square" style="{{ $object->css }}">
              </div>
          @elseif($object->type == "circle")
              <div class="object object_circle_wrapper" id="wrapper_{{ $id }}" style="{{ $object->line_css }}">
                  <div id="{{ $id }}" class="object_circle" style="{{ $object->css }}">
                  </div>
              </div>
          @endif
      @endforeach

    @endif


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
  @if($back_image_css)
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
             
      <div id="div_image_{{ $id }}" name="{{ $name }}" style="{{ $div_css }}" class="template_image_div">
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
    @if($templates->type == "horizontal")
    <div class="row">
      <a id="back_guideline" class="btn btn-primary card-buttons"  style="margin-left:10px;width:174px;">
        Hide Guidelines
      </a>
      <a id="back_btnborder" class="btn btn-primary card-buttons"  >
        Show Borders
      </a>
      <a type="button" class="btn btn-primary card-buttons" data-toggle="modal" data-target="#getSize">
        Upload Image
      </a>
      <a id="back_btnsave" class="btn btn-primary card-buttons">
        Save
      </a>
    </div>
    <div class="col-md-8" style="padding-left:0px;">
      <button class="btn btn-dark btn-lg card-buttons" style="width:692px;" id="back_button">Front</button>
    </div>
    @else
    <div class="row">

      <a id="back_btnborder" class="btn btn-primary card-buttons-verticle"  style="margin-left:10px;margin-right: 3px;">
        Show Borders
      </a>
      <a type="button" class="btn btn-primary card-buttons-verticle" data-toggle="modal" data-target="#getSize" style="margin-right: 2px;">
        Upload Image
      </a>
      <a id="back_btnsave" class="btn btn-primary card-buttons-verticle">
        Save
      </a>

      <a id="back_guideline" class="btn btn-primary  card-buttons card-buttons-guide-line">
        Hide Guidelines
      </a>
    </div>

    <div class="col-md-4" style="padding-left:0px;">
      <button class="btn btn-dark btn-lg card-buttons" style="width:410px;" id="back_button">Front</button>
    </div>
    @endif
        
        
   
    </div>
    
    </div>
</div>
 <div class="row">
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
                <a href="#" style="font-size: 20px;" id="flip">More</a>
            </div>
        </div>
       
        <!--Toolbar Delete Button end-->

        <!--Toolbar Textbox-->

        <input type="text" id="myTextBox" class="toolbar-textbox form-control" placeholder="Enter Data" />
        <!--Toolbar Textbox end-->

        </div><!--Toolbar end-->


      <!--Object Toolbar start-->
        <div id="objectToolbar" class="object-toolbar row" style="position:absolute;padding:0px;">
          
          <div class="col-md-12 col-md-offset-3 object-toolbar-submenu">
            <div id="object_fill_color" class="col-md-6 submenu" style="padding-bottom:8px;">
              <div class="col-md-8">
                <div class="object-toolbar-submenu-text">Object Color</div>
              </div>
              <div class="col-md-4">
                <div id="colorSelector1" class="object-color-picker">
                  <div style="background-color: #0000ff">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-md-offset-5 object-toolbar-submenu">
            <div id="object_stroke_tools" class="col-md-8 submenu">
              <div class="col-md-4 side-break-submenu">
                <select id="thickness" class="select-thickness">
                <option value = "1">1px</option>
                <option value = "2">2px</option>
                <option value = "3">3px</option>
                <option value = "4">4px</option>
                <option value = "5">5px</option>
                <option value = "6">6px</option>
                <option value = "7">7px</option>
                <option value = "8">8px</option>
              </select>
              </div>
              <div class="col-md-3 side-break-submenu text-center">
                <div id="colorSelector3" class="object-color-picker" style="margin-left:4px;">
                  <div style="background-color: #0000ff">
                  </div>
                </div>
              </div>
              <div class="col-md-5 text-center">
                <select id="border_type" class="select-border-style">
                  <option value = "solid">Solid</option>
                  <option value = "dashed">Dashed</option>
                  <option value = "dotted">Dotted</option>
                </select>
              </div>
            </div>
          </div>
           <div class="col-md-12 col-md-offset-7 object-toolbar-submenu" >
            <div id="object_opacity_tool" class="col-md-7 submenu" style="">
              <div class="col-md-10">
                <input id="opacity_slider" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="100"/>
              </div>
              <div class="col-md-2" id="opacity_value">
                20%
              </div>
            </div>
          </div>
          <div class="col-md-12 col-md-offset-9 object-toolbar-submenu" >
            <div id="object_rotate_tool" class="col-md-7 submenu">
              <div class="col-md-7"  style="margin-top:17px;">
                Enter Rotation :
              </div>
                <input type="text" id="rotation_degrees" class="col-md-2"  style="margin-top:13px;">
              <div class="col-md-3"  style="margin-top:17px;">
                Degrees
              </div>
            </div>
          </div>
          <div class="col-md-12 col-md-offset-11 object-toolbar-submenu" >
            <div id="object_arrange_tool" class="col-md-4 submenu" style="padding-left:10px;">
              <div class="col-md-6 side-break-submenu" id="arrange_back">
                <i class="fa fa-arrow-circle-left arrange_icon" aria-hidden="true" ></i>
                <br>
                <b class="arrange_font"> BACK </b>
              </div>
              <div class="col-md-6" id="arrange_front">
                <i class="fa fa-arrow-circle-right arrange_icon" aria-hidden="true"></i>
                <br>
                <b class="arrange_font"> FRONT </b>
              </div>

            </div>
          </div>

            <!--Thickness Dropdown-->
            <div class="col-md-2 text-center side-break" id="object_fill">
              <img src="{{ url('assets/images/fill.png') }}" height="20px" width="20x" class="fill-color">
              <div class="object-toolbar-text">Fill</div>
            </div>
            <div class="col-md-2 text-center side-break" id="object_stroke">
              <img src="{{ url('assets/images/stroke.png') }}" height="20px" width="20x" class="stroke-color">
              <div class="">Stroke</div>
            </div>
            <div class="col-md-2 text-center side-break" id="object_opacity">
              <img src="{{ url('assets/images/opacity.png') }}" height="20px" width="20x" class="stroke-color">
              <div class="">Opacity</div>
            </div>
            <div class="col-md-2 text-center side-break" id="object_rotate">
              <img src="{{ url('assets/images/rotation.png') }}" height="20px" width="20x" class="stroke-color">
              <div class="">Rotation</div>
            </div>
            <div class="col-md-2 text-center side-break" id="object_arrange">
              <img src="{{ url('assets/images/arrange.png') }}" height="20px" width="20x" class="stroke-color">
              <div class="">Arrange</div>
            </div>
            <div id="square_radius">
            </div>
            <div class="col-md-2 text-center side-break" id="object_delete">
              <img src="{{ url('assets/images/delete.png') }}" height="20px" width="20x" class="stroke-color">
              <div class="">Delete</div>
            </div>
        </div>


  </div>
         <!-- Modal -->
            <div class="modal fade" id="getSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Select Image Size</h4>
                  </div>
                  <div class="modal-body">
                      <select class="form-control" id="image-size">
                        <option value="passport">Passport size Image</option>
                        <option value="menualy">Other Size Image</option>
                      </select>
                      <div id="size" style="margin-top:10px;display: none">
                        <form id="uploadimage" method="POST" action="" enctype="multipart/form-data">
                          <div class="form-group" >
                            <label class="col-sm-3 control-label" style="margin-top:10px;">Image Name : </label>
                            <div class="col-sm-9" style="margin-top:10px;">
                              <input type="text"  name="imagenameform" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label" style="margin-top:10px;">Image : </label>
                            <div class="col-sm-9" style="margin-top:10px;">
                              <input type="file" id="other_image" name="image" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="margin-top:10px;">
                              <input type="submit" class="btn btn-primary"></div>
                            </div> 
                        </form>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="upload" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="saveSize" data-toggle="modal" data-target="#myModal">OK</button>
                  </div>
                </div>
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
                    <div class="image-editor" id="image-editor">
                          <hr>
                          <input type="file" class="cropit-image-input">
                          <label style="position: absolute;margin-top: 14px;margin-left: 6px;">Name </label>
                          <input type="text" class="form-control" style="margin-top:10px;width:400px;margin-left:53px;" id="image_name" name="image_name" placeholder="Enter image Feild Name.." required="required" />
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
</div>

   


@endsection

@section('js')
 


    <script>


    var token = "{{ csrf_token() }}";
    var site_url = "{{ url('') }}";
    var feild_names = {!! json_encode($names) !!};
    var upload_images = {!! json_encode($template_images) !!};
    var label_names = {!! json_encode($template_labels) !!};;
    var template_id = {{ $templates->id }};
    var side = "";
    var is_back = "0";
    var template_both_side = {{ $templates->is_both_side }};
    var lines = {!! json_encode($lines) !!};
    var circles = {!! json_encode($circles) !!};
    var squares = {!! json_encode($squares) !!};
    var deleted_lines = [];
    var deleted_circles = [];
    var deleted_squares = [];
    var back_lines = {!! json_encode($back_lines) !!};
    var back_circles = {!! json_encode($back_circles) !!};
    var back_squares = {!! json_encode($back_squares) !!};
    var back_deleted_lines = [];
    var back_deleted_circles = [];
    var back_deleted_squares = [];
    var back_feild_names = {!! json_encode($back_names) !!};
    var back_upload_images = {!! json_encode($back_template_images) !!};
    var back_label_names = {!! json_encode($back_template_labels) !!};


    $(document).ready(function()
    {
        $("#guideline").click(function(){
          if($(this).text() == "Show Guideline")
          {
              $('#guideline_border').show();
              $(this).text("Hide Guideline");
          }
          else
          { 
              $('#guideline_border').hide();
              $(this).text("Show Guideline");
          }
      });

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
              $('#newFeildBtn').attr('disabled','disabled');
          }
          else
          { 
              $('.error').html("");
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
                $('#newLabelBtn').attr('disabled','disabled');
            }
            else
            { 
                $('.lable-error').html("");
                document.getElementById("newLabelBtn").disabled=false;
            }
        }


       $(document).ready(function(){
        $("#flip").click(function(){
            $("#panel").slideToggle("slow");
        });
       $("#front_button").click(function(){
              $("#back_side").show();
              $("#front_side").hide();
              side = "back_";
              is_back = "1";

          });
       $("#back_button").click(function(){
             $("#front_side").show();
              $("#back_side").hide();
              side = "";
              is_back = "0"; 
       });
    });
    
</script>

    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>
    <!--Color Picker -->
    <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
    <!--end-->
    <script src="{{ url('assets/js/admin.js') }}"></script>
    <script src="{{ url('assets/js/admin_backside.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.fontselect.js') }}"></script>
    <script src="{{ url('assets/js/objects.js') }}"></script>

@endsection
