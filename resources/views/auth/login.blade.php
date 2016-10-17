@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('flash_message'))
                    <div class="alert alert-danger">
                         <span class="glyphicon glyphicon-close"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
            @endif

        </div>

        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="panel panel-default">
               
                <div class="panel-heading "><h3>Log in</h3></div>
                <div class="panel-body login-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' ' : '' }}">
                            <label for="email" class="control-label form-textbox">Username</label>
                            
                                <input id="email" type="text" class="form-control textbox-controll" placeholder="Username Or Email address" name="email" value="{{ old('email') }}">
                                
                                @if ($errors->has('email'))
                                    <p class="error-msg">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' ' : '' }}">
                            <label for="password" class="control-label form-textbox">Password</label>
                                <input id="password" type="password" placeholder="Password" class="textbox-controll form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                                <div class="checkbox form-textbox">
                                    <label>
                                        <input type="checkbox" name="remember"> &nbsp;&nbsp;&nbsp;Remember Me
                                    </label>
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn-blog col-md-12">
                                    Log in
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-4">
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
