<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Identity Cards</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}" >
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">-->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
   <!--  <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}"> -->
    <link rel="stylesheet" href="{{ url('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontselect.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}">
    <!--ColorPicker-->
    <link rel="stylesheet" href="{{ url('assets/colorpicker/css/colorpicker.css') }}" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="{{ url('assets/colorpicker/css/layout.css') }}" />

    <!--end-->

   

    <link rel="stylesheet" href="{{ url('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/admin_backside.css') }}">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
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
                    
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                  

                </ul>
            </div>
        </div>
    </nav>



    
   <div class="container" style="">
      <div class="row">
      @if(Auth::guard('employee')->user())
    

        @if(Auth::guard('employee')->user()->is_admin == 1)
        <div class="col-md-2" style="padding-right:0px;padding-left:0px;">
            @include('sidebar')
        </div>
        @endif
      @endif
        <div class="col-md-10">
            @yield('content')
        </div>
      </div>
       <div id="overlay" style="display:none;">
        <img id="loading" src="{{ url('assets\images\ajax-loader.gif') }}">
    </div>
    </div>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/html2canvas.js') }}"></script>
    <script src="{{ url('assets/js/jquery.cropit.js') }}"></script>
  
    @yield('js');

  </body>
</html>