

@extends('master')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Add New Category</h2>
      <ul class="nav navbar-right panel_toolbox">
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      {{ Form::model($category,array('id' => 'myform','method' => 'post','url' => url('admin/categories/edit',$category->id), 'class' => "form-horizontal col-md-10")) }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <div class="form-group">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-9">
            {{ Form::text('name', null , $attributes= ['class' => 'form-control','placeholder' => 'Category Name']) }}
            @if($errors->first('name'))
              <div class="alert alert-danger">
                {{ $errors->first('name') }}
              </div>
            @endif
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save',[ "class" => "btn btn-primary" ]) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection