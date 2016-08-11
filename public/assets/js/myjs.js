


		
		$('#sidebar_company_name').keyup(function(){
			var txt = $('#sidebar_company_name').val();
			$('#company_name').text(txt);
			$('#myTextBox').text(txt);
			if(txt == "")
			{
				$('#company_name').text("Enter your Name");
			}

			
		});
		$('#myTextBox').keyup(function(){
			var txt = $('#myTextBox').val();
			$('#company_name').text(txt);
			$('#sidebar_company_name').val(txt);

			
		});
		$(document).ready(function(){
			$('#company_name').draggable();
			$('#company_name').resizable();

		});

		$('#company_name').click(function() {
		    var l = $('#company_name').css('left');
		    var t = $('#company_name').css('top');
		    t = t.substring(0,t.length - 2);

		    if( parseInt(t) < 100 )
		    {
		    	var txt_hight = $('#company_name').css('height');
		    	console.log(txt_hight);
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
		
		

