@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>
        <h4>Profile</h4>    
        <div class="col-md-12 innerWrapper">
            
            <div class="">

                @if($user->image)
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        
                        <img src="images/{{ $user->image }}">
                         <label for="image" class="form-textbox control-label profile-lable">Image : </label>

                                <input type="file"  class="form-control textbox-controll" id="inputEmail3" name="image" value="{{ old('image') }}" style="margin:0px 0px 10px 0px;">

                                @if ($errors->has('image'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                    </div>

                @else
                     <div class="col-md-2 col-sm-3 col-xs-12">

                        <img src="images/user.png" >

                        <label for="image" class="form-textbox control-label profile-lable">Image : </label>
                        <input type="file"  class="form-control textbox-controll" id="inputEmail3" name="image" value="{{ old('image') }}" style="margin:0px 0px 10px 0px;">

                        @if ($errors->has('image'))
                            <span class="error-msg">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif       

                    </div>
                @endif
                <div class="col-md-9">
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' ' : '' }}">
                            <div class="col-md-2 col-sm-3">
                                <label for="first_name" class="form-textbox control-label profile-lable">First Name</label>
                            </div>

                            <div class="col-md-10 col-sm-9">
                                <input id="first_name" type="text" class="form-control textbox-controll" name="first_name" value="{{ $user->first_name }}">

                                @if ($errors->has('first_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' ' : '' }}">
                            
                            <div class="col-md-2 col-sm-3">
                                <label for="last_name" class="form-textbox control-label">Last Name</label>
                            </div>

                            <div class="col-md-10 col-sm-9">
                                <input id="last_name" type="text" class="form-control textbox-controll" name="last_name" value="{{ $user->last_name }}">

                                @if ($errors->has('last_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                  

                        <div class="form-group">
                            <div class="col-md-offset-10 col-md-2 col-sm-offset-9 col-sm-3">
                                <button type="submit" class="btn-blog">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!--         <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Edit Profile</h3></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' ' : '' }}">
                            <label for="first_name" class="form-textbox control-label">First Name</label>

                                <input id="first_name" type="text" class="form-control textbox-controll" name="first_name" value="{{ $user->first_name }}">

                                @if ($errors->has('first_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' ' : '' }}">
                            <label for="last_name" class="form-textbox control-label">Last Name</label>

                                <input id="last_name" type="text" class="form-control textbox-controll" name="last_name" value="{{ $user->last_name }}">

                                @if ($errors->has('last_name'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' ' : '' }}">
                            <label for="image" class="form-textbox control-label">Image</label>

                                <input type="file"  class="form-control textbox-controll" id="inputEmail3" name="image" value="{{ old('image') }}">

                                @if ($errors->has('image'))
                                    <span class="error-msg">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                        </div>

                        @if($user->image)
                        <div class="form-group{{ $errors->has('image') ? ' ' : '' }}">
                           
                           
                            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                                <img src="images/{{ $user->image }}" style="height:auto;width:200px;">
                            </div>
                        @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn-blog col-md-12">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
</div>


@endsection
