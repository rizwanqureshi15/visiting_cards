		var element_id;
		var image_id;
		var delete_feilds = [];
		var delete_images = [];
		var delete_labels = [];	
		var image_name = [];
		var element2 = $("#div1"); // global variable
		var feild_color;
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

		
  
		$("#under_line").click(function(){
			var check = $("#span_" + element_id).css("text-decoration");
			//alert(check);
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

		$(window).click(function() {
			
			$('#myToolbar').hide();
			$('#imageToolbar').hide();
			//$('#' + element_id).css('border', 'none');
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
		
		
		// $(document).on('click',".feild-elements", function(event) {
		// 	console.log();
		//      event.stopPropagation();
		//     var l = $('#' + element_id).css('left');
		//     var t = $('#' + element_id).css('top');
		//     var txt = $('#' +element_id).text();
		//     $('#myTextBox').val($.trim(txt));

		//     t = t.substring(0,t.length - 2);

		//     if( parseInt(t) < 100 )
		//     {
		//     	var txt_hight = $('#' + element_id).css('height');
		//     	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	
		//     }
		//     else
		//     {
		//     	t = parseInt(t)-110;
		//     }
		  
		// 	var selectedfont = $('#span_' + element_id).css('font-family');		 
		// 	$('#font-text').css('font-family', selectedfont);
		// 	$('#font-text').text(selectedfont);
		// 	 var selectedfontsize = $('#span_' + element_id).css('font-size');	
		// 	 var s = selectedfontsize.substring(0,selectedfontsize.length-2);
		// 	 var hex = $('#span_' + element_id).css('color');	
		// 	 $('#colorSelector div').css('backgroundColor', '#' + hex);
		// 	 feild_color = rgb2hex(hex);
			
		// 	$('#size-font').val(s).prop('selected', true);

		//     t += "px";

		//     $('#myToolbar').css('left',l);
		//     $('#myToolbar').css('top',t);
		    
		//     $("#myToolbar").show();
		// });

		// //Font Style Select
		// $(function(){
  //       $('#font').fontselect();

  //       $('.font-select').click(function(){
  //       	var ft = $('#font-text').text();
  //       	$('#span_'+element_id).css('font-family', ft);
  //       });
  //       $('#size-font').change(function(){
  //       	var fs = $('#size-font').val();
        	
  //       	var size = parseInt(fs) * 10;
  //       	fs += 'px';
  //       	size += 'px';
  //       	$('#span_'+element_id).css('font-size', fs);
  //       	$('#'+element_id).css('height', 'auto');
  //       	var h = $('#'+element_id).css('height');
  //       	var t = $('#'+element_id).css('top');
  //       	var tool_height = parseInt(t) + parseInt(h) + 10;
  //       	tool_height += 'px';
  //       	$('#myToolbar').css('top', tool_height);

  //       });
       

  //       //end
  //       //color picker
       
		// $(document).on('click', '.colorpicker', function(event){
		// 	event.stopPropagation();
		// });

  //       $('#colorSelector').ColorPicker({

		// 	color : '#0000ff',
		// 	onShow: function (colpkr) {
		// 		$(colpkr).fadeIn(500);
		// 		return false;
		// 	},
		// 	onHide: function (colpkr) {
		// 		$(colpkr).fadeOut(500);
		// 		return false;
		// 	},
		// 	onChange: function (hsb, hex, rgb) {

		// 		$('#colorSelector div').css('backgroundColor', '#' + hex);
		// 		$('#span_'+element_id).css('color', '#' + hex)
		// 	}

		// });

		// $('#toolbardelete').click(function(){
		// 	var name = $('#'+element_id).data('name');
		// 	var type = $('#'+element_id).data('type');
		// 	var dlt;
			
		// 	if(type == 'label')
		// 	{
		// 		$.each(label_names, function(key,  value){
		// 			if(value == name)
		// 			{
		// 				delete_labels[delete_labels.length] = name;
		// 				dlt=key;
		// 				for (var i = dlt; i< label_names.length; i++) {
		// 				label_names[i] = label_names[i+1];

		// 				}
		// 				label_names.pop();

		// 			}
		// 		});
		// 	}
		// 	else
		// 	{
		// 		$.each(feild_names, function(key,  value){
		// 			if(value == name)
		// 			{
		// 				delete_feilds[delete_feilds.length] = name;
		// 				dlt=key;
		// 				for (var i = dlt; i< feild_names.length; i++) {
		// 				feild_names[i] = feild_names[i+1];

		// 				}
		// 				feild_names.pop();

		// 			}
		// 		});
				
		// 	}
			
		// 	$('#'+element_id).remove();
		// 	$('#sidebar_'+element_id).remove();
		// 	$("#myToolbar").hide();			
		// });

		
     

		//Admin Panel Js

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
	            	$.each(feild_names, function(key,  value){
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
		            		$("#error_label").html("<div class='validation' style='color:red;margin-bottom:05px;margin-left:20px;'>Label Name shoud be unique.. </div>");
		            	}
		            	else
		            	{
		                $("#error").html(''); // remove it
		                var feild = $('#newFeildName').val();
		                 str = feild;

		                 feild_names.push(str);

		                 feild = feild.toLowerCase();
		                 feild = feild.replace(/\ /g, '_');
		                 element_id = feild;

		                $('#feild_body').append("<input type='text' id='sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"' name="+ str +"></td></tr>");
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
	            	$.each(feild_names, function(key,  value){
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
			                 console.log(feild);
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
		$('#btnsave').click(function(){
			var i=0;
			feilds=[];	
			$('#overlay').show();
			$('#guideline_border').hide();
			$('.feild-elements').css('border', 'none');	
			$('.template_image_div').css('border', 'none');	
			
			$.each(feild_names, function(key,  value){

				var id1  = value.toLowerCase();
			 	var id = id1.replace(/\ /g, '_');
				var css = $('#'+id).attr('style');
				var font_css = $('#span_'+id).attr('style');
				var content = $('#span_'+id).text();
				var values = { name: value, css: css, font_css: font_css, content: content};
				feilds[i] = values;
				//console.log(feilds);
				i++; 
			});

			labels = [];
			i=0;
			$.each(label_names, function(key,  value){

				var id1  = value.toLowerCase();
			 	var id = id1.replace(/\ /g, '_');
				var css = $('#'+id).attr('style');
				var font_css = $('#span_'+id).attr('style');
				var content = $('#span_'+id).text();
				var values = { name: value, css: css, font_css: font_css, content: content};
				labels[i] = values;
				//console.log(feilds);
				i++; 
			});

			var images_temp=[];
			i=0;
			$.each(upload_images, function(key, value){

				var css = $('#image_'+value).attr('style');
				var div_css = $('#div_image_'+value).attr('style');
				var name = $('#div_image_'+value).attr('name');
				var values = { css: css, id: value , div_css: div_css, name: name};
				images_temp[i] = values;
				//console.log(feilds);
				i++; 
			});

			var circle_object = [];
			i=0;
			$.each(circles, function(key, value){
				var name = value; 
				var css = $('#'+ value).attr('style');
				var line_css = $('#wrapper_' + value).attr('style');
				var type = 'circle';
				var values = { name: name, css: css, line_css: line_css,type: type};
				circle_object[i] = values;
				i++;
			});
			
			console.log(circle_object);
			var square_object = [];
			i=0;
			$.each(squares, function(key, value){
				var name = value;
				var css = $('#'+ value).attr('style');
				var type = 'square';
				var values = { name: name, css: css, type: type};
				square_object[i] = values;
				i++;
			});

			
			var line_object = [];
			i=0;
			$.each(lines, function(key, value){
				var name = value;
				var css = $('#'+ value).attr('style'); 
				var line_css = $('#wrapper_' + value).attr('style');
				var type = 'line';
				var values = { name: name, css: css, line_css: line_css,type: type};
				line_object[i] = values;
				i++;
			});

			html2canvas(element2, {
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
					        url: site_url+"/admin/templates/save_cards",
					        type: "post",
					        async: true,
					        data: { "_token": token ,"feilds": feilds, "deleted_circle_object": deleted_circles,"deleted_square_object": deleted_squares,"deleted_line_object":deleted_lines, "circle_object": circle_object,"square_object": square_object,"line_object":line_object, "deleted_feilds": delete_feilds, "labels": labels,"deleted_labels": delete_labels, "template_id": template_id, "snap": image ,"images": images_temp, "deleted_images": delete_images},
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

		$(document).on('click','#btnborder', function(){
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


		// $(function() {
  //       $('.image-editor').cropit({
  //         exportZoom: 1.25,
  //         imageBackground: true,
  //         imageBackgroundBorderWidth: 20,
  //         smallImage: 'allow',
  //         height: 250,
  //         width: 200,
  //         maxZoom: 2,
  //       });

  //       $('.rotate-cw').click(function() {
  //         $('.image-editor').cropit('rotateCW');
  //       });
  //       $('.rotate-ccw').click(function() {
  //         $('.image-editor').cropit('rotateCCW');
  //       });

  //       $('.export').click(function() {
  //       	if($('#image_name').val()=='')
  //       	{
  //       		$('#image_error').append("<div class='alert-danger form-control'>Name feild is required..!</div>");
  //       	}
  //       	else
  //       	{
  //       		var name = $('#image_name').val();
  //       		$('#image_error').remove();
	 //          var imageData = $('.image-editor').cropit('export');
	 //          $.ajax({
	 //            url: site_url+"\\upload_template_image",
	 //            type: "post",
	 //            async: true,
	 //            data: { "_token": token,"image": imageData,"css": "height:100%;width:100%;", "div_css": "position:absolute;height:102px;width:102px;left:30px;top:15px;background-color:trasprent;border:none","template_id": template_id,"name": $('#image_name').val()},
	 //            dataType: 'json',
	 //            success: function(data) {
	 //            	$('#myModal').modal('hide');
	 //            	$('#image_name').val();
	 //            	$('#card_body').append("<div id='div_image_"+data.id+"' name='"+name+"' class='ui-widget-content template_image_div' style='position:absolute;height:101px;width:101px;left:30px;top:15px;background-color:trasprent;border:none'><img src='"+site_url+"\\templates\\images\\"+data.name+"' data-id='"+data.id+"' style='height:100%;width:100%;' class='template_image' id='image_"+data.id+"'></div>");
	 //               	$('#div_image_'+data.id).resizable();
	 //               	$('#div_image_'+data.id).draggable();
	 //               	upload_images[upload_images.length] = data.id; 
	 //               	console.log(data.id);
	               	
	 //            },
	 //            error: function(jqXHR, textStatus, errorThrown) {
	 //               console.log(textStatus, errorThrown);
	 //            }
  //       	});
	 //         }

               
  //       });
        
        $(document).on('click','.template_image',function(event){
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
		    	$('#image_border').text("Show Border");
		    }
		    else
		    {
		    	$('#image_border').text("Hide Border");
		    }

			t += "px";
			l += "px";
		    $('#imageToolbar').css('left',l);
		    $('#imageToolbar').css('top',t);
        	$('#imageToolbar').show();
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

		$(document).on('click','#image_border', function(event){
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


		//Lable bar Codding

		$('#slide_feilds').click(function(){
			$('#table_body_lables').slideToggle();
			$('#table_body_feilds').slideToggle();
		});			


		//Lable bar Codding end




