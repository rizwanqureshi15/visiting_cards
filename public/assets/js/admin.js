		var element_id
		var delete_feilds=[];	
		 var element = $("#div1"); // global variable
    var getCanvas; 	


		$('.feild-elements').click(function(){
			element_id = $(this).attr('id');
			//console.log(element_id);
			
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
		$(document).on("keyup", ".sidebar-elements" , function(){
			
			var id = $(this).attr('id');
			var txt = $(this).val();
			var str = id.substring(8,id.length);
			var span_element = '#span_' + str;

			$(span_element).text(txt);

			$('#myTextBox').val(txt);
			
			if(txt == "")
			{
				$(span_element).text();
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
			//$('#' + element_id).css('border', 'none');
		});

		$('#myToolbar').click(function(event){
			
			event.stopPropagation();
		});

		$(document).ready(function(){
			
			$('.textbox-size').draggable();
			$('.textbox-size').resizable();
			
		});
		
		$(document).on('click',".feild-elements", function(event) {
		     event.stopPropagation();
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
		    	t = parseInt(t)-110;
		    }
		    

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		    
		    $("#myToolbar").show();
		});
		

		$('.toolbar-elements').droppable({
			drop: function(event, ui) {
		    console.log("call");
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
		    	t = parseInt(t)-100;
		    }
		    

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		   // $('#' + element_id).css('border', '2px dashed black');
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
			
			$('#'+element_id).remove();
			$('#sidebar_'+element_id).closest("tr").remove();
			$("#myToolbar").hide();			
		});

		
     

		//Admin Panel Js

		$("#add-text").click(function(){
			
			$("#newFeild").slideToggle("slow");
			
		});

		// $('#newFeildBtn').click(function(){
		// 	var feild = $('#newFeildName').val();
		// 	console.log(feild_names.length);
		// 	 feild_names[feild_names.length] = feild;
		// 	str = feild;
		// 	 feild = feild.toLowerCase();
		// 	 feild = feild.replace(/\ /g, '_');
		// 	 element_id = feild;

			
		// 	$('#table_body').append("<tr><td><input type='text' id='sidebar_"+feild+"' class='form-control sidebar-elements' placeholder='Enter "+str+"'></td></tr>");
		// 	$('#card_body').append("<div id='"+feild+"' data-name='"+str+"' class='ui-widget-content textbox-size feild-elements' style='position:absolute;top:15px;left:30px;height:25px;'> <span id='span_"+feild+"' style='color:black;font-family:arial;font-weight:400;font-style:normal;font-size:12px;'>"+str+"</span></div>");
		// 	$('#'+feild).draggable();
		// 	$('#'+feild).resizable();
		// });
		$('#newFeildBtn').click(function(){

            if (!$('#newFeildName').val()) {
                if ($("#newFeildName").parent().next(".validation").length == 0) // only add if not added
                {
                    //$("#newFeildBtn").parent().after("Please enter field value");
                    $("#error").html("<div class='validation' style='color:red;bottom:0;margin-left:20px;'>Please Enter Feild value</div>");
                }
                else
                {
                    $("#error").html('');
                }
            } 
            else 
            {
                $("#error").html(''); // remove it
                var feild = $('#newFeildName').val();
                 str = feild;
                 feild = feild.toLowerCase();
                 feild = feild.replace(/\ /g, '_');
                 element_id = feild;

                $('#table_body').append("");
                $('#card_body').append(" "+str+"");
                $('#'+feild).draggable();
                $('#'+feild).resizable();

                $('#newFeildName').length = 0;
        }
    });
		$('#btnsave').click(function(){
			var i=0;
			feilds=[];

			var template_id = $("#template_id").val();

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
					        url: site_url+"/admin/templates/save_cards",
					        type: "post",
					        async: true,
					        data: { "_token": token ,"feilds": feilds, "deleted_feilds": delete_feilds, "template_id": template_id, "snap": image },
					        dataType: 'json',
					        success: function(msg) {
					        	alert(msg);
					          	
					        },
					        error: function(jqXHR, textStatus, errorThrown) {
					           console.log(textStatus, errorThrown);
					        }
							
							});
					          
			        },
			        error: function(jqXHR, textStatus, errorThrown) {
					           console.log("hello12");
					}

	                });
	             }
	         });
			
      });

		$(document).on('click','#btnborder', function(){
			if($(this).text() == "Show Borders")
			{
				 $('.feild-elements').css('border', '2px dashed black');
				 $(this).text("Hide Borders");
			}else{
				$('.feild-elements').css('border', 'none');	
				 $(this).text("Show Borders");

			}
		});



	});




