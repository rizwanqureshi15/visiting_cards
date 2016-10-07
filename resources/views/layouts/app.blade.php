<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Identity Cards</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">-->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
     <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontselect.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font.css') }}">

    <!--ColorPicker-->
    <link rel="stylesheet" href="{{ url('assets/colorpicker/css/colorpicker.css') }}" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="{{ url('assets/colorpicker/css/layout.css') }}" />

    <!--end-->
    

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <style>
  #resizable { width: 150px; height: 150px; padding: 0.5em; }
  #resizable h3 { text-align: center; margin: 0; }
  </style>
</head>
<body id="app-layout">
    <nav id="navbar" class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Identity Cards
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li><a href="{{ url('mytemplates') }}">My Templates</a></li>
                        <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/change_password') }}"><i class="fa fa-btn fa-edit"></i>Change Password</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/html2canvas.js') }}"></script>

    <script src="{{ url('assets/js/jquery-ui.js') }}"></script>

    <script src="{{ url('assets/js/jquery.validate.js') }}"></script>

    <!--Image cropper-->
    <script src="{{ url('assets/js/jquery.cropit.js') }}"></script>
    <!--End Image Cropper-->
    
    @yield('js')
    <!-- JavaScripts -->
    
</body>
</html>
