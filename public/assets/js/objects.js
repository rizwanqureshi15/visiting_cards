var lines = [];
var circles = [];
var squeres = [];
var back_lines = [];
var back_circles = [];
var back_squeres = [];
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

	$('#object_squere').on("click", function(){

		var length = squeres.length;
		length = parseInt(length) + 1;
		var id = "squere_" + length;
		squeres.push(id);
		$('#'+ side +'card_body').append('<div class="object object_squere" id="' + side + id +'"></div>');
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
		selected_object = $(this).attr('id');
		var top = $('#' + selected_object).css('top');
		var left = $('#' + selected_object).css('left');
		var toolbar_height = $('#objectToolbar').css('height');
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
			$('#'+side+'span_'+element_id).css('color', '#' + hex)
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
				$('#'+side+'span_'+element_id).css('color', '#' + hex)
			}

		});


});