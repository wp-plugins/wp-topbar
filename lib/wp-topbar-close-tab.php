<?php 

/*
Close Options Tab
*/


//=========================================================================			
// Close Button Options
//=========================================================================			


function wptb_closebutton_bulk_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Close Button Bulk Options</code>';


	$allow_close = "no";
	$respect_cookie = "ignore";
	$cookie_value = "1";
	$close_button_image = str_ireplace( 'https://','http://',plugins_url('/images/close.png', __FILE__) );
	$close_button_css = 'vertical-align:text-bottom;float:right;'; 

	$row_count = $wpdb->get_var(  'SELECT COUNT(*) FROM '.$wptb_table_name );

	$allow_close_max   = $wpdb->get_var( ( 'SELECT MAX(`allow_close`) FROM '.$wptb_table_name ) );
	$allow_close_count = $wpdb->get_var( ( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `allow_close` = "'.$allow_close_max.'"' ) );
	if ( $allow_close_count == $row_count) $allow_close = $allow_close_max;

	$respect_cookie_max   = $wpdb->get_var( ( 'SELECT MAX(`respect_cookie`) FROM '.$wptb_table_name ) );
	$respect_cookie_count = $wpdb->get_var( ( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `respect_cookie` = "'.$respect_cookie_max.'"' ) );
	if ( $respect_cookie_count == $row_count) $respect_cookie = $respect_cookie_max;

	$cookie_value_max   = $wpdb->get_var( ( 'SELECT MAX(`cookie_value`) FROM '.$wptb_table_name ) );
	$cookie_value_count = $wpdb->get_var( ( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `cookie_value` = "'.$cookie_value_max.'"' ) );
	if ( $cookie_value_count == $row_count) $cookie_value = $cookie_value_max;

	$close_button_image_max   = $wpdb->get_var( ( 'SELECT MAX(`close_button_image`) FROM '.$wptb_table_name ) );
	$close_button_image_count = $wpdb->get_var( ( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `close_button_image` = "'.$close_button_image_max.'"' ) );
	if ( $close_button_image_count == $row_count) $close_button_image = $close_button_image_max;

	$close_button_css_max   = $wpdb->get_var( ( 'SELECT MAX(`close_button_css`) FROM '.$wptb_table_name ) );
	$close_button_css_count = $wpdb->get_var( ( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `close_button_css` = "'.$close_button_css_max.'"' ) );
	if ( $close_button_css_count == $row_count) $close_button_css = $close_button_css_max;

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: Allow Close=['.$allow_close.'] / Respect Cookie=['.$respect_cookie.']</code>';



	?>
	
	<div class="postbox">
										
	<h3><a name="CloseButton">Close Button</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings to allow you to reset all TopBars to use the same values for the Close Button.
		<br><br>This plugin can use a cookie to remember if the user closed the TopBar.   If you enable cookies, then a cookie is created if the user closes the TopBar.  If the value stored in the cookie matches the Cookie Value (below), then the TopBar will not be shown on subsequent page views.  If you disable the use of cookies, then the plugin will delete the users cookies the next time the page is loaded.
		<br><br>To have a consistent user experience, <strong>ALL</strong> TopBars need to use the same settings.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
					<td width="150">Allow TopBar to be closed by user:</label></td>
					<td>
					 	<p id="radio1" class="ui-button ui-button-wptbset">
							<input type="radio" id="wptballowcloseb1" name="wptballowclose" class="ui-helper-hidden-accessible" value="yes" <?php if ($allow_close == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptballowcloseb1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
							<input type="radio" id="wptballowcloseb2" name="wptballowclose" class="ui-helper-hidden-accessible" value="no" <?php if ($allow_close == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptballowcloseb2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
						</p>						
					</td>
					<td>
						<p class="sub"><em>Allows the user to close the TopBar.  Default is <code>No</code></em></p>
					</td>
				</tr>					
				<tr valign="top">
					<td width="150">Enable Cookies:</label></td>
					<td>						
					 	<p id="radio2" class="ui-button ui-button-wptbset">
							<input type="radio" id="wptbrespectcookieb1" name="wptbrespectcookie" class="ui-helper-hidden-accessible" value="always" <?php if ($respect_cookie == "always") { _e('checked="checked"', "wptb"); }?>><label for="wptbrespectcookieb1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
							<input type="radio" id="wptbrespectcookieb2" name="wptbrespectcookie" class="ui-helper-hidden-accessible" value="ignore" <?php if ($respect_cookie == "ignore") { _e('checked="checked"', "wptb"); }?>><label for="wptbrespectcookieb2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
						</p>					
					
					</td>
					<td>
							<p class="sub"><em>Enable use of cookies to control TopBar behavior.  Default is <code>No</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Cookie Value:</label></td>
					<td>
						<input type="text" name="wptbcookievalue" id="cookievalue" size="10" value="<?php echo stripslashes($cookie_value); ?>" >
					</td>
					<td>
							<p class="sub"><em>Change this value to force the cookie to reshow.  Default is <code>1</code></em></p>
					</td>
				</tr>				
				<tr valign="top">
					<td width="150">Enter the CSS for the Close Button:</label></td>
					<td>
					<textarea name="wptbclosecss" id="closecss" rows="2" cols="100"><?php echo stripslashes($close_button_css); ?></textarea>
					</td>
					<td>
						<p class="sub"><em>Default is <code>vertical-align:text-bottom;float:right;</code></em></p>
					</td>
				</tr>	
		
				<tr valign="top">
					<th scope="row">Close Button Image URL:</th>
					<td><label for="wptbupload_closebutton">
					<input id="wptbupload_closebutton" type="text" size="85" name="wptbcloseimage" value="<?php echo $close_button_image; ?>" />
					<input class="browse_upload button" name="wptbcloseimage" id="wptbupload_closebutton_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
					
					</td><td><p class="sub"><em>Enter a URL or upload an image for the close button on the TopBar.</em></p>
					</label></td>
				</tr>					
			</table>
		</div>
		<table>
		<tr>
			<td style="valign:top; width:500px;"><p class="submit">
				<input type="submit" style="<?php _e( $wptb_submit_style, 'wptb' ); ?>" name="update_wptbCloseButton" value="<?php _e('Replace ALL Close Button Settings', 'wptb') ?>" />
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Close Button Settings -->
	
	<?php 
}	// End of wptb_closebutton_bulk_options


function wptb_closebutton_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Close Button Options</code>';

	?>
	
	<div class="postbox">
										
	<h3><a name="CloseButton">Close Button</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings to allow the user to close the TopBar.
		<br><br>This plugin can use a cookie to remember if the user closed the TopBar.   If you enable cookies, then a cookie is created if the user closes the TopBar.  If the value stored in the cookie matches the Cookie Value (below), then the TopBar will not be shown on subsequent page views.  If you disable the use of cookies, then the plugin will delete the users cookies the next time the page is loaded.
		<br><br>To be used effecively, <strong>ALL</strong> TopBars must use the same settings. Use the <a <?php echo 'href="?page=wp-topbar.php&action=bulkclosebutton"'; ?>>Close Button tab</a> to set all TopBars to the same seetings.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
						<td width="150">Allow TopBar to be closed by user:</label></td>
						<td>
						 	<p id="radio3" class="ui-button ui-button-wptbset">
								<input type="radio" id="wptballowclose1" name="wptballowclose" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbOptions['allow_close'] == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptballowclose1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
								<input type="radio" id="wptballowclose2" name="wptballowclose" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbOptions['allow_close'] == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptballowclose2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
							</p>						
						</td>
						<td>
								<p class="sub"><em>Allows the user to close the TopBar.  Default is <code>No</code></em></p>
						</td>
				</tr>					
				<tr valign="top">
					<td width="150">Enable Cookies:</label></td>
						<td>
						 	<p id="radio4" class="ui-button ui-button-wptbset">
								<input type="radio" id="wptbrespectcookie1" name="wptbrespectcookie" class="ui-helper-hidden-accessible" value="always" <?php if ($wptbOptions['respect_cookie'] == "always") { _e('checked="checked"', "wptb"); }?>><label for="wptbrespectcookie1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
								<input type="radio" id="wptbrespectcookie2" name="wptbrespectcookie" class="ui-helper-hidden-accessible" value="ignore" <?php if ($wptbOptions['respect_cookie'] == "ignore") { _e('checked="checked"', "wptb"); }?>><label for="wptbrespectcookie2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
							</p>											
						</td>
					<td>
							<p class="sub"><em>Enable use of cookies to control TopBar behavior.  Default is <code>No</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Cookie Value:</label></td>
					<td>
						<input type="text" name="wptbcookievalue" id="cookievalue" size="10" value="<?php echo stripslashes($wptbOptions['cookie_value']); ?>" >
					<?php	
						if ( $wptbOptions['past_cookie_values'] != "" ) {
							echo "<p>Your previous cookie value was: ".$wptbOptions['past_cookie_values'];
						}
					?>
					</td>
					<td>
							<p class="sub"><em>Change this value to force the cookie to reshow.  See <a href='?page=wp-topbar.php&action=faq&barid=<?php echo ($wptb_barid_prefix+$wptbOptions['bar_id']); ?>'>FAQ</a>.  Default is <code>1</code></em></p>
					</td>
				</tr>				
				<tr valign="top">
					<td width="150">Enter the CSS for the Close Button:</label></td>
					<td>
					<textarea name="wptbclosecss" id="closecss" rows="2" cols="100"><?php echo stripslashes($wptbOptions['close_button_css']); ?></textarea>
					</td>
					<td>
						<p class="sub"><em>Default is <code>vertical-align:text-bottom;float:right;</code></em></p>
					</td>
				</tr>	
		
				<tr valign="top">
					<th scope="row">Close Button Image URL:</th>
					<td><label for="wptbupload_closebutton">
					<input id="wptbupload_closebutton" type="text" size="85" name="wptbcloseimage" value="<?php echo $wptbOptions['close_button_image']; ?>" />
					<input class="browse_upload button" name="wptbcloseimage" id="wptbupload_closebutton_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
					
					</td><td><p class="sub"><em>Enter a URL or upload an image for the close button on the TopBar.</em></p>
					</label></td>
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
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Close Button Settings -->
	
	<?php 
}	// End of wptb_closebutton_options



?>