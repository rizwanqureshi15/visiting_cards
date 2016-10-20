@extends('layouts.app')

@section('content')
         <div class="col-md-10 col-md-offset-1">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
                @endif
            </div>
        <!-- <div class="col-md-10 col-md-offset-1">
            
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Welcome</h3></div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div>
        </div> -->

          <br>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
              <!-- <li data-target="#myCarousel" data-slide-to="3"></li> -->
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img class="slider-image" src="{{ url('assets/images/slide-1.jpg') }}" alt="Chania" width="460" height="345">
              </div>

              <div class="item">
                <img class="slider-image" src="{{ url('assets/images/slide-2.jpg') }}" alt="Chania" width="460" height="345">
              </div>
            
              <div class="item">
                <img class="slider-image" src="{{ url('assets/images/slide-3.jpg') }}" alt="Flower" width="460" height="345">
              </div>

              <!-- <div class="item">
                <img src="slide-2.jpg" alt="Flower" width="460" height="345">
              </div> -->
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="title1">
                <span>Cards</span>
            </div>
        </div>
    </div>
</div>

@endsection
