<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.css') }}" >
    <!-- NProgress -->
    <link href="{{ url('assets/css/nprogress.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ url('assets/css/gentelella.min.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ url('assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/login.css') }}" rel="stylesheet">
   
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form role="form" method="POST" action="{{ url('employees/login') }}">
              <h1>Login Form</h1>
              <div>
                @if(Session::get('error_msg'))
                  <div class="alert alert-danger" role="alert" style="color:white">
                    <a class="alert-link">{{ Session::get('error_msg') }}</a>
                  </div>
                @endif
                @if(Session::get('dlt_msg'))
                  <div class="alert alert-danger" role="alert"  style="color:white">
                    <a class="alert-link">{{ Session::get('dlt_msg') }}</a>
                  </div>
                @endif
              </div>
              <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required="" />
                @if ($errors->has('username'))
                  <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                  </span>
                @endif
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
                @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
              <div>
                <button type="submit" class="btn btn-dark">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-heart"></i> Identity Cards!</h1>
                  <p>©2016 All Rights Reserved By Web Design & Solutions.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
