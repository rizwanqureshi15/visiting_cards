var element = $('#a4');
var order_id;
var count=0;
var a=0;

$(document).ready(function(){
	if(card_type == 'horizontal')
    {
        var i = 0;
    $('#user_overlay').show();
    $('#admin_navbar').hide();
    $.each(cards,function(k, card){
        $.each(card,function(key, value){
            if(key == "order_id")
            {
                order_id = value; 
            }
            if(key == "front_snap")
            {
                count++;
                i++;
                $('#image_'+i).attr('src', site_url+"/order/"+username+"/"+ order_no +"/front/"+value);
            }
            if(key == "back_snap" && value != "")
            {
                count++;
                i++;
                $('#image_'+i).attr('src', site_url+"/order/"+username+"/"+ order_no +"/back/"+value);
            }
        });
        if(i == 10 && cards.length != count)
        {
            i = 0;

            html2canvas(element, {
                onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");
                $.ajax({
                type: "POST",
                url: site_url+'/card_list_snap',
                dataType: 'json',
                async: false,
                data: {"_token": token ,"image": imgageData, "order_id":order_id},
                success : function(image)
                {
                    if(cards.length == count)
                    {
                        $.ajax({
                            type: "POST",
                            url: site_url+'/change_status',
                            dataType: 'json',
                            async: true,
                            data: {"_token": token , "order_id":order_id, "status": "done"},
                            success : function(image)
                            {
                                
                               window.location.href = site_url+"/admin/orders/final/"+order_id+"/list";
                                $('#user_overlay').hide();
                                $('#admin_navbar').show();

                            }}).fail(function(data){
                        
                                var errors = data.responseJSON;
                            });
                    }
                }}).fail(function(data){
                    
                    var errors = data.responseJSON;
                });
            }});
        }
    });
    var j;
    for (j = i+1; j<=10 ; j++)
    {
        $('#image_'+j).attr('src', " ");
    }
    html2canvas(element, {
        onrendered: function (canvas) {
        getCanvas = canvas;
        var imgageData = getCanvas.toDataURL("image/png");
        $.ajax({
            type: "POST",
            url: site_url+'/card_list_snap',
            dataType: 'json',
            async: false,
            data: {"_token": token ,"image": imgageData, "order_id":order_id},
            success : function(image)
            {
                if(cards.length == count)
                {
                    $.ajax({
                    type: "POST",
                    url: site_url+'/change_status',
                    dataType: 'json',
                    async: true,
                    data: {"_token": token , "order_id":order_id, "status": "done"},
                    success : function(image)
                    {
                        
                       window.location.href = site_url+"/admin/orders/final/"+order_id+"/list";
                        $('#user_overlay').hide();
                        $('#admin_navbar').show();

                    }}).fail(function(data){
                
                        var errors = data.responseJSON;
                    });
                }
            }}).fail(function(data){
        
                var errors = data.responseJSON;
            });
    }});
    }
    else
    {
        var i = 0;
    $('#user_overlay').show();
    $('#admin_navbar').hide();
    $.each(cards,function(k, card){
        $.each(card,function(key, value){
            if(key == "order_id")
            {
                order_id = value; 
            }
            if(key == "front_snap")
            {
                count++;
                i++;
                $('#image_'+i).attr('src', site_url+"/order/"+username+"/"+ order_no +"/front/"+value);
            }
            if(key == "back_snap" && value != "")
            {
                count++;
                i++;
                $('#image_'+i).attr('src', site_url+"/order/"+username+"/"+ order_no +"/back/"+value);
            }
        });
        if(i == 6 && cards.length != count)
        {
            i = 0;

            html2canvas(element, {
                onrendered: function (canvas) {
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");
                $.ajax({
                type: "POST",
                url: site_url+'/card_list_snap',
                dataType: 'json',
                async: false,
                data: {"_token": token ,"image": imgageData, "order_id":order_id},
                success : function(image)
                {
                    if(cards.length == count)
                    {
                        $.ajax({
                            type: "POST",
                            url: site_url+'/change_status',
                            dataType: 'json',
                            async: true,
                            data: {"_token": token , "order_id":order_id, "status": "done"},
                            success : function(image)
                            {
                                
                               window.location.href = site_url+"/admin/orders/final/"+order_id+"/list";
                                $('#user_overlay').hide();
                                $('#admin_navbar').show();

                            }}).fail(function(data){
                        
                                var errors = data.responseJSON;
                            });
                    }
                }}).fail(function(data){
                    
                    var errors = data.responseJSON;
                });
            }});
        }
    });
    var j;
    for (j = i+1; j<=6 ; j++)
    {
        $('#image_'+j).attr('src', " ");
    }
    html2canvas(element, {
        onrendered: function (canvas) {
        getCanvas = canvas;
        var imgageData = getCanvas.toDataURL("image/png");
        $.ajax({
            type: "POST",
            url: site_url+'/card_list_snap',
            dataType: 'json',
            async: false,
            data: {"_token": token ,"image": imgageData, "order_id":order_id},
            success : function(image)
            {
                if(cards.length == count)
                {
                    $.ajax({
                    type: "POST",
                    url: site_url+'/change_status',
                    dataType: 'json',
                    async: true,
                    data: {"_token": token , "order_id":order_id, "status": "done"},
                    success : function(image)
                    {
                        
                       window.location.href = site_url+"/admin/orders/final/"+order_id+"/list";
                        $('#user_overlay').hide();
                        $('#admin_navbar').show();

                    }}).fail(function(data){
                
                        var errors = data.responseJSON;
                    });
                }
            }}).fail(function(data){
        
                var errors = data.responseJSON;
            });
    }});
    }
    
});