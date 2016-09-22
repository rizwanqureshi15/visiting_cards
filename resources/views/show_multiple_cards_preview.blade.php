@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>
                  
        @foreach($user_template_images as $image)
            <div class="col-md-4">
                <img src="{{ url('assets/images/delete.png') }}" data-toggle="modal" data-target="#delete_image_model" style="height:30px;position:absolute;z-index: 1;margin-top: 22px;margin-left:84%;">
                <img src="{{ url('temp/'.$username.'/'.$image) }}" style="height:220px;width:100%;margin-top:20px;">
            </div>

            <!-- Modal -->
            <form method="post" action="{{ url('delete_image',$image) }}">
                {{ csrf_field() }}
                <div class="modal fade" id="delete_image_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete Image</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure want to delete ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" Value="Delete" ></button>
                      </div>
                    </div>
                  </div>
                </div>
            </form>
            <!-- End Model -->

        @endforeach

    </div>
</div>
@endsection

@section('js')

<script>

    var site_url = "{{url('')}}";
    var page_no = 1;
    var last_page = false;
    var token = "{{ csrf_token() }}";

    $(document).ready(function() {
        var win = $(window);

        win.scroll(function() {
            // End of the document reached?
        
            if ($(document).height() - win.height() == win.scrollTop()) {
                if(last_page == false)
                {  
                $.ajax({
                    type: "POST",
                    url: "{{ url('multiple_image_scroll') }}",
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