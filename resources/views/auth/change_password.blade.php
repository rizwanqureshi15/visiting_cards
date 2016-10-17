@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Change Password</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/change_password') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('password') ? ' ' : '' }}">
                            <label for="password" class=" form-textbox control-label">New Password</label>

                                <input id="password" type="password" class="form-control textbox-controll" name="password">

                                @if ($errors->has('password'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' ' : '' }}">
                            <label for="password-confirm" class=" form-textbox control-label">Confirm Password</label>

                                <input id="password-confirm" type="password" class="form-control textbox-controll" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn-blog col-md-12">
                                    Change
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
