
@extends('layouts.app')

@section('content')
	 <style>
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 5px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 350px;
        height: 350px;
        margin-left:110px;
      }

      .cropit-preview-image-container {
        cursor: move;
      }

      .cropit-preview-background {
        opacity: .2;
        cursor: auto;
      }

      .image-size-label {
        margin-top: 10px;
      }

      input, .export {
        /* Use relative position to prevent from being covered by image background */
        position: relative;
        z-index: 10;
        display: block;
      }

      button {
        margin-top: 10px;
      }
    </style>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

        	<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
			  Upload Image
			</button>

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="modal-title" id="myModalLabel">Upload Your Image</h4>
			      </div>
			      <div class="modal-body">
			        <div class="image-editor">
			        	  <hr>
					      <input type="file" class="cropit-image-input">
					      <hr>
					      <div class="cropit-preview"></div>
					      <hr>
					      <input type="range" class="cropit-image-zoom-input" />
					    
					    </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" id="upload" class="btn btn-default" data-dismiss="modal">Close</button>

			        <button type="button" class="btn btn-primary export" style="display:inline-block;">Upload</button>
			      </div>
			    </div>
			  </div>
			</div>
            <img src="{{ url('assets/images/delete.png') }}" id="image_view" height="100px" width="100px">
           
        </div>
    </div>

@endsection

@section('js')
	 <script>
      $(function() {
        $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });

        $('.export').click(function() {
          var imageData = $('.image-editor').cropit('export');
          $.ajax({
	        url: "card_image_upload",
	        type: "post",
	        async: true,
	        data: { "_token": "{{ csrf_token() }}","image": imageData},
	        dataType: 'json',
	        success: function(json) {

	          	$('#image_view').attr('src', json);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });

               
        });
      });
      
    </script>
@endsection
	