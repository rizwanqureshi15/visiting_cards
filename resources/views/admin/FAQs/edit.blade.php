

@extends('master')

@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      
      <div class="x_panel">
          <div class="x_title">
              <h2>Edit Question</h2>
              <div class="clearfix"></div>
              </div>
          <div class="x_content">
            {{ Form::model($faq,array('id' => 'myform','method' => 'post','url' => url('admin/faq/edit',$faq->id), 'class' => "form-horizontal col-md-10")) }}

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <div class="form-group">
              <label class="col-sm-2 control-label">Question</label>
              <div class="col-sm-9">
                {{ Form::text('question', null , $attributes= ['class' => 'form-control','placeholder' => 'Add Question here']) }}
              @if($errors->first('question'))
                <div class="alert alert-danger">
                  {{ $errors->first('question') }}
                </div>
              @endif
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Answer</label>
              <div class="col-sm-9">
                {{ Form::textarea('answer', null , $attributes= ['class' => 'form-control','placeholder' => 'Type Answer here']) }}
              @if($errors->first('answer'))
                <div class="alert alert-danger">
                  {{ $errors->first('answer') }}
                </div>
              @endif
              </div>
            </div>

            <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
               {{ Form::submit('Submit',[ "class" => "btn btn-primary" ]) }}
              </div>
            </div>
          {{ Form::close() }}
        </div>
    </div>
  </div>
</div>

@endsection
