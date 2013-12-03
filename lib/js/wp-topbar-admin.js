jQuery(document).ready(function() {
	
//
//
//		
	jQuery('#wptbstarttimebtnClear').click( function(e) {jQuery('#wptbstarttimebtn').val('').change(); } );
	jQuery('#wptbtimebtnClear').click( function(e) {jQuery('#wptbendtimebtn').val('').change(); } );
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
    jQuery( "#wtpb-priority" ).slider({
	  value: jQuery("#priority").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#priority" ).val( ui.value );
      }
    });

    jQuery( "#priority" ).val( jQuery( "#wtpb-priority" ).slider( "value" ) );
   
	jQuery( "#priority" ).change(function() {
	    jQuery( "#wtpb-priority" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wtpb-delayintime" ).slider({
	  value: jQuery("#delayintime").val(),
      min: 0,
      max: 60000,
      step: 500,
      slide: function( event, ui ) {
        jQuery( "#delayintime" ).val( ui.value );
      }
    });

    jQuery( "#delayintime" ).val( jQuery( "#wtpb-delayintime" ).slider( "value" ) );
   
	jQuery( "#delayintime" ).change(function() {
	    jQuery( "#wtpb-delayintime" ).slider( "value", jQuery(this).val() );
	});    
//
//
//   
   jQuery( "#wtpb-slidetime" ).slider({
	  value: jQuery("#slidetime").val(),
      min: 0,
      max: 5000,
      step: 50,
      slide: function( event, ui ) {
        jQuery( "#slidetime" ).val( ui.value );
      }
    });

    jQuery( "#slidetime" ).val( jQuery( "#wtpb-slidetime" ).slider( "value" ) );
   
	jQuery( "#slidetime" ).change(function() {
	    jQuery( "#wtpb-slidetime" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wtpb-displaytime" ).slider({
	  value: jQuery("#displaytime").val(),
      min: 0,
      max: 60000,
      step: 500,
      slide: function( event, ui ) {
        jQuery( "#displaytime" ).val( ui.value );
      }
    });

    jQuery( "#displaytime" ).val( jQuery( "#wtpb-displaytime" ).slider( "value" ) );
   
	jQuery( "#displaytime" ).change(function() {
	    jQuery( "#wtpb-displaytime" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wtpb-bottomborderheight" ).slider({
	  value: jQuery("#bottomborderheight").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#bottomborderheight" ).val( ui.value );
      }
    });

    jQuery( "#bottomborderheight" ).val( jQuery( "#wtpb-bottomborderheight" ).slider( "value" ) );
   
	jQuery( "#bottomborderheight" ).change(function() {
	    jQuery( "#wtpb-bottomborderheight" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wtpb-paddingtop" ).slider({
	  value: jQuery("#paddingtop").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#paddingtop" ).val( ui.value );
      }
    });

    jQuery( "#paddingtop" ).val( jQuery( "#wtpb-paddingtop" ).slider( "value" ) );
   
	jQuery( "#paddingtop" ).change(function() {
	    jQuery( "#wtpb-paddingtop" ).slider( "value", jQuery(this).val() );
	});   
//
//
//   
   jQuery( "#wtpb-paddingbottom" ).slider({
	  value: jQuery("#paddingbottom").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#paddingbottom" ).val( ui.value );
      }
    });

    jQuery( "#paddingbottom" ).val( jQuery( "#wtpb-paddingbottom" ).slider( "value" ) );
   
	jQuery( "#paddingbottom" ).change(function() {
	    jQuery( "#wtpb-paddingbottom" ).slider( "value", jQuery(this).val() );
	});   
//
//
//

   jQuery( "#wtpb-margintop" ).slider({
	  value: jQuery("#margintop").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#margintop" ).val( ui.value );
      }
    });

    jQuery( "#margintop" ).val( jQuery( "#wtpb-margintop" ).slider( "value" ) );
   
	jQuery( "#margintop" ).change(function() {
	    jQuery( "#wtpb-margintop" ).slider( "value", jQuery(this).val() );
	});   
//
//
//	
   jQuery( "#wtpb-marginbottom" ).slider({
	  value: jQuery("#marginbottom").val(),
      min: 0,
      max: 100,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#marginbottom" ).val( ui.value );
      }
    });

    jQuery( "#marginbottom" ).val( jQuery( "#wtpb-marginbottom" ).slider( "value" ) );
   
	jQuery( "#marginbottom" ).change(function() {
	    jQuery( "#wtpb-marginbottom" ).slider( "value", jQuery(this).val() );
	});   
//
//
//
   jQuery( "#wtpb-fontsize" ).slider({
	  value: jQuery("#fontsize").val(),
      min: 0,
      max: 148,
      step: 1,
      slide: function( event, ui ) {
        jQuery( "#fontsize" ).val( ui.value );
      }
    });

    jQuery( "#fontsize" ).val( jQuery( "#wtpb-fontsize" ).slider( "value" ) );
   
	jQuery( "#fontsize" ).change(function() {
	    jQuery( "#wtpb-fontsize" ).slider( "value", jQuery(this).val() );
	});   
//
//
//		
   jQuery( "#wtpb-scroll-amount" ).slider({
	  value: jQuery("#scrollamount").val(),
      min: 0,
      max: 5000,
      step: 50,
      slide: function( event, ui ) {
        jQuery( "#scrollamount" ).val( ui.value );
      }
    });

    jQuery( "#scrollamount" ).val( jQuery( "#wtpb-scroll-amount" ).slider( "value" ) );
   
	jQuery( "#scrollamount" ).change(function() {
	    jQuery( "#wtpb-scroll-amount" ).slider( "value", jQuery(this).val() );
	}); 
//
//
//
	jQuery('#wptbstarttimebtn').datetimepicker();
	jQuery('#wptbendtimebtn').datetimepicker();


    
});
