
var selected_line;
var selected_object;

$(document).ready(function(){
	$('.object_circle_wrapper').draggable().resizable({
		handles: "se, sw, ne ,nw"
		});
	$('.object_square').draggable().resizable({
		handles: "e, w, s, n"
		});
	$('.object_line_wrapper').draggable().resizable({
		handles: "e, w"
		});

	$('#objectToolbar').click(function(event){
	event.stopPropagation();
	});
	$("#object_fill").click(function(event){
	event.stopPropagation();
        $("#object_fill_color").slideToggle("slow");
        $("#object_stroke_tools").slideUp();
        $("#object_opacity_tool").slideUp();
        $("#object_rotate_tool").slideUp();
        $("#object_arrange_tool").slideUp();

    });
   $("#object_stroke").click(function(event){
   	event.stopPropagation();
        $("#object_stroke_tools").slideToggle("slow");
        $("#object_fill_color").slideUp();
        $("#object_opacity_tool").slideUp();
        $("#object_rotate_tool").slideUp();
        $("#object_arrange_tool").slideUp();
    });
   $("#object_opacity").click(function(event){
   	event.stopPropagation();
        $("#object_opacity_tool").slideToggle("slow");
        $("#object_fill_color").slideUp("slow");
        $("#object_stroke_tools").slideUp();
        $("#object_rotate_tool").slideUp();
        $("#object_arrange_tool").slideUp();
    });
   $("#object_rotate").click(function(event){
   	event.stopPropagation();
        $("#object_rotate_tool").slideToggle("slow");
        $("#object_fill_color").slideUp("slow");
        $("#object_stroke_tools").slideUp();
        $("#object_opacity_tool").slideUp();
        $("#object_arrange_tool").slideUp();
    });
   $("#object_arrange").click(function(event){
   	event.stopPropagation();
        $("#object_arrange_tool").slideToggle("slow");
        $("#object_fill_color").slideUp();
        $("#object_stroke_tools").slideUp();
        $("#object_opacity_tool").slideUp();
        $("#object_rotate_tool").slideUp();
    });


   	$('#back_object_line').on("click", function(){

		var length = back_lines.length;
		length = parseInt(length) + 1;
		var id = "back_line_" + length;
		back_lines.push(id);
		$('#back_card_body').append('<div class="object object_line_wrapper" style="" id="wrapper_' + id + '"><div class="object_line" id="'+ id +'" style="border-color:black;"></div></div>');
		$('#wrapper_' + id).draggable();
		$('#wrapper_' + id).resizable({
			handles: "e, w"
		});

	});

	$('#object_line').on("click", function(){

		var length = lines.length;
		length = parseInt(length) + 1;
		var id = "line_" + length;
		lines.push(id);
		$('#card_body').append('<div class="object object_line_wrapper" style="" id="wrapper_' + id + '"><div class="object_line" id="'+ id +'" style="border-color:black;"></div></div>');
		$('#wrapper_' + id).draggable();
		$('#wrapper_' + id).resizable({
			handles: "e, w"
		});

	});

	$(window).click(function() {
		$('#' + selected_line).removeClass('selected');
		$('#objectToolbar').hide();
	});

	$(document).on("click", ".object_line_wrapper", function(event){
		event.stopPropagation();
		selected_line = $(this).attr('id');
		$('#' + selected_line).addClass('selected');
	});

	$('#back_object_square').on("click", function(){
		
		var length = back_squares.length;
		length = parseInt(length) + 1;
		var id = "back_square_" + length;
		back_squares.push(id);
		$('#back_card_body').append('<div class="object object_square" style="border-color:black;" id="' + id +'"></div>');
		$('#' + id).draggable();
		$('#' + id).resizable({
			handles: "e, w, s, n"
		});

	});

	$('#object_square').on("click", function(){

		var length = squares.length;
		length = parseInt(length) + 1;
		var id = "square_" + length;
		squares.push(id);
		$('#card_body').append('<div class="object object_square" style="border-color:black;" id="' + id +'"></div>');
		$('#' + id).draggable();
		$('#' + id).resizable({
			handles: "e, w, s, n"
		});

	});


	$('#back_object_circle').on("click", function(){

		var length = back_circles.length;
		length = parseInt(length) + 1;
		var id = "back_circle_" + length;
		back_circles.push(id);
		$('#back_card_body').append('<div class="object object_circle_wrapper" id="wrapper_' + id +'"><div class="object object_circle" id="'+ id +'" style="border-color:black;border-radious:15px/15px;"></div></div>');
		$('#wrapper_'+ id).draggable();
		$('#wrapper_'+ id).resizable({
			resize: function( event, ui ) {
				var h = ui.size.height;
				var w = ui.size.width;
				var hh = parseInt(h)/2;
				var ww = parseInt(w)/2;
				if(h > w)
				{
					$('#' + id).css({'border-radius': ww,'height':w,'width':w});
				}
				else
				{
					$('#' + id).css({'border-radius': hh,'height':h,'width':h});
				}
				
			},
			stop: function( event, ui )
			{ 
				var h = $('#' + id).css('height');
				var w = $('#' + id).css('width'); 

				$('#wrapper_' + id).css({'height': h,'width': w});
			},
			handles: "se, sw, ne ,nw"
		});

	});

	$('#object_circle').on("click", function(){

		var length = circles.length;
		length = parseInt(length) + 1;
		var id = "circle_" + length;
		circles.push(id);
		$('#card_body').append('<div class="object object_circle_wrapper" id="wrapper_' + id +'"><div class="object object_circle" id="'+ id +'" style="border-color:black;border-radious:15px/15px;"></div></div>');
		$('#wrapper_' + id).draggable();
		$('#wrapper_' + id).resizable({
			resize: function( event, ui ) {
				var h = ui.size.height;
				var w = ui.size.width;
				var hh = parseInt(h)/2;
				var ww = parseInt(w)/2;
				if(h > w)
				{
					$('#' + id).css({'border-radius': ww,'height':w,'width':w});
				}
				else
				{
					$('#' + id).css({'border-radius': hh,'height':h,'width':h});
				}	
			},
			stop: function( event, ui )
			{ 
				var h = $('#' + id).css('height');
				var w = $('#' + id).css('width'); 

				$('#wrapper_' + id).css({'height': h,'width': w});
			},
			handles: "se, sw, ne ,nw"
		});


	});

	
	$(document).on("click", '.object', function(event){ 
		event.stopPropagation();
		$("#object_arrange_tool").slideUp();
        $("#object_fill_color").slideUp();
        $("#object_stroke_tools").slideUp();
        $("#object_opacity_tool").slideUp();
        $("#object_rotate_tool").slideUp();

		selected_object = $(this).attr('id');
		
		if(selected_object.substring(0,6) == 'square' || selected_object.substring(5,11) == 'square')
		{
			$('#square_radius').empty();
			var data = '<div class="col-md-2 text-center side-break" id="object_radius"><img src="'+ site_url +'/assets/images/radius.svg" height="20px" width="20x" class="stroke-color"><div class="">Radius</div></div>';
			$('#square_radius').append(data);
			$('.side-break').css('width','14.28%');
		}
		else
		{	
			$('.side-break').css('width','');
			$('#square_radius').empty();
		}

		if(selected_object.substring(0,6)=="circle")
		{
			var top = $('#wrapper_' + selected_object).css('top'); 
			var left = $('#wrapper_' + selected_object).css('left');
		}
		else if(selected_object.substring(5,11) == "circle")
		{
			var top = $('#wrapper_back_' + selected_object).css('top'); 
			var left = $('#wrapper_back_' + selected_object).css('left');
		}
		else
		{
			var top = $('#' + selected_object).css('top');
			var left = $('#' + selected_object).css('left');
		}
		var toolbar_height = $('#objectToolbar').css('height');

		if(selected_object.substring(0,7) == "wrapper")
		{
			selected_object = selected_object.substring(8, selected_object.length);
		}
		
		var fill = $('#' + selected_object).css('background-color');
		var stroke_color = $('#' + selected_object).css('border-color');
		var stroke_width = $('#' + selected_object).css('border-width');
		var stroke_type = $('#'+ selected_object).css('border-style');
		var object_opacity = $('#' + selected_object).css('opacity');
		$('#colorSelector1 div').css('backgroundColor', fill);
		$('#colorSelector3 div').css('backgroundColor', stroke_color);
		stroke_width = stroke_width.substring(0, stroke_width.length - 2);
		$('#thickness').val(stroke_width);
		$('#border_type').val(stroke_type);
		object_opacity = parseInt(object_opacity)*100;
		var t = top.substring(0,top.length-2);
		var selected_height;
		if(selected_object.substring(0,4) == 'line' || selected_object.substring(5,9) == 'line')
		{
			selected_height = $('#wrapper_'+selected_object).css('height');
		}
		else
		{
		   selected_height = $('#'+selected_object).css('height');	
		}
		if(t > 100)
		{
			$('#objectToolbar').css('top', parseInt(top) - parseInt(toolbar_height) -10).css('left', parseInt(left) + 16);
		}
		else
		{
			$('#objectToolbar').css('top', parseInt(top) + parseInt(selected_height.substring(0,selected_height.length)) + 10).css('left', parseInt(left) + 16);
		}
		
		$('#objectToolbar').show();
	});


	$(document).on("click", ".object_circle_wrapper", function(event){
		event.stopPropagation();
		selected_line = $(this).attr('id');
		$('#' + selected_line).addClass('selected');
	});


	$('#colorSelector1').ColorPicker({

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

			$('#colorSelector1 div').css('backgroundColor', '#' + hex);
			$('#' + selected_object).css('backgroundColor', '#' + hex);
		}

	});

	$('#colorSelector3').ColorPicker({

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

				$('#colorSelector3 div').css('backgroundColor', '#' + hex);
				$('#' + selected_object).css('border-color', '#' + hex);
			}

		});

	$(document).on("change", '#thickness', function(){
		var size = $(this).val();
		$('#' + side + selected_object).css('border-width', size + "px");
	});


	$(document).on("change", '#border_type', function(){
		var style = $(this).val();
		$('#' + side + selected_object).css('border-style', style);
	});

	$('#opacity_slider').bootstrapSlider({
        
        formatter: function(value) {
        	$('#opacity_value').text(value + '%');
        	var key = value;
        	value = parseInt(value)/100;
        	$('#' + side + selected_object).css('opacity', value);
        	
          return 'Current value: ' + key;
        }
      });

	$('#rotation_degrees').keyup(function(){
		var degree = $(this).val();
		$('#' + side + selected_object).css('-ms-transform', 'rotate(' + degree + 'deg)' );
		$('#' + side + selected_object).css('-webkit-transform', 'rotate(' + degree + 'deg)' );
		$('#' + side + selected_object).css('transform', 'rotate(' + degree + 'deg)' );

	});

		$('#arrange_back').click(function(){
		if(selected_object.substring(0,6)=='circle' || selected_object.substring(5,11) == 'circle')
		{
			$("#wrapper_" + selected_object).css('z-index', '1');
		}
		else if(selected_object.substring(0,4)=='line' || selected_object.substring(5,9) == 'line')
		{
			$("#wrapper_" + selected_object).css('z-index', '1');
		}
		else
		{
			$("#" + selected_object).css('z-index', '1');
		}
	});

	$('#arrange_front').click(function(){
		if(selected_object.substring(0,6)=='circle' || selected_object.substring(5,11) == 'circle')
		{
			$("#wrapper_" + selected_object).css('z-index', '50');
		}
		else if(selected_object.substring(0,4)=='line' || selected_object.substring(5,9) == 'line')
		{
			$("#wrapper_" + selected_object).css('z-index', '50');
		}
		else
		{
			$("#" + selected_object).css('z-index', '50');
		}

	});

	$('#object_delete').click(function(){
		var id = $('#'+selected_object).attr('id');

		if(id.substring(0,6) == 'circle')
		{

			$.each(circles, function(key, value){

					if(value == id)
					{
						deleted_circles.push(id);
						dlt=key;
						for (var i = dlt; i< circles.length; i++) {
						circles[i] = circles[i+1];

						}
						circles.pop();

					}
				});

			$('#wrapper_'+selected_object).remove();
			$('#objectToolbar').hide();
		}
		else if(id.substring(0,4) == 'line')
		{
			
			$.each(lines, function(key,  value){
					if(value == id)
					{
						deleted_lines.push(id);
						dlt=key;
						for (var i = dlt; i< lines.length; i++) {
						lines[i] = lines[i+1];

						}
						lines.pop();

					}
				});
			$('#wrapper_'+selected_object).remove();
			$('#objectToolbar').hide();
		}
		else if(id.substring(0,6) == 'square')
		{
			$.each(squares, function(key,  value){
					if(value == id)
					{
						deleted_squares.push(id);
						dlt=key;
						for (var i = dlt; i< squares.length; i++) {
						squares[i] = squares[i+1];

						}
						squares.pop();

					}
				});
			$('#'+selected_object).remove();
			$('#objectToolbar').hide();
		}
		
		if(id.substring(5,11) == 'circle')
		{

			$.each(back_circles, function(key, value){

					if(value == id)
					{
						back_deleted_circles.push(id);
						dlt=key;
						for (var i = dlt; i< back_circles.length; i++) {
						back_circles[i] = back_circles[i+1];

						}
						back_circles.pop();

					}
				});

			$('#wrapper_'+selected_object).remove();
			$('#objectToolbar').hide();
		}
		else if(id.substring(5,9) == 'line')
		{
			
			$.each(back_lines, function(key,  value){
					if(value == id)
					{
						back_deleted_lines.push(id);
						dlt=key;
						for (var i = dlt; i< back_lines.length; i++) {
						back_lines[i] = back_lines[i+1];

						}
						back_lines.pop();

					}
				});
			$('#wrapper_'+selected_object).remove();
			$('#objectToolbar').hide();
		}
		else
		{
			$.each(back_squares, function(key,  value){
					if(value == id)
					{
						back_deleted_squares.push(id);
						dlt=key;
						for (var i = dlt; i< back_squares.length; i++) {
						back_squares[i] = back_squares[i+1];

						}
						back_squares.pop();

					}
				});
			$('#'+selected_object).remove();
			$('#objectToolbar').hide();
		}

	});

});

$('#square_radius').on('click','#object_radius', function(){
		if($('#' + selected_object).css('border-radius') == '10px')
		{
			$("#" + selected_object).css('border-radius', '0px');
		}
		else
		{
			$("#" + selected_object).css('border-radius', '10px');
		}
	});
