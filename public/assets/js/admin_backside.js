		var element_id;
		var image_id;
		var back_delete_feilds = [];
		var back_delete_images = [];
		var back_delete_labels = [];	
		var back_image_name = [];
		var element = $("#div2"); // global variable
		var back_feild_color;
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

		$(document).on('click','.feild-elements', function(){
			element_id = $(this).attr('id');
			if(side == "back_")
			{
				element_id = element_id.substring(5,element_id.length);
			}
			
		});

		
  
		$("#back_under_line").click(function(){
			var check = $("#back_span_" + element_id).css("text-decoration");
			//alert(check);
			 if(check == "none")
			 {
				$("#back_span_" + element_id).css("text-decoration", "underline"); 	
				$("#back_under_line").addClass("button-selected");
			 }
			 else
			 {
			 	$("#back_span_" + element_id).css("text-decoration", "none");
			 	$("#back_under_line").removeClass("button-selected");
			 }
			
		});
		$("#back_italic").click(function(){
			var check = $("#back_span_" + element_id).css("font-style");
			
			 if(check == "normal")
			 {
				$("#back_span_" + element_id).css("font-style", "italic");
				$("#back_italic").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#back_span_" + element_id).css("font-style", "normal");
			 	$("#back_italic").removeClass("button-selected");
			 }
			
		});
		$("#back_bold").click(function(){
			var check = $("#back_span_" + element_id).css("font-weight");
			
			 if(check == 400)
			 {
				$("#back_span_" + element_id).css("font-weight", 900);
				$("#back_bold").addClass("button-selected"); 	
			 }
			 else
			 {
			 	$("#back_span_" + element_id).css("font-weight", 400);
			 	$("#back_bold").removeClass("button-selected");
			 }
			
		});
		$(document).on("keyup", ".sidebar-elements" , function(){
			
			var id = $(this).attr('id');
			var txt = $(this).val();
			var index;
			if(side == "back_")
			{
				index = 13;
			}
			else
			{
				index = 8;
			}
			var str = id.substring(index,id.length);

			var span_element = '#'+side+'span_' + str;

			$(span_element).text(txt);

			$('#myTextBox').val(txt);
			
			if(txt == "")
			{
				$(span_element).text();
			}	
			$('#' + side + str).resizable();
		});

		$('#myTextBox').keyup(function(){
			
			var txt = $('#myTextBox').val();
			
			$('#'+side+'span_'+element_id).text(txt);
			$('#'+side+'sidebar_'+element_id).val(txt);
			$('#'+side+element_id).resizable();
		});

		$(window).click(function() {
			
			$('#myToolbar').hide();
			$('#back_imageToolbar').hide();
			//$('#' + element_id).css('border', 'none');
		});

		
		
		$(document).ready(function(){
			
			$('.back-textbox-size').draggable();
			$('.back-textbox-size').resizable();
			
			$('.back_template_image_div').resizable();
			$('.back_template_image_div').draggable();
		});
		
		
		$(document).on('click',".feild-elements", function(event) {
		     event.stopPropagation();
		    var l = $('#'+side + element_id).css('left');
		    if(template_both_side==1)
		    {
		    	l = l.substring(0,l.length - 2);
		    	l = parseInt(l) + 530;
		    	l += "px";	
		    }
		    
		    var t = $('#'+side + element_id).css('top');
		    var txt = $('#'+side +element_id).text();
		    $('#myTextBox').val($.trim(txt));
		    
		    t = t.substring(0,t.length - 2);

		    if( parseInt(t) < 100 )
		    {
		    	if(template_both_side==1)
		    	{
		    		var txt_hight = $('#'+side + element_id).css('height');
		    		t = parseInt(t) + parseInt(txt_hight) + 70;
		    	}
		    	else
		    	{
			    	var txt_hight = $('#'+side + element_id).css('height');
			    	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	}
		    }
		    else
		    {
		    	if(template_both_side==1)
		    	{
		    		t = parseInt(t)-40;
		    	}
		    	else
		    	{
		    		t = parseInt(t)-110;	
		    	}
		    	
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

		//Font Style Select
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

		
     

		//Admin Panel Js

		$("#back_add-text").click(function(){
			
			$("#back_newFeild").slideToggle("slow");
			
		});

		$('#back_newFeildBtn').click(function(){

            if (!$('#back_newFeildName').val()) {
                if ($("#back_newFeildName").parent().next(".validation").length == 0) // only add if not added
                {
                    
                    $("#back_error").html("<div class='validation' style='color:red;bottom:0;margin-left:20px;'>Please Enter Feild value</div>");
                }
                else
                {
                    $("#back_error").html('');
                }
            } 
            else 
            {
              new_txt = $('#back_newFeildName').val();
            	new_txt = new_txt.toLowerCase();
            	new_txt = new_txt.trim();
            	var error =false;
            	var error_label = false;
	            	$.each(back_feild_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error = true;
		            	}
		            	
		            });

		             $.each(back_label_names, function(key,  value){
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
	            	$("#back_error").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Feild Name shoud be unique.. </div>");
	            }
	            else
	            {
	            	if(error_label == true)
		            	{
		            		error_label=false;
		            		$("#back_error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            	}
		            	else
		            	{
		                $("#back_error").html(''); // remove it
		                var feild = $('#back_newFeildName').val();
		                 str = feild;

		                 back_feild_names.push(str);

		                 feild = feild.toLowerCase();
		                 feild = feild.replace(/\ /g, '_');
		                 element_id = feild;

		                $('#back_feild_body').append("<input type='text' id='back_sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
		                $('#back_card_body').append("<div id='back_"+feild+"' data-name='"+str+"' class='idcard-transperent ui-widget-content back-textbox-size feild-elements' style='border:none;position:absolute;top:15px;left:30px;height:25px;'> <span id='back_span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
		                $('#back_'+feild).draggable();
		                $('#back_'+feild).resizable();
		                $('#back_newFeildName').val("");

	            }
        }
    }
});


		//work on Lable

			$('#back_newLabelBtn').click(function(){

	            if (!$('#back_newLabelName').val()) {
	                if ($("#back_newLabelName").parent().next(".validation").length == 0) // only add if not added
	                {
	                    
	                    $("#back_error_label").html("<div class='validation' style='color:red;bottom:0;margin-left:20px;'>Please Enter Lable value</div>");
	                }
	                else
	                {
	                    $("#back_error_label").html('');
	                }
	            } 
	            else 
	            {
	              new_txt = $('#back_newLabelName').val();
	            	new_txt = new_txt.toLowerCase();
	            	new_txt = new_txt.trim();
	            	var error =false;
	            	var error_label = false;
	            	$.each(back_feild_names, function(key,  value){
	            		value = value.toLowerCase();
	            		value = value.trim();
	            		if(new_txt == value)
		            	{
		            		error = true;
		            	}
		            	
		            });

		             $.each(back_label_names, function(key,  value){
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
		            	$("#back_error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            }
		            else
		            {
		            	
		            	if(error_label == true)
		            	{
		            		error_label=false;
		            		$("#back_error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            	}
		            	else
		            	{
			                $("#back_error_label").html(''); // remove it
			                var feild = $('#back_newLabelName').val();
			                 str = feild;
			          
			                 back_label_names.push(str);

			                 feild = feild.toLowerCase();
			                 feild = feild.replace(/\ /g, '_');
			                 element_id = feild;

			                $('#back_label_body').append("<input type='text' id='back_sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
			                $('#back_card_body').append("<div id='back_"+feild+"' data-type='label' data-name='"+str+"' class='idcard-transperent ui-widget-content back-textbox-size feild-elements' style='border:none;position:absolute;top:15px;left:30px;height:25px;'> <span id='back_span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
			                $('#back_'+feild).draggable();
			                $('#back_'+feild).resizable();
			                $('#back_newLabelName').val("");

			                $('#back_newLabelName').length = 0;
		            	}
		        	}
	       		}
	    });

		//work on lable end
		$('#back_btnsave').click(function(){
			var i=0;
			feilds=[];	
			$('#overlay').show();
			
			$.each(back_feild_names, function(key,  value){

				var id1  = value.toLowerCase();
			 	var id = id1.replace(/\ /g, '_');
				var css = $('#back_'+id).attr('style');
				var font_css = $('#back_span_'+id).attr('style');
				var content = $('#back_span_'+id).text();
				var values = { name: value, css: css, font_css: font_css, content: content};
				feilds[i] = values;
				//console.log(feilds);
				i++; 
			});

			labels = [];
			i=0;
			$.each(back_label_names, function(key,  value){

				var id1  = value.toLowerCase();
			 	var id = id1.replace(/\ /g, '_');
				var css = $('#back_'+id).attr('style');
				var font_css = $('#back_span_'+id).attr('style');
				var content = $('#back_span_'+id).text();
				var values = { name: value, css: css, font_css: font_css, content: content};
				labels[i] = values;
				//console.log(feilds);
				i++; 
			});

			var images_temp=[];
			i=0;
			$.each(back_upload_images, function(key, value){

				var css = $('#image_'+value).attr('style');
				var div_css = $('#div_image_'+value).attr('style');
				var name = $('#div_image_'+value).attr('name');
				var values = { css: css, id: value , div_css: div_css, name: name};
				images_temp[i] = values;
				//console.log(feilds);
				i++; 
			});

			html2canvas(element, {
	         onrendered: function (canvas) {
	                //$("#previewImage").append(canvas);
	                getCanvas = canvas;
	              
	                var imgageData = getCanvas.toDataURL("image/png");

	                $.ajax({
	                url: site_url+"/template_save",
	                type: "post",
					async: true,
	                data: { "_token": token ,"image": imgageData, "template_id": template_id},
	                dataType: 'json',
					success: function(image) {
						
						$.ajax({
					        url: site_url+"/admin/templates/save_back_cards",
					        type: "post",
					        async: true,
					        data: { "_token": token ,"feilds": feilds, "deleted_feilds": back_delete_feilds, "labels": labels,"deleted_labels": back_delete_labels, "template_id": template_id, "snap": image ,"images": images_temp, "deleted_images": back_delete_images},
					        dataType: 'json',
					        success: function(msg) {
					        	$('#overlay').hide();
					        	alert(msg);
					        },
					        error: function(jqXHR, textStatus, errorThrown) {
					        	$('#overlay').hide();
					        	alert("Error");
					           console.log(textStatus, errorThrown);
					        }
							
							});
					          
			        },
			        error: function(jqXHR, textStatus, errorThrown) {
			        			$('#overlay').hide();
					        	alert("Error");
					           console.log("hello12");
					}

	                });
	             }
	         });
			
      });

		$(document).on('click','#back_btnborder', function(){
			//console.log($(this).text());
			if($(this).text().trim() == "Show Borders")
			{
				 $('.feild-elements').css('border', '2px dashed black');
				 $('.back_template_image_div').css('border', '2px dashed black');
				 $(this).text("Hide Borders");
			}else{
				$('.feild-elements').css('border', 'none');	
				$('.back_template_image_div').css('border', 'none');	
				 $(this).text("Show Borders");

			}
		});


      
	});
		$(function() {
			$('.image-editor').cropit({
              exportZoom: 1.25,
              imageBackground: true,
              imageBackgroundBorderWidth: 20,
              smallImage: 'allow',
              maxZoom: 2,
              height:250,
              width:200
              
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
        		$('#image_error').append("<div class='alert-danger form-control'>Name feild is required..!</div>");
        	}
        	else
        	{
        		var name = $('#image_name').val();
        		$('#image_error').remove();
	          var imageData = $('.image-editor').cropit('export');

	          var is_back;
	          if(side == "back_")
	          	{
	           		is_back = 1;
	        	}
	            else
	            {
	            	is_back = 0;
	            }
	          $.ajax({
	            url: site_url+"\\upload_template_image",
	            type: "post",
	            async: true,
	            data: { "_token": token,"image": imageData,"css": "height:100%;width:100%;", "div_css": "position:absolute;height:102px;width:102px;left:30px;top:15px;background-color:trasprent;border:none","template_id": template_id,"name": $('#image_name').val(),"is_back": is_back},
	            dataType: 'json',
	            success: function(data) {
	            	$('#myModal').modal('hide');
	            	$('#'+side+'image_name').val();
	            	$('#'+side+'card_body').append("<div id='div_image_"+data.id+"' name='"+name+"' class='ui-widget-content template_image_div' style='position:absolute;height:101px;width:101px;left:30px;top:15px;background-color:trasprent;border:none'><img src='"+site_url+"\\templates\\images\\"+data.name+"' data-id='"+data.id+"' style='height:100%;width:100%;' class='"+side+"template_image' id='image_"+data.id+"'></div>");
	               	$('#div_image_'+data.id).resizable();
	               	$('#div_image_'+data.id).draggable();
	               	if(side == "back_")
	               	{
	               		back_upload_images[back_upload_images.length] = data.id;
	               	}
	               	else
	               	{
	               		upload_images[upload_images.length] = data.id;
	               	}
	               	
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	               console.log(textStatus, errorThrown);
	            }
        	});
	         }

               
        });
        


        $(document).on('click','.back_template_image',function(event){
        	event.stopPropagation();
        	image_id = $(this).attr('id');

        	var l = $('#div_' + image_id).css('left');
		    var t = $('#div_' + image_id).css('top');

		    t = t.substring(0,t.length - 2);
		    l = l.substring(0,l.length - 2);
		    l = parseInt(l) + 15;
		    if( parseInt(t) < 100 )
		    {
		    	var txt_hight = $('#div_' + image_id).css('height');
		    	t = parseInt(t) + parseInt(txt_hight) + 5;
		    	
		    }
		    else
		    {
		    	t = parseInt(t)-60;
		    }

		    var image_border = $('#'+image_id).css('border');
		    var image_shape = $('#'+image_id).css('border-radius');
		    if(image_shape == "100px")
		    {
		    	$('.round_shape').css('background-color',"blue");
				$('.squere_shape').css('background-color',"white");	
		    }
		    else
		    {
		    	$('.round_shape').css('background-color',"white");
				$('.squere_shape').css('background-color',"blue");
		    }
		    if(image_border == "0px none rgb(51, 51, 51)")
		    {
		    	$('#back_image_border').text("Show Border");
		    }
		    else
		    {
		    	$('#back_image_border').text("Hide Border");
		    }

			t += "px";
			l += "px";
		    $('#back_imageToolbar').css('left',l);
		    $('#back_imageToolbar').css('top',t);
        	$('#back_imageToolbar').show();
        });

        $(document).on('click','.squere_shape', function(event){
        	event.stopPropagation();
        	$('.round_shape').css('background-color',"white");
			$('.squere_shape').css('background-color',"blue");
			$('#'+image_id).css('border-radius','0px');
			$('#'+image_id).css('border-radius','0px');
			

		});
        

        $(document).on('click','.round_shape', function(event){
        	event.stopPropagation();

        	$('.round_shape').css('background-color',"blue");
			$('.squere_shape').css('background-color',"white");
			$('#'+image_id).css('border-radius','100px');
			$('#'+image_id).css('border-radius','100px');
			

		});

		$(document).on('click','#back_image_border', function(event){
			event.stopPropagation();
			if($(this).text().trim() == "Show Border")
			{
				 $('#'+image_id).css('display', 'block');
				 $('#'+image_id).css('border', '1px solid black');

				 $(this).text("Hide Border");
			}else{
				$('#'+image_id).css('border', 'none');	
				 $(this).text("Show Border");

			}
		});



		$(document).on('click','#back_imagetoolbardelete', function(){
			var id = $('#'+image_id).data('id');
			$('#'+image_id).remove();
			$('#div_'+image_id).remove();
			var dlt;
			$.each(back_upload_images, function(key,  value){
				if(value == id)
				{
					back_delete_images[back_delete_images.length] = id;
					dlt=key;
					
					for (var i = dlt; i< back_upload_images.length; i++) {
					back_upload_images[i] = back_upload_images[i+1];

					}
					back_upload_images.pop();

				}
			});
			
			$("#back_imageToolbar").hide();				
		});

		$('#image-size').change(function(){
          if($('#image-size').val()== "passport")
          {
          		$('#size').hide();
          } 
          else
          {

            $('#size').show();
          }   
        });

        $('#saveSize').click(function(){
           if($('#image-size').val()== "passport")
           {
           		$('myModal').modal('show');
           }
           else
           {   		
           }
           $('#getSize').modal('hide');
        });
		
		$("#uploadimage").validate({
        //errorLabelContainer: "#message_box", wrapper: "li",
		        rules: {
		            image: {
		                required: true
		            },
		            imagenameform: {
		                required: true
		            }
		        },
		        submitHandler: function(form, event) {
		          var formElement = document.querySelector("form");
		          event.preventDefault();
		          imagedata = new FormData(formElement);
		          $('#image_name_alert').hide();
		          $('#image_alert').hide();
		          imagedata.append('css', 'height:100%;width:100%;');
		          imagedata.append('div_css', 'position:absolute;height:102px;width:102px;left:30px;top:15px;background-color:trasprent;border:none');
		          imagedata.append("template_id", template_id);
		          imagedata.append("is_back", is_back);
		          imagedata.append('name', $('#image_name').val());

		          $.ajax({
		          url: site_url+"/upload_image", // Url to which the request is send
		          type: "POST",             // Type of request to be send, called as method
		          data: imagedata, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		          contentType: false,       // The content type used when sending data to the server.
		          cache: false,             // To unable request pages to be cached
		          processData:false,        // To send DOMDocument or non processed data file it is set to false
		          success: function(data)   // A function to be called if request succeeds
		          {
		            data = JSON.parse(data);
		            $('#getSize').modal('hide');
		            $('#'+side+'image_name').val();
		            $('#'+side+'card_body').append("<div id='div_image_"+data.id+"' name='"+name+"' class='ui-widget-content template_image_div' style='position:absolute;height:101px;width:101px;left:30px;top:15px;background-color:trasprent;border:none'><img src='"+site_url+"\\templates\\images\\"+data.name+"' data-id='"+data.id+"' style='height:100%;width:100%;' class='"+side+"template_image' id='image_"+data.id+"'></div>");
		              $('#div_image_'+data.id).resizable();
		              $('#div_image_'+data.id).draggable();
		              if(side == "back_")
		              {
		                back_upload_images[back_upload_images.length] = data.id;
		              }
		              else
		              {
		                upload_images[upload_images.length] = data.id;
		              }
		            }
		        });
		       
		        }
		        
		    });
      });





