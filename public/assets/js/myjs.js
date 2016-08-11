

	var txt = document.getElementById("company_name");
	var canvas = document.getElementById("canvas1");
	var ctx = canvas.getContext("2d");
	ctx.font = "30px Arial";
		
		$('#sidebar_company_name').keyup(function(){
			
			var txt = $('#sidebar_company_name').val();
			
			$('#span_company_name').text(txt);
			$('#myTextBox').val(txt);
			
			if(txt == "")
			{
				$('#span_company_name').text("Enter your Name");
			}	
			$('#company_name').resizable();
		});

		$('#myTextBox').keyup(function(){
			
			var txt = $('#myTextBox').val();
			
			$('#span_company_name').text(txt);
			$('#sidebar_company_name').val(txt);
			$('#company_name').resizable();
		});

		$(window).click(function() {
			
			$('#myToolbar').hide();
			$('#company_name').css('border', 'none');
		});

		$('#myToolbar').click(function(event){
			
			event.stopPropagation();
		});

		$(document).ready(function(){
			
			$('#company_name').draggable();
			$('#company_name').resizable();
		});

		$('#company_name').click(function(event) {
		    
		    event.stopPropagation();
		    var l = $('#company_name').css('left');
		    var t = $('#company_name').css('top');
		    t = t.substring(0,t.length - 2);

		    if( parseInt(t) < 100 )
		    {
		    	var txt_hight = $('#company_name').css('height');
		    	t = parseInt(t) + parseInt(txt_hight) + 10;
		    	
		    }
		    else
		    {
		    	t = parseInt(t)-100;
		    }
		    

		    t += "px";

		    $('#myToolbar').css('left',l);
		    $('#myToolbar').css('top',t);
		    $('#company_name').css('border', '2px dashed black');
		    $("#myToolbar").show();

		});

		//Font Style Select
		$(function(){
        $('#font').fontselect();

        $('.font-select').click(function(){
        	var ft = $('#font-text').text();
        	$('#span_company_name').css('font-family', ft);
        });
        $('#size-font').change(function(){
        	var fs = $('#size-font').val();
        	
        	var size = parseInt(fs) * 10;
        	fs += 'px';
        	size += 'px';
        	$('#span_company_name').css('font-size', fs);
        	$('#company_name').css('height', 'auto');
        	var h = $('#company_name').css('height');
        	var t = $('#company_name').css('top');
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
				$('#span_company_name').css('color', '#' + hex)
			}
		});

		$('#toolbardelete').click(function(){
			$('#company_name').remove();
			$("#myToolbar").hide();			
		});
      });

