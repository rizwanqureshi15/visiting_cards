@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Register</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" id="myform" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? '' : '' }}">
                            <label for="first_name" class="control-label form-textbox">First Name</label>

                                <input id="first_name" type="text" class="textbox-controll form-control" name="first_name" value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' ' : '' }}">
                            <label for="last_name" class="form-textbox control-label">Last Name</label>

                                <input id="last_name" type="text" class="textbox-controll form-control" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' ' : '' }}">
                            <label for="email" class="form-textbox control-label">E-Mail Address</label>

                                <input id="email" type="email" class="textbox-controll form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                         <div class="form-group{{ $errors->has('username') ? ' ' : '' }}">
                            <label for="username" class="form-textbox control-label">Username</label>

                                <input id="username" type="text" class="textbox-controll textbox-controll form-control" id="username" name="username" value="{{ old('username') }}">
                                <div class="results help-block" style="color:#a94442;margin-left:20px;"></div>
                                <div class="length help-block" style="color:#a94442;margin-left:20px;"></div>
                                @if ($errors->has('username'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' ' : '' }}">
                            <label for="password" class="form-textbox control-label">Password</label>

                                <input id="password" type="password" class="textbox-controll form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' ' : '' }}">
                            <label for="password-confirm" class="form-textbox control-label">Confirm Password</label>

                                <input id="password-confirm" type="password" class="textbox-controll form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>

                

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn-blog col-md-12">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript">


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
                url: "check_username",
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
