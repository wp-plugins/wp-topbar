<?php 

/*
Plugin Name: WP-TopBar
Admin Page
*/

//=========================================================================		
//
//  Future Enhancements:
//   -- multiple topbars?
//
//
//
//
//=========================================================================		


//=========================================================================			
// Options Page
//=========================================================================			



function wptb_options_page() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    


	require_once( dirname(__FILE__).'/wp-topbar-db-io.php');  //database and I-O functions php
	require_once( dirname(__FILE__).'/wp-topbar-export.php');  //export functions
	require_once( dirname(__FILE__).'/wp-topbar-debug-tab.php');  //load debug pages php
	require_once( dirname(__FILE__).'/wp-topbar-close-tab.php');  //load close pages php
	require_once( dirname(__FILE__).'/wp-topbar-color-tab.php');  //load color selection pages php
	require_once( dirname(__FILE__).'/wp-topbar-css-tab.php');  //load CSS pages php
	require_once( dirname(__FILE__).'/wp-topbar-control-tab.php');  //load control logic pages php
	require_once( dirname(__FILE__).'/wp-topbar-social-tab.php');  //load social button pages php
	require_once( dirname(__FILE__).'/wp-topbar-textbar-tab.php');  //load textbar edit pages php
	require_once( dirname(__FILE__).'/wp-topbar-delete-tab.php');  //load delete pages php
	require_once( dirname(__FILE__).'/wp-topbar-display-functions.php');  //load admin pages php
	require_once( dirname(__FILE__).'/wp-topbar-faq-tab.php');  //load faq page php	

	// $wptb_common_style is used by all buttons except the Copy & Special buttons
		
	$wptb_common_style = "padding:7.5px 15px;
		-webkit-border-radius:23px;
		-moz-border-radius:23px;
		border-radius:23px;
		-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
		-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
		box-shadow:rgba(0,0,0,1) 0 1px 0;
		text-shadow:rgba(0,0,0,.4) 0 1px 0;
		font-size:16px;
		font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
		text-decoration:none;
		vertical-align:middle;";
			
	$wptb_button_style = 'border-top:1px solid #96d1f8;
		background:#65a9d7;
		background:-webkit-gradient(linear, left top, left bottom, from(#215375), to(#65a9d7));
		background:-webkit-linear-gradient(top, #215375, #65a9d7);
		background:-moz-linear-gradient(top, #215375, #65a9d7);
		background:-ms-linear-gradient(top, #215375, #65a9d7);
		background:-o-linear-gradient(top, #215375, #65a9d7);
		color:white;'.$wptb_common_style; 
	
	$wptb_clear_style = 'border-top:1px solid #96d1f8;
		background:#FFFF90;
		color:black;'.$wptb_common_style; 
		
	$wptb_cssgradient_style='border-top: 1px solid #c5f797;
	   background: #92d665;
	   background: -webkit-gradient(linear, left top, left bottom, from(#699c3e), to(#92d665));
	   background: -webkit-linear-gradient(top, #699c3e, #92d665);
	   background: -moz-linear-gradient(top, #699c3e, #92d665);
	   background: -ms-linear-gradient(top, #699c3e, #92d665);
	   background: -o-linear-gradient(top, #699c3e, #92d665);
	   color: white;'.$wptb_common_style.'font-size:12px;'; 
	
	$wptb_submit_style = 'border-top:1px solid #97f7c1;
		background:#65d67f;
		background:-webkit-gradient(linear, left top, left bottom, from(#217342), to(#65d67f));
		background:-webkit-linear-gradient(top, #217342, #65d67f);
		background:-moz-linear-gradient(top, #217342, #65d67f);
		background:-ms-linear-gradient(top, #217342, #65d67f);
		background:-o-linear-gradient(top, #217342, #65d67f);
		color: white;'.$wptb_common_style;  
	
	$wptb_delete_style = 'border-top:1px solid #f59898;
		background:#d46565;
		background:-webkit-gradient(linear, left top, left bottom, from(#732121), to(#d46565));
		background:-webkit-linear-gradient(top, #732121, #d46565);
		background:-moz-linear-gradient(top, #732121, #d46565);
		background:-ms-linear-gradient(top, #732121, #d46565);
		background:-o-linear-gradient(top, #732121, #d46565);
		color:#f2f2f2;'.$wptb_common_style;
	
	$wptb_special_button_style = "border-top: 1px solid #d7ddcb;
		   background: #ebf3df;
		   color: black;
		   margin-left:auto;
		   margin-right:auto;
		   width:130px;
		   font-size: 10px;
		   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
		   text-decoration: none;
		   vertical-align: middle;";

//	first time through, check for updated settings

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: ', date('D, d M Y H:i:s (e)',get_transient( 'wptb_debug' )),'</code>';	

// check action options, deaault = 'table'

    if ( isset ( $_GET['action'] ) )
        $action = $_GET['action'];
    else
        $action = 'table';    

// check page we are displaying, if > that max possible pages, then reset to max_pages

    if ( isset ( $_GET['paged'] ) ) {
        $current_page = $_GET['paged'];
		global $wpdb;
		$wptb_table_name = $wpdb->prefix . "wp_topbar_data";
		$query = "SELECT * FROM ".$wptb_table_name;
		$wpdb->get_results($query, ARRAY_A);   
		$max_pages = intval( ( $wpdb->num_rows ) / 10) + 1;
		if ($current_page > $max_pages) $current_page = $max_pages;
		$current_page = "&amp;paged=".$current_page;
     }
     else
        $current_page = '';    
 
// process items that require a Bar_ID
	if ( isset ( $_GET['barid'] ) ) {
        $wptb_barid = $_GET['barid'];
        
        if (isset($_POST['update_wptbSettings']))  {
			$wptbOptions=wptb_update_settings($wptb_barid, $wptb_debug);	
			}
		
	}
	
	if ( isset (  $_POST['wptbExportJSON'] ) ) {			
		wptb_export_options_json();
		wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');
	}
	else if ( isset (  $_POST['wptbExportCSV'] ) ) {
		wptb_export_options_csv();
		wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');					
	}
	else if ( isset (  $_POST['wptbExportSQL'] ) ) {
		wptb_export_options_sql();
		wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');					
	}
	else if ( isset($_POST['wptbInsertBar']) )  {
		wtpb_insert_default_row(false);
		$action = 'insertdefault';
	}		
	else if ( ( isset (  $_POST['wptbDeleteBar'] ) ) && ( get_transient( 'wptb_delete_row') ) ) {
		// make sure “&noheader=true” is added to the page that called this to make WP wait before the it outputs any of the HTML.
		// then the redirect will work!  Also, debug is forced off to ensure no output occurs before redirect
		$wptb_barid = get_transient( 'wptb_delete_row');
		wptb_delete_settings( $wptb_barid , false);
		delete_transient ('wptb_delete_row' );
		// store bar_id of row that was deleted for 5 minutes to display on next refresh
		set_transient( 'wptb_row_deleted', $wptb_barid, 5*60 );
		wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');				
	}		
	else {
		wtpb_check_for_plugin_upgrade($wptb_debug);
		if ( isset( $wptb_barid ) )
			$wptbOptions = wptb_get_Specific_TopBar($wptb_barid,true);
		else
			$wptbOptions = array();
	}

	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Version ',$wptbOptions['wptb_version'],'</code>';

    switch ( $action ) :
        case 'enable' :
        case 'disable' :
	        wptb_toggle_enabled($action,$wptb_barid,$wptbOptions,$wptb_debug);
/*
			wptb_display_admin_header();
        	wptb_options_tabs($action);
            wptb_display_all_TopBars();
*/
            wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table'.$current_page);				
            break;
        case 'duplicate' :
  			// make sure “&noheader=true” is added to the page that called this to make WP wait before the it outputs any of the HTML.
  			// then the redirect will work!  Also, debug is forced off to ensure no output occurs before redirect
  			$wptbOptions=wptb_get_Specific_TopBar($wptb_barid, false);
  			$wptbOptions['enable_topbar']='false';
  			wtpb_insert_row($wptbOptions, false);
			global $wpdb;
			// store number of rows affected for 5 minutes to display on next refresh
			set_transient( 'wptb_inserted_rows', $wpdb->rows_affected, 5*60 );
			wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table'.$current_page);					
        	break;
        	             
        case 'export' :
			wptb_display_admin_header();
        	wptb_options_tabs($action);
        	wptb_display_export_options();
        	break;
        
//        case 'exportcsv' :
//			wptb_export_options_csv();
//			wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');
//          break;
//        case 'exportjson' :
//			wptb_export_options_json();
//			wp_redirect(get_option('siteurl').'/wp-admin/?page=wp-topbar.php&action=table');
//            break;


        case 'testpriority' :
			wptb_display_admin_header();
            wptb_options_tabs($action);
			wptb_test_topbar(10 ,$wptb_debug);
			break;
        case 'main' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_main_options($wptbOptions);
            break;
        case 'control' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_control_options($wptbOptions);
            break;
        case 'topbarcss' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_topbarcss_options($wptbOptions);
            break;
        case 'colorselection' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_colorselection_options($wptbOptions);
            break;
        case 'topbartext' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_topbartext_options($wptbOptions);
            break;
        case 'closebutton' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_closebutton_options($wptbOptions);
            break;
        case 'delete' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_delete_options($wptbOptions);
            break;
        case 'faq' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_faq_page($wptbOptions,true);
            break;        
        case 'mainfaq' :
			wptb_display_admin_header();
        	wptb_options_tabs($action);
            wptb_faq_page($wptbOptions,false);
            break;
        case 'socialbuttons' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
        	wptb_display_common_info($wptbOptions);
            wptb_socialbutton_options($wptbOptions);
            break;
        case 'debug' :
			wptb_display_admin_header();
			wptb_bar_edit_options_tabs($action,$wptb_barid);
			wptb_display_common_info($wptbOptions);
            wptb_debug_options($wptbOptions);
            break;
        case 'insertdefault' :
			wptb_display_admin_header();
        	wptb_options_tabs('table');
    		echo '<div class="updated"><p><strong>Inserted default row.</strong></p></div>';
        	wptb_display_all_TopBars();
            break;        
        default :
			wptb_display_admin_header();
        	wptb_options_tabs('table');
        	wptb_display_all_TopBars();
            break;
        endswitch;

}  // end function wptb_options_page





//=========================================================================			
// Main Options
//=========================================================================			


		
function wptb_main_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
	$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Main Options</code>';

	?>

	<script type='text/javascript'>
		jQuery(document).ready(function() {
	
		jQuery('#wptbstarttimebtn').datetimepicker();
		jQuery('#wptbendtimebtn').datetimepicker();
	
		jQuery('#wptbstarttimebtnClear').click( function(e) {jQuery('#wptbstarttimebtn').val('0').change(); } );
		jQuery('#wptbtimebtnClear').click( function(e) {jQuery('#wptbendtimebtn').val('0').change(); } );
				
	});
 	</script>
 	
 	
 	<div class="postbox">
	<h3><a name="MainOptions">Main Options</a></h3>
	<div class="inside">
		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td width="150">Enable TopBar:</label></td>
					<td>
						<label for="wptb_enable_topbar"><input type="radio" id="wptb_enable_topbar" name="wptbenabletopbar" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenabletopbar_no"><input type="radio" id="wptbenabletopbar_no" name="wptbenabletopbar" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>				
					</td>
					<td>
						<p class="sub"><em>This allows you to turn off the TopBar without disabling the plugin.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Priority:</label></td>
					<td>
						<input type="text" name="wptbpriority" id="priority" size="30" value="<?php echo $wptbOptions['weighting_points']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the relative priorty (1 to 100) for the TopBar to show.  A higher number means this TopBar will be selected more frequently; a lower number means less frequently.  (See the <a <?php echo 'href="?page=wp-topbar.php&action=faq&barid='.$wptbOptions['bar_id'].'"'; ?>">FAQ</a> for more details.) Default is <code>25</code>.</em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">TopBar Location:</label></td>
					<td>
					<label for="wptb_topbar_pos_header"><input type="radio" id="wptb_topbar_pos_header" name="wptbtopbarpos" value="header" <?php if ($wptbOptions['topbar_pos'] == "header") { _e('checked="checked"', "wptb"); }?>/> Above Header</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_topbar_pos_footer"><input type="radio" id="wptb_topbar_pos_footer" name="wptbtopbarpos" value="footer" <?php if ($wptbOptions['topbar_pos'] == "footer") { _e('checked="checked"', "wptb"); }?> /> Below Footer</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
							<p class="sub"><em>Select where you want to TopBar to be located. Default is <code>Above Header</code></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">Start Delay:</label></td>
					<td>
						<input type="text" name="wptbdelayintime" id="delayintime" size="30" value="<?php echo $wptbOptions['delay_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to delay before appearing.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Slide Time:</label></td>
					<td>
						<input type="text" name="wptbslidetime" id="slidetime" size="30" value="<?php echo $wptbOptions['slide_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Display Time:</label></td>
					<td>
						<input type="text" name="wptbdisplaytime" id="displaytime" size="30" value="<?php echo $wptbOptions['display_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to remain on the page.  Enter 0 for the TopBar to not disappear.</em></p>
					</td>
				</tr>							
				<tr valign="top">
					<td width="150">Starting Time:</label></td>
					<td>
						<div class="wptb-date-picker-container"> <input type="text" id="wptbstarttimebtn" name="wptbstarttime" size="30" value="<?php echo $wptbOptions['start_time']; ?>"></label></div><p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbstarttimebtnClear">Set Start Time to Zero</p>									  
						<div id="wptb_start_time"></div>				    
					</td>
					<td>
							<p class="sub"><em>Pick the date/time for the TopBar to start showing.  Default is <code>zero</code>.</em></p>
					</td>
				</tr>							
				<tr valign="top">
					<td width="150">Ending Time:</label></td>
					<td>
						<input type="text" id="wptbendtimebtn" name="wptbendtime" size="30" value="<?php echo $wptbOptions['end_time']; ?>"></label>	<p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbtimebtnClear">&nbspSet End Time to Zero</p>							  
						<div id="wptb_end_time"></div>				    
					</td>
					<td>
							<p class="sub"><em>Pick the date/time for the TopBar to stop showing.  Of course, it must be after the start time. Select 0 for the TopBar to never disappear.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Bottom border height (px):</label></td>
					<td>
						<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the height of the bottom of the border.  Default is <code>3px</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Top padding (px):</label></td>
					<td>
						<input type="text" name="wptbpaddingtop" id="paddingtop" size="5" value="<?php echo $wptbOptions['padding_top']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the top padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom padding (px):</label></td>
					<td>
						<input type="text" name="wptbpaddingbottom" id="paddingbottom" size="5" value="<?php echo $wptbOptions['padding_bottom']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the bottom padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>		
				<tr valign="top">
					<td width="150">Top margin (px):</label></td>
					<td>
						<input type="text" name="wptbmargintop" id="margintop" size="5" value="<?php echo $wptbOptions['margin_top']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the top margin.  Default is <code>0px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom margin (px):</label></td>
					<td>
						<input type="text" name="wptbmarginbottom" id="marginbottom" size="5" value="<?php echo $wptbOptions['margin_bottom']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the bottom margin.  Default is <code>0px</code></em></p>
					</td>
				</tr>				
				<tr valign="top">
					<td width="150">Font size (px):</label></td>
					<td>
						<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the font size.  Default is <code>14px</code></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">Text alignment:</label></td>
					<td>
					<label for="wptb_text_align_left"><input type="radio" id="wptb_text_align_left" name="wptbtextalign" value="left" <?php if ($wptbOptions['text_align'] == "left") { _e('checked="checked"', "wptb"); }?>/> Left</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_text_align"><input type="radio" id="wptb_text_align" name="wptbtextalign" value="center" <?php if ($wptbOptions['text_align'] == "center") { _e('checked="checked"', "wptb"); }?> /> Center</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_text_align_right"><input type="radio" id="wptb_text_align_right" name="wptbtextalign" value="right" <?php if ($wptbOptions['text_align'] == "right") { _e('checked="checked"', "wptb"); }?>/> Right</label>	
					</td>
					<td>
							<p class="sub"><em>Select how you want the text to align. Default is <code>center</code> When using right -- try adding padding via the TopBar CSS tab. e.g. </em><code>padding-right:10px;</code></p>
					</td>
				</tr>
			</table>
		</div>
		<table>
		<tr>
			<td style="valign:top; width:500px;"><p class="submit">
				<input type="submit" style="<?php _e( $wptb_submit_style, 'wptb' ); ?>" name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>	<div class="clear"></div>	
		</div>
	</div> <!-- end of Main Options -->
	
	<?
}	// End of wptb_main_options





?>