@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row block">
        <div class="col-md-10 col-md-offset-1">
             @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                         <span class="glyphicon glyphicon-ok"></span>
                            <em> {!! session('flash_message') !!}</em>
                    </div>
             @endif
        </div>

        <input type="hidden" value="{{ Session::get('material_id') }}" id="material">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="col-md-12" id="posts">
                @if($user_cards == false)
                    <h4>No Templates Found</h4>
                @else
               
                    @foreach($user_cards as $user_card)
                         <div class="col-md-4">
                          <!--   <a href="{{ url('create-card/'.$user_card->url) }}"> 
                                <img class="image" src="{{ url('images/'.$username.'/'.$user_card->snap) }}">
                            </a>  -->
                            <!-- <a href="" data-url="{{ $user_card->url }}" data-toggle="modal" data-target="#card_options" class="url">  -->

                            <a id="{{ $user_card->url }}" data-url="{{ $user_card->url }}" class="url"> 

                            @if($user_card->type == "horizontal")
                                <img class="image" src="{{ url('images/'.$username.'/'.$user_card->snap) }}">                           
                            @else
                                <img class="vertical_image" src="{{ url('images/'.$username.'/'.$user_card->snap) }}">
                            @endif
                            </a>
                            <a href="{{ url('mytemplates/'.$user_card->url.'/edit') }}">
                                <button class="btn-blog col-md-5">Edit</button>
                            </a>
                            <a href="{{ url('mytemplates/'.$user_card->url.'/delete') }}">
                                <button class="btn-blog col-md-6" style="margin-right:22px;">Delete</button>
                            </a>
                        </div>
                        
                        
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

            <!--Modal-->
                <div class="modal fade" id="material_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close"><span aria-hidden="true" data-dismiss="modal">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Choose Material</h4>
                          </div>
                          <div class="modal-body">
                                <select class="form-control textbox-controll" id="selected_materil_id">
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}" data-material="{{ $material->id }}" class="form-control textbox-controll">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                          </div>
                          <div class="modal-footer">
                                <button id="material_id_save" type="button" class="model-btn">Save</button>
                          </div>
                        </div>
                      </div>
                </div> 
            <!--Modal End-->

     <!--Modal-->
            <div class="modal fade" id="card_options" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Card Options</h4>
                      </div>
                      <div class="modal-body raw" style="height:250px;">
                        <div class="col-md-6" style="height:200px;">
                            <a href="" class="btn-blog" style="height:100%;width:100%;text-align:center" id="single"><h2 style="margin-top:70px;">Single</h2></a>
                        </div>
                        <div class="col-md-6" style="height:200px;">
                            <a href="" class="btn-blog" style="height:100%;width:100%;text-align:center" id="multiple"><h2 style="margin-top:70px;">Multiple</h2></a>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="model-btn" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
            </div> 
     <!--Modal End--> 

    </div>
</div>
@endsection

@section('js')

<script>
    
    // $('#material_popup').modal({backdrop: 'static', keyboard: false , show: true}); 
  
    var site_url = "{{url('')}}";
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

    
        $(".url").click(function()
            {
                var material_id = $("#material").val();
                var a = $(this).data('url');
                var new_url = '{{ url("multiple_cards") }}/'+a+'';
                
                if(material_id == "")
                {
                    $("#material_popup").modal("show");
                }
                else
                {
                    $("#card_options").modal("show");
                }
                
                $('#multiple').attr('href',new_url);

            });

        $(".url").click(function()
        {
            var a = $(this).data('url');
            var new_url = '{{ url("single_card") }}/'+a+'/create';
            $('#single').attr('href',new_url);

        });

        $("#material_id_save").click(function()
        {
            var material_id = $("#selected_materil_id").val();
            
            $.ajax({
                    type: "POST",
                    url: "{{ url('save_material_id') }}",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}","material_id":material_id},
                    success: function(user_cards) 
                    {   
                        $("#material").val(material_id);
                        $("#material_popup").modal("hide");
                        $("#card_options").modal("show");
                    }
                });
        });
    
});

</script>

@endsection