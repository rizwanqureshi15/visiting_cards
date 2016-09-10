@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="col-md-12" id="posts">
                @if(count($user_cards) == 0)

                    <h4>No Templates Found</h4>
                @else
               
                    @foreach($user_cards as $user_card)
                        
                         <div class="col-md-4">
                          <!--   <a href="{{ url('create-card/'.$user_card->url) }}"> 
                                <img class="image" src="{{ url('images/'.$username.'/'.$user_card->snap) }}">
                            </a>  -->
                              <a href="{{ url('single_card/'.$user_card->url.'/create') }}" > 
                                <img class="image" src="{{ url('images/'.$username.'/'.$user_card->snap) }}">
                            </a> 
                            <a href="{{ url('mytemplates/'.$user_card->url.'/edit') }}">
                                <button class="btn btn-primary" style="margin-top:10px;float:right;width:130px;border-radius:0px;">Edit</button>
                            </a>
                            <a href="{{ url('mytemplates/'.$user_card->url.'/delete') }}">
                                <button class="btn btn-primary" style="margin-top:10px;float:right;width:130px;margin-right:13px;border-radius:0px;">Delete</button>
                            </a>
                        </div>
                        
                        
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
  
    var  site_url = "{{url('')}}";
    var username = "{{ $username }}"
    var page_no=1;
    var last_page=false;
    
    $(document).ready(function() {
        var win = $(window);
        
        win.scroll(function() {
            // End of the document reached?
        
            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
                $.ajax({
                    type: "POST",
                    url: "{{ url('user-images') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","page_no":page_no},
                    success: function(user_cards) {
                        
                        if(user_cards.length == 0){  
                            last_page=true;
                        }
                        
                        page_no++;
                        var html = '';

                            $.each(user_cards, function( i,val ) 
                            {
                                html+="<div class='col-md-4'><img src='"+site_url+"/images/"+ username+"/"+ val.image +"' style='width:100%;padding-top:20px;'></div>";
                            });
            
                        $('#posts').append(html);
                    }
                });
                }
            }
        });
    
});

</script>

@endsection