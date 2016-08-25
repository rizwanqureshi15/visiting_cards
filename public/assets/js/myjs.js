		var element_id
		var delete_feilds=[];	
		 var element = $("#div1"); // global variable
    var getCanvas; 	


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
});

		// var element_id;

		// $('.toolbar-elements').click(function(){
		// 	element_id = $(this).attr('id');
			
		// });
		// $("#under_line").click(function(){
		// 	var check = $("#span_" + element_id).css("text-decoration");
		// 	//alert(check);
		// 	 if(check == "none")
		// 	 {
		// 		$("#span_" + element_id).css("text-decoration", "underline"); 	
		// 		$("#under_line").addClass("button-selected");
		// 	 }
		// 	 else
		// 	 {
		// 	 	$("#span_" + element_id).css("text-decoration", "none");
		// 	 	$("#under_line").removeClass("button-selected");
		// 	 }
			
		// });
		// $("#italic").click(function(){
		// 	var check = $("#span_" + element_id).css("font-style");
			
		// 	 if(check == "normal")
		// 	 {
		// 		$("#span_" + element_id).css("font-style", "italic");
		// 		$("#italic").addClass("button-selected"); 	
		// 	 }
		// 	 else
		// 	 {
		// 	 	$("#span_" + element_id).css("font-style", "normal");
		// 	 	$("#italic").removeClass("button-selected");
		// 	 }
			
		// });
		// $("#bold").click(function(){
		// 	var check = $("#span_" + element_id).css("font-weight");
			
		// 	 if(check == 400)
		// 	 {
		// 		$("#span_" + element_id).css("font-weight", 900);
		// 		$("#bold").addClass("button-selected"); 	
		// 	 }
		// 	 else
		// 	 {
		// 	 	$("#span_" + element_id).css("font-weight", 400);
		// 	 	$("#bold").removeClass("button-selected");
		// 	 }
			
		// });
		// $("#sidebar_company_name,#sidebar_company_message").keyup(function(){
			
		// 	var txt = $(this).val();
		// 	var str = element_id.substring(8,element_id.length);
		// 	var span_element = '#span_' + str;
		// 	$(span_element).text(txt);
		// 	$('#myTextBox').val(txt);
			
		// 	if(txt == "")
		// 	{
		// 		$(span_element).text("");
		// 	}	
		// 	$('#' + str).resizable();
		// });

		// $('#myTextBox').keyup(function(){
			
		// 	var txt = $('#myTextBox').val();
			
		// 	$('#span_'+element_id).text(txt);
		// 	$('#sidebar_'+element_id).val(txt);
		// 	$('#'+element_id).resizable();
		// });

		// $(window).click(function() {
			
		// 	$('#myToolbar').hide();
		// 	$('#' + element_id).css('border', 'none');
		// });

		// $('#myToolbar').click(function(event){
			
		// 	event.stopPropagation();
		// });

		// $(document).ready(function(){
			
		// 	$('#company_name').draggable();
		// 	$('#company_name').resizable();
		// 	$('#company_message').draggable();
		// 	$('#company_message').resizable();
		// });
		
		// $("#company_name, #company_message").click(function(event) {
		    
		//     event.stopPropagation();
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
		//     	t = parseInt(t)-100;
		//     }
		    

		//     t += "px";

		//     $('#myToolbar').css('left',l);
		//     $('#myToolbar').css('top',t);
		//     $('#' + element_id).css('border', '2px dashed black');
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
		// 	color: '#0000ff',
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
		// 	$('#'+element_id).remove();
		// 	$("#myToolbar").hide();			
		// });

		
  //     });






















		// // $('#sidebar_company_name').keyup(function(){
			
		// // 	var txt = $('#sidebar_company_name').val();
			
		// // 	$('#span_company_name').text(txt);
		// // 	$('#myTextBox').val(txt);
			
		// // 	if(txt == "")
		// // 	{
		// // 		$('#span_company_name').text("Enter your Name");
		// // 	}	
		// // 	$('#company_name').resizable();
		// // });

		// // $('#myTextBox').keyup(function(){
			
		// // 	var txt = $('#myTextBox').val();
			
		// // 	$('#span_company_name').text(txt);
		// // 	$('#sidebar_company_name').val(txt);
		// // 	$('#company_name').resizable();
		// // });

		// // $(window).click(function() {
			
		// // 	$('#myToolbar').hide();
		// // 	$('#company_name').css('border', 'none');
		// // });

		// // $('#myToolbar').click(function(event){
			
		// // 	event.stopPropagation();
		// // });

		// // $(document).ready(function(){
			
		// // 	$('#company_name').draggable();
		// // 	$('#company_name').resizable();
		// // 	$('#company_message').draggable();
		// // 	$('#company_message').resizable();
		// // });

		// // $('#company_name').click(function(event) {
		    
		// //     event.stopPropagation();
		// //     var l = $('#company_name').css('left');
		// //     var t = $('#company_name').css('top');
		// //     t = t.substring(0,t.length - 2);

		// //     if( parseInt(t) < 100 )
		// //     {
		// //     	var txt_hight = $('#company_name').css('height');
		// //     	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	
		// //     }
		// //     else
		// //     {
		// //     	t = parseInt(t)-100;
		// //     }
		    

		// //     t += "px";

		// //     $('#myToolbar').css('left',l);
		// //     $('#myToolbar').css('top',t);
		// //     $('#company_name').css('border', '2px dashed black');
		// //     $("#myToolbar").show();

		// // });

		// // //Font Style Select
		// // $(function(){
  // //       $('#font').fontselect();

  // //       $('.font-select').click(function(){
  // //       	var ft = $('#font-text').text();
  // //       	$('#span_company_name').css('font-family', ft);
  // //       });
  // //       $('#size-font').change(function(){
  // //       	var fs = $('#size-font').val();
        	
  // //       	var size = parseInt(fs) * 10;
  // //       	fs += 'px';
  // //       	size += 'px';
  // //       	$('#span_company_name').css('font-size', fs);
  // //       	$('#company_name').css('height', 'auto');
  // //       	var h = $('#company_name').css('height');
  // //       	var t = $('#company_name').css('top');
  // //       	var tool_height = parseInt(t) + parseInt(h) + 10;
  // //       	tool_height += 'px';
  // //       	$('#myToolbar').css('top', tool_height);

  // //       });
  // //       //end
  // //       //color picker
       
		// // $(document).on('click', '.colorpicker', function(event){
		// // 	event.stopPropagation();
		// // });

  // //       $('#colorSelector').ColorPicker({
		// // 	color: '#0000ff',
		// // 	onShow: function (colpkr) {
		// // 		$(colpkr).fadeIn(500);
		// // 		return false;
		// // 	},
		// // 	onHide: function (colpkr) {
		// // 		$(colpkr).fadeOut(500);
		// // 		return false;
		// // 	},
		// // 	onChange: function (hsb, hex, rgb) {

		// // 		$('#colorSelector div').css('backgroundColor', '#' + hex);
		// // 		$('#span_company_name').css('color', '#' + hex)
		// // 	}
		// // });

		// // $('#toolbardelete').click(function(){
		// // 	$('#company_name').remove();
		// // 	$("#myToolbar").hide();			
		// // });
  // //     });