<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Identity Cards</title>
     <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <!-- Fonts -->
     <link rel="stylesheet" href="{{ url('assets/css/font-awesome.css') }}" >
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">-->

    <!-- Styles -->
   
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
   <!--  <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}"> -->
    <link rel="stylesheet" href="{{ url('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontselect.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font.css') }}">


    <!-- <link rel="stylesheet" href="{{ url('assets/css/mystyle.css') }}"> -->
    <!--ColorPicker-->
    <link rel="stylesheet" href="{{ url('assets/colorpicker/css/colorpicker.css') }}" type="text/css" />
    <!--end-->

    <!--DataTable-->
    <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/css/jquery.dataTables.css') }}" type="text/css" />
    <!--end-->

    <!--template styles-->
        <!-- NProgress -->
        <link href="{{ url('assets/css/nprogress.css') }}" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="{{ url('assets/css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet"/>
        <!-- Custom Theme Style -->
        <link href="{{ url('assets/css/gentelella.min.css') }}" rel="stylesheet">
    <!--end template-->

   

    <link rel="stylesheet" href="{{ url('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/admin_backside.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/objects.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-slider.min.css') }}">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
 <body class="nav-md"  style="background-color:#fff;">
@include('include.sidebar')
@include('include.header')

    <!--Page Content-->
    <div class="right_col" role="main">
        @yield('content')
    </div>
    <div id="overlay" style="display:none;">
        <img id="loading" src="{{ url('assets\images\ajax-loader.gif') }}">
    </div>
    <div id="user_overlay" style="display:none;">
            <img id="user_loading" src="{{ url('assets\images\loading.gif') }}">
    </div>
    <!--End Page Content-->

    @include('include.footer')
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/html2canvas.js') }}"></script>
    <script src="{{ url('assets/js/jquery.cropit.js') }}"></script>
    <script src="{{ url('assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('assets/js/jquery.dataTables.js') }}"></script>
    <script src="{{ url('assets/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ url('assets/js/fastclick.js') }}"></script>
    <script src="{{ url('assets/js/nprogress.js') }}"></script>
    <script src="{{ url('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
     <script src="{{ url('assets/js/custom.min.js') }}"></script>

    @yield('js');

  </body>
</html>