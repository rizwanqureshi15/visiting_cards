var lines = [];
var circles = [];
var squeres = [];
var selected_line;

$(document).ready(function(){

	$('#object_line').on("click", function(){
		
		var length = lines.length;
		length = parseInt(length) + 1;
		var id = "line_" + length;
		lines.push(id);
		$('#'+ side +'card_body').append('<div class="object_line_wrapper" id="wrapper_' + side + id + '"><div class="object_line" id="'+ id +'"></div></div>');
		$('#'+ side + 'wrapper_' + id).draggable();
		$('#'+ side + 'wrapper_' + id).resizable({
			handles: "e, w"
		});

	});

	$(window).click(function() {
		$('#' + selected_line).removeClass('selected');
	});

	$(document).on("click", ".object_line_wrapper", function(event){
		event.stopPropagation();
		selected_line = $(this).attr('id');
		$('#' + selected_line).addClass('selected');

		$('#objectToolbar').show();
	});

	$('#object_squere').on("click", function(){

		var length = squeres.length;
		length = parseInt(length) + 1;
		var id = "squere_" + length;
		squeres.push(id);
		$('#'+ side +'card_body').append('<div class="object_squere" id="' + side + id +'"></div>');
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
		$('#'+ side +'card_body').append('<div class="object_circle" id="' + side + id +'"></div>');
		$('#'+ side + id).draggable();
		$('#'+ side + id).resizable({
			handles: "e, w, s, n"
		});

	});


});