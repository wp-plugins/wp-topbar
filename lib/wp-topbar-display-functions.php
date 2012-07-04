<?php 

/*
Plugin Name: WP-TopBar
Display Functions
*/


//=========================================================================			
// Build the tabs on top of the non-edit pages 
//=========================================================================			


function wptb_options_tabs( $current = 'table' ) {
    $tabs = array( 'table'=> 'All TopBars', 'testpriority' => 'Test Priority', 'bulkclosebutton'=> 'Close Button', 'export' => 'Export Options', 'mainfaq' => 'FAQ' );
    $links = array();
        
	if ( $current == 'table' ) $wptb_barid="";

    foreach( $tabs as $tab => $name ) {
    	if ( $tab == "faq" ) {
    		$css="ui-widget-content"; 
    		$font="18px;";
    	}
	    else if ( $tab == "table" ) {
    		$css="ui-state-default;";
       		$font="20px;background: #ece8da 50% 50% repeat-x; color: #433f38; font-weight: bold;"; 
    	}
    	else {
    		$css="ui-state-default"; 
    		$font="20px;"; 
    	}
    
    	
        if ( $tab == $current ) 
            $links[] = "<a class='".$css." ui-corner-top ui-tabs-selected ui-state-active ui-state-hover' style='text-decoration:none; padding: 0 10px 0 10px;' href='?page=wp-topbar.php&action=".$tab."'>$name</a>";
        else 
            $links[] = "<a class='".$css." ui-corner-top' style='font-size:".$font." font-weight:normal; padding: 0 10px 0 10px; text-decoration:none' href='?page=wp-topbar.php&action=".$tab."'>$name</a>";
        
    }
    echo '<h2>';
	foreach ($links as $i => $value) {
        echo $value;
		if ( $i == "5") echo "<br>";
	}
	
	if ( ! ( false  === ( $wptb_barid = get_transient( 'wptb_row_deleted' ) ) ) ) {
		echo '<div class="updated"><p><strong>'.$wptb_barid.' row deleted.</strong></p></div>';
		echo "deleted";
		delete_transient( 'wptb_row_deleted' );	  	 
	}
	
	
 	if ( ! ( false === ( $wptb_num_rows = get_transient( 'wptb_inserted_rows' ) ) ) ) {
		if ($wptb_num_rows == 1)	
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' row inserted.</strong></p></div>';
		else
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' rows inserted.</strong></p></div>';
		delete_transient( 'wptb_inserted_rows' );	  	    	}
 
/*
    $wptb_num_rows=get_transient( 'wptb_inserted_rows' );
    if ( $wptb_num_rows ) {
		if ($wptb_num_rows == 1)	
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' row inserted.</strong></p></div>';
		else
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' rows inserted.</strong></p></div>';
		delete_transient( 'wptb_inserted_rows' );	  	    
    }
*/
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>Plugin Homepage</a>";
    echo '</h2>';

}  // end function wptb_options_tabs


//=========================================================================			
// Build the tabs on top of the Edit pages 
//=========================================================================			


function wptb_bar_edit_options_tabs( $current = 'table', $wptb_barid ) {
    $tabs = array( 'table'=> 'All TopBars', 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','debug' => 'Debug', 'delete' => 'Delete&nbspSettings', 'faq' => 'FAQ' );
    $links = array();
    
	if ( $current == 'table' ) $wptb_barid="";

    foreach( $tabs as $tab => $name ) {
    	if ( $tab == "faq" ) {
    		$css="ui-widget-content"; 
    		$font="18px;";
    	}
    	 else if ( $tab == "table" ) {
    		$css="ui-state-default;";
       		$font="20px;background: #ece8da 50% 50% repeat-x; color: #433f38; font-weight: bold;"; 
    	}
    	else {
    		$css="ui-state-default"; 
    		$font="20px;"; 
    	}
    	
    	if ( $tab == 'table' ) 
    		$wptb_barid_action="";
    	else
			$wptb_barid_action="&barid=".$wptb_barid;


        if ( $tab == $current ) 
            $links[] = "<a class='".$css." ui-corner-top ui-tabs-selected ui-state-active ui-state-hover' style='text-decoration:none; padding: 0 10px 0 10px;' href='?page=wp-topbar.php&action=".$tab.$wptb_barid_action."'>$name</a>";
        else 
            $links[] = "<a class='".$css." ui-corner-top' style='font-size:".$font." font-weight:normal; padding: 0 10px 0 10px; text-decoration:none' href='?page=wp-topbar.php&action=".$tab.$wptb_barid_action."'>$name</a>";
        
    }
    echo '<h2>';
	foreach ($links as $i => $value) {
        echo $value;
		if ( $i == "4") echo "<br>";
		if ( $i == "9") echo "<br>";
	}
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>Plugin Homepage</a>";
    echo '</h2>';

}  // end function wptb_bar_edit_options_tabs



//=========================================================================			
// Display Top Of Admin Page
//=========================================================================			



function wptb_display_admin_header() {
		
	$wptb_debug=get_transient( 'wptb_debug' );	
		
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		WP-TopBar - Version 4.01</h2>
		<div class="postbox">
		<br>
		Creates TopBars that can be shown at the top of your website.  Version 4.01 is a massive, major, mondo upgrade that allows you to add multiple TopBars.  If all works well, previous users will have their existing options converted as their 1st TopBar.
		<br><br>
		Please <a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:20px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
if you find this plugin useful.

		<hr>

		</div>
		
	<?php 
	
}  // end function wptb_display_admin_header



//=========================================================================			
// Display Top Of Admin Page
//		
//=========================================================================			


function wptb_display_common_info($wptbOptions) {

	$wptb_debug=get_transient( 'wptb_debug' );	
	
	if($wptb_debug)
			wptb_debug_display_TopBar_Options($wptbOptions);
	
	if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc'] && $wptbOptions['end_time_utc'] != 0 ) {
		echo '<div class="error"><strong>End Time is before Start Time - TopBar will not display.</strong></div>';
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: End Time Before Start Time Error</code>';
	}

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Displaying Common Info</code>';
		   
	$wptb_cookie = "wptopbar_".COOKIEHASH;
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) 
		 _e( "<div class='error'><strong>You have a cookie with this browser that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the Close Button tab.</strong></div>", 'wptb' ); 

	?>
	
				<div class="postbox">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="error"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>
		<h3>Check<em><p style="font-weight:normal;">Time check: Based on your Start/End time settings in the Main Options,<?php if ($wptbOptions['enable_topbar'] == "false") { _e( ' when enabled,', 'wptb' ); } ?> the TopBar will <?php if (!wptb_check_time($wptbOptions['bar_id'])) echo "<strong>not</strong>"; ?> display (based on the current time.)
		<br><?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo "<br>Cookie check: The plugin is not checking for the presence of cookies.";
				  else
						if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] )  
							echo "<br>Cookie check: The TopBar is  checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the Close Button tab."; 
						else 
							echo "<br>Cookie check: The TopBar is  checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.";?>
		<br><?php switch ( $wptbOptions['show_homepage'] ) {
				
				case 'always':
					echo '<br>Home Page check: TopBar will <strong>ALWAYS</strong> display on the Home Page (if the TopBar is enabled)';
					break;
					
				case 'never':
					echo '<br>Home Page check: TopBar will <strong>NEVER</strong> display on the Home Page (if the TopBar is enabled)';
					break;

				case 'conditionally':
					echo '<br>Home Page check: TopBar will <strong>check</strong> Page/Category criteria to determine if it should display on the Home Page (if the TopBar is enabled)';
		}
		?>
		<br><?php
		switch ( $wptbOptions['include_logic'] ) {
					
				case 'page_only':
		
					echo '<br>Control check: TopBar is only checking for Page IDs (if any are entered and the TopBar is enabled)';
					break;
					
				case 'cat_only':
				
					echo '<br>Control check: TopBar is only checking for Categories IDs (if any are entered and the TopBar is enabled)';
					break;
					
				case 'boolean_and':
					
					echo '<br>Control check: TopBar is checking that Page IDs <strong>AND</strong> Category IDs (if any are entered and the TopBar is enabled)';
					break;
					
				case 'boolean_or':
						
					echo '<br>Control check: TopBar is checking that Page IDs <strong>OR</strong> Category IDs (if any are entered and the TopBar is enabled)';
					
		}

		
		?>

		</p>
		</em></h3>
		<h3>Live Preview of TopBar #: <?php echo $wptbOptions['bar_id'];?></h3>
		<div class="inside">
			<p class="sub"><strong>This is how the TopBar will appear on the website.</strong>
			<br>To test the TopBar on your site, you can set the Page IDs (on the <a href="?page=wp-topbar.php&action=control&barid=<?php echo $wptbOptions['bar_id']; ?>">Control tab</a>) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
			<br> The first black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>
			<div class="table">
				<table class="form-table">
					<tr valign="top">
							<div>
							<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />
							<?php wptb::wptb_display_TopBar("",$wptbOptions, false); ?>
							<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />
							</div> 
		 				</td>
					</tr>
				</table>
			</div>
			<div class="clear"></div>	
			</div>
		</div>
		<?php
}	// End of wptb_display_common_info
	

?>