

@extends('master')

@section('content')

<div class="row" style="margin-top:10px;">
<div class="col-md-12 col-md-offset-1" style="padding-bottom:20px;"><h2>Add New Category</h2></div>
{{ Form::model($category,array('id' => 'myform','method' => 'post','url' => url('admin/categories/edit',$category->id), 'class' => "form-horizontal col-md-10")) }}
<!--lcKdznp68eH1IWpi48YSBOConAHZQIEyRQsGkJT1-->
<input type="hidden" name="_token" value="{{ csrf_token() }}" >
  <div class="form-group">
     <label class="col-sm-2 control-label">Name</label>
    <div class="col-sm-5">
      {{ Form::text('name', null , $attributes= ['class' => 'form-control','placeholder' => 'Category Name']) }}
      @if($errors->first('name'))<div class="alert alert-danger">{{ $errors->first('name') }}</div>@endif

    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      {{ Form::submit('Save',[ "class" => "btn btn-primary" ]) }}
     
    </div>
  </div>
{{ Form::close() }}
</div>
@endsection


@section('js')

@endsection