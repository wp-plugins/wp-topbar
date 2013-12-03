<?php 

/*
Display Functions
*/


//=========================================================================			
// Build the tabs on top of the non-edit pages 
//=========================================================================			


function wptb_options_tabs( $current = 'table' ) {

	$wptb_debug=get_transient( 'wptb_debug' );	

    $tabs = array( 'table'=> 'All TopBars', 'testpriority' => 'Test Priority', 'bulkclosebutton'=> 'Close Button', 'export' => 'Export Options', 'samples' => 'Sample TopBars', 'mainfaq' => 'FAQ', 'globalsettings' => 'Global Settings', 'uninstall' => 'Uninstall');
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
		
	$wptb_num_rows = get_transient( 'wptb_inserted_rows' );
	
 	if ( $wptb_num_rows ) {
		if ($wptb_num_rows == 1)	
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' row created.</strong></p></div>';
		else
			echo '<div class="updated"><p><strong>'.$wptb_num_rows.' rows created.</strong></p></div>';
		delete_transient( 'wptb_inserted_rows' );	  	    	
	}
 
        
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

	$wptb_debug=get_transient( 'wptb_debug' );	

    $tabs = array( 'table'=> 'All TopBars', 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS&nbsp&&nbspHTML', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons', 'phptexttab' => 'PHP',  'debug' => 'Debug', 'faq' => 'FAQ' );
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

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_admin_header()</code>';
		
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		WP-TopBar - Version <?php _e($WPTB_VERSION); ?></h2>
		<div class="postbox">
		<br>
		Creates TopBars that can be shown at the top of your website.  Version 5 adds ability to close TopBars and also gives you a Sample TopBar Tab that has starter TopBars that you can customize.
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

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	$wptbRotateTopbars = $wptbGlobalOptions [ 'rotate_topbars' ];
	
   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_common_info() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';
	
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
	
	if (($wptbRotateTopbars == "yes") && ($wptbOptions['scroll_action'] == "on")) 
		_e( "<div class='error'><strong>You have allowed the Scroll Action on for this TopBar (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Main Options tab</a>) and have the Rotate TopBars turned on in the <a href='?page=wp-topbar.php&action=globalsettings'>Global Settings tab</a>.  Scroll Action option is ignored if the TopBars are being rotated.</strong></div>", 'wptb' ); 

	if (($wptbRotateTopbars == "yes") && ($wptbOptions['allow_close'] == "yes")) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be closed (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) and have the Rotate TopBars turned on in the <a href='?page=wp-topbar.php&action=globalsettings'>Global Settings tab</a>.  Close Buttons are ignored if the TopBars are being rotated.</strong></div>", 'wptb' ); 

	if (($wptbRotateTopbars == "yes") && ($wptbOptions['allow_reopen'] == "yes"))
		_e( "<div class='error'><strong>You have turned on the Re-Open TopBar option (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) and have the Rotate TopBars turned on in the <a href='?page=wp-topbar.php&action=globalsettings'>Global Settings tab</a>.  Re-open buttons are ignored if the TopBars are being rotated.</strong></div>", 'wptb' ); 

	if (($wptbOptions['topbar_pos'] == 'footer') && (strpos($wptbOptions['div_css'], "bottom") === false))
		_e( "<div class='error'><strong>You have set the TopBar Location to Below Footer (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#priority'>Main Options</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS & HTML Tab - Option C</a> may not be set correctly.<br>It should be something like <code>position:fixed; bottom: 0; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

	if (($wptbOptions['topbar_pos'] == 'header') && (strpos($wptbOptions['div_css'], "top") === false))
		_e( "<div class='error'><strong>You have set the TopBar Location to be Above Header (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#priority'>Main Options tab</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS & HTML Tab - Option C</a> may not be set correctly.<br>It should be something like <code>position: fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

	if (($wptbOptions['scroll_action'] == "on") && (strpos($wptbOptions['div_css'], "fixed") === false))
		_e( "<div class='error'><strong>You have turned on the Scroll Action option (in the <a href='?page=wp-topbar.php&action=main&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Main Options</a>) but the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#divcss'>TopBar CSS & HTML Tab -  Option C</a> may not be set correctly.<br>It should have it's position 'fixed' like <code>position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code></strong></div>", 'wptb' ); 

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['respect_cookie'] == 'always' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be re-opened (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) and have have Enabled Cookies.  Cookies are ignored if the TopBar is allowed to be re-opened.</strong></div>", 'wptb' ); 

	if (((isset($wptbOptions['allow_close']) && ($wptbOptions['allow_close']) == "yes") ||  (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" )) && $wptbOptions['close_button_css'] == '' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be closed (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) but no close button CSS is entered for this TopBar on the same option page.</strong></div>", 'wptb' ); 

	if (((isset($wptbOptions['allow_close']) && ($wptbOptions['allow_close']) == "yes") ||  (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" )) && $wptbOptions['close_button_image'] == '' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be closed (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) but no close button image has been entered for this TopBar.</strong></div>", 'wptb' ); 

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['reopen_button_css'] == '' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be re-opened (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) but no re-open button CSS is entered for this TopBar on the same option page.  Re-open button will not work without (at least) the default CSS entered.</strong></div>", 'wptb' ); 

	if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes" && $wptbOptions['reopen_button_image'] == '' ) 
		_e( "<div class='error'><strong>You have allowed the TopBar to be re-opened (in the <a href='?page=wp-topbar.php&action=closebutton&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."#location'>Close Button tab</a>) but no re-open button image has been entered for this TopBar.</strong></div>", 'wptb' ); 

	if (isset($wptbOptions['enable_image']) && ($wptbOptions['enable_image']) == "true" && $wptbOptions['bar_image'] == '' ) 
		_e( "<div class='error'><strong>You have enabled a bar image (in the <a href='?page=wp-topbar.php&action=topbartext&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>TopBar Text & Image tab</a>) but no image has been entered for this TopBar.</strong></div>", 'wptb' ); 


	for ($i=1; $i<=10; $i++)  {
		if (isset($wptbOptions['social_icon'.$i]) && ($wptbOptions['social_icon'.$i]) == "on" && $wptbOptions['social_icon'.$i.'_image'] == '' ) 
			_e( "<div class='error'><strong>You have enabled an image for Social Button # ".$i." (in the <a href='?page=wp-topbar.php&action=socialbuttons&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>Social Buttons tab</a>) but no image has been entered for this Social Button.</strong></div>", 'wptb' ); 
	}


	// 
	// end of Warning Messges
	// 

	if ( $wptbRotateTopbars == "yes" ) {				// force these to off/no if Rotate is turned on
		$wptbOptions['scroll_action'] = "off";
		$wptbOptions['allow_reopen'] = "no";
		$wptbOptions['allow_close'] = "no";
	}
	
		   
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
			<br/>To test the TopBar on your site, you can set the Page IDs (on the <a href="?page=wp-topbar.php&action=control&barid=<?php echo ($wptbOptions['bar_id']+$wptb_barid_prefix); ?>">Control tab</a>) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
			<br/> The first black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>
			<?php if ( $wptbRotateTopbars == "yes" ) 
			echo "The <strong>Rotate TopBars</strong> option is turned on in the <a href='?page=wp-topbar.php&action=globalsettings'>Global Settings tab</a>.  With this turned ON, the Scrollable, Close Button, and Re-Open options are <strong>ignored and turned off</strong>.<br/><br/>";
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


//=========================================================================		
//  Display the All topbars table
//
//=========================================================================		

function wptb_display_all_TopBars() {

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
			'bar_id' => 'ID',
			'weighting_points' => 'Priority',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'show_it' => 'Time Check',
			'enable_topbar' => 'Enabled?',
			'only_logged_in' => 'Logged In Users Only?',
			'mobile_check' => 'Mobile?'
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
					return "Only Logged In";					
				else if ($item[$column_name] == "no" ) 
					return "Only NOT Logged In";	
				else 
					return "All Users";				
				break;			
			case "mobile_check":
				if ($item[$column_name] == "only_mobile" ) 
					return "Only Mobile Devices";					
				else if ($item[$column_name] == "not_mobile" ) 
					return "Not on Mobile Devices";	
				else 
					return "All Devices";				
				break;	
			case "weighting_points": 
				$width=$item[$column_name]+0;
//				return $item[$column_name];
				echo $item[$column_name]."<br><img height='22px' width='".$width."%' src='".plugins_url('/images/priority.png', __FILE__)."' />";
				return;

			case "enable_topbar": 
				if ($item[$column_name] == 'false')								
					return sprintf( "<span class='wtpb-off-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/off.png', __FILE__).')"'."></span>");
				else
					return sprintf( "<span class='wtpb-on-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/on.png', __FILE__).')"'."></span>");
					break;
			case "show_it": 
				if ($item[$column_name] == 0 )							
					return sprintf( "<span class='wtpb-off-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/off.png', __FILE__).')"'."></span>");
				else
					return sprintf( "<span class='wtpb-on-button'".'style="display: block;width: 32px;height: 32px;color:red;background:url('.plugins_url('/images/on.png', __FILE__).')"'."></span>");
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
	        	        
        $tabs = array( 'main' => 'Main&nbspOptions',  'control' => 'Control',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS&nbsp&&nbspHTML', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','phptexttab' => 'PHP', 'debug' => 'Debug' );    

        //Build row actions

        if ( $item['enable_topbar'] == "false" ) {
	        $actions = array('enable'    => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Enable</a>',$_REQUEST['page'],'enable',($item['bar_id']+$wptb_barid_prefix), $current_page));
        }
        else {
	        $actions = array('disable'   => sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Disable</a>',$_REQUEST['page'],'disable',($item['bar_id']+$wptb_barid_prefix), $current_page));	        
        }
        
        $actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s&amp;noheader=true">Duplicate</a>',$_REQUEST['page'],'duplicate',($item['bar_id']+$wptb_barid_prefix), $current_page);

        foreach( $tabs as $tab => $name ) {
        	$actions[] = sprintf('<a href="?page=%s&amp;action=%s&amp;barid=%s%s">%s</a>',$_REQUEST['page'],$tab,($item['bar_id']+$wptb_barid_prefix), $current_page, $name);
        }

        return sprintf('%1$s %2$s',
            /*$2%s*/ $item['bar_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }	
    
    function no_items() {
	    echo '<br><strong>No TopBars to show - if none exist will create default TopBar.</strong><br>	';
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
		echo '<td style="border-top: thin solid black; border-bottom: thin solid black;  border-left: thin solid black; border-right: thin solid black;" colspan="8">';
		
		
		$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
		$wptbRotateTopbars = $wptbGlobalOptions [ 'rotate_topbars' ];

		if ( $wptbRotateTopbars == "yes" ) {				// force these to off/no if Rotate is turned on
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
			'show_it' => array('show_it', false)
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
            'bulkdelete'    => 'Delete',
            'bulkduplicate' => 'Duplicate',
            'bulkenable'    => 'Enable',
            'bulkdisable'   => 'Disable',
            'bulkincrease'	=> 'Increase Priority by 10',
            'bulkdecrease'	=> 'Decrease Priority by 10'
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
    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row changed priority by +10.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows changed priority by +10.</strong></p></div>';
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

    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row changed priority by -10.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows changed priority by -10.</strong></p></div>';
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
    				if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row disabled.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows disabled.</strong></p></div>';
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
					if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row enabled.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows enabled.</strong></p></div>';
	            }
				break;
	
		case "bulkdelete": 
				global $wpdb;
				$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		        $barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
		        if (is_array($barids)) $barids = implode(',', $barids);

		        if (!empty($barids)) {
		            $wpdb->query("DELETE FROM $wptb_table_name WHERE `bar_id` IN($barids)");
		            $n = $wpdb->rows_affected;
		            if ($n == 0) break;
		            if ($n == 1)	
		                echo '<div class="updated"><p><strong>'.$n.' row deleted.</strong></p></div>';
	                else
		                echo '<div class="updated"><p><strong>'.$n.' rows deleted.</strong></p></div>';
		         }
				break;
				
		case "bulkduplicate":
				$barids = isset($_REQUEST['barid']) ? $_REQUEST['barid'] : array();
	            $n = count($barids);
				foreach ($barids as $key => $barid) {
				  	$wptbOptions=wptb_get_Specific_TopBar($barid);
		  			$wptbOptions['enable_topbar']='false';
		  			wtpb_insert_row($wptbOptions);
		  		}
				if ($n == 1)	
					echo '<div class="updated"><p><strong>'.$n.' row duplicated.</strong></p></div>';
				else
					echo '<div class="updated"><p><strong>'.$n.' rows duplicated.</strong></p></div>';

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
		
		$query = "SELECT *,  ((start_delta <= 0 ) AND (end_delta <=0 )) as show_it, concat(bar_text, '<br>',bar_link_text) as text_line
				  		FROM (
					
			SELECT 	*,	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
												COALESCE(STR_TO_DATE(  `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) as start_delta, 
						COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
												COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) as end_delta
						
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
	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
	$myrows = $wpdb->get_results( 'SELECT * FROM '.$wptb_table_name);
	if ( $wpdb->num_rows == 0 ){
		$wptbOptions=wtpb_insert_default_row();
		$wp_list_table->prepare_items();
		echo '<div class="updated"><p><strong>All TopBars deleted; created default TopBar.</strong></p></div>';
	}
	
	?>
	
    <div class="wrap">
        
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2>Listing of all TopBars</h2>
        <table style="background:white;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
			<tr valign="top" >
			<td width="400" bgcolor="#bcfbc5" align="center">
			<strong>Overview</strong>
			</td>
			<td width="5">
			</td>
			<td bgcolor="#e2f8b9" align="center">
	        <strong>Step-by-Step</strong>
			</td>
 			</tr>	
			<tr valign="top" >
			<td width="400">
            Select a TopBar to edit.  You can also enable, disable, bulk duplicate or delete your TopBars from here.
	        <br /><br />Use the <strong><a href='?page=wp-topbar.php&action=testpriority'>Test Priority tab</a></strong> to see how the plugin will randomly select 10 TopBars.
	        <br /><br />The table below shows you the Priority and Start/Stop times for each TopBar.  It also tells you if a TopBar will show based on the current time and if that TopBar is enabled.   It will also show you if it will show only for logged in users or all users.
			<br /><br />Use the <strong><a href='?page=wp-topbar.php&action=globalsettings'>Global Settings tab</a></strong> to affect how all TopBars are processed. 
			</td>
			<td width="5" bgcolor="grey">
			</td>
			<td>
	        1.  Select the TopBar to edit by hovering over the row and selecting the Main Options link.   
	        <br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>
	        <br />&nbsp&nbsp&nbsp&nbspHit the <strong>Create Default Row</strong> button below to insert a default TopBar at end of the table.  Find it and edit it.
	        <br />&nbsp&nbsp&nbsp&nbsp<strong>OR</strong>
	        <br />&nbsp&nbsp&nbsp&nbspGo to the <strong><a href='?page=wp-topbar.php&action=samples'>Sample TopBar tab</a></strong> (above) and select one or more TopBars to add to the table below. 
	        <br />2.  Change the various options to configure the TopBar, using the Tabs to setup how the TopBar looks.  Explore each tab to see all the options.
	        <br />3.  Go back to the Main Options tab and toggle the Enable switch to allow the TopBar to be shown.
	        <br />4.  Go back to the All TopBars tab to add more TopBars. Add and customize as many TopBars as you need.
	        <br />5.  Now, every time a web page is displayed, the plugin builds all of the TopBars that match the Control Tab and Time criteria.
	     	<br />&nbsp&nbsp&nbsp&nbspA TopBar is randomly selected (although, the Priority Weighting can be used to give one TopBar more preference than another.)  
	     	<br />&nbsp&nbsp&nbsp&nbspThey are built in such a way that your cacheing plugin will cache the results.			<td>
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
				<input type="submit" class="button-primary" name=wptbInsertBar value="<?php _e('Create Default Row', 'wptb') ?>" />
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
	$wptbRotateTopbars = $wptbGlobalOptions [ 'rotate_topbars' ];

	?>
    <div class="wrap">
    
    <div id="icon-options-general" class="icon32"><br/></div>
    <h2>Test Priority of TopBars - Displaying <?php echo $number_to_show; ?> TopBars</h2>
    
    <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <p>This shows how the Plugin will show a random select a set of TopBars.  Only those TopBars that are enabled and pass the Time Check will be part of the selection pool. The Priority value is used to skew how often a TopBar is shown.  A higher number means that TopBar will be selected more frequently; a lower number means less frequently.</p> 
    </div>
	<table class="widefat alternate">
	<thead>
	    <tr>
	        <th>ID</th>
	        <th>Priority</th>       
	        <th>TopBar</th>
	    </tr>
	</thead>
	<tfoot>
	    <th>ID</th>
	    <th>ID</th>
	    <th>Priority</th>
	    <th>TopBar</th>
	    </tr>
	</tfoot>
	<tbody>
	<?php 

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$tabs = array( 'disable'=> '<br>Disable |<br>', 'main' => 'Main&nbspOptions |<br>',   'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage |<br>', 'topbarcss' => 'TopBar&nbspCSS&nbsp&&nbspHTML |<br>', 'colorselection' => 'Color&nbspSelection' );    
	$n=1;
	while ( $n <= $number_to_show ) {
		$wptbOptions=wptb_get_Random_TopBar();
		if (isset ( $wptbOptions ['bar_id'] ) ) {

			if ( $wptbRotateTopbars == "yes" ) {				// force these to off/no if Rotate is turned on
				$wptbOptions['scroll_action'] = "off";
				$wptbOptions['allow_reopen'] = "no";
				$wptbOptions['allow_close'] = "no";
			}
		
			echo "<tr>";
			echo "<td  width=125px>".$wptbOptions['bar_id'];

			foreach( $tabs as $tab => $name ) {
	        	echo '<a href="?page='.$_REQUEST['page'].'&amp;action='.$tab.'&amp;barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">'.$name.'</a>';
	        	}
//			echo '<a href="?page='.$_REQUEST['page'].'&amp;action='.$tab.'&amp;barid='.$item['bar_id'].$current_page.">'.$name.'</a>';
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
		
		echo "<br><h3>No TopBars are enabled.</h3>";
	}
	
	echo "</tbody></table></div>";


} // end of wptb_test_topbar

//=========================================================================		
//
//Displays TopBar variables, if debug is turned on
//
//=========================================================================		
	
function wptb_debug_display_TopBar_Options($wptbOptions) {

	$wptb_current_time=current_time('timestamp', 1);

	echo '<br><code>WP-TopBar Debug Mode: Server Timezone:',date_default_timezone_get(),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: Current Time&nbsp:',$wptb_current_time,'-',date('Y-m-d H:i:s (e)',$wptb_current_time),'</code>';				
	echo '<br><code>WP-TopBar Debug Mode: Starting Time:',$wptbOptions['start_time_utc'],'-',$wptbOptions['start_time'],'-',date('Y-m-d H:i:s (e)',$wptbOptions['start_time_utc']),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: Ending Time&nbsp&nbsp:',$wptbOptions['end_time_utc'],'-',$wptbOptions['end_time'],'-',date('Y-m-d H:i:s (e)',$wptbOptions['end_time_utc']),'</code>';
	
	if ($wptbOptions['start_time_utc'] == 0) 
		echo '<br><code>WP-TopBar Debug Mode: Start Time is zero</code>';
	else
		if (($wptb_current_time - $wptbOptions['start_time_utc']) >= 0)
			echo '<br><code>WP-TopBar Debug Mode: Start Time is before or equal Current Time</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: Start Time is in the future</code>';

	if ($wptbOptions['end_time_utc'] == 0) 
		echo '<br><code>WP-TopBar Debug Mode: End Time is zero</code>';
	else {
		if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc']) 
			echo '<br><code>WP-TopBar Debug Mode: End Time is before Start Time - Error - TopBar will <strong>NOT</strong> display</code>';
		if (($wptbOptions['end_time_utc'] - $wptb_current_time) >= 0)
			echo '<br><code>WP-TopBar Debug Mode: End Time is after or equal to Current Time</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: End Time is in the past</code>';
	}
	if (wptb_check_time($wptbOptions['bar_id']))
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display because it is not enabled, even though the time settings would allow it</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: TopBar will display due to time settings and because it is enabled</code>';
	else
		if ($wptbOptions['enable_topbar'] == 'false') 
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings and because it is not enabled</code>';
		else
			echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings even though it is enabled</code>';
	
	switch ( $wptbOptions['show_homepage'] ) {
				
			case 'always':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>ALWAYS</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;
				
			case 'never':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NEVER</strong> display on the Home Page (if the TopBar is enabled)</code>';
				break;

			case 'conditionally':
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>check</strong> Page/Category criteria to determine if it should display on the Home Page (if the TopBar is enabled)</code>';
			
	}
	
	
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH; 
	
	echo "<br><code>WP-TopBar Debug Mode: Cookie Name: ".$wptb_cookie."</code>";
	if (isset($_COOKIE[$wptb_cookie]) && ($wptbOptions['respect_cookie'] = "always"))
		echo "<br><code>WP-TopBar Debug Mode: Cookie Value: ". $_COOKIE[$wptb_cookie]."</code>"; 
	else
		echo "<br><code>WP-TopBar Debug Mode: Cookie not found</code>";
	
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) {
		echo "<br><code>WP-TopBar Debug Mode: TopBar will not show</code>";

	}	
	
	// check for iPhone, iPad or iPod -- they can't use flash 
	
	$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	
	if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) 
		echo '<br><code>WP-TopBar Debug Mode: Not an iPhone/iPad/iPod Device</code>';
	else 
		echo '<br><code>WP-TopBar Debug Mode: An iPhone/iPad/iPod Device</code>';

	echo '<br><code>WP-TopBar Debug Mode: Filename:',plugin_dir_path(__FILE__),'</code>';
	echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	echo '<br><code>WP-TopBar Debug Mode: Using these "wptbAdminOptions" Values:</code>';
	foreach ($wptbOptions as $i => $value) {
		  	echo '<br><code>WP-TopBar Debug Mode:&nbsp&nbsp[',$i,']: ',$value,'</code>';
		}
	echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	
}	// End of wptb_debug_display_TopBar_Options


?>
