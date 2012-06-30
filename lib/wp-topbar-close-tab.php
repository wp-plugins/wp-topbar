<?php 

/*
Plugin Name: WP-TopBar
Close Options Tab
*/


//=========================================================================			
// Close Button Options
//=========================================================================			


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
		<br><br>This plugin can use a cookie to remember if the user closed the TopBar.   If you enable cookies, then a cookie is created if the user closes the TopBar.  If the value stored in the cookie matches the Cookie Value (below), then the TopBar will not be shown on subsequent page views.  If you disable the use of cookies, then the plugin will delete the users cookies the next time the page is loaded.</em></p>
		
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
					<?php	  $wptbPastValues = $wptbOptions['past_cookie_values'];
						if ( count ( $wptbPastValues ) > 0 ) {
							echo "<p>Your past ".count ( $wptbPastValues )." previous cookie value(s) are:";
							foreach ($wptbPastValues as $i => $value) {
			  					echo '<br>[',$i+1,']: <code>',$value.'</code>';
							}
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