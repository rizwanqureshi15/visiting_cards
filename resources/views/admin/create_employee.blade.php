

@extends('master')

@section('content')

<div class="row" style="margin-top:100px;">
{{ Form::open(array('id' => 'myform','method' => 'post','url' => url('admin/create_employee'), 'class' => "form-horizontal col-md-10")) }}
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
    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
       {{ Form::text('username', null , $attributes= ['class' => 'form-control','placeholder' => 'Username','id' => 'username']) }}
       @if ($errors->first('username'))<div class="alert alert-danger">{{ $errors->first('username') }}</div>@endif
       <div class="results help-block" style="color:red"></div>
       <div class="length help-block" style="color:red"></div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
       {{ Form::text('email', null , $attributes= ['class' => 'form-control','placeholder' => 'Email'])}}
       @if ($errors->first('email'))<div class="alert alert-danger">{{ $errors->first('email') }}</div>@endif
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
       {{ Form::password('password', ['class' => 'form-control','placeholder' => 'Password']) }}
       @if ($errors->first('password'))<div class="alert alert-danger">{{ $errors->first('password') }}</div>@endif
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Retype-Password</label>
    <div class="col-sm-10">
       {{ Form::password('password_confirmation', ['class' => 'form-control','placeholder' => 'retype-Password']) }}
       @if ($errors->first('password_confirmation'))<div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>@endif   
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      {{ Form::submit('Create',[ "class" => "btn btn-primary" ]) }}
     
    </div>
  </div>
{{ Form::close() }}
</div>
@endsection


@section('js')

<script>

  $(document).ready(function () {

    var typingTimer;                
    var doneTypingInterval = 500;
    $('#username').keyup(function () {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(CheckUsername, doneTypingInterval);
                });

    function CheckUsername () 
    {
        if($("#username").val().length < 5)
        {
            $('.length').html('Username must be at least 5 characters.');
        }
        else
        {
            $('.length').html('');
        }


        $('#myform').submit (function() {
            if($("#username").val().length < 5)
            {
                $('.length').html('Username must be at least 5 characters.');
                return false;
            }
            else
            {
                $('.length').html('');
                return true;
            }
        });
            var a=$("#username").val();
            $.ajax({
                type: "POST",
                url: "check_employeename",
                dataType: 'json',
                data: { "_token": "{{ csrf_token() }}","username": a},
                success : function(username){

                    if (jQuery.isEmptyObject(username)) {
                        $('.results').html('');
                    }
                    else
                    {
                        $('.results').html('Username is already exist');
                    }

                     $('#myform').submit (function() {
                            if (jQuery.isEmptyObject(username))
                            {
                                $('.results').html('');
                                return true;
                            }
                            else
                            {
                                $('.results').html('Username is already exist');
                                return false;
                            }
                    });
                   
                }  
            }).fail(function(data){
                // on an error show us a warning and write errors to console
                var errors = data.responseJSON;
            });
    }

});

</script>
@endsection