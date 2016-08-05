

@extends('master')

@section('content')

<div class="row" style="margin-top:100px;">
{{ Form::model($employee, array('method' => 'post','url' => url('admin/edit_profile', $employee->id), 'class' => "form-horizontal col-md-10")) }}
<!--lcKdznp68eH1IWpi48YSBOConAHZQIEyRQsGkJT1-->
<input type="hidden" name="_token" value="{{ csrf_token() }}" >
  <div class="form-group">
     <label class="col-sm-2 control-label">Name</label>
    <div class="col-sm-5">
      {{ Form::text('first_name', null , $attributes= ['class' => 'form-control','placeholder' => 'First Name']) }}
      @if($errors->first('first_name'))<div class="alert alert-danger">{{ $errors->first('first_name') }}</div>@endif

    </div>
    <div class="col-sm-5">
      {{ Form::text('last_name', null , $attributes= ['class' => 'form-control','placeholder' => 'Last Name']) }}
      @if($errors->first('last_name'))<div class="alert alert-danger">{{ $errors->first('last_name') }}</div>@endif

    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
       {{ Form::text('email', null , $attributes= ['class' => 'form-control','placeholder' => 'Email']) }}
       @if ($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      {{ Form::submit('Edit Profile',[ "class" => "btn btn-primary" ]) }}
     
    </div>
  </div>
{{ Form::close() }}
</div>
@endsection