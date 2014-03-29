<?php 

/*
Display Functions

i18n Compatible

*/


//=========================================================================			
// Build the tabs on top of the non-edit pages 
//=========================================================================			


function wptb_options_tabs( $current = 'table' ) {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if ( is_multisite() ) // remove Uninstall Option for Multi Site installs
	    $tabs = array( 'table'=> __('All TopBars','wp-topbar'), 'testpriority' => __('Test Priority','wp-topbar'), 'bulkclosebutton'=> __('Close Button','wp-topbar'), 'export' => __('Export Options','wp-topbar'), 'samples' => __('Sample TopBars','wp-topbar'), 'mainfaq' => __('FAQ','wp-topbar'), 'globalsettings' => __('Global Settings','wp-topbar') );
	else
	    $tabs = array( 'table'=> __('All TopBars','wp-topbar'), 'testpriority' => __('Test Priority','wp-topbar'), 'bulkclosebutton'=> __('Close Button','wp-topbar'), 'export' => __('Export Options','wp-topbar'), 'samples' => __('Sample TopBars','wp-topbar'), 'mainfaq' => __('FAQ','wp-topbar'), 'globalsettings' => __('Global Settings','wp-topbar'), 'uninstall' => __('Uninstall','wp-topbar'));
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
		if ( $i == "5") echo "<br/>";
	}
		
	$wptb_num_rows = get_transient( 'wptb_inserted_rows' );
	
 	if ( $wptb_num_rows ) {
 	
		if ($wptb_num_rows > 0) {
	        $wptb_i18n = sprintf( _n('%d row created.', '%d rows created.', $wptb_num_rows, 'wp-topbar'), $wptb_num_rows );
	        echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
		}	  
		delete_transient( 'wptb_inserted_rows' );	  	    	
	}
 
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>".__('Plugin Homepage','wp-topbar')."</a>";
    echo '</h2>';

}  // end function wptb_options_tabs


//=========================================================================			
// Build the tabs on top of the Edit pages 
//=========================================================================			


function wptb_bar_edit_options_tabs( $current = 'table', $wptb_barid, $wptbOptions ) {

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	

    $tabs = array( 'table'=> __('All TopBars','wp-topbar'), 'main' => __('Main&nbspOptions','wp-topbar'),  'control' => __('Control','wp-topbar'),  'topbartext' => __('TopBar&nbspText&nbsp&&nbspImage','wp-topbar'),  'topbarcss' => __('TopBar&nbspCSS&nbsp&&nbspHTML','wp-topbar'), 'colorselection' => __('Color&nbspSelection','wp-topbar'),'closebutton' => __('Close&nbspButton','wp-topbar'), 'socialbuttons' => __('Social&nbspButtons','wp-topbar'), 'phptexttab' => __('PHP','wp-topbar'),  'debug' => __('Debug','wp-topbar'), 'faq' => __('FAQ','wp-topbar') );
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
		if ( $i == "4") echo "<br/>";
		if ( $i == "10") echo "<br/>";
	}
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>".__('Plugin Homepage','wp-topbar')."</a>";
    echo '</h2>';
    if (( $current == "debug" ) || ( $current == "faq" ))
	  return;
    ?>

	<div class="postbox">

    			<table>

				<tr valign="middle">
					<td width="100"><strong><?php _e('Enable TopBar','wp-topbar'); ?>:</strong></td>
					<td>
				 	<p id="radio0" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbenabletopbar1" name="wptbenabletopbar" class="ui-helper-hidden-accessible" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { echo 'checked="checked"'; }?>><label for="wptbenabletopbar1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text"><?php _e('Yes','wp-topbar'); ?></span></label>
						<input type="radio" id="wptbenabletopbar2" name="wptbenabletopbar" class="ui-helper-hidden-accessible" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { echo 'checked="checked"'; }?>><label for="wptbenabletopbar2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text"><?php _e('No','wp-topbar'); ?></span></label>
					</p>
					</td>
					<td width="50">
					</td>
					<td>
						<?php 
					echo "<strong>".__("Time Check:")."</strong></td><td>";
					if (wptb_check_time($wptbOptions [ 'bar_id' ]))
						echo "<td data-value='0'><img title='Time Settings OK!' src='".plugins_url('/images/on.png', __FILE__)."'></td>";
					else
						echo "<td data-value='0'><img title='Time Settings preventing TopBar from showing' src='".plugins_url('/images/off.png', __FILE__)."'></td>";
					?>
					</td>
					<td width="50">
					</td>					
					<td>
					<?php
					echo "<strong>".__("Restrictions:")."</strong></td><td>";
					if ($wptbOptions['only_logged_in'] == "yes" ) 
						echo "<img title='Logged in Only' src='".plugins_url('/images/users_logged_in.png', __FILE__)."'>";
					else if ($wptbOptions['only_logged_in'] == "no" ) 
						echo "<img title='Not Lgged in Only' src='".plugins_url('/images/users_not_logged_in.png', __FILE__)."'>";
					else 
						echo "<img title='All Users' src='".plugins_url('/images/users_all.png', __FILE__)."'>";
			
					if ($wptbOptions['mobile_check'] == "only_mobile" ) 
						echo "<img title='Mobile Devices Only' src='".plugins_url('/images/devices_mobile.png', __FILE__)."'>";
					else if ($wptbOptions['mobile_check'] == "not_mobile" ) 
						echo "<img title='Not Mobile Devices Only' src='".plugins_url('/images/devices_not_mobile.png', __FILE__)."'>";
					else 
						echo "<img title='All Devices' src='".plugins_url('/images/devices_all.png', __FILE__)."'>";
			
					if ($wptbOptions['show_homepage'] == "always" ) 
						echo "<img title='Always on the Home Page' src='".plugins_url('/images/home_always.png', __FILE__)."'>";
					else if ($wptbOptions['show_homepage'] == "never" ) 
						echo "<img title='Never on the Home Page' src='".plugins_url('/images/home_never.png', __FILE__)."'>";
					else if ($wptbOptions['show_homepage'] == "conditionally" ) 
						echo "<img title='Conditionally on the Home Page' src='".plugins_url('/images/home_conditionally.png', __FILE__)."'>";
					else 
						echo "<img title='Only on the Home Page' src='".plugins_url('/images/home_only.png', __FILE__)."'>";
				?>
				</td>
				</tr>
				</table>
	</div>
				<?php
    

}  // end function wptb_bar_edit_options_tabs



//=========================================================================			
// Display Top Of Admin Page
//=========================================================================			



function wptb_display_admin_header() {
		
	global $WPTB_VERSION;
		
	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_admin_header()</code>';

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();

	if ($wptbGlobalOptions [ 'custom_samples_path' ] != "" && filter_var($wptbGlobalOptions [ 'custom_samples_path' ], FILTER_VALIDATE_URL) === FALSE ) 
		echo '<div class="error"><strong>'.__('The Custom Samples Directory is not a valid URL. To fix this go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=globalsettings'>".__('Global Settings tab','wp-topbar').'</a></strong></div>';
		
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php echo plugins_url('/images/banner-772x250.png', __FILE__); ?>" height="50" alt="TopBar Banner"/>
		<?php echo __('WP-TopBar - Version','wp-topbar').' '.$WPTB_VERSION; ?></h2>
		<div class="postbox">
		<br/>
		<?php _e('Creates TopBars that can be shown at the top of your website.  Version 5 adds ability to close TopBars and also gives you a Sample TopBar Tab that has starter TopBars that you can customize.','wp-topbar'); ?>
		<br/><br/>
		<?php echo _x('Please','part of please donate if you find this plugin useful', 'wp-topbar'); ?> <a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:20px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
<?php echo _x('if you find this plugin useful.', 'part of please donate if you find this plugin useful', 'wp-topbar'); ?>
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

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	
   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_common_info() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';
	
	if($wptb_debug)
			wptb_debug_display_TopBar_Options($wptbOptions);
	
	if (strtotime($wptbOptions['start_time_utc']) > strtotime($wptbOptions['end_time_utc']) && strtotime($wptbOptions['end_time_utc']) != 0 ) {
		echo '<div class="error"><strong>'.__('End Time is before Start Time - TopBar will not display.  To fix this go to the','wp-topbar')." <a href='?page=wp-topbar.php&action=control&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>".__('Control tab','wp-topbar').'</a></strong></div>';
		if($wptb_debug) echo '<br/><code>WP-TopBar Debug Mode: End Time Before Start Time Error</code>';
	}
		
	if($wptb_debug) echo '<br/><code>WP-TopBar Debug Mode: Displaying Common Info</code>';
	
	// 
	// Display Warning Messges for any possible incompatible plugin settings.
	// 
	
	if (($wptbGlobalOptions [ 'rotate_topbars' ] == "yes") && ($wptbOptions['scroll_action'] == "on")) 
		echo '<div class="error"><strong>'.__('You have allowed the Scroll Action on for this TopBar and have the Rotate TopBars turned on in the Global Settings tab. Scroll Action option is ignored if the TopBars are being rotated. To fix this go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Main Options tab','wp-topbar').'</a></strong></div>';


	if (($wptbGlobalOptions [ 'rotate_topbars' ] == "yes") && ($wptbOptions['allow_close'] == "yes")) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be closed and have the Rotate TopBars turned on in the Global Settings tab. Close buttons are ignored if the TopBars are being rotated. To fix this go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';

	if (($wptbGlobalOptions [ 'rotate_topbars' ] == "yes") && ($wptbOptions['allow_reopen'] == "yes"))
		echo '<div class="error"><strong>'.__('You have turned on the Re-Open TopBar option and have the Rotate TopBars turned on in the Global Settings tab. Re-open buttons are ignored if the TopBars are being rotated. To fix this go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';

	if (($wptbOptions['topbar_pos'] == 'footer') && (strpos($wptbOptions['div_css'], "bottom") === false))
		echo '<div class="error"><strong>'.__('You have set the TopBar Location to be Below Footer in the Main Options tab but the TopBar CSS & HTML Tab -  Option C may not be set correctly.  It should have a \'bottom:\' parameter like <code>position:fixed; bottom: 0; padding:0; margin:0; z-index: 99999;</code>  To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>".__('TopBar CSS & HTML Tab - Option C','wp-topbar').'</a></strong></div>'; 


	if (($wptbOptions['topbar_pos'] == 'header') && (strpos($wptbOptions['div_css'], "top") === false))
		echo '<div class="error"><strong>'.__('You have set the TopBar Location to be Above Header in the Main Options tab but the TopBar CSS & HTML Tab -  Option C may not be set correctly.  It should have a \'top:\' parameter like <code>position:fixed; top: 40; padding:0; margin:0; z-index: 99999;</code>  To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>".__('TopBar CSS & HTML Tab - Option C','wp-topbar').'</a></strong></div>';

	if (($wptbOptions['scroll_action'] == "on") && (strpos($wptbOptions['div_css'], "fixed") === false))
		echo '<div class="error"><strong>'.__('You have turned on the Scroll Action option in the Main Options tab but the TopBar CSS & HTML Tab -  Option C may not be set correctly.  It should have it\s position \'fixed\' like <code>position:fixed; top: 40; padding:0; margin:0; z-index: 99999;</code>  To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>".__('TopBar CSS & HTML Tab - Option C','wp-topbar').'</a></strong></div>';; 

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['respect_cookie'] == 'always' ) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be re-opened and have have Enabled Cookies.  Cookies are ignored if the TopBar is allowed to be re-opened. To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';  

	if (((isset($wptbOptions['allow_close']) && ($wptbOptions['allow_close']) == "yes") ||  (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" )) && $wptbOptions['close_button_css'] == '' ) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be closed but no close button CSS is entered for this TopBar on the same option page. To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';  

	if (((isset($wptbOptions['allow_close']) && ($wptbOptions['allow_close']) == "yes") ||  (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" )) && $wptbOptions['close_button_image'] == '' ) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be closed but no close button image has been entered for this TopBar. To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';  

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['reopen_button_css'] == '' ) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be re-opened but no re-open button CSS is entered for this TopBar on the same option page.  Re-open button will not work without (at least) the default CSS entered.  To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>'; 

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['reopen_button_image'] == '' ) 
		echo '<div class="error"><strong>'.__('You have allowed the TopBar to be re-opened but no re-open button image has been entered for this TopBar. To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>".__('Close Button tab','wp-topbar').'</a></strong></div>';

	if (isset($wptbOptions['enable_image']) && ($wptbOptions['enable_image']) == "true" && $wptbOptions['bar_image'] == '' ) 
		echo '<div class="error"><strong>'.__('You have enabled a bar image but no image has been entered for this TopBar. To fix this go to the', 'wp-topbar' )." <a href='?page=wp-topbar.php&action=topbartext&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>".__('TopBar Text & Image tab','wp-topbar').'</a></strong></div>'; 

	for ($i=1; $i<=10; $i++)  {
		if (isset($wptbOptions['social_icon'.$i]) && ($wptbOptions['social_icon'.$i]) == "on" && $wptbOptions['social_icon'.$i.'_image'] == '' ) 
			echo '<div class="error"><strong>'.sprintf(__('You have enabled an image for Social Button # %d but no image has been entered for this Social Button. To fix this go to the','wp-topbar'),$i)." <a href='?page=wp-topbar.php&action=socialbuttons&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>".__('Social Buttons tab','wp-topbar').'</a></strong></div>'; 
	}


	// 
	// end of Warning Messges
	// 

	if ( $wptbGlobalOptions [ 'rotate_topbars' ] == "yes" ) {				// force these to off/no if Rotate is turned on
		$wptbOptions['scroll_action'] = "off";
		$wptbOptions['allow_reopen'] = "no";
		$wptbOptions['allow_close'] = "no";
	}
	
		   
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND ( isset ($_COOKIE[$wptb_cookie])) ) 
	if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']  ) 
	 echo '<div class=\'error\'><strong>'.__( 'You have a cookie with this browser that will prevent the TopBar from showing.  To show the TopBar, clear your browser\'s cookies, change the Cookie Value, or disable cookies in the Close Button tab.', 'wp-topbar' ).'</strong></div>'; 

	?>
	
				<div class="postbox">
		<?php if ($wptbOptions['enable_topbar'] == "false") { echo '<div class="error"><strong>'.__('TopBar is not enabled.','wp-topbar').'</strong></div>'; } ?>
		<h3><?php _e('Check','wp-topbar'); ?>
		<p style="font-weight:normal;">
		<?php 
		
		if ( $wptbOptions['enable_topbar'] == "false" ) 
			if ( wptb_check_time($wptbOptions['bar_id'] ) )
				echo '<strong>'.__('Time check','wp-topbar').':</strong>'.__(' Based on your Start/End time settings in the Main Options, (when enabled) the TopBar will display (based on the current time.)','wp-topbar');
			else
				echo '<strong>'.__('Time check','wp-topbar').':</strong>'.__(' Based on your Start/End time settings in the Main Options, (when enabled) the TopBar will <strong>not</strong> display (based on the current time.)','wp-topbar');
		else
			if ( wptb_check_time($wptbOptions['bar_id'] ) )
				echo '<strong>'.__('Time check','wp-topbar').':</strong>'.__(' Based on your Start/End time settings in the Main Options, the TopBar will display (based on the current time.)','wp-topbar');
			else
				echo '<strong>'.__('Time check','wp-topbar').':</strong>'.__(' Based on your Start/End time settings in the Main Options, the TopBar will <strong>not</strong> display (based on the current time.)','wp-topbar');

		echo '<br/>';
		
		 if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo '<br/><strong>'.__('Cookie check','wp-topbar').':</strong>'.__(' The plugin is not checking for the presence of cookies.','wp-topbar');
				  else
						if  ( isset ($_COOKIE[$wptb_cookie]) AND ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) )
							echo '<br/><strong>'.__('Cookie check','wp-topbar').':</strong>'.__(' The TopBar is checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser\'s cookies, change the Cookie Value, or disable cookies in the Close Button tab.','wp-topbar'); 
						else 
							echo '<br/><strong>'.__('Cookie check','wp-topbar').':</strong>'.__(' The TopBar is checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.','wp-topbar');?>
		<br/><?php switch ( $wptbOptions['show_homepage'] ) {
				
				case 'always':
					echo '<br/><strong>'.__('Home Page check','wp-topbar').':</strong>'.__(' TopBar will <strong>ALWAYS</strong> display on the Home Page (if the TopBar is enabled)','wp-topbar');
					break;
					
				case 'never':
					echo '<br/><strong>'.__('Home Page check','wp-topbar').':</strong>'.__(' TopBar will <strong>NEVER</strong> display on the Home Page (if the TopBar is enabled)','wp-topbar');
					break;

				case 'conditionally':
					echo '<br/><strong>'.__('Home Page check','wp-topbar').':</strong>'.__(' TopBar will <strong>CHECK</strong> Page/Category criteria to determine if it should display on the Home Page (if the TopBar is enabled)','wp-topbar');
		}

		echo '<br/>';

		switch ( $wptbOptions['include_logic'] ) {
					
				case 'page_only':
		
					echo '<br/><strong>'.__('Control check','wp-topbar').':</strong>'.__(' TopBar is only checking for Page IDs (if any are entered and the TopBar is enabled)','wp-topbar');
					break;
					
				case 'cat_only':
				
					echo '<br/><strong>'.__('Control check','wp-topbar').':</strong>'.__(' TopBar is only checking for Categories IDs (if any are entered and the TopBar is enabled)','wp-topbar');
					break;
					
				case 'boolean_and':
					
					echo '<br/><strong>'.__('Control check','wp-topbar').':</strong>'.__(' TopBar is checking that Page IDs <strong>AND</strong> Category IDs (if any are entered and the TopBar is enabled)','wp-topbar');
					break;
					
				case 'boolean_or':
						
					echo '<br/><strong>'.__('Control check','wp-topbar').':</strong>'.__(' TopBar is checking that Page IDs <strong>OR</strong> Category IDs (if any are entered and the TopBar is enabled)','wp-topbar');
					
		}

		
		?>

		</p>
		</em></h3>
		<h3><?php echo __('Live Preview of TopBar #:','wp-topbar').' '.$wptbOptions['bar_id'];?></h3>
		<div class="inside">
			<p class="sub"><strong><?php _e('This is how the TopBar will appear on the website.','wp-topbar'); ?></strong>
			<br/><?php _e('To test the TopBar on your site, you can set the Page IDs (on the','wp-topbar'); ?> <a href="?page=wp-topbar.php&action=control&barid=<?php echo ($wptbOptions['bar_id']+$wptb_barid_prefix); ?>"><?php _e('Control tab','wp-topbar'); ?></a>) <?php _e('to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.'.
			'<br/> The first black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>','wp-topbar'); ?>
			<?php 
			if ( $wptbGlobalOptions [ 'rotate_topbars' ] == "yes" ) 
				echo __('The <strong>Rotate TopBars</strong> option is turned on in the','wp-topbar')." <a href='?page=wp-topbar.php&action=globalsettings'>".__('Global Settings tab','wp-topbar')."</a>.  ".__('With this turned ON, the Scrollable, Close Button, and Re-Open options are <strong>ignored and turned off</strong>.','wp-topbar').'<br/><br/>';
			if (isset( $_GET['action'] ) && ( $_GET['action'] == 'phptexttab' ) ) {
		        echo __('<strong>IF THE TopBar IS NOT RENDERING CORRECTLY</strong> in the Preview section below and is breaking the page, then your custom PHP needs to be fixed','wp-topbar').'</br><ul>'.__('You have two options To fix this this:','wp-topbar').
'<br/><li>1. '.__('Append','wp-topbar').'&nbsp;<code>&nopreview</code>&nbsp;'.__('to the url when you are trying to edit a TopBar.  e.g.','wp-topbar').' <a href="?page=wp-topbar.php&action=phptexttab&barid='.($wptbOptions['bar_id']+$wptb_barid_prefix).'&nopreview"><code>?page=wp-topbar.php&action=phptexttab&barid='.($wptbOptions['bar_id']+$wptb_barid_prefix).'&nopreview</code></a>.  '.__('Hit <code>enter</code> to reload the page. You should now be able to edit the custom php.','wp-topbar').'</li><li>2. '.
__('Go into your database tool (usually using phpMyAdmin), find the wp-topbar table and delete the offending row.','wp-topbar').'</li></ul></br>';
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


//=========================================================================		
//  Display the All topbars table
//
//=========================================================================		
function wptb_display_all_TopBars() {

	wptb_display_all_TopBarsFooTable();
//	wptb_display_all_TopBarsWP();

}

function wptb_display_all_TopBarsFooTable() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_all_TopBars()</code>';

	 //Prepare Table of elements

	global $WPTB_DB_VERSION;
	global $wpdb;

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	
   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );


	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	$wptb_rows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name);
	$wptb_num_rows = $wpdb->num_rows;
	if ( $wptb_num_rows == 0 ){
		$wptbOptions=wptb_insert_default_row($WPTB_DB_VERSION);
		echo '<div class="updated"><p><strong>'.__('All TopBars deleted; created default TopBar.','wp-topbar').'</strong></p></div>';
		$wptb_num_rows=1;
	}
	$query = "SELECT *,  ((start_delta <= 0 ) AND (end_delta <=0 )) as show_it, concat(bar_text, '<br/>',bar_link_text) as text_line
			  		FROM (
				
		SELECT 	*,	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 0)."',  '%Y-%m-%d %H:%i' ), 0), 
											COALESCE(STR_TO_DATE(  `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) as start_delta, 
					COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
											COALESCE(STR_TO_DATE(  '".current_time('mysql', 0)."',  '%Y-%m-%d %H:%i' ), 0)),0) as end_delta
					
					FROM ".$wptb_table_name."
					ORDER BY bar_id asc
					) as Table1;";

	$data = $wpdb->get_results($query, ARRAY_A);   	
	?>
	
<style media="screen" type="text/css">
	.wptbactions {
	    visibility:hidden;
	}
</style>
	
	
    <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><?php _e('Listing of all TopBars','wp-topbar'); ?></h2>
        <?php 	if ( ! isset($wptbGlobalOptions [ 'show_overview' ]) || $wptbGlobalOptions [ 'show_overview' ] == "on") { ?>
        <table style="background:white;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
			<tr valign="top" >
			<td width="400" bgcolor="#bcfbc5" align="center">
			<strong><?php _e('Overview','wp-topbar'); ?></strong>
			</td>
			<td width="5">
			</td>
			<td bgcolor="#e2f8b9" align="center">
	        <strong><?php _e('Step-by-Step','wp-topbar'); ?></strong>
			</td>
 			</tr>	
			<tr valign="top" >
			<td width="400">
            <?php _e('Select a TopBar to edit.  You can also enable, disable, bulk duplicate or delete your TopBars from here.'.
	        '<br /><br />Use the','wp-topbar'); ?> <strong><a href='?page=wp-topbar.php&action=testpriority'><?php _e('Test Priority tab','wp-topbar'); ?></a></strong> <?php _e('to see how the plugin will randomly select 10 TopBars.'.
	        '<br /><br />The table below shows you the Priority and Start/Stop times for each TopBar.  It also tells you if a TopBar will show based on the current time and if that TopBar is enabled.   It will also show you if it will show only for logged in users or all users.'.
			'<br /><br />Use the','wp-topbar'); ?> <strong><a href='?page=wp-topbar.php&action=globalsettings'><?php _e('Global Settings tab','wp-topbar'); ?></a></strong> <?php _e('to affect how all TopBars are processed.','wp-topbar'); ?> 
			</td>
			<td width="5" bgcolor="grey">
			</td>
			<td>
	        <?php _e('1.  Select the TopBar to edit by hovering over the row and selecting the Main Options link.'.   
	        '<br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>'.
	        '<br />&nbsp&nbsp&nbsp&nbspHit the <strong>Create Default Row</strong> button below to insert a default TopBar at end of the table.  Find it and edit it.'.
	        '<br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>'.
	        '<br />&nbsp&nbsp&nbsp&nbspGo to the','wp-topbar'); ?> <strong><a href="?page=wp-topbar.php&action=samples"><?php _e('Sample TopBar tab','wp-topbar'); ?></a></strong> <?php _e('(above) and select one or more TopBars to add to the table below.'. 
	        '<br />2.  Change the various options to configure the TopBar, using the Tabs to setup how the TopBar looks.  Explore each tab to see all the options.'.
	        '<br />3.  Go back to the Main Options tab and toggle the Enable switch to allow the TopBar to be shown.'.
	        '<br />4.  Go back to the All TopBars tab to add more TopBars. Add and customize as many TopBars as you need.'.
	        '<br />5.  Now, every time a web page is displayed, the plugin builds all of the TopBars that match the Control Tab and Time criteria.'.
	     	'<br />&nbsp&nbsp&nbsp&nbspA TopBar is randomly selected (although, the Priority Weighting can be used to give one TopBar more preference than another.)'.  
	     	'<br />&nbsp&nbsp&nbsp&nbspThey are built in such a way that your cacheing plugin will cache the results.','wp-topbar'); ?><td>
			</td>
 			</tr>	
		</table>
		<?php } ?>

		<p class="submit">
		<input type="submit" class="button-primary" name=wptbInsertBar value="<?php _e('Create Default Row', 'wp-topbar') ?>" />
		</p>
 <div class="tab-pane active" id="demo">
      <p >
		<strong>Bulk Actions</strong>: <select id="selectOpt">
		<option></option>
		<?php 
			echo '<option value="bulkdelete">'.__('Delete','wp-topbar')."</option>";
			echo '<option value="bulkduplicate">'.__('Duplicate','wp-topbar')."</option>";
			echo '<option value="bulkenable">'.__('Enable','wp-topbar')."</option>";
			echo '<option value="bulkdisable">'.__('Disable','wp-topbar')."</option>";
			echo '<option value="bulkincrease">'.__('Increase Priority by 10','wp-topbar')."</option>";
			echo '<option value="bulkdecrease">'.__('Decrease Priority by 10','wp-topbar')."</option>";
         ?>  
        </select>
        <button type="button" onclick="processCheckBoxes()">Apply</button>
&nbsp;&nbsp;&nbsp;
        <strong>Search</strong>: <input id="filter" type="text">
        <form id="topbar-filter" name="addform" method="get">
  	    <table data-filter="#filter" data-filter-disable-enter="true" data-page-size="20" id="footable">		
	    <thead>
			<tr>
		        <th data-sort-ignore="true" data-ignore="true"><input type="checkbox" id="chk_new"  onclick="checkAll('chk');" ></th>
				<th data-class="expand">ID</th>
		        <th data-sort-ignore="true" data-ignore="true"></th>
		        <?php 
				echo "<th>".__('Priority')."</th>";
				echo "<th>".__('Start<br/>Time')."</th>";
				echo "<th>".__('End<br/>Time')."</th>";
				echo "<th>".__('Time<br/>Check')."</th>";
				echo "<th>".__('Enabled')."</th>";
				echo '<th data-sort-ignore="true" data-ignore="true">'.__('Restrictions')."</th>";
				echo "<th>".__('Sample')."</th>";
				?>
			</tr>
		</thead>
		<tbody>
		
    <?php 

	foreach ( $data as $wptbOptions ) {	
			
		echo '<tr class="wptbrow" style="vertical-align: top;">';
		echo '<td data-ignore="true"><input type="checkbox"  class="wptbCheckBox" value="'.($wptbOptions['bar_id']+0).'"></td>';
		echo '<td data-type="numeric" data-value="'.($wptbOptions['bar_id']+0).'">'.$wptbOptions['bar_id']."</td>";
		echo '<td data-ignore="true">';	
		
        $tabs = array( 'main' => __('Main&nbspOptions','wp-topbar'),  'control' => __('Control','wp-topbar'),  'topbartext' => __('TopBar&nbspText&nbsp&&nbspImage','wp-topbar'),  'topbarcss' => __('TopBar&nbspCSS&nbsp&&nbspHTML','wp-topbar'), 'colorselection' => __('Color&nbspSelection','wp-topbar'),'closebutton' => __('Close&nbspButton','wp-topbar'), 'socialbuttons' => __('Social&nbspButtons','wp-topbar'),'phptexttab' => __('PHP','wp-topbar'), 'debug' => __('Debug','wp-topbar') );    

        //Build row actions
		$options = "<option>Actions...</option>";
		
        if ( $wptbOptions['enable_topbar'] == "false" ) {
	        $actions = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true">'.__('Enable','wp-topbar').'</a>',$_REQUEST['page'],'enable',($wptbOptions['bar_id']+$wptb_barid_prefix))."<br/>";
	        $options .= "<option value='".sprintf('?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true',$_REQUEST['page'],'enable',($wptbOptions['bar_id']+$wptb_barid_prefix))."'>".__('Enable','wp-topbar')."</options>";
        }
        else {
	        $actions = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true">'.__('Disable','wp-topbar').'</a>',$_REQUEST['page'],'disable',($wptbOptions['bar_id']+$wptb_barid_prefix))."<br/>";	        
	        $options .= "<option value='".sprintf('?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true',$_REQUEST['page'],'disable',($wptbOptions['bar_id']+$wptb_barid_prefix))."'>".__('Disable','wp-topbar')."</options>";	        
        }
                
        $actions .= sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true">'.__('Duplicate','wp-topbar').'</a>',$_REQUEST['page'],'duplicate',($wptbOptions['bar_id']+$wptb_barid_prefix))."<br/>";
        $options .= "<option value='".sprintf('?page=%s&amp;action=%s&amp;barid=%s&amp;noheader=true',$_REQUEST['page'],'duplicate',($wptbOptions['bar_id']+$wptb_barid_prefix))."'>".__('Duplicate','wp-topbar').'</options>';

        foreach( $tabs as $tab => $name ) {
        	$actions .= sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s">%s</a>',$_REQUEST['page'],$tab,($wptbOptions['bar_id']+$wptb_barid_prefix), $name)."<br/>";
	        $options .= "<option value='".sprintf('?page=%s&amp;action=%s&amp;barid=%s',$_REQUEST['page'],$tab,($wptbOptions['bar_id']+$wptb_barid_prefix))."'>".$name.'</options>';
        }

		echo '<select class="rowoptions">'.$options.'</select>';

//		echo '<p class="wptbactions">'.sprintf('%1$s',$actions).'</p>';
        		
		echo '</td>';
		
		echo '<td width="100" data-type="numeric" data-value="'.($wptbOptions['weighting_points']+0).'">'.$wptbOptions['weighting_points']."<br/><img height='22px' width='".($wptbOptions['weighting_points']+0)."%' src='".plugins_url('/images/priority.png', __FILE__)."' /></td>";		
		
		if ($wptbOptions['start_time'] == 0) 
			echo '<td data-value="0">N/A</td>';
		else 
			echo '<td data-value="'.date('Y-m-d-H:i:s',strtotime($wptbOptions['start_time'])).'">'.$wptbOptions['start_time'].'</td>';

		if ($wptbOptions['end_time'] == 0) 
			echo '<td data-value="9999-99-99-24:00:00:00">N/A</td>';
		else 
			echo '<td data-value="'.date('Y-m-d-H:i:s',strtotime($wptbOptions['end_time'])).'">'.$wptbOptions['end_time'].'</td>';
		
		
		if ($wptbOptions['show_it'] == 0 )							
			echo "<td data-value='0'><img title='Time Settings preventing TopBar from showing' src='".plugins_url('/images/off.png', __FILE__)."'></td>";
		else
			echo "<td data-value='1'><img title='Time Settings OK!' src='".plugins_url('/images/on.png', __FILE__)."'></td>";
			
		if ($wptbOptions['enable_topbar'] == 'false')								
			echo "<td data-value='0'><img title='Disabled' src='".plugins_url('/images/off.png', __FILE__)."'></td>";
		else
			echo "<td data-value='1'><img title='Enabled' src='".plugins_url('/images/on.png', __FILE__)."'></td>";

		echo '<td width="96">';
		if ($wptbOptions['only_logged_in'] == "yes" ) 
			echo "<img title='Logged in Only' src='".plugins_url('/images/users_logged_in.png', __FILE__)."'>";
		else if ($wptbOptions['only_logged_in'] == "no" ) 
			echo "<img title='Not Lgged in Only' src='".plugins_url('/images/users_not_logged_in.png', __FILE__)."'>";
		else 
			echo "<img title='All Users' src='".plugins_url('/images/users_all.png', __FILE__)."'>";

		if ($wptbOptions['mobile_check'] == "only_mobile" ) 
			echo "<img title='Mobile Devices Only' src='".plugins_url('/images/devices_mobile.png', __FILE__)."'>";
		else if ($wptbOptions['mobile_check'] == "not_mobile" ) 
			echo "<img title='Not Mobile Devices Only' src='".plugins_url('/images/devices_not_mobile.png', __FILE__)."'>";
		else 
			echo "<img title='All Devices' src='".plugins_url('/images/devices_all.png', __FILE__)."'>";

		if ($wptbOptions['show_homepage'] == "always" ) 
			echo "<img title='Always on the Home Page' src='".plugins_url('/images/home_always.png', __FILE__)."'>";
		else if ($wptbOptions['show_homepage'] == "never" ) 
			echo "<img title='Never on the Home Page' src='".plugins_url('/images/home_never.png', __FILE__)."'>";
		else if ($wptbOptions['show_homepage'] == "conditionally" ) 
			echo "<img title='Conditionally on the Home Page' src='".plugins_url('/images/home_conditionally.png', __FILE__)."'>";
		else 
			echo "<img title='Only on the Home Page' src='".plugins_url('/images/home_only.png', __FILE__)."'>";
		echo '</td>';
	
		echo '<td>';

		if ( $wptbGlobalOptions [ 'rotate_topbars' ] == "yes" ) {				// force these to off/no if Rotate is turned on
			$$wptbOptions['scroll_action'] = "off";
			$wptbOptions['allow_reopen'] = "no";
			$wptbOptions['allow_close'] = "no";
		}		
				
		if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('',$wptbOptions, false, 1, true);
		else 
			wptb::wptb_display_TopBar('',$wptbOptions, false, 1, false);		
		
		echo '</td>';
		
		echo '</div></tr>';
	}

	?>
		</tbody>
	<tfoot>
		<tr>
			<td colspan="5">
				<div class="pagination pagination-centered hide-if-no-paging"></div>
			</td>
		</tr>
	</tfoot>		
	</table>
    <p style='font-style:italic; text-align:right;'>
	<?php echo sprintf( _n('%d TopBar', '%d TopBars', $wptb_num_rows, 'wp-topbar'), $wptb_num_rows ); ?>
	</p>

	
    </form>
    </div>	
    </div>	
	
	<?php


} 
    

function wptb_process_FOO_bulk_action() {

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : array();

   	switch ( $action ) {
	case "bulkincrease":	
			global $wpdb;
			$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();

            if (!empty($barids)) {
                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`+10 WHERE bar_id IN($barids)");
                $n = $wpdb->rows_affected;
                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 100 WHERE `weighting_points` > 100");
	  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row changed priority by +10.', '%d rows changed priority by +10.', $n, 'wp-topbar'), $n );
	                $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		              
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
					echo $wptb_message;
	  				}	
            }
			break;

	case "bulkdecrease":	
			global $wpdb;
			$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();

            if (!empty($barids)) {
                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`-10 WHERE bar_id IN($barids)");
                $n = $wpdb->rows_affected;
                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 1 WHERE `weighting_points` < 1");
	  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row changed priority by -10.', '%d rows changed priority by -10.', $n, 'wp-topbar'), $n );
	                $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
					echo $wptb_message;
	  				}
            }
			break;
							
	case "bulkdisable":	
			global $wpdb;
			$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();

            if (!empty($barids)) {
                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'false' WHERE bar_id IN($barids)");
                $n = $wpdb->rows_affected;
	  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row disabled.', '%d rows disabled.', $n, 'wp-topbar'), $n );
	                $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
					echo $wptb_message;
	  				}
            }
			break;

	case "bulkenable": 
			global $wpdb;
			$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();

            if (!empty($barids)) {
                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'true' WHERE bar_id IN($barids)");
                $n = $wpdb->rows_affected;
	  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row enabled.', '%d rows enabled.', $n, 'wp-topbar'), $n );
	                $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
					echo $wptb_message;
	  				}	            }
			break;

	case "bulkdelete": 
			global $wpdb;
			$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	        $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();

	        if (!empty($barids)) {
	            $wpdb->query("DELETE FROM $wptb_table_name WHERE `bar_id` IN($barids)");
	            $n = $wpdb->rows_affected;
	  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row deleted.', '%d rows deleted.', $n, 'wp-topbar'), $n );
	                $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
					echo $wptb_message;
				}
	         }
			break;
			
	case "bulkduplicate":
			$barid = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
			$barids = explode(",", $barid);
            $n = count($barids);
            if (is_array($barids)) {
				foreach ($barids as $key => $barid) {
				  	$wptbOptions=wptb_get_Specific_TopBar($barid);
		  			$wptbOptions['enable_topbar']='false';
		  			wptb_insert_row($wptbOptions);
		  		}
		  	}
			if ($n > 0) {
            $wptb_i18n = sprintf( _n('%d row duplicated.', '%d rows duplicated.', $n, 'wp-topbar'), $n );
            $wptb_message='<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
//    				set_transient( 'wptb_message', $wptb_message, 60 );	
				echo $wptb_message;
			}	  
	}
}


	 


//=========================================================================		
//  Display the All topbars table
//
//=========================================================================		

function wptb_display_all_TopBarsWP() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_all_TopBars()</code>';


	//Our class extends the WP_List_Table class, so we need to make sure that it's there
	if(!class_exists('WP_List_Table')){
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	class wptb_All_TopBar_Table extends WP_List_Table {

	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	 function __construct() {
		 parent::__construct( array(
		'singular'=> 'barid', //Singular label
		'plural' => 'barids', //plural label, also this well be one of the table css class
		'ajax'	=> false //We won't support Ajax for this table
		) );
	 }
    /**************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['bar_id']                //The value of the checkbox should be the record's id
        );
    }
	 /**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return $columns= array(
			'cb' => '<input type="checkbox" />',
			'bar_id' => __('ID','wp-topbar'),
			'weighting_points' => __('Priority','wp-topbar'),
			'start_time' => __('Start Time','wp-topbar'),
			'end_time' => __('End Time','wp-topbar'),
			'show_it' => __('Time Check','wp-topbar'),
			'enable_topbar' => __('Enabled?','wp-topbar'),
			'show_homepage' => __('Home Page Check?', 'wp-topbar'),
			'only_logged_in' => __('Logged In Users Only?','wp-topbar'),
			'mobile_check' => __('Mobile?','wp-topbar')
//			'text_line' => 'Bar and Link Text'
		);
	}
	    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){

   	switch ( $column_name ) {
			case "bar_id":	
					return	$item[$column_name];	
					break;
			case "text_line": return stripslashes($item[$column_name]);
			case "only_logged_in":
				if ($item[$column_name] == "yes" ) 
					return "<img title='Logged in Only' src='".plugins_url('/images/users_logged_in.png', __FILE__)."'>";
				else if ($item[$column_name] == "no" ) 
					return "<img title='Not Lgged in Only' src='".plugins_url('/images/users_not_logged_in.png', __FILE__)."'>";
				else 
					return "<img title='All Users' src='".plugins_url('/images/users_all.png', __FILE__)."'>";
				break;			
			case "mobile_check":
				if ($item[$column_name] == "only_mobile" ) 
					return "<img title='Mobile Devices Only' src='".plugins_url('/images/devices_mobile.png', __FILE__)."'>";
				else if ($item[$column_name] == "not_mobile" ) 
					return "<img title='Not Mobile Devices Only' src='".plugins_url('/images/devices_not_mobile.png', __FILE__)."'>";
				else 
					return "<img title='All Devices' src='".plugins_url('/images/devices_all.png', __FILE__)."'>";
				break;	
			case "weighting_points": 
				$width=$item[$column_name]+0;
//				return $item[$column_name];
				echo $item[$column_name]."<br/><img height='22px' width='".$width."%' src='".plugins_url('/images/priority.png', __FILE__)."' />";
				return;

			case "enable_topbar": 
				if ($item[$column_name] == 'false')	
				
					return "<img title='Disabled' src='".plugins_url('/images/off.png', __FILE__)."'>";
				else
					return "<img title='Enabled' src='".plugins_url('/images/on.png', __FILE__)."'>";
				break;
			case "show_it": 
				if ($item[$column_name] == 0 )
					return "<img title='Time Settings preventing TopBar from showing' src='".plugins_url('/images/off.png', __FILE__)."'>";
				else
					return "<img title='Time Settings OK!' src='".plugins_url('/images/on.png', __FILE__)."'>";
				break;
			case 'show_homepage':
				if ($item[$column_name] == "always" ) 
					return "<img title='Always on the Home Page' src='".plugins_url('/images/home_always.png', __FILE__)."'>";
				else if ($item[$column_name] == "never" ) 
					return "<img title='Never on the Home Page' src='".plugins_url('/images/home_never.png', __FILE__)."'>";
				else if ($item[$column_name] == "conditionally" ) 
					return "<img title='Conditionally on the Home Page' src='".plugins_url('/images/home_conditionally.png', __FILE__)."'>";
				else 
					return "<img title='Only on the Home Page' src='".plugins_url('/images/home_only.png', __FILE__)."'>";			
				break;
			case "start_time": 
			case "end_time": 
			
				if ($item[$column_name] == 0) 
					return "N/A";
				else 
					return $item[$column_name];
					
			default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
		}
    }
    
    

        
    /** ************************************************************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'. Every time the class
     * needs to render a column, it first looks for a method named 
     * column_{$column_title} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_bar_id($item){
        
       	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
       	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
       	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );


        
	    if ( isset ( $_GET['paged'] ) )
	        $current_page = '&paged='.$_GET['paged'];
	    else
	        $current_page = '';    
	        	        
        $tabs = array( 'main' => __('Main&nbspOptions','wp-topbar'),  'control' => __('Control','wp-topbar'),  'topbartext' => __('TopBar&nbspText&nbsp&&nbspImage','wp-topbar'),  'topbarcss' => __('TopBar&nbspCSS&nbsp&&nbspHTML','wp-topbar'), 'colorselection' => __('Color&nbspSelection','wp-topbar'),'closebutton' => __('Close&nbspButton','wp-topbar'), 'socialbuttons' => __('Social&nbspButtons','wp-topbar'),'phptexttab' => __('PHP','wp-topbar'), 'debug' => __('Debug','wp-topbar') );    

        //Build row actions

        if ( $item['enable_topbar'] == "false" ) {
	        $actions = array('enable'    => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">'.__('Enable','wp-topbar').'</a>',$_REQUEST['page'],'enable',($item['bar_id']+$wptb_barid_prefix), $current_page));
        }
        else {
	        $actions = array('disable'   => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">'.__('Disable','wp-topbar').'</a>',$_REQUEST['page'],'disable',($item['bar_id']+$wptb_barid_prefix), $current_page));	        
        }
        
        $actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">'.__('Duplicate','wp-topbar').'</a>',$_REQUEST['page'],'duplicate',($item['bar_id']+$wptb_barid_prefix), $current_page);

        foreach( $tabs as $tab => $name ) {
        	$actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s">%s</a>',$_REQUEST['page'],$tab,($item['bar_id']+$wptb_barid_prefix), $current_page, $name);
        }

        return sprintf('%1$s %2$s',
            /*$2%s*/ $item['bar_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }	
    
    function no_items() {
	    echo '<br/><strong>'.__('No TopBars to show - if none exist will create default TopBar.','wp-topbar').'</strong><br/>	';
	    return;
    }
    
    
    function single_row( $item ) {
		static $row_class = '';
		$row_class = ( $row_class == '' ? ' class="alternate"' : '' );

		echo '<tr' . $row_class . 'style="border-bottom-style:none;"'.'>';
		echo $this->single_row_columns( $item );
		echo '</tr>';
		echo '<tr' . $row_class .  '>';
		echo '<td>&nbsp</td>';
		echo '<td style="border-top: thin solid black; border-bottom: thin solid black;  border-left: thin solid black; border-right: thin solid black;" colspan="9">';
		
		
		$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();

		if ( $wptbGlobalOptions [ 'rotate_topbars' ] == "yes" ) {				// force these to off/no if Rotate is turned on
			$item['scroll_action'] = "off";
			$item['allow_reopen'] = "no";
			$item['allow_close'] = "no";
		}
				
		if (isset($item['allow_reopen']) && ($item['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('',$item, false, 1, true);
		else 
			wptb::wptb_display_TopBar('',$item, false, 1, false);
		echo '</td>';
		echo '</tr>';
	}
    
    	function single_row_columns( $item ) {
		list( $columns, $hidden ) = $this->get_column_info();

		foreach ( $columns as $column_name => $column_display_name ) {
			$class = "class='$column_name column-$column_name'";

			$style = '';
			if ( in_array( $column_name, $hidden ) )
				$style = ' style="display:none;border-bottom-style:none;"';
			else
				$style = ' style="border-bottom-style:none;"';

			$attributes = "$class$style";

			if ( 'cb' == $column_name ) {
				echo '<th scope="row" class="check-column" style="border-bottom-style:none;">';
				echo $this->column_cb( $item );
				echo '</th>';
			}
			elseif ( method_exists( $this, 'column_' . $column_name ) ) {
				echo "<td $attributes>";
				echo call_user_func( array( &$this, 'column_' . $column_name ), $item );
				echo "</td>";
			}
			else {
				echo "<td $attributes>";
				echo $this->column_default( $item, $column_name );
				echo "</td>";
			}
		}
	}
 
	function print_column_headers( $with_id = true ) {
		$screen = get_current_screen();

		list( $columns, $hidden, $sortable ) = $this->get_column_info();

		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$current_url = remove_query_arg( 'paged', $current_url );

		if ( isset( $_GET['orderby'] ) )
			$current_orderby = $_GET['orderby'];
		else
			$current_orderby = '';

		if ( isset( $_GET['order'] ) && 'desc' == $_GET['order'] )
			$current_order = 'desc';
		else
			$current_order = 'asc';

		foreach ( $columns as $column_key => $column_display_name ) {
			$class = array( 'manage-column', "column-$column_key" );

			$style = '';
			if ( in_array( $column_key, $hidden ) )
				$style = 'display:none;';


			switch ( $column_key ):
				case 'start_time':
				case 'end_time':
					 $style .= $style.'width:150px;';
					 break;
				case 'show_it':
				case 'weighting_points':
					 $style .= $style.'width:105px;';
					 break;
				case 'enable_topbar':
					 $style .= $style.'width:95px;';
					 break;
				case 'bar_id':
					 $style .= $style.'width:200px;';
			endswitch;
			
			$style = ' style="' . $style . '"';

			if ( 'cb' == $column_key )
				$class[] = 'check-column';
			elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ) ) )
				$class[] = 'num';
				
			if ( isset( $sortable[$column_key] ) ) {
				list( $orderby, $desc_first ) = $sortable[$column_key];

				if ( $current_orderby == $orderby ) {
					$order = 'asc' == $current_order ? 'desc' : 'asc';
					$class[] = 'sorted';
					$class[] = $current_order;
				} else {
					$order = $desc_first ? 'desc' : 'asc';
					$class[] = 'sortable';
					$class[] = $desc_first ? 'asc' : 'desc';
				}

				$column_display_name = '<a href="' . esc_url( add_query_arg( compact( 'orderby', 'order' ), $current_url ) ) . '"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
			}

			$id = $with_id ? "id='$column_key'" : '';

			if ( !empty( $class ) )
				$class = "class='" . join( ' ', $class ) . "'";

			echo "<th scope='col' $id $class $style>$column_display_name</th>";
		}
	}
  
	function get_1table_classes() {
		return array( 'border=0', 'fixed', $this->_args['plural'] );
	}
       
	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	*/
	 
	function get_sortable_columns() {
		return $sortable = array(
			'bar_id' => array('bar_id',true),
			'enable_topbar' => array('enable_topbar',false),
			'only_logged_in' => array('only_logged_in',false),
			'weighting_points' => array('weighting_points',false),
			'start_time' => array('start_time',false),
			'end_time' => array('end_time', false),
			'show_it' => array('show_it', false),
			'mobile_check' => array('mobile_check', false)
		);
	}

	
	 /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'bulkdelete'    => __('Delete','wp-topbar'),
            'bulkduplicate' => __('Duplicate','wp-topbar'),
            'bulkenable'    => __('Enable','wp-topbar'),
            'bulkdisable'   => __('Disable','wp-topbar'),
            'bulkincrease'	=> __('Increase Priority by 10','wp-topbar'),
            'bulkdecrease'	=> __('Decrease Priority by 10','wp-topbar')
        );
        return $actions;
    }
    
    
       
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {

	/*
	$string = ""; // initialize blank string
	foreach($_REQUEST as $key => $value) // loop through all $_GET values
	$string .= $key."=".$value."&"; // add key/value to string
	$string = substr_replace($string, "", -1); // remove trailing &
	echo $string;
	*/

	   	switch ( $this->current_action() ) {
		case "bulkincrease":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`+10 WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 100 WHERE `weighting_points` > 100");
  	  				if ($n > 0) {
			            $wptb_i18n = sprintf( _n('%d row changed priority by +10.', '%d rows changed priority by +10.', $n, 'wp-topbar'), $n );
		                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
  	  				}	
	            }
				break;

		case "bulkdecrease":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = `weighting_points`-10 WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
	                $wpdb->query("UPDATE $wptb_table_name SET `weighting_points` = 1 WHERE `weighting_points` < 1");
  	  				if ($n > 0) {
			            $wptb_i18n = sprintf( _n('%d row changed priority by -10.', '%d rows changed priority by -10.', $n, 'wp-topbar'), $n );
		                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
  	  				}
	            }
				break;
								
		case "bulkdisable":	
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'false' WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
   	  				if ($n > 0) {
			            $wptb_i18n = sprintf( _n('%d row disabled.', '%d rows disabled.', $n, 'wp-topbar'), $n );
		                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
  	  				}
	            }
				break;

		case "bulkenable": 
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	            $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            if (is_array($barids)) $barids = implode(',', $barids);
	
	            if (!empty($barids)) {
	                $wpdb->query("UPDATE $wptb_table_name SET `enable_topbar` = 'true' WHERE bar_id IN($barids)");
	                $n = $wpdb->rows_affected;
   	  				if ($n > 0) {
			            $wptb_i18n = sprintf( _n('%d row enabled.', '%d rows enabled.', $n, 'wp-topbar'), $n );
		                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
  	  				}	            }
				break;
	
		case "bulkdelete": 
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		        $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
		        if (is_array($barids)) $barids = implode(',', $barids);

		        if (!empty($barids)) {
		            $wpdb->query("DELETE FROM $wptb_table_name WHERE `bar_id` IN($barids)");
		            $n = $wpdb->rows_affected;
   	  				if ($n > 0) {
			            $wptb_i18n = sprintf( _n('%d row deleted.', '%d rows deleted.', $n, 'wp-topbar'), $n );
		                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';
					}
		         }
				break;
				
		case "bulkduplicate":
				$barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            $n = count($barids);
				foreach ($barids as $key => $barid) {
				  	$wptbOptions=wptb_get_Specific_TopBar($barid);
		  			$wptbOptions['enable_topbar']='false';
		  			wptb_insert_row($wptbOptions);
		  		}
  				if ($n > 0) {
		            $wptb_i18n = sprintf( _n('%d row duplicated.', '%d rows duplicated.', $n, 'wp-topbar'), $n );
	                echo '<div class="updated"><p><strong>'.$wptb_i18n.'</strong></p></div>';		
  				}	  
		}
    }
    
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items() {
        
        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 20;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
               
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        global $wpdb;
		$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		
	    $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'bar_id'; //If no sort, default to title
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
		
		$query = "SELECT *,  ((start_delta <= 0 ) AND (end_delta <=0 )) as show_it, concat(bar_text, '<br/>',bar_link_text) as text_line
				  		FROM (
					
			SELECT 	*,	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 0)."',  '%Y-%m-%d %H:%i' ), 0), 
												COALESCE(STR_TO_DATE(  `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) as start_delta, 
						COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
												COALESCE(STR_TO_DATE(  '".current_time('mysql', 0)."',  '%Y-%m-%d %H:%i' ), 0)),0) as end_delta
						
						FROM ".$wptb_table_name."
						ORDER BY ".$orderby." ".$order."
						) as Table1;";

		$data = $wpdb->get_results($query, ARRAY_A);   
                
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */

        if ('bulkdelete' === $this->current_action()) 
			$current_page = 1;

		else
	        $current_page = $this->get_pagenum();
	        
	    if (! isset($current_page))
			$current_page = 1;
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }


	}
	 
	 //Prepare Table of elements
	$wp_list_table = new wptb_All_TopBar_Table();
	$wp_list_table->prepare_items();
	global $WPTB_DB_VERSION;
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	$wptb_rows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name);
	$wptb_num_rows = $wpdb->num_rows;
	if ( $wptb_num_rows == 0 ){
		$wptbOptions=wptb_insert_default_row($WPTB_DB_VERSION);
		$wp_list_table->prepare_items();
		echo '<div class="updated"><p><strong>'.__('All TopBars deleted; created default TopBar.','wp-topbar').'</strong></p></div>';
	}
	
	?>
	
    <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><?php _e('Listing of all TopBars','wp-topbar'); ?></h2>
        <table style="background:white;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
			<tr valign="top" >
			<td width="400" bgcolor="#bcfbc5" align="center">
			<strong><?php _e('Overview','wp-topbar'); ?></strong>
			</td>
			<td width="5">
			</td>
			<td bgcolor="#e2f8b9" align="center">
	        <strong><?php _e('Step-by-Step','wp-topbar'); ?></strong>
			</td>
 			</tr>	
			<tr valign="top" >
			<td width="400">
            <?php _e('Select a TopBar to edit.  You can also enable, disable, bulk duplicate or delete your TopBars from here.'.
	        '<br /><br />Use the','wp-topbar'); ?> <strong><a href='?page=wp-topbar.php&action=testpriority'><?php _e('Test Priority tab','wp-topbar'); ?></a></strong> <?php _e('to see how the plugin will randomly select 10 TopBars.'.
	        '<br /><br />The table below shows you the Priority and Start/Stop times for each TopBar.  It also tells you if a TopBar will show based on the current time and if that TopBar is enabled.   It will also show you if it will show only for logged in users or all users.'.
			'<br /><br />Use the','wp-topbar'); ?> <strong><a href='?page=wp-topbar.php&action=globalsettings'><?php _e('Global Settings tab','wp-topbar'); ?></a></strong> <?php _e('to affect how all TopBars are processed.','wp-topbar'); ?> 
			</td>
			<td width="5" bgcolor="grey">
			</td>
			<td>
	        <?php _e('1.  Select the TopBar to edit by hovering over the row and selecting the Main Options link.'.   
	        '<br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>'.
	        '<br />&nbsp&nbsp&nbsp&nbspHit the <strong>Create Default Row</strong> button below to insert a default TopBar at end of the table.  Find it and edit it.'.
	        '<br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>'.
	        '<br />&nbsp&nbsp&nbsp&nbspGo to the','wp-topbar'); ?> <strong><a href="?page=wp-topbar.php&action=samples"><?php _e('Sample TopBar tab','wp-topbar'); ?></a></strong> <?php _e('(above) and select one or more TopBars to add to the table below.'. 
	        '<br />2.  Change the various options to configure the TopBar, using the Tabs to setup how the TopBar looks.  Explore each tab to see all the options.'.
	        '<br />3.  Go back to the Main Options tab and toggle the Enable switch to allow the TopBar to be shown.'.
	        '<br />4.  Go back to the All TopBars tab to add more TopBars. Add and customize as many TopBars as you need.'.
	        '<br />5.  Now, every time a web page is displayed, the plugin builds all of the TopBars that match the Control Tab and Time criteria.'.
	     	'<br />&nbsp&nbsp&nbsp&nbspA TopBar is randomly selected (although, the Priority Weighting can be used to give one TopBar more preference than another.)'.  
	     	'<br />&nbsp&nbsp&nbsp&nbspThey are built in such a way that your cacheing plugin will cache the results.','wp-topbar'); ?><td>
			</td>
 			</tr>	
		</table>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="topbar-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
		<table>
		<tr>
			<td style="valign:top;;"><p class="submit">
				<input type="submit" class="button-primary" name=wptbInsertBar value="<?php _e('Create Default Row', 'wp-topbar') ?>" />
			</td>
		</tr>
		</table>
		<?php $wp_list_table->display(); ?>
        </form>
        
    </div>

    <?php
	

} // end of wptb_display_all_TopBars
	
//=========================================================================		
// Tests how the TopBar will show
//
//
//=========================================================================		

function wptb_test_topbar($number_to_show) {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_test_topbar() for ID: '.$number_to_show.'</code>';

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();

	?>
    <div class="wrap">
    
    <div id="icon-options-general" class="icon32"><br/></div>
    <h2><?php echo sprintf( __('Test Priority of TopBars - Displaying %d TopBars', 'wp-topbar'), $number_to_show ); ?></h2>
    
    <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <p><?php _e('This shows how the Plugin will show a random select a set of TopBars.  Only those TopBars that are enabled and pass the Time Check will be part of the selection pool. The Priority value is used to skew how often a TopBar is shown.  A higher number means that TopBar will be selected more frequently; a lower number means less frequently.','wp-topbar'); ?></p> 
    </div>
	<table class="widefat alternate">
	<thead>
	    <tr>
	        <th><?php _e('ID','wp-topbar');?></th>
	        <th><?php _e('Priority','wp-topbar'); ?></th>       
	        <th><?php _e('TopBar','wp-topbar'); ?></th>
	    </tr>
	</thead>
	<tfoot>
	        <th><?php _e('ID','wp-topbar');?></th>
	        <th><?php _e('Priority','wp-topbar'); ?></th>       
	        <th><?php _e('TopBar','wp-topbar'); ?></th>
	    </tr>
	</tfoot>
	<tbody>
	<?php 

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$tabs = array( 'disable'=> '<br/>'.__('Disable','wp-topbar').' |<br/>', 'main' => __('Main&nbspOptions','wp-topbar').' |<br/>',   'topbartext' => __('TopBar&nbspText&nbsp&&nbspImage','wp-topbar').' |<br/>', 'topbarcss' => __('TopBar&nbspCSS&nbsp&&nbspHTML','wp-topbar').' |<br/>', 'colorselection' => __('Color&nbspSelection','wp-topbar') );    

	$n=1;
	while ( $n <= $number_to_show ) {
		$wptbOptions=wptb_get_Random_TopBar();
		if (isset ( $wptbOptions ['bar_id'] ) ) {

			if ( $wptbGlobalOptions [ 'rotate_topbars' ] == "yes" ) {				// force these to off/no if Rotate is turned on
				$wptbOptions['scroll_action'] = "off";
				$wptbOptions['allow_reopen'] = "no";
				$wptbOptions['allow_close'] = "no";
			}
		
			echo "<tr>";
			echo "<td  width=150px>".$wptbOptions['bar_id'];

			foreach( $tabs as $tab => $name ) {
	        	echo '<a href="?page='.$_REQUEST['page'].'&amp;action='.$tab.'&amp;barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">'.$name.'</a>';
	        }
			echo "</td>";
			echo "<td width=50px>".$wptbOptions['weighting_points']."</td>";
			echo '<td valign="top">';
			if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
				wptb::wptb_display_TopBar('',$wptbOptions, false, 1, true);
			else 
				wptb::wptb_display_TopBar('',$wptbOptions, false, 1, false);
			echo '</td>';
		}
		else break;
		$n++;
	}
	if ( $n == 0) {		
		echo '<br/><h3>'.__('No TopBars are enabled','wp-topbar').'</h3>';
	}
	
	echo "</tbody></table></div>";


} // end of wptb_test_topbar

//=========================================================================		
//
//Displays TopBar variables, if debug is turned on
//
//=========================================================================		
	
function wptb_debug_display_TopBar_Options($wptbOptions) {

	$wptb_current_time_gmt    =current_time('timestamp', 1);
	$wptb_current_time_local  =current_time('timestamp', 0);
	$wptb_current_time_mysql  =strtotime(current_time('mysql', 0));

	echo '</br><code>WP-TopBar Debug Mode: wptb_debug_display_TopBar_Options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';	
	echo '<br/><code>WP-TopBar Debug Mode: Server Timezone:',date_default_timezone_get(),'</code>';
	echo '<br/><code>WP-TopBar Debug Mode: WordPress GMT Offset: ',get_option( 'gmt_offset', 0 ),'</code>';
	echo '<br/><code>WP-TopBar Debug Mode: Current Time (Local):',$wptb_current_time_local,'-',date('Y-m-d H:i:s',$wptb_current_time_local),'</code>';				
	echo '<br/><code>WP-TopBar Debug Mode: Current Time (GMT):&nbsp;&nbsp;',$wptb_current_time_gmt,'-',date('Y-m-d H:i:s',$wptb_current_time_gmt),'</code>';				
	echo '<br/><code>WP-TopBar Debug Mode: Current Time (MySQL):',$wptb_current_time_mysql,'-',date('Y-m-d H:i:s',$wptb_current_time_mysql),'</code>';				
	echo '<br/><code>WP-TopBar Debug Mode: Starting Time:</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$wptbOptions['start_time'],' (As entered)</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('Y-m-d H:i:s',strtotime($wptbOptions['start_time'])),' (Formatted)</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$wptbOptions['start_time_utc'],' (UTC-As Entered)</code>',
		 '<br/><code>WP-TopBar Debug Mode:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.strtotime($wptbOptions['start_time_utc']),' (UTC-time)</code>';
	echo '<br/><code>WP-TopBar Debug Mode: Ending Time:</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$wptbOptions['end_time'],' (As entered)</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('Y-m-d H:i:s',strtotime($wptbOptions['end_time'])),' (Formatted)</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$wptbOptions['end_time_utc'],' (UTC-As Entered)</code>',
		 '<br/><code>WP-TopBar Debug Mode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.strtotime($wptbOptions['end_time_utc']),' (UTC-time)</code>';
		 
	if ($wptbOptions['start_time_utc'] == 0) 
		echo '<br/><code>WP-TopBar Debug Mode: Start Time is zero</code>';
	else
		if (($wptb_current_time_mysql - strtotime($wptbOptions['start_time_utc'])) >= 0)
			echo '<br/><code>WP-TopBar Debug Mode: Start Time is before or equal Current Time</code>';
		else
			echo '<br/><code>WP-TopBar Debug Mode: Start Time is in the future</code>';

	if ($wptbOptions['end_time_utc'] == 0) 
		echo '<br/><code>WP-TopBar Debug Mode: End Time is zero</code>';
	else {
		if ($wptbOptions['start_time_utc'] > strtotime($wptbOptions['end_time_utc'] )) 
			echo '<br/><code>WP-TopBar Debug Mode: End Time is before Start Time - Error - TopBar will <strong>NOT</strong> display</code>';
		if (strtotime(($wptbOptions['end_time_utc']) - $wptb_current_time_mysql) >= 0)
			echo '<br/><code>WP-TopBar Debug Mode: End Time is after or equal to Current Time</code>';
		else
			echo '<br/><code>WP-TopBar Debug Mode: End Time is in the past</code>';
	}
	if (wptb_check_time($wptbOptions['bar_id']))
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display because it is not enabled, even though the time settings would allow it</code>';
		else
			echo '<br/><code>WP-TopBar Debug Mode: TopBar will display due to time settings and because it is enabled</code>';
	else
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings and because it is not enabled</code>';
		else
			echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings even though it is enabled</code>';
	
	switch ( $wptbOptions['show_homepage'] ) {
				
			case 'always':
				echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>ALWAYS</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;
				
			case 'never':
				echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>NEVER</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;

			case 'conditionally':
				echo '<br/><code>WP-TopBar Debug Mode: TopBar will <strong>check</strong> Page/Category criteria to determine if it should display on the Home Page (if the TopBar is enabled)</code>';
			
	}
	
	
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH; 
	
	echo "<br/><code>WP-TopBar Debug Mode: Cookie Name: ".$wptb_cookie."</code>";
	if (isset($_COOKIE[$wptb_cookie]) && ($wptbOptions['respect_cookie'] = "always"))
		echo "<br/><code>WP-TopBar Debug Mode: Cookie Value: ". $_COOKIE[$wptb_cookie]."</code>"; 
	else
		echo "<br/><code>WP-TopBar Debug Mode: Cookie not found</code>";
	
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) {
		echo "<br/><code>WP-TopBar Debug Mode: TopBar will not show</code>";

	}	
	
	// check for iPhone, iPad or iPod -- they can't use flash 
	
	$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	
	if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) 
		echo '<br/><code>WP-TopBar Debug Mode: Not an iPhone/iPad/iPod Device</code>';
	else 
		echo '<br/><code>WP-TopBar Debug Mode: An iPhone/iPad/iPod Device</code>';

	echo '<br/><code>WP-TopBar Debug Mode: Filename:',plugin_dir_path(__FILE__),'</code>';
	echo '<br/><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	echo '<br/><code>WP-TopBar Debug Mode: Using these "wptbAdminOptions" Values:</code>';
	foreach ($wptbOptions as $i => $value) {
		  	echo '<br/><code>WP-TopBar Debug Mode:&nbsp&nbsp[',$i,']: ',$value,'</code>';
		}
	echo '<br/><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	
}	// End of wptb_debug_display_TopBar_Options


?>
