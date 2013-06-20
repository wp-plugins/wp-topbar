<?php 

/*
Display Functions
*/


//=========================================================================			
// Build the tabs on top of the non-edit pages 
//=========================================================================			


function wptb_options_tabs( $current = 'table' ) {
    $tabs = array( 'table'=> 'All TopBars', 'testpriority' => 'Test Priority', 'bulkclosebutton'=> 'Close Button', 'export' => 'Export Options', 'uninstall' => 'Uninstall', 'mainfaq' => 'FAQ' );
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
            $links[] = "<a class='wptb-".$tab." ".$css." ui-corner-top ui-tabs-selected ui-state-active ui-state-hover' style='text-decoration:none; padding: 0 10px 0 10px;' href='?page=wp-topbar.php&action=".$tab."'>$name</a>";
        else 
            $links[] = "<a class='wptb-".$tab." ".$css." ui-corner-top' style='font-size:".$font." font-weight:normal; padding: 0 10px 0 10px; text-decoration:none' href='?page=wp-topbar.php&action=".$tab."'>$name</a>";
        
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

	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

//    $tabs = array( 'table'=> 'All TopBars', 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','debug' => 'Debug', 'delete' => 'Delete&nbspSettings', 'faq' => 'FAQ' );

    $tabs = array( 'table'=> 'All TopBars', 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons', 'phptexttab' => 'PHP',  'debug' => 'Debug', 'faq' => 'FAQ' );
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
			$wptb_barid_action="&barid=".($wptb_barid_prefix+$wptb_barid);


        if ( $tab == $current ) 
            $links[] = "<a class='wptb-".$tab." ".$css." ui-corner-top ui-tabs-selected ui-state-active ui-state-hover' style='text-decoration:none; padding: 0 10px 0 10px;' href='?page=wp-topbar.php&action=".$tab.$wptb_barid_action."'>$name</a>";
        else 
            $links[] = "<a class='wptb-".$tab." ".$css." ui-corner-top' style='font-size:".$font." font-weight:normal; padding: 0 10px 0 10px; text-decoration:none' href='?page=wp-topbar.php&action=".$tab.$wptb_barid_action."'>$name</a>";
        
    }
    echo '<h2>';
	foreach ($links as $i => $value) {
        echo $value;
		if ( $i == "4") echo "<br>";
		if ( $i == "10") echo "<br>";
	}
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>Plugin Homepage</a>";
    echo '</h2>';

}  // end function wptb_bar_edit_options_tabs



//=========================================================================			
// Display Top Of Admin Page
//=========================================================================			



function wptb_display_admin_header() {
		
		
	global $WPTB_VERSION;
		
	$wptb_debug=get_transient( 'wptb_debug' );	
		
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		WP-TopBar - Version <?php _e($WPTB_VERSION); ?></h2>
		<div class="postbox">
		<br>
		Creates TopBars that can be shown at the top of your website.  Version 4 is a massive, major, mondo upgrade that allows you to add multiple TopBars.
		<br><br>
		Please <a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:20px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
if you find this plugin useful.
		</br>
		<p class="wptb-pointer"></p>
		<hr>
		</div>
		<?php wp_nonce_field('wptb_update_setting_nonce','wptbupdatesettingnonce'); ?> 	

	<?php 
	
}  // end function wptb_display_admin_header



//=========================================================================			
// Display Top Of Admin Page
//		
//=========================================================================			


function wptb_display_common_info($wptbOptions) {

	$wptb_debug=get_transient( 'wptb_debug' );	
	
	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );
	
	if($wptb_debug)
			wptb_debug_display_TopBar_Options($wptbOptions);
	
	if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc'] && $wptbOptions['end_time_utc'] != 0 ) {
		echo '<div class="error"><strong>End Time is before Start Time - TopBar will not display.</strong></div>';
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: End Time Before Start Time Error</code>';
	}

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Displaying Common Info</code>';
	
	// 
	// Display Warning Messges for any possible incompatible plugin settings.
	// 
	
	if (($wptbOptions['topbar_pos'] == 'footer') && (strpos($wptbOptions['div_css'], "bottom") === false))
		_e( "<div class='error'><strong>You have set the TopBar Location to Below Footer (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#priority'>Main Options</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS Option C</a> may not be set correctly.<br>It should be something like <code>position:fixed; bottom: 0; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

	if (($wptbOptions['topbar_pos'] == 'header') && (strpos($wptbOptions['div_css'], "top") === false))
		_e( "<div class='error'><strong>You have set the TopBar Location to be Above Header (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#priority'>Main Options</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS Option C</a> may not be set correctly.<br>It should be something like <code>position: fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

	if (($wptbOptions['scroll_action'] == "on") && (strpos($wptbOptions['div_css'], "fixed") === false))
		_e( "<div class='error'><strong>You have turned on the Scroll Action option (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Main Options</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS Option C</a> may not be set correctly.<br>It should have it's position 'fixed' like <code>position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

//	if (($wptbOptions['allow_close'] == "yes") && (strpos($wptbOptions['div_css'], "fixed") === false))
//		_e( "<div class='error'><strong>You have turned allowed the user to close the Top Bar (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#allowclose'>Close Button tab</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS Option C</a> may not be set correctly.<br>It should have it's position 'fixed' like <code>position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 
	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['respect_cookie'] == 'always' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be re-opened (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) and have have Enabled Cookies.  Cookies are ignored if the TopBar is allowed to be re-opened.</strong></div>", 'wptb' ); 

		   
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND ( isset ($_COOKIE[$wptb_cookie])) ) 
	if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']  ) 
	 _e( "<div class='error'><strong>You have a cookie with this browser that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the Close Button tab.</strong></div>", 'wptb' ); 

	?>
	
				<div class="postbox">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="error"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>
		<h3>Check<em><p style="font-weight:normal;">Time check: Based on your Start/End time settings in the Main Options,<?php if ($wptbOptions['enable_topbar'] == "false") { _e( ' when enabled,', 'wptb' ); } ?> the TopBar will <?php if (!wptb_check_time($wptbOptions['bar_id'])) echo "<strong>not</strong>"; ?> display (based on the current time.)
		<br><?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo "<br>Cookie check: The plugin is not checking for the presence of cookies.";
				  else
						if  ( isset ($_COOKIE[$wptb_cookie]) AND ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) )
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
			<br>To test the TopBar on your site, you can set the Page IDs (on the <a href="?page=wp-topbar.php&action=control&barid=<?php echo ($wptbOptions['bar_id']+$wptb_barid_prefix); ?>">Control tab</a>) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
			<br> The first black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>
			<?php 
			if (isset( $_GET['action'] ) && ( $_GET['action'] == 'phptexttab' ) ) {
		        echo '
			<strong>IF THE TopBar IS NOT RENDERING CORRECTLY</strong> in the Preview section below and is breaking the page, then your custom PHP needs to be fixed.
</br>
<ul>You have two options to fix this:</br>
<li>1. Append <code>&nopreview</code> to the url when you are trying to edit a TopBar.  E.g. <a href="?page=wp-topbar.php&action=phptexttab&barid='.($wptbOptions['bar_id']+$wptb_barid_prefix).'&nopreview"><code>?page=wp-topbar.php&action=phptexttab&barid='.($wptbOptions['bar_id']+$wptb_barid_prefix).'&nopreview</code></a>.  Hit <code>enter</code> to reload the page. You should now be able to edit the custom php.</li>
<li>2. Go into your database tool (usually using phpMyAdmin), find the wp-topbar table and delete the offending row.</li>
</ul></br>';
			}
			?>
			<div class="table">
				<table class="form-table">
					<tr valign="top">
							<div>
							<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />
							<?php 
									if ((isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') &&
								        isset( $_GET['nopreview'] ) && current_user_can( 'manage_options' ) ) {
											unset($_GET['nopreview']);
											echo "<strong>Preview disabled</strong>";
										}
									else
										if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "on")
											wptb::wptb_display_TopBar('',$wptbOptions, false, 1, true);
										else 
											wptb::wptb_display_TopBar('',$wptbOptions, false, 1, false);
										?>

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
