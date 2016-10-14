@extends('master')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
  @if(Session::get('err_msg'))
    <div class="alert alert-danger" role="alert">
      <a class="alert-link">{{ Session::get('err_msg') }}</a>
    </div>
  @endif
  <div class="x_panel">
    <div class="x_title">
      <h2>Add New Material</h2>
      <ul class="nav navbar-right panel_toolbox">
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      {{ Form::model(null,array('enctype' => 'multipart/form-data', 'id' => 'myform','method' => 'post','url' => url('admin/materials/create'), 'class' => "form-horizontal col-md-10")) }}
      <!--lcKdznp68eH1IWpi48YSBOConAHZQIEyRQsGkJT1-->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <div class="form-group">
          <label class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
            {{ Form::text('name', null , $attributes= ['class' => 'form-control','placeholder' => 'Material Name']) }}
            @if($errors->first('name'))
              <div class="alert alert-danger">
                {{ $errors->first('name') }}
              </div>
            @endif
          </div>
        </div>
          
        <div class="form-group">
          <label class="col-sm-3 control-label">Price</label>
          <div class="col-sm-9">
            {{ Form::text('price', null , $attributes= ['class' => 'form-control','placeholder' => 'Material Price']) }}
            @if($errors->first('price'))
              <div class="alert alert-danger">
                {{ $errors->first('price') }}
              </div>
            @endif
          </div>
        </div>
          
        <div class="form-group">
          <label class="col-sm-3 control-label">Description</label>
          <div class="col-sm-9">
            {{ Form::text('description', null , $attributes= ['class' => 'form-control','placeholder' => 'Material Description']) }}
            @if($errors->first('description'))
              <div class="alert alert-danger">
                {{ $errors->first('description') }}
              </div>
            @endif
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            {{ Form::submit('Create',[ "class" => "btn btn-primary" ]) }}
          </div>
        </div>
        {{ Form::close() }}
    </div>
  </div>
</div>
<div class="row" style="margin-top:10px;">
  
  

<div class="col-md-12 col-md-offset-1" style="padding-bottom:20px;">
  <h2></h2>
</div>



</div>

@endsection


@section('js')
   
@endsection