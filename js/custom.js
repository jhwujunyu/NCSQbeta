$(document).ready(function(){ 
         $(function() {
              $( "#sortable" ).sortable({stop:saveLayout});
              $( "#sortable" ).disableSelection();
            });
            
            
            function saveLayout(){
                var linum=0;
                $("#sortable li").each(function(){
                    
                    var productIDValSplitter 	= (this.id).split("_");
                    var productIDVal 		= productIDValSplitter[1];
                    $("#notificationsLoader").html('<img src="image/loader.gif">');   
                    $.ajax({  
                            type: "POST",  
                            url: "../functions.php",  
                            data: { num:linum ,productID:productIDVal, action: "updatelinum"},
                            success: function(theResponse) {
                                    $("#notificationsLoader").empty();}    
                    });   
                 
                    linum++;

    
              });
            }
       
        $("#totalitems").html($("#basketItemsWrap li").size()-2);
      
	$("#basketItemsWrap li:first").hide();

	$(".productPriceWrapRight a img").click(function() {
                document.getElementById(this.id).style.display="none";
             
		var productIDValSplitter 	= (this.id).split("_");
		var productIDVal 			= productIDValSplitter[1];
		
		var productX 		= $("#productImageWrap").offset().left;
		var productY 		= $("#productImageWrap").offset().top;
		
		if( $("#productID_" + productIDVal).length > 0){
			var basketX 		= $("#productID_" + productIDVal).offset().left;
			var basketY 		= $("#productID_" + productIDVal).offset().top;			
		} else {
			var basketX 		= $("#basketTitleWrap").offset().left;
			var basketY 		= $("#basketTitleWrap").offset().top;
		}
		
		var gotoX 			= basketX - productX;
		var gotoY 			= basketY - productY;
		
		var newImageWidth 	= $("#productImageWrap").width() / 3;
		var newImageHeight	= $("#productImageWrap").height() / 3;
		var licount= $("#basketItemsWrap li").size();	
		$("#productImageWrap img")
		.clone()
		.prependTo("#productImageWrap")
		.css({'position' : 'absolute'})
		.animate({opacity: 0.4}, 100 )
		.animate({opacity: 0.1, marginLeft: gotoX, marginTop: gotoY, width: newImageWidth, height: newImageHeight}, 1200, function() {
																																																																									  			$(this).remove();
	
			$("#notificationsLoader").html('<img src="image/loader.gif">');
		
			$.ajax({  
				type: "POST",  
				url: "../functions.php",  
				data: { productID: productIDVal, action: "addToBasket"},  
				success: function(theResponse) {
                                      
					if( $("#productID_" + productIDVal).length > 0){
						$("#productID_" + productIDVal).animate({ opacity: 0 }, 500);
						$("#productID_" + productIDVal).before(theResponse).remove();
						$("#productID_" + productIDVal).animate({ opacity: 0 }, 500);
						$("#productID_" + productIDVal).animate({ opacity: 1 }, 500);
						$("#notificationsLoader").empty();
                                              
						
					} else {
						$("#basketItemsWrap li:last").before(theResponse);
						$("#basketItemsWrap li:last").hide();
						$("#basketItemsWrap li:last").show("slow");
                                                if($("#basketItemsWrap li").size()-licount==0){
                                                 alert("The module is already selected.");
                                                 }
						$("#notificationsLoader").empty();
                                               
                                                 $("#totalitems").html($("#basketItemsWrap li").size()-2);
					}
					
				},
                                
			});  
		
		});
		
	});
	
	
	
	$("#basketItemsWrap li img").live("click", function(event) { 
		var productIDValSplitter 	= (this.id).split("_");
		var productIDVal 			= productIDValSplitter[1];
               
             var addimg=document.getElementById("featuredProduct_"+productIDValSplitter[0])
           //  alert(addimg);
             if(addimg){addimg.style.display = "";}
                    
            
		$("#notificationsLoader").html('<img src="image/loader.gif">');
	
		$.ajax({  
			type: "POST",  
			url: "../functions.php",  
			data: { productID:productIDVal, action: "deleteFromBasket"},  
			success: function(theResponse) {
				
				$("#productID_" + productIDVal).hide("slow",  function() {$(this).remove();});
				$("#notificationsLoader").empty();
                                
                                $("#totalitems").html($("#basketItemsWrap li").size()-3);
			}  
		});  
		
	});

});
