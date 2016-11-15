
var back_lines = [];
var back_circles = [];
var back_squares = [];
var selected_line;
var selected_object;

$(document).ready(function(){
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

	$('#object_line').on("click", function(){
		
		var length = lines.length;
		length = parseInt(length) + 1;
		var id = "line_" + length;
		if(is_back == "0")
		{
			lines.push(id);
		}
		else
		{
			back_lines.push(id);
		}
		$('#'+ side +'card_body').append('<div class="object object_line_wrapper" id="wrapper_' + side + id + '"><div class="object_line" id="'+ id +'"></div></div>');
		$('#'+ side + 'wrapper_' + id).draggable();
		$('#'+ side + 'wrapper_' + id).resizable({
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

	$('#object_square').on("click", function(){

		var length = squares.length;
		length = parseInt(length) + 1;
		var id = "square_" + length;
		squares.push(id);
		$('#'+ side +'card_body').append('<div class="object object_square" id="' + side + id +'"></div>');
		$('#'+ side + id).draggable();
		$('#'+ side + id).resizable({
			handles: "e, w, s, n"
		});

	});

	$('#object_circle').on("click", function(){

		var length = circles.length;
		length = parseInt(length) + 1;
		var id = "circle_" + length;
		circles.push(id);
		$('#'+ side +'card_body').append('<div class="object object_circle" id="' + side + id +'"></div>');
		$('#'+ side + id).draggable();
		$('#'+ side + id).resizable({
			handles: "e, w, s, n"
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
		var top = $('#' + selected_object).css('top');
		var left = $('#' + selected_object).css('left');
		var toolbar_height = $('#objectToolbar').css('height');

		if(selected_object.substring(0,7) == "wrapper")
		{
			selected_object = selected_object.substring(8, selected_object.length);
		}

		var fill = $('#' + selected_object).css('background-color');
		var stroke_color = $('#' + selected_object).css('border-color');
		var stroke_width = $('#' + selected_object).css('border-width');
		var stroke_type = $('#'+selected_object).css('border-style');
		var object_opacity = $('#' + selected_object).css('opacity');
		$('#colorSelector1 div').css('backgroundColor', fill);
		$('#colorSelector3 div').css('backgroundColor', stroke_color);
		stroke_width = stroke_width.substring(0, stroke_width.length - 2);
		$('#thickness').val(stroke_width);
		$('#border_type').val(stroke_type);
		object_opacity = parseInt(object_opacity)*100;
		$('#objectToolbar').css('top', parseInt(top) - parseInt(toolbar_height) - 10).css('left', left);
		$('#objectToolbar').show();
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
		$("#" + side + selected_object).css('z-index', '1');
	});

	$('#arrange_front').click(function(){
		$("#" + side + selected_object).css('z-index', '7');
	});

	$('#object_delete').click(function(){
		var id = $('#'+selected_object).attr('id');

		if(id.substring(0,6) == 'circle')
		{
			$.each(circles, function(key,  value){
					if(value == id)
					{
						deleted_circles[deleted_circles.length] = id;
						dlt=key;
						for (var i = dlt; i< circles.length; i++) {
						circles[i] = circles[i+1];

						}
						circles.pop();

					}
				});
		}
		else if(id.substring(0,4) == 'line')
		{
			$.each(lines, function(key,  value){
					if(value == id)
					{
						deleted_lines[deleted_lines.length] = id;
						dlt=key;
						for (var i = dlt; i< lines.length; i++) {
						lines[i] = lines[i+1];

						}
						lines.pop();

					}
				});
		}
		else
		{
			$.each(squares, function(key,  value){
					if(value == id)
					{
						deleted_squares[deleted_squares.length] = id;
						dlt=key;
						for (var i = dlt; i< squares.length; i++) {
						squares[i] = squares[i+1];

						}
						squares.pop();

					}
				});
		}

	});
});