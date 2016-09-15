		var element_id;
		var image_id;
		var delete_feilds=[];	
		var delete_images=[];	
		 var element = $("#div1"); // global variable
    var getCanvas; 	


    	var hexDigits = new Array
        ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

		//Function to convert hex format to a rgb color
		function rgb2hex(rgb) {
		 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
		 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
		}

		function hex(x) {
		  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
		 }

		$('.feild-elements').click(function(){
			element_id = $(this).attr('id');
			//console.log(element_id);
			
		});

		$('.feild-elements').click(function(){
			element_id = $(this).attr('id');
			
		});
		$("#under_line").click(function(){
			var check = $("#span_" + element_id).css("text-decoration");
			
			 if(check == "none")
			 {
				$("#span_" + element_id).css("text-decoration", "underline"); 	
				$("#under_line").addClass("button-selected");
			 }
			 else
			 {
			 	$("#span_" + element_id).css("text-decoration", "none");
			 	$("#under_line").removeClass("button-selected");
			 }
			
		});
		$("#italic").click(function(){
			var check = $("#span_" + element_id).css("font-style");
			
			 if(check == "normal")
			 {
				$("#span_" + element_id).css("font-style", "italic");
				$("#italic").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#span_" + element_id).css("font-style", "normal");
			 	$("#italic").removeClass("button-selected");
			 }
			
		});
		$("#bold").click(function(){
			var check = $("#span_" + element_id).css("font-weight");
			
			 if(check == 400)
			 {
				$("#span_" + element_id).css("font-weight", 900);
				$("#bold").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#span_" + element_id).css("font-weight", 400);
			 	$("#bold").removeClass("button-selected");
			 }
			
		});
		$(document).on("keyup", ".sidebar-elements" , function(){
			
			var id = $(this).attr('id');
			var txt = $(this).val();
			var str = id.substring(8,id.length);
			var span_element = '#span_' + str;

			$(span_element).text(txt);

			$('#myTextBox').val(txt);
			
			if(txt == "")
			{
				 txt = str.replace(/\_/g, ' ');
				$(span_element).text(txt);
			}	
			$('#' + str).resizable();
		});

		$('#myTextBox').keyup(function(){
			
			var txt = $('#myTextBox').val();
			
			$('#span_'+element_id).text(txt);
			$('#sidebar_'+element_id).val(txt);
			$('#'+element_id).resizable();
		});

		$(window).click(function() {
			
			$('#myToolbar').hide();
		});

		$('#myToolbar').click(function(event){
			
			event.stopPropagation();
		});

		$(document).ready(function(){
			
			$('.textbox-size').draggable();
			$('.textbox-size').resizable();
			

			$('.template_image_div').resizable();
			$('.template_image_div').draggable();
		});
		
		$(document).on('click',".feild-elements", function(event) {
		     event.stopPropagation();
		    element_id = $(this).attr('id')	;
		    var l = $('#' + element_id).css('left');
		    var t = $('#' + element_id).css('top');
		    var txt = $('#' +element_id).text();
		    $('#myTextBox').val($.trim(txt));

		    t = t.substring(0,t.length - 2);

		    if( parseInt(t) < 100 )
		    {
		    	var txt_hight = $('#' + element_id).css('height');
		    	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	
		    }
		    else
		    {
		    	t = parseInt(t)-parseInt($("#myToolbar").css('height'))-10;
		    }
		   var selectedfont = $('#span_' + element_id).css('font-family');		 
			$('#font-text').css('font-family', selectedfont);
			$('#font-text').text(selectedfont);
			 var selectedfontsize = $('#span_' + element_id).css('font-size');	
			 var s = selectedfontsize.substring(0,selectedfontsize.length-2);
			 var hex = $('#span_' + element_id).css('color');	
			 $('#colorSelector div').css('backgroundColor', '#' + hex);
			 feild_color = rgb2hex(hex);
			
			$('#size-font').val(s).prop('selected', true);
 

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		    
		    $("#myToolbar").show();
		});
		

		$('.toolbar-elements').droppable({
			drop: function(event, ui) {
		    event.stopPropagation();
		    var element_id = $(this).attr('id')	;
		    var l = $('#' + element_id).css('left');
		    var t = $('#' + element_id).css('top');
		    var txt = $('#' +element_id).text();
		    $('#myTextBox').val($.trim(txt));

		    t = t.substring(0,t.length - 2);

		    if( parseInt(t) < 100 )
		    {
		    	var txt_hight = $('#' + element_id).css('height');

		    	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	
		    }
		    else
		    {

		    	t = parseInt(t)-parseInt($("#myToolbar").css('height'));
		    	console.log(t);
		    }
		    

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		   
		    $("#myToolbar").show();
		}
		});

		//Font Style Select
		$(function(){
        $('#font').fontselect();

        $('.font-select').click(function(){
        	var ft = $('#font-text').text();
        	$('#span_'+element_id).css('font-family', ft);
        });
        $('#size-font').change(function(){
        	var fs = $('#size-font').val();
        	
        	var size = parseInt(fs) * 10;
        	fs += 'px';
        	size += 'px';
        	$('#span_'+element_id).css('font-size', fs);
        	$('#'+element_id).css('height', 'auto');
        	var h = $('#'+element_id).css('height');
        	var t = $('#'+element_id).css('top');
        	var tool_height = parseInt(t) + parseInt(h) + 10;
        	tool_height += 'px';
        	$('#myToolbar').css('top', tool_height);

        });
        //end
        //color picker
       
		$(document).on('click', '.colorpicker', function(event){
			event.stopPropagation();
		});

        $('#colorSelector').ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {

				$('#colorSelector div').css('backgroundColor', '#' + hex);
				$('#span_'+element_id).css('color', '#' + hex)
			}
		});

		$('#toolbardelete').click(function(){
            	
            var name = $('#'+element_id).data('name');
			var dlt;
			$.each(field_names, function(key,  value){
				if(value == name)
				{
					delete_feilds[delete_feilds.length] = name;
					dlt=key;
					for (var i = dlt; i< field_names.length; i++) {
					field_names[i] = field_names[i+1];

					}
					field_names.pop();

				}
			});

            field_names.pop($('#sidebar_'+element_id).val());
            $('#'+element_id).remove();
            $('#sidebar_'+element_id).closest("tr").remove();
            $("#myToolbar").hide();         
        });

        $(document).on('click','#btnborder', function(){
		
			if($(this).text().trim() == "Show Borders")
			{
				 $('.feild-elements').css('border', '2px dashed black');
				 $('.template_image_div').css('border', '2px dashed black');
				 $(this).text("Hide Borders");
			}else{
				$('.feild-elements').css('border', 'none');	
				$('.template_image_div').css('border', 'none');	
				 $(this).text("Show Borders");

			}
		});

		$("#add-text").click(function(){
            
            $("#newFeild").slideToggle("slow");
            
        });

        $('#newFeildBtn').click(function(){

            if (!$('#newFeildName').val()) {
               

                if ($("#newFeildName").parent().next(".validation").length == 0) // only add if not added
                {
                    //$("#newFeildBtn").parent().after("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Please enter field value</div>");
                    

                    $("#error").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Please enter field value</div>");
                }
                else
                {
                    $("#error").html('');
                }
            } 
            else 
            {
            	new_txt = $('#newFeildName').val();
            	new_txt = new_txt.toLowerCase();
            	new_txt = new_txt.trim();
            	var error =false;
            	$.each(field_names, function(key,  value){
            		value = value.toLowerCase();
            		value = value.trim();
            		if(new_txt == value)
	            	{
	            		error = true;
	            	}
	            	
	            });
	            if(error == true)
	            {
	            	error=false;
	            	$("#error").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Feild Name shoud be unique.. </div>");
	            }
	            else
	            {
	            	
	                $("#error").html(''); // remove it
	                var feild = $('#newFeildName').val();
	                 str = feild;

	                 field_names.push(str);

	                 feild = feild.toLowerCase();
	                 feild = feild.replace(/\ /g, '_');
	                 element_id = feild;

	                $('#table_body').append("<tr><td><input type='text' id='sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
	                $('#card_body').append("<div id='"+feild+"' data-name='"+str+"' class='idcard-transperent ui-widget-content textbox-size feild-elements' style='border:none;position:absolute;top:15px;left:30px;height:25px;'> <span id='span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
	                $('#'+feild).draggable();
	                $('#'+feild).resizable();

	                $('#newFeildName').length = 0;
	            }
        }
    });


	 $(document).ready(function(){
        
        

    
    var element = $("#div1"); // global variable
    var getCanvas; // global variable

    $("#Preview").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewImage").html(' ');
            html2canvas(element, {
                    onrendered: function (canvas) {
                    
                    $("#previewImage").html(canvas);
                }
        });
    });

    $("#Previewuser").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewuserImage").html(' ');
            html2canvas(element, {
                    onrendered: function (canvas) {
                    
                    $("#previewuserImage").html(canvas);
                }
        });
    });

});


	$(document).on('click','.template_image',function(){
   			image_id = $(this).attr("id");     	
     });


});
 $(document).ready(function(){

        $("#flip").click(function(){
            $("#panel").slideToggle("slow");
        });


        $("#btn-template-formate").on('click', function () {

                $.ajax({
                type: "POST",
                url: "{{ url('download-template-formate') }}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}","field_names": field_names},
                success : function(file_download){

                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });

        });

         $(function() {
        $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
          smallImage: 'allow',
          height: 250,
          width: 200,
          maxZoom: 2,
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });

        $('.export').click(function() {
          var imageData = $('.image-editor').cropit('export');
          $('#'+image_id).attr('src', imageData);
          $('#myModal').modal('hide');
         
         });

    });

         $(document).ready(function(){
        
        

    
    var element = $("#div1"); // global variable
    var getCanvas; // global variable

    $("#Preview").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewImage").html(' ');
            html2canvas(element, {
                    onrendered: function (canvas) {
                    
                    $("#previewImage").html(canvas);
                }
        });
    });

    $("#Previewuser").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewuserImage").html(' ');
            html2canvas(element, {
                    onrendered: function (canvas) {
                    
                    $("#previewuserImage").html(canvas);
                }
        });
    });

});
    $("#btnSave").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");

                $.ajax({
                type: "POST",
                url: site_url+'/save_single_card',
                dataType: 'json',
                data: {"_token": token ,"image": imgageData},
                success : function(image){
                	alert('Your card is Successfuly Saved..!!');
                	$('#preview_image').modal('hide');
                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });


                 }
             });
        });

    });
