<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Identity Cards</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
   <!--  <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}"> -->
    <link rel="stylesheet" href="{{ url('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontselect.css') }}">

    <!--ColorPicker-->
    <link rel="stylesheet" href="{{ url('assets/colorpicker/css/colorpicker.css') }}" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="{{ url('assets/colorpicker/css/layout.css') }}" />

    <!--end-->
    <link rel="stylesheet" href="{{ url('assets/css/admin.css') }}">
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
    </div>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    

    @yield('js');

  </body>
</html>