<?php 

/*
Textbar Options Tab
*/


//=========================================================================			
// TopBar Text Options
//=========================================================================			


function wptb_topbartext_options($wptbOptions) {
	
	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In TopBar Text Options</code>';

	?>

	<div class="postbox">
										
	<h3><a name="TopBarText">TopBar Text, Image and Link</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the text, image and links to be used in the TopBar. The image is placed first (if any), then the text (if any) is overlaid on it.  Scale the image to fix your website.  If you enable the image (by selecting "Yes"), then the image will be used and the bar color will be ignored.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
					<td width="150">Message:</label></td>
					<td>
						<input type="text" name="wptbbartext" id="bbartext" size="85" value="<?php echo stripslashes($wptbOptions['bar_text']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Link Text:</label></td>
					<td>
						<input type="text" name="wptblinktext" id="linktext" size="85" value="<?php echo stripslashes($wptbOptions['bar_link_text']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Link:</label></td>
					<td>
						<input type="text" name="wptblinkurl" id="link" size="100" value="<?php echo stripslashes($wptbOptions['bar_link']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="50">Link Target:</label></td>
					<td>
					<label for="wptb_link_target_blank"><input type="radio" id="wptb_link_target_blank" name="wptblinktarget" value="blank" <?php if ($wptbOptions['link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_self"><input type="radio" id="wptb_link_target_self" name="wptblinktarget" value="self" <?php if ($wptbOptions['link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_parent"><input type="radio" id="wptb_link_target_parent" name="wptblinktarget" value="parent" <?php if ($wptbOptions['link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_top"><input type="radio" id="wptb_link_target_top" name="wptblinktarget" value="top" <?php if ($wptbOptions['link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>	
					<p></p>
							<p class="sub"><em>Select how you want the link to open:</p>
							<p><?php _e(" _blank - 	Opens the linked document in a new window or tab (this is default)") ?></p>
							<p><?php _e(" _self	-	Opens the linked document in the same frame as it was clicked") ?></p>
							<p><?php _e(" _parent -	Opens the linked document in the parent frame") ?></p>
							<p><?php _e(" _top	-	Opens the linked document in the full body of the windowtext to align.") ?></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="50">Enable image:</label></td>
					<td width="50">
						<label for="wptb_enable_image"><input type="radio" id="wptb_enable_image" name="wptbenableimage" value="true" <?php if ($wptbOptions['enable_image'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenableimage_no"><input type="radio" id="wptbenableimage_no" name="wptbenableimage" value="false" <?php if ($wptbOptions['enable_image'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Image URL:</th>
					<td><label for="wptbupload_image">
					<input id="wptbupload_image" type="text" size="85" name="wptbbarimage" value="<?php echo $wptbOptions['bar_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_image_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
					<br /><em>Enter an URL or upload an image for the TopBar.</em)
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
	</div> <!-- end of TopBarText Settings -->
	
	<?php 	
}	// End of wptb_topbartext_options




?>