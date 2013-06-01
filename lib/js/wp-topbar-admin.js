jQuery(document).ready(function() {
	
		jQuery('#wptbstarttimebtn').datetimepicker();
		jQuery('#wptbendtimebtn').datetimepicker();
			
		jQuery('#wptbstarttimebtnClear').click( function(e) {jQuery('#wptbstarttimebtn').val('0').change(); } );
		jQuery('#wptbtimebtnClear').click( function(e) {jQuery('#wptbendtimebtn').val('0').change(); } );
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
//		jQuery( ".ui-state-active").css("text-transform","uppercase");

});
