  

@extends('master')

@section('content')

<div class="row" style="margin-top:10px;">
  @if(Session::get('err_msg'))
    <div class="alert alert-danger" role="alert">
      <a class="alert-link">{{ Session::get('err_msg') }}</a>
    </div>
  @endif
  <div class="col-md-12 col-md-offset-1" style="padding-bottom:20px;">
    <h2>Edit Template</h2>
  </div>
  
  {{ Form::model($template,array('enctype' => 'multipart/form-data', 'id' => 'myform','method' => 'post','url' => url('admin/templates/edit', $template->id), 'class' => "form-horizontal col-md-10")) }}

  <input type="hidden" name="_token" value="{{ csrf_token() }}" >
  <div class="form-group">
    <label class="col-sm-3 control-label">Name</label>
    <div class="col-sm-5">
      {{ Form::text('name', null , $attributes= ['class' => 'form-control','placeholder' => 'Template Name','id' => 'temp_name']) }}
      
      @if($errors->first('name'))
        <div class="alert alert-danger">
          {{ $errors->first('name') }}
        </div>
      @endif

    </div>
  </div>
  <div class="form-group">
    <div class="col-md-offset-3 col-sm-5">
      {{ Form::text('url', null , $attributes= ['class' => 'form-control','placeholder' => '','id' => 'txt_url']) }}
      @if($errors->first('url'))
        <div class="alert alert-danger">
          {{ $errors->first('url') }}
        </div>
      @endif
    </div>
  </div>
  <div class="form-group">
     <label class="col-sm-3 control-label">Price</label>
    <div class="col-sm-5">
      {{ Form::text('price', null , $attributes= ['class' => 'form-control','placeholder' => 'Template Price']) }}
      @if($errors->first('price'))
        <div class="alert alert-danger">
          {{ $errors->first('price') }}
        </div>
      @endif
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Category</label>
    <div class="col-sm-5"> 
      <select class="form-control" name="category_id">
        @foreach($categories as $category)
          <option value="{{ $category->id }}" 
          @if($category->id == $template->category_id )
              {{ "selected" }}
          @endif >{{ $category->name }}
          </option>
        @endforeach
      </select>
      @if($errors->first('category_id'))<div class="alert alert-danger">{{ $errors->first('category_id') }}</div>@endif
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Type</label>
    <div class="col-sm-5">
      <select class="form-control" name="type">
        <option value="horizontal" @if($template->type=='horizontal') {{ "selected" }} @endif> Horizontal </option>
        <option value="vertical" @if($template->type=='vertical') {{ "selected" }} @endif> Vertical </option>
      </select>
      @if($errors->first('type'))<div class="alert alert-danger">{{ $errors->first('type') }}</div>@endif
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-5 col-md-offset-3">
      <input type="checkbox" id="double_card" name="double_side" @if($template->is_both_side == 1) {{ "checked=checked" }} @endif> Card is Double side 
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Background Image - Front</label>
    <div class="col-sm-5" >
      @if($template->background_image)
        <img id="front-img" src="{{ url('templates/background-images',$template->background_image) }}" height="200px" width="300px">
        <a class="btn btn-primary" id="img-delete" style="margin-top:10px;">Delete</a>
        <br>
        <br>
        <?php
        $check = 1;
        ?>
        @else
        
        <?php
        $check = 0;
        ?>
      @endif
        {{ Form::hidden('is_image', $check, $attributes = ['id' => 'is_img'])}}
        {{ Form::file("background_image") }}
        @if($errors->first('background_image'))
          <div class="alert alert-danger">
            {{ $errors->first('background_image') }}
          </div>
        @endif
    </div>
  </div>
    <div class="form-group" id="back_image" @if($template->is_both_side != 1){{ "style=display:none;"}}@endif>
      <label class="col-sm-3 control-label">Background Image- Back </label>
      <div class="col-sm-5" >

        @if($template->background_image_back)
          <img id="back-img" src="{{ url('templates/background-images',$template->background_image_back) }}" height="200px" width="300px">
          <a class="btn btn-primary" id="back-img-delete" style="margin-top:10px;">Delete</a>
          <br>
          <br>
          <?php
          $check = 1;
          ?>
          @else
          
          <?php
          $check = 0;
          ?>
        @endif
      {{ Form::hidden('is_back_image', $check, $attributes = ['id' => 'is_back_img'])}}
      {{ Form::file("background_image_back") }}
      @if($errors->first('background_image_back'))<div class="alert alert-danger">{{ $errors->first('background_image_back') }}</div>@endif

    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      {{ Form::submit('Update',[ "class" => "btn btn-primary" ]) }}
     
    </div>
  </div>
{{ Form::close() }}
</div>
@endsection


@section('js')
   <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
   <script type="text/javascript">
     $('#temp_name').keyup(function(){
        var str = $('#temp_name').val();
        str = str.toLowerCase();
        str = str.replace(/\ /g, '-');
        $('#txt_url').val(str);
     });
     $('input[type=file]').change(function(){
     $('#is_img').val("1");

    });
    $('#img-delete').click(function(){
      $('#is_img').val("0");
      $('#front-img').hide();
      $(this).hide();
    });
     $('#back-img-delete').click(function(){
      $('#is_back_img').val("0");
      $('#back-img').hide();
      $(this).hide();
    });
     $('#double_card').click(function(){
      if(this.checked)
      {
        $('#back_image').show();

      }
      else
      {
        $('#back_image').hide();
      }
     });
    
   </script>
@endsection