

@extends('master')

@section('content')

<div class="row" style="margin-top:10px;">
@if(Session::get('err_msg'))
        <div class="alert alert-danger" role="alert">
          <a class="alert-link">{{ Session::get('err_msg') }}</a>
        </div>
@endif
<div class="col-md-12 col-md-offset-1" style="padding-bottom:20px;"><h2>Add New Template</h2></div>
{{ Form::model(null,array('enctype' => 'multipart/form-data', 'id' => 'myform','method' => 'post','url' => url('admin/templates/create'), 'class' => "form-horizontal col-md-10")) }}
<!--lcKdznp68eH1IWpi48YSBOConAHZQIEyRQsGkJT1-->
<input type="hidden" name="_token" value="{{ csrf_token() }}" >
  <div class="form-group">
     <label class="col-sm-3 control-label">Name</label>
    <div class="col-sm-5">
      {{ Form::text('name', null , $attributes= ['class' => 'form-control','placeholder' => 'Template Name','id' => 'temp_name']) }}
      @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif

    </div>
  </div>
   <div class="form-group">
    
    <div class="col-md-offset-3 col-sm-5">
      {{ Form::text('url', null , $attributes= ['class' => 'form-control','placeholder' => '','id' => 'txt_url']) }}
      @if($errors->first('url'))<div class="alert alert-danger">{{ $errors->first('url') }}</div>@endif

    </div>
  </div>

  <div class="form-group">
     <label class="col-sm-3 control-label">Category</label>
    <div class="col-sm-5">
      <select class="form-control" name="category_id">
        @foreach($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
      @if($errors->first('category_id'))<div class="alert alert-danger">{{ $errors->first('category_id') }}</div>@endif
    </div>
  </div>
    <div class="form-group">
     <label class="col-sm-3 control-label">Type</label>
    <div class="col-sm-5">
       <select class="form-control" name="type">
          <option value="horizontal"> Horizontal </option>
          <option value="vertical"> Vertical </option>
      </select>
      @if($errors->first('type'))<div class="alert alert-danger">{{ $errors->first('type') }}</div>@endif

    </div>
  </div>
   <div class="form-group">
     <label class="col-sm-3 control-label">Background Image</label>
    <div class="col-sm-5" >
      {{ Form::file("background_image") }}
        @if($errors->first('background_image'))<div class="alert alert-danger">{{ $errors->first('background_image') }}</div>@endif
     

    </div>
  </div>
 <!--  <div class="col-md-offset-4 col-md-8" style="padding-bottom:20px;">OR</div>
   <div class="form-group">
     <label class="col-sm-3 control-label">Background Color</label>
    <div class="col-sm-4">
      {{ Form::text('background_color', null , $attributes= ['class' => 'form-control','placeholder' => 'eg. #cccccc', 'id' => 'back-color']) }}
    </div>
   
       <div id="colorSelector" class="col-md-5"><div style="background-color: #0000ff"></div></div>
  
  </div>
 -->
   

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      {{ Form::submit('Create',[ "class" => "btn btn-primary" ]) }}
     
    </div>
  </div>
{{ Form::close() }}
</div>
@endsection


@section('js')
   <script type="text/javascript" src="{{ url('assets/colorpicker/js/colorpicker.js') }}"></script>
   <script type="text/javascript">
     // $('#colorSelector').ColorPicker({
     //    color: '#0000ff',
     //    onShow: function (colpkr) {
     //      $(colpkr).fadeIn(500);
     //      return false;
     //    },
     //    onHide: function (colpkr) {
     //      $(colpkr).fadeOut(500);
     //      return false;
     //    },
     //    onChange: function (hsb, hex, rgb) {
     //      $('#colorSelector div').css('backgroundColor', '#' + hex);
     //      $('#back-color').val('#'+hex);
     //    }
     //  });
     // $('#back-color').keyup(function(){
     //    var hex =  $('#back-color').val();
     //    console.log(hex);
     //    $('#colorSelector div').css('backgroundColor', hex);
     // });
     $('#temp_name').keyup(function(){
        var str = $('#temp_name').val();
        str = str.toLowerCase();
        str = str.replace(/\ /g, '-');
        $('#txt_url').val(str);
     });
    
   </script>
@endsection