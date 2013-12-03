<?php 

/*
Close Options Tab
*/


//=========================================================================			
// Close Button Options
//=========================================================================			


function wptb_globalsettings_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;   
			
	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_globalsettings_options()</code>';
	
	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	
	$wptbRotateTopbars 		= $wptbGlobalOptions [ 'rotate_topbars' ];
	$wptbRotateDisplayTime 	= $wptbGlobalOptions [ 'rotate_display_time' ];
	$wptbRotateStartDelay 	= $wptbGlobalOptions [ 'rotate_start_delay' ];
	
	?>

	
	<div class="postbox">
										
	<h3><a name="CloseButton">Global Settings</a></h3>
										
	<div class="inside">
		<p class="sub"><em>This page contains the Global Settings that effect all TopBars.</em>
		<br>
		</p>
		
		<div class="table">
			<table class="form-table">	
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150">Rotate TopBars:</label></td>
					<td>
					 	<p id="radio1" class="ui-button ui-button-wptbset">
							<input type="radio" id="wptbrotatetopbars1" name="wptbrotatetopbars" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbRotateTopbars == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptbrotatetopbars1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
							<input type="radio" id="wptbrotatetopbars2" name="wptbrotatetopbars" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbRotateTopbars == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptbrotatetopbars2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
						</p>						
					</td>
					<td>
						<p class="sub"><em>TopBars will rotate, after a user set delay.  Note that the Scrollable Option, Close Button and Re-Open options on each TopBar are ignored.  That is, the TopBars that are displayed will not be Scrollable nor can they be Closed (or Reopened).  Default is <code>No</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Rotation Start Delay:</td>
					<td>
						<input type="text" name="wptbrotatestartdelay" id="rotatestartdelay" size="30" value="<?php echo $wptbRotateStartDelay; ?>" >
						<div id="wtpb-rotatestartdelay"></div>
					</td>
					<td>
						<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to delay before displaying each TopBar.  No TopBar will be displayed during this time.  Enter 0 for no delay. Default is <code>1000</code>.</em></p>
					</td>
				</tr>					
				<tr valign="top">
					<td width="150">Rotation Display Time:</td>
					<td>
						<input type="text" name="wptbrotatedisplaytime" id="rotatedisplaytime" size="30" value="<?php echo $wptbRotateDisplayTime; ?>" >
						<div id="wtpb-rotatedisplaytime"></div>
					</td>
					<td>
						<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to display before rotating for the next TopBar.  Enter 0 for no delay (not recommended!)  Default is <code>9000</code>.</em></p>
					</td>
				</tr>	
				<tr>
					<td colspan="3"><hr></td>
				</tr>								
			</table>
		</div>
		<table>
		<tr>
			<td style="valign:top; width:500px;"><p class="submit">
				<input type="submit" style="<?php _e( $wptb_submit_style, 'wptb' ); ?>" name="update_wptbGlobalSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Close Button Settings -->
						
	<div class="postbox">
	<h3><a name="Debug">Server/Install Info</a></h3>
	<div class="inside">
		<ul>
			<li><strong>Database/Column Check:</strong></br>
<?php


	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";

	$wptb_bar_text_encoding=$wpdb->get_col(  
	"
		SELECT 
		  COLLATION_NAME
		  FROM information_schema.COLUMNS
		  where TABLE_NAME = '".$wptb_table_name."'
		  	AND COLUMN_NAME = 'bar_text';
		  	"
	); 	
	
	$wptb_bar_link_text_encoding=$wpdb->get_col(  
	"
		SELECT 
		  COLLATION_NAME
		  FROM information_schema.COLUMNS
		  where TABLE_NAME = '".$wptb_table_name."'
		  	AND COLUMN_NAME = 'bar_link_text';
		  	"
	); 	
	
	echo "Charset <small><i>(DB_CHARSET)</i></small>: <strong>".DB_CHARSET."</strong></br>";
	echo "Collation <small><i>(DB_COLLATE)</i></small>: <strong>".DB_COLLATE."</strong></br>";
	echo "bar_text encoding: <strong>".$wptb_bar_text_encoding[0]."</strong></br>";
	echo "bar_link_text encoding: <strong>".$wptb_bar_link_text_encoding[0]."</strong></br>";
	echo "wp-tobar internal db version: <strong>".get_option( "wptb_db_version" )."</strong></br>";
	echo "</br>";
	?>
				</li>
				<li><strong>Time Check:</strong></br>
	<?php
	$wptb_current_time=current_time('timestamp', 1);
	echo 'Server Timezone:   <strong>',date_default_timezone_get(),'</strong></br>';
	echo 'Current Time:      <strong>',date('m/d/Y H:i (e)',$wptb_current_time),'</strong></br>';		
	echo "</br>";
	

	
	
}	// End of wptb_closebutton_bulk_options



?>