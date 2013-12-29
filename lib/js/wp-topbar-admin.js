jQuery(document).ready(function() {
	
//
//
//		
	jQuery('#wptbstarttimebtnClear').click( function(e) {jQuery('#wptbstarttimebtn').val('').change(); } );
	jQuery('#wptbtimebtnClear').click( function(e) {jQuery('#wptbendtimebtn').val('').change(); } );
	jQuery( "#radio0" ).buttonset();
	jQuery( "#radio1" ).buttonset();
	jQuery( "#radio2" ).buttonset();
	jQuery( "#radio3" ).buttonset();
	jQuery( "#radio4" ).buttonset();
	jQuery( "#radio5" ).buttonset();
	jQuery( "#radio6" ).buttonset();
	jQuery( "#radio7" ).buttonset();
	jQuery( "#radio8" ).buttonset();
	jQuery( "#radio9" ).buttonset();
	jQuery( "#radio10" ).buttonset();
	jQuery( "#radio11" ).buttonset();
	jQuery( "#radio12" ).buttonset();
	jQuery( "#radio13" ).buttonset();
	jQuery( "#radio14" ).buttonset();
	jQuery( "#radio15" ).buttonset();
	jQuery( "#radio16" ).buttonset();
	jQuery( "#radio17" ).buttonset();
	jQuery( "#radio18" ).buttonset();
	jQuery( "#radio19" ).buttonset();
	jQuery( "#radio110" ).buttonset();//
//
//
    jQuery( "#wptb-priority" ).slider({
	  value: jQuery("#priority").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#priority" ).val( ui.value );
      }
    });

    jQuery( "#priority" ).val( jQuery( "#wptb-priority" ).slider( "value" ) );
   
	jQuery( "#priority" ).change(function() {
	    jQuery( "#wptb-priority" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wptb-rotatedisplaytime" ).slider({
	  value: jQuery("#rotatedisplaytime").val(),
      min: 0,
      max: 60000,
      step: 250,
      slide: function( event, ui ) {
        jQuery( "#rotatedisplaytime" ).val( ui.value );
      }
    });

    jQuery( "#rotatedisplaytime" ).val( jQuery( "#wptb-rotatedveisplaytime" ).slider( "value" ) );
   
	jQuery( "#rotatedisplaytime" ).change(function() {
	    jQuery( "#wptb-rotatedisplaytime" ).slider( "value", jQuery(this).val() );
	}); 
//
//
//
   jQuery( "#wptb-rotatestartdelay" ).slider({
	  value: jQuery("#rotatestartdelay").val(),
      min: 0,
      max: 10000,
      step: 250,
      slide: function( event, ui ) {
        jQuery( "#rotatestartdelay" ).val( ui.value );
      }
    });

    jQuery( "#rotatestartdelay" ).val( jQuery( "#wptb-rotatestartdelay" ).slider( "value" ) );
   
	jQuery( "#rotatestartdelay" ).change(function() {
	    jQuery( "#wptb-rotatestartdelay" ).slider( "value", jQuery(this).val() );
	});  
	//
//
//
   jQuery( "#wptb-rotatecount" ).slider({
	  value: jQuery("#rotatecount").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#rotatecount" ).val( ui.value );
      }
    });

    jQuery( "#rotatecount" ).val( jQuery( "#wptb-rotatecount" ).slider( "value" ) );
   
	jQuery( "#rotatecount" ).change(function() {
	    jQuery( "#wptb-rotatecount" ).slider( "value", jQuery(this).val() );
	});    
//
//
//
   jQuery( "#wptb-delayintime" ).slider({
	  value: jQuery("#delayintime").val(),
      min: 0,
      max: 60000,
      step: 250,
      slide: function( event, ui ) {
        jQuery( "#delayintime" ).val( ui.value );
      }
    });

    jQuery( "#delayintime" ).val( jQuery( "#wptb-delayintime" ).slider( "value" ) );
   
	jQuery( "#delayintime" ).change(function() {
	    jQuery( "#wptb-delayintime" ).slider( "value", jQuery(this).val() );
	});  
//
//
//   
   jQuery( "#wptb-slidetime" ).slider({
	  value: jQuery("#slidetime").val(),
      min: 0,
      max: 5000,
      step: 50,
      slide: function( event, ui ) {
        jQuery( "#slidetime" ).val( ui.value );
      }
    });

    jQuery( "#slidetime" ).val( jQuery( "#wptb-slidetime" ).slider( "value" ) );
   
	jQuery( "#slidetime" ).change(function() {
	    jQuery( "#wptb-slidetime" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wptb-displaytime" ).slider({
	  value: jQuery("#displaytime").val(),
      min: 0,
      max: 60000,
      step: 250,
      slide: function( event, ui ) {
        jQuery( "#displaytime" ).val( ui.value );
      }
    });

    jQuery( "#displaytime" ).val( jQuery( "#wptb-displaytime" ).slider( "value" ) );
   
	jQuery( "#displaytime" ).change(function() {
	    jQuery( "#wptb-displaytime" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wptb-bottomborderheight" ).slider({
	  value: jQuery("#bottomborderheight").val(),
      min: 0,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#bottomborderheight" ).val( ui.value );
      }
    });

    jQuery( "#bottomborderheight" ).val( jQuery( "#wptb-bottomborderheight" ).slider( "value" ) );
   
	jQuery( "#bottomborderheight" ).change(function() {
	    jQuery( "#wptb-bottomborderheight" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wptb-paddingtop" ).slider({
	  value: jQuery("#paddingtop").val(),
      min: 0,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#paddingtop" ).val( ui.value );
      }
    });

    jQuery( "#paddingtop" ).val( jQuery( "#wptb-paddingtop" ).slider( "value" ) );
   
	jQuery( "#paddingtop" ).change(function() {
	    jQuery( "#wptb-paddingtop" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wptb-paddingbottom" ).slider({
	  value: jQuery("#paddingbottom").val(),
      min: 0,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#paddingbottom" ).val( ui.value );
      }
    });

    jQuery( "#paddingbottom" ).val( jQuery( "#wptb-paddingbottom" ).slider( "value" ) );
   
	jQuery( "#paddingbottom" ).change(function() {
	    jQuery( "#wptb-paddingbottom" ).slider( "value", jQuery(this).val() );
	});   
//
//
//

   jQuery( "#wptb-margintop" ).slider({
	  value: jQuery("#margintop").val(),
      min: -500,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#margintop" ).val( ui.value );
      }
    });

    jQuery( "#margintop" ).val( jQuery( "#wptb-margintop" ).slider( "value" ) );
   
	jQuery( "#margintop" ).change(function() {
	    jQuery( "#wptb-margintop" ).slider( "value", jQuery(this).val() );
	});   
//
//
//	
   jQuery( "#wptb-marginbottom" ).slider({
	  value: jQuery("#marginbottom").val(),
      min: -500,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#marginbottom" ).val( ui.value );
      }
    });

    jQuery( "#marginbottom" ).val( jQuery( "#wptb-marginbottom" ).slider( "value" ) );
   
	jQuery( "#marginbottom" ).change(function() {
	    jQuery( "#wptb-marginbottom" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wptb-marginleft" ).slider({
	  value: jQuery("#marginleft").val(),
      min: -500,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#marginleft" ).val( ui.value );
      }
    });

    jQuery( "#marginleft" ).val( jQuery( "#wptb-marginleft" ).slider( "value" ) );
   
	jQuery( "#marginleft" ).change(function() {
	    jQuery( "#wptb-marginleft" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wptb-marginright" ).slider({
	  value: jQuery("#marginright").val(),
      min: -500,
      max: 500,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#marginright" ).val( ui.value );
      }
    });

    jQuery( "#marginright" ).val( jQuery( "#wptb-marginright" ).slider( "value" ) );
   
	jQuery( "#marginright" ).change(function() {
	    jQuery( "#wptb-marginright" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wptb-fontsize" ).slider({
	  value: jQuery("#fontsize").val(),
      min: 0,
      max: 148,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#fontsize" ).val( ui.value );
      }
    });

    jQuery( "#fontsize" ).val( jQuery( "#wptb-fontsize" ).slider( "value" ) );
   
	jQuery( "#fontsize" ).change(function() {
	    jQuery( "#wptb-fontsize" ).slider( "value", jQuery(this).val() );
	});   
//
//
//		
   jQuery( "#wptb-scroll-amount" ).slider({
	  value: jQuery("#scrollamount").val(),
      min: 0,
      max: 5000,
      step: 5,
      slide: function( event, ui ) {
        jQuery( "#scrollamount" ).val( ui.value );
      }
    });

    jQuery( "#scrollamount" ).val( jQuery( "#wptb-scroll-amount" ).slider( "value" ) );
   
	jQuery( "#scrollamount" ).change(function() {
	    jQuery( "#wptb-scroll-amount" ).slider( "value", jQuery(this).val() );
	}); 
//
//
//
	jQuery('#wptbstarttimebtn').datetimepicker();
	jQuery('#wptbendtimebtn').datetimepicker();


    
});
