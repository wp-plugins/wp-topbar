<?php 

/*
Plugin Name: WP-TopBar
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

	$row_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name ) );

	$allow_close_max   = $wpdb->get_var( $wpdb->prepare( 'SELECT MAX(`allow_close`) FROM '.$wptb_table_name ) );
	$allow_close_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `allow_close` = "'.$allow_close_max.'"' ) );
	if ( $allow_close_count == $row_count) $allow_close = $allow_close_max;

	$respect_cookie_max   = $wpdb->get_var( $wpdb->prepare( 'SELECT MAX(`respect_cookie`) FROM '.$wptb_table_name ) );
	$respect_cookie_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `respect_cookie` = "'.$respect_cookie_max.'"' ) );
	if ( $respect_cookie_count == $row_count) $respect_cookie = $respect_cookie_max;

	$cookie_value_max   = $wpdb->get_var( $wpdb->prepare( 'SELECT MAX(`cookie_value`) FROM '.$wptb_table_name ) );
	$cookie_value_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `cookie_value` = "'.$cookie_value_max.'"' ) );
	if ( $cookie_value_count == $row_count) $cookie_value = $cookie_value_max;

	$close_button_image_max   = $wpdb->get_var( $wpdb->prepare( 'SELECT MAX(`close_button_image`) FROM '.$wptb_table_name ) );
	$close_button_image_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `close_button_image` = "'.$close_button_image_max.'"' ) );
	if ( $close_button_image_count == $row_count) $close_button_image = $close_button_image_max;

	$close_button_css_max   = $wpdb->get_var( $wpdb->prepare( 'SELECT MAX(`close_button_css`) FROM '.$wptb_table_name ) );
	$close_button_css_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM '.$wptb_table_name.' WHERE `close_button_css` = "'.$close_button_css_max.'"' ) );
	if ( $close_button_css_count == $row_count) $close_button_css = $close_button_css_max;


	?>
	
	<div class="postbox">
										
	<h3><a name="CloseButton">Close Button</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings to allow you to reset all TopBars to use the same values for the Close Button.
		<br><br>This plugin can use a cookie to remember if the user closed the TopBar.   If you enable cookies, then a cookie is created if the user closes the TopBar.  If the value stored in the cookie matches the Cookie Value (below), then the TopBar will not be shown on subsequent page views.  If you disable the use of cookies, then the plugin will delete the users cookies the next time the page is loaded.
		<br><br>To be used effecively, <strong>ALL</strong> TopBars must use the same settings.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
						<td width="150">Allow TopBar to be closed by user:</label></td>
						<td>
						<label for="wptb_allow_close_yes"><input type="radio" id="allow_close_yes" name="wptballowclose" value="yes" <?php if ($allow_close == "yes") { _e('checked="checked"', "wptb"); }?>/> Yes</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="wptb_allow_close_no"><input type="radio" id="allow_close_no" name="wptballowclose" value="no" <?php if ($allow_close == "no") { _e('checked="checked"', "wptb"); }?> /> No</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
								<p class="sub"><em>Allows the user to close the TopBar.  Default is <code>No</code></em></p>
						</td>
				</tr>					
				<tr valign="top">
					<td width="150">Enable Cookies:</label></td>
					<td>
					<label for="wptb_respect_cookie_use"><input type="radio" id="respect_cookie_use" name="wptbrespectcookie" value="always" <?php if ($respect_cookie == "always") { _e('checked="checked"', "wptb"); }?> /> Yes</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_respect_cookie_ignore"><input type="radio" id="respect_cookie_ignore" name="wptbrespectcookie" value="ignore" <?php if ($respect_cookie == "ignore") { _e('checked="checked"', "wptb"); }?>/> No</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
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
}	// End of wptb_closebutton_options


function wptb_closebutton_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

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
				<tr valign="top">
						<td width="150">Allow TopBar to be closed by user:</label></td>
						<td>
						<label for="wptb_allow_close_yes"><input type="radio" id="allow_close_yes" name="wptballowclose" value="yes" <?php if ($wptbOptions['allow_close'] == "yes") { _e('checked="checked"', "wptb"); }?>/> Yes</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="wptb_allow_close_no"><input type="radio" id="allow_close_no" name="wptballowclose" value="no" <?php if ($wptbOptions['allow_close'] == "no") { _e('checked="checked"', "wptb"); }?> /> No</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
								<p class="sub"><em>Allows the user to close the TopBar.  Default is <code>No</code></em></p>
						</td>
				</tr>					
				<tr valign="top">
					<td width="150">Enable Cookies:</label></td>
					<td>
					<label for="wptb_respect_cookie_use"><input type="radio" id="respect_cookie_use" name="wptbrespectcookie" value="always" <?php if ($wptbOptions['respect_cookie'] == "always") { _e('checked="checked"', "wptb"); }?> /> Yes</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_respect_cookie_ignore"><input type="radio" id="respect_cookie_ignore" name="wptbrespectcookie" value="ignore" <?php if ($wptbOptions['respect_cookie'] == "ignore") { _e('checked="checked"', "wptb"); }?>/> No</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
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
							<p class="sub"><em>Change this value to force the cookie to reshow.  See <a href='?page=wp-topbar.php&action=faq&barid=<?php echo $wptbOptions['bar_id']; ?>'>FAQ</a>.  Default is <code>1</code></em></p>
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