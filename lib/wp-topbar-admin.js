jQuery(document).ready(function() {
			       	
			       	
	jQuery('#wptbstarttimebtn').datetimepicker();
	jQuery('#wptbendtimebtn').datetimepicker();

	jQuery("#wptbstarttimebtnClear").click( function(e) {jQuery("#wptbstarttimebtn").val("0").change(); } );
	jQuery("#wptbtimebtnClear").click( function(e) {jQuery("#wptbendtimebtn").val("0").change(); } );
			    
    jQuery('#wptb_colorpicker_bar').hide();
    jQuery('#wptb_colorpicker_bar').farbtastic("#barcolor");
    jQuery("#barcolor").click(function(){jQuery('#wptb_colorpicker_bar').slideDown()});
    jQuery("#barcolor").blur(function(){jQuery('#wptb_colorpicker_bar').slideUp()});

    jQuery('#wptb_colorpicker_text').hide();
    jQuery('#wptb_colorpicker_text').farbtastic("#textcolor");
    jQuery("#textcolor").click(function(){jQuery('#wptb_colorpicker_text').slideDown()});
    jQuery("#textcolor").blur(function(){jQuery('#wptb_colorpicker_text').slideUp()});

    jQuery('#wptb_colorpicker_bottom').hide();
    jQuery('#wptb_colorpicker_bottom').farbtastic("#bottomcolor");
    jQuery("#bottomcolor").click(function(){jQuery('#wptb_colorpicker_bottom').slideDown()});
    jQuery("#bottomcolor").blur(function(){jQuery('#wptb_colorpicker_bottom').slideUp()});
    
    jQuery('#wptb_link_color').hide();
    jQuery('#wptb_link_color').farbtastic("#linkcolor");
    jQuery("#linkcolor").click(function(){jQuery('#wptb_link_color').slideDown()});
    jQuery("#linkcolor").blur(function(){jQuery('#wptb_link_color').slideUp()});	
  });
 
 
 	//function to set string to copy. If conversion parm is set, then convert string from hex

   function wptb_copy_to_Clibboard(me,strMsg,conversion) {
   
	var clip = new ZeroClipboard.Client();
	
	clip.setHandCursor( true );
	
	if(!conversion) {clip.setText(strMsg);}
	else {
	
	// strMsg must be in hex -- so decode it
	
		var bytes = [];
	
		for(var i=0; i< strMsg.length-1; i+=2){
		    bytes.push(parseInt(strMsg.substr(i, 2), 16));
		}
					    
		clip.setText(String.fromCharCode.apply(String, bytes));
	}  
	    	
	clip.addEventListener('complete', function (client, text) {
		alert("Copied this: "+text.substring(0,100)+"…");
	});
	clip.glue(me);
}
