

@extends('master')

@section('content')
<div class="page-title">
  <div class="title_left">
    <h3>Categories</h3>
  </div>
  <div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="input-group">
        <ol class="breadcrumb">
          <li><i class="fa fa-home" aria-hidden="true"></i> Home</li>
          <li>Categories</li>
          <li class="active">Create</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div class="x_title">
              <h2>Create</h2>
              <div class="clearfix"></div>
              </div>
          <div class="x_content">
            {{ Form::model(null,array('enctype' => 'multipart/form-data', 'id' => 'myform','method' => 'post','url' => url('admin/categories/create'), 'class' => "form-horizontal col-md-10")) }}

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <div class="form-group">
              <label class="col-sm-3 control-label">Name</label>
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
              <label class="col-sm-3 control-label">Image</label>
              <div class="col-sm-9">
                {{ Form::file('image') }}
                @if($errors->first('image'))
                  <div class="alert alert-danger">
                    {{ $errors->first('image') }}
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
</div>

@endsection
