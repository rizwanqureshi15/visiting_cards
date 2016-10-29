		var element_id;
		var image_id;
		var delete_feilds=[];	
		var delete_images=[];	
		var delete_labels = [];	
		var image_name = [];
		var feild_color;
		var element2;
		var order_no;
		
		 var element = $("#div1");
		  // global variable
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
			if(side == "back_")
			{
				element_id = element_id.substring(5,element_id.length);
			}
			//console.log(element_id);
			
		});

		$("#under_line").click(function(){
			var check = $("#"+ side +"span_" + element_id).css("text-decoration");
			
			 if(check == "none")
			 {
				$("#"+ side +"span_" + element_id).css("text-decoration", "underline"); 	
				$("#under_line").addClass("button-selected");
			 }
			 else
			 {
			 	$("#"+ side +"span_" + element_id).css("text-decoration", "none");
			 	$("#under_line").removeClass("button-selected");
			 }
			
		});
		$("#italic").click(function(){
			var check = $("#"+ side +"span_" + element_id).css("font-style");
			
			 if(check == "normal")
			 {
				$("#"+ side +"span_" + element_id).css("font-style", "italic");
				$("#italic").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#"+ side +"span_" + element_id).css("font-style", "normal");
			 	$("#italic").removeClass("button-selected");
			 }
			
		});
		$("#bold").click(function(){
			var check = $("#"+ side +"span_" + element_id).css("font-weight");
			
			 if(check == 400)
			 {
				$("#"+ side +"span_" + element_id).css("font-weight", 900);
				$("#bold").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#"+ side +"span_" + element_id).css("font-weight", 400);
			 	$("#bold").removeClass("button-selected");
			 }
			
		});
		// $(document).on("keyup", ".sidebar-elements" , function(){
			
		// 	var id = $(this).attr('id');
		// 	var txt = $(this).val();
		// 	var str = id.substring(8,id.length);
		// 	var span_element = '#span_' + str;

		// 	$(span_element).text(txt);

		// 	$('#myTextBox').val(txt);
			
		// 	if(txt == "")
		// 	{
		// 		$(span_element).text();
		// 	}	
		// 	$('#' + str).resizable();
		// });

		$('#myTextBox').keyup(function(){
			
			var txt = $('#myTextBox').val();
			
			$('#span_'+element_id).text(txt);
			$('#sidebar_'+element_id).val(txt);
			$('#'+element_id).resizable();
		});

		$(document).on('click',".feild-elements", function(event) {
		     event.stopPropagation();
		    var l = $('#'+side+element_id).css('left');
		    if(template_both_side == 1)
		    {
			    l = l.substring(0,l.length - 2);
			    l = parseInt(l) + 470;
			    l += "px";
		    }
		    var t = $('#'+side + element_id).css('top');
		    var txt = $('#'+side +element_id).text();
		    $('#myTextBox').val($.trim(txt));
		   
		    t = t.substring(0,t.length - 2);
		    
		    if( parseInt(t) < 100 )
		    {
		   
		    	var txt_hight = $('#'+side+element_id).css('height');
		    	txt_hight = txt_hight.substring(0,txt_hight.length - 2);
		    	if(template_both_side == 1)
		    	{
		    		t = parseInt(t) + parseInt(txt_hight) + 150;
		    	}else
		    	{
		    		t = parseInt(t) + parseInt(txt_hight) + 10;
		    	}
		    }
		    else
		    {
		 		if(template_both_side == 1)
		    	{
		    		t = parseInt(t) + 30;
		    	}else
		    	{
		    		t = parseInt(t) - 110;
		    	}
		    }
		  	
		  	var check = $("#"+ side +"span_" + element_id).css("text-decoration");
			 if(check == "none")
			 {		
			 	$("#under_line").removeClass("button-selected");
			 }
			 else
			 {
				$("#under_line").addClass("button-selected");	
			 }
			 var check = $("#"+ side +"span_" + element_id).css("font-style");
			 if(check == "normal")
			 {
			 	$("#italic").removeClass("button-selected");	
			 }
			 else
			 {
			 	$("#italic").addClass("button-selected");
			 }
			 var check = $("#"+ side +"span_" + element_id).css("font-weight");
			 if(check == 400)
			 {
			 	$("#bold").removeClass("button-selected");	
			 }
			 else
			 {
				$("#bold").addClass("button-selected"); 
			 	
			 }
			var selectedfont = $('#'+side+'span_' + element_id).css('font-family');		 
			$('#font-text').css('font-family', selectedfont);
			$('#font-text').text(selectedfont);
			 var selectedfontsize = $('#'+side+'span_' + element_id).css('font-size');
			 
			 var s = selectedfontsize.substring(0,selectedfontsize.length-2);
			 var hex = $('#'+side+'span_' + element_id).css('color');	
			 $('#colorSelector div').css('backgroundColor', '#' + hex);
			 feild_color = rgb2hex(hex);
			
			$('#size-font').val(s).prop('selected', true);

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		    
		    $("#myToolbar").show();
		});

		$(window).click(function() {
			
			$('#myToolbar').hide();
			$('#imageToolbar').hide();
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
	
		$(function(){
        $('#font').fontselect();

        $('.font-select').click(function(){
        	var ft = $('#font-text').text();
        	
        	$('#'+side+'span_'+element_id).css('font-family', ft);
        });
        $('#size-font').change(function(){
        	var fs = $('#size-font').val();
        	
        	var size = parseInt(fs) * 10;
        	fs += 'px';
        	size += 'px';
        	$('#'+side+'span_'+element_id).css('font-size', fs);
        	$('#'+side+element_id).css('height', 'auto');
        	var h = $('#'+side+element_id).css('height');
        	var t = $('#'+side+element_id).css('top');
        	t = t.substring(0,t.length-2);
        	h = h.substring(0,h.length-2); 
        	var tool_height = parseInt(t) + parseInt(h) + 70;
        	tool_height += 'px';
        	$('#myToolbar').css('top', tool_height);

        });
       

		$(document).on('click', '.colorpicker', function(event){
			event.stopPropagation();
		});

	$(document).on('click', '.colorpicker', function(event){
			event.stopPropagation();
		});

        $('#colorSelector').ColorPicker({

			color : '#0000ff',
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
				$('#'+side+'span_'+element_id).css('color', '#' + hex)
			}

		});
		$('#toolbardelete').click(function(){
			var name = $('#'+side+element_id).data('name');
			var type = $('#'+side+element_id).data('type');
			var dlt;
		if(side == "back_")
		{
			if(type == 'label')
			{
				$.each(back_label_names, function(key,  value){
					if(value == name)
					{
						back_delete_labels[back_delete_labels.length] = name;
						dlt=key;
						for (var i = dlt; i< back_label_names.length; i++) {
						back_label_names[i] = back_label_names[i+1];

						}
						back_label_names.pop();

					}
				});
			}
			else
			{
				$.each(back_feild_names, function(key,  value){
					if(value == name)
					{
						back_delete_feilds[back_delete_feilds.length] = name;
						dlt=key;
						for (var i = dlt; i< back_feild_names.length; i++) {
						back_feild_names[i] = back_feild_names[i+1];

						}
						back_feild_names.pop();

					}
				});
				
			}
		}
		else
		{
			if(type == 'label')
			{
				$.each(label_names, function(key,  value){
					if(value == name)
					{
						delete_labels[delete_labels.length] = name;
						dlt=key;
						for (var i = dlt; i< label_names.length; i++) {
						label_names[i] = label_names[i+1];

						}
						label_names.pop();

					}
				});
			}
			else
			{
				$.each(feild_names, function(key,  value){
					if(value == name)
					{
						delete_feilds[delete_feilds.length] = name;
						dlt=key;
						for (var i = dlt; i< feild_names.length; i++) {
						feild_names[i] = feild_names[i+1];

						}
						feild_names.pop();

					}
				});
				
			}
		}	
			$('#'+side+element_id).remove();
			$('#'+side+'sidebar_'+element_id).remove();
			$("#myToolbar").hide();			
		});


		$("#add-text").click(function(){
            
            $("#newFeild").slideToggle("slow");
            
        });

        $('#newFeildBtn').click(function(){

             if (!$('#newFeildName').val()) {
                if ($("#newFeildName").parent().next(".validation").length == 0) // only add if not added
                {
                    
                    $("#error").html("<div class='validation' style='color:red;bottom:0;margin-left:20px;'>Please Enter Feild value</div>");
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
            	var error_label = false;
	            	$.each(field_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error = true;
		            	}
		            	
		            });

		             $.each(label_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error_label = true;
		            	}
		            	
		            });
	           
	            if(error == true)
	            {
	            	error=false;
	            	$("#error").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Feild Name shoud be unique.. </div>");
	            }
	            else
	            {
	            	if(error_label == true)
		            	{
		            		error_label=false;
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

		                $('#feild_body').append("<tr><td><input type='text' id='sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
		                $('#card_body').append("<div id='"+feild+"' data-name='"+str+"' class='idcard-transperent ui-widget-content textbox-size feild-elements' style='border:none;position:absolute;top:15px;left:30px;height:25px;'> <span id='span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
		                $('#'+feild).draggable();
		                $('#'+feild).resizable();
		                $('#newFeildName').val("");
		       
		            }
	            }
        }
    });

    //work on Lable

			$('#newLabelBtn').click(function(){

	            if (!$('#newLabelName').val()) {
	                if ($("#newLabelName").parent().next(".validation").length == 0) // only add if not added
	                {
	                    
	                    $("#error_label").html("<div class='validation' style='color:red;bottom:0;margin-left:20px;'>Please Enter Lable value</div>");
	                }
	                else
	                {
	                    $("#error_label").html('');
	                }
	            } 
	            else 
	            {
	              new_txt = $('#newLabelName').val();
	            	new_txt = new_txt.toLowerCase();
	            	new_txt = new_txt.trim();
	            	var error =false;
	            	var error_label = false;
	            	$.each(field_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error = true;
		            	}
		            	
		            });

		             $.each(label_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error_label = true;
		            	}
		            	
		            });
		            if(error == true)
		            {
		            	error=false;
		            	$("#error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            }
		            else
		            {
		            	
		            	if(error_label == true)
		            	{
		            		error_label=false;
		            		$("#error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            	}
		            	else
		            	{
			                $("#error_label").html(''); // remove it
			                var feild = $('#newLabelName').val();
			                 str = feild;
			                 
			                 label_names.push(str);

			                 feild = feild.toLowerCase();
			                 feild = feild.replace(/\ /g, '_');
			                 element_id = feild;

			                $('#label_body').append("<input type='text' id='sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
			                $('#card_body').append("<div id='"+feild+"' data-type='label' data-name='"+str+"' class='idcard-transperent ui-widget-content textbox-size feild-elements' style='border:none;position:absolute;top:15px;left:30px;height:25px;'> <span id='span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
			                $('#'+feild).draggable();
			                $('#'+feild).resizable();
			                $('#newLabelName').val("");

			                $('#newLabelName').length = 0;
		            	}
		        	}
	       		}
	    });

		//work on lable end


	 $(document).ready(function(){
        
        

    
    var element = $("#div1");
    var element2 = $("#div2");
     // global variable
    var getCanvas; // global variable
     $("#Preview_single").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewImage").html(' ');
            html2canvas(element, {
                    onrendered: function (canvas) {
                    
                    $("#previewImage").html(canvas);
                }
        });
    });
    $("#Preview").on('click', function () {
        $('.feild-elements').css('border','none'); 
            $("#previewImage").html(' ');
        if($('#front_side').css("display") == "none")
        {
        	$('#front_side').show();
            html2canvas(element, {
                    onrendered: function (canvas) {
                    	$("#previewImageFront").html(canvas);
              
                }
        	});
        	$('#front_side').hide();
        }
        else
        {
        	 html2canvas(element, {
                    onrendered: function (canvas) {
                    	$("#previewImageFront").html(canvas);
              
                }
        	});
        }
	if($('#back_side').css("display") == "none")
        {
        	$('#back_side').show();
            html2canvas(element2, {
                    onrendered: function (canvas) {
                    	$("#previewImageBack").html(canvas);
              
                }
        	});
        	$('#back_side').hide();
        }
        else
        {
        	 html2canvas(element2, {
                    onrendered: function (canvas) {
                    	$("#previewImageBack").html(canvas);
              
                }
        	});
        }
    });

});

 	// $(document).on('click','.squere_shape', function(event){
 	// 		event.stopPropagation();
  //       	$('.round_shape').css('background-color',"white");
		// 	$('.squere_shape').css('background-color',"blue");
		// 	$('#'+image_id).css('border-radius','0px');
		// 	$('#'+image_id).css('border-radius','0px');
			

		// });
        

  //       $(document).on('click','.round_shape', function(event){
  //       	event.stopPropagation();
  //       	$('.round_shape').css('background-color',"blue");
		// 	$('.squere_shape').css('background-color',"white");
		// 	$('#'+image_id).css('border-radius','100px');
		// 	$('#'+image_id).css('border-radius','100px');
			

		// });
		 $(document).on('click','#btnborder', function(event){
		 	event.stopPropagation();
			//console.log($(this).text());
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
});
		// $(document).on('click','#image_border', function(event){
		// 	event.stopPropagation();
		// 	if($(this).text().trim() == "Show Border")
		// 	{
		// 		 $('#'+image_id).css('display', 'block');
		// 		 $('#'+image_id).css('border', '1px solid black');

		// 		 $(this).text("Hide Border");
		// 	}else{
		// 		$('#'+image_id).css('border', 'none');	
		// 		 $(this).text("Show Border");

		// 	}
		// });

		$(document).on('click','#imagetoolbardelete', function(){
			var id = $('#'+image_id).data('id');
			$('#'+image_id).remove();
			$('#div_'+image_id).remove();
			var dlt;
			
			$.each(upload_images, function(key,  value){
				if(value == id)
				{
					delete_images[delete_images.length] = id;
					dlt=key;
					
					for (var i = dlt; i< upload_images.length; i++) {
					upload_images[i] = upload_images[i+1];

					}
					upload_images.pop();

				}
			});
			
			$("#imageToolbar").hide();				
		});
 $(document).ready(function(){

        $("#flip").click(function(){
            $("#more_links").slideToggle("slow");
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



    });

        $(function() {
        $(document).on('click','.template_image',function(){
        	image_id = $(this).attr('id');
        });
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
        	if($('#image_name').val()=='')
        	{
        		$('#'+side+'image_error').append("<div class='alert-danger form-control'>Name feild is required..!</div>");
        	}
        	else
        	{
        		var name = $('#image_name').val();
        		$('#image_error').remove();
        			var imageData = $('.image-editor').cropit('export');
			        $('#'+side+image_id).attr('src', imageData);
			        $('#myModal').modal('hide');
	 

	         }

               
        });

$(document).ready(function(){
    $("#btnSave").on('click', function () {
    	$('#front_side').show();
         html2canvas(element, {
         onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");

                $.ajax({
                type: "POST",
                url: site_url+'/save_single_card',
                dataType: 'json',
                data: {"_token": token ,"image": imgageData ,"url": template_url ,"is_back": 0},
                success : function(data){
          				order_no = data;
          				if(template_both_side == 1)
				        {
					         $('#back_side').show();
					         html2canvas(element2, {
					         onrendered: function (canvas) {
					                getCanvas = canvas;
					                var imgageData = getCanvas.toDataURL("image/png");

					                $.ajax({
					                type: "POST",
					                url: site_url+'/save_single_card',
					                dataType: 'json',
					                data: {"_token": token ,"image": imgageData ,"url": template_url,"is_back": 1,"order_no": order_no},
					                success : function(image)
					                {
					                	window.location.href = site_url+'/order/'+order_no+'/payment'; 

					                    } 
					                    }).fail(function(data){
					                        var errors = data.responseJSON;
					                    });
					                 }
					             });
					         	$('#back_side').hide();
				     	}
				     	else
				     	{
				     		window.location.href = site_url+'/order/'+order_no+'/payment'; 
				     	}
				     		
                    } 
                    }).fail(function(data){
                        var errors = data.responseJSON;
                    });


                 }
             });

         if(template_both_side == 1)
         {
	         $('#back_side').show();
	         html2canvas(element2, {
	         onrendered: function (canvas) {
	                getCanvas = canvas;
	                var imgageData = getCanvas.toDataURL("image/png");

	                $.ajax({
	                type: "POST",
	                url: site_url+'/save_single_card',
	                dataType: 'json',
	                data: {"_token": token ,"image": imgageData ,"url": template_url,"is_back": 1,"order_no": order_no},
	                success : function(image){
	                	
	                	window.location.href = "{{ url('myorders'}}"; 

	                	$('#preview_image').modal('hide');
	                    } 
	                    }).fail(function(data){
	                        var errors = data.responseJSON;
	                    });


	                 }
	             });
	         	$('#back_side').hide();
     	}
        });

    });

$("#preview_front_back").click(function(){
          if($(this).text() == "Front")
          {
              $(this).text("Back");
              $("#previewImageFront").show();
              $("#previewImageBack").hide();
             
          }
          else
          { 
              $(this).text("Front");
              $("#previewImageBack").show();
              $("#previewImageFront").hide();
             
          }
       });
});