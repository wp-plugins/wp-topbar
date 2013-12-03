<?php 

/*
Textbar Options Tab
*/


//=========================================================================			
// TopBar Text Options
//=========================================================================			


function wptb_topbartext_options($wptbOptions) {
	
	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_topbartext_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

	?>

	<div class="postbox">
										
	<h3><a name="TopBarText">TopBar Text, Image and Link</a></h3>
										
	<div class="inside">
		<p class="sub"><strong>These are the text, image and links to be used in the TopBar. The image is placed first (if any), then the text (if any) is overlaid on it.  Scale the image to fix your website.  If you enable the image (by selecting "Yes"), then the image will be used and the bar color will be ignored.</strong></p>
		
		<div class="table">
			<table class="form-table">	
				<tr>
					<td colspan="3"><hr></td>
				</tr>				
				<tr valign="top">
					<td width="150">Font size (px):</td>
					<td>
						<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
						<div id="wtpb-fontsize"></div>
						</br>
						<p class="sub"><em>Enter the font size.  Default is <code>14px</code></em></p>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150">Text alignment:</td>
					<td>
				 	<p id="radio1" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbtextalign1" name="wptbtextalign" class="ui-helper-hidden-accessible" value="left" <?php if ($wptbOptions['text_align'] == "left") { _e('checked="checked"', "wptb"); }?>><label for="wptbtextalign1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Left</span></label>
						<input type="radio" id="wptbtextalign2" name="wptbtextalign" class="ui-helper-hidden-accessible" value="center" <?php if ($wptbOptions['text_align'] == "center") { _e('checked="checked"', "wptb"); }?>><label for="wptbtextalign2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Center</span></label>
						<input type="radio" id="wptbtextalign3" name="wptbtextalign" class="ui-helper-hidden-accessible" value="right" <?php if ($wptbOptions['text_align'] == "right") { _e('checked="checked"', "wptb"); }?>><label for="wptbtextalign3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Right</span></label>
				 	</p>					
					</br>
				 	<p class="sub"><em>Select how you want the text to align. Default is <code>center</code> When using right -- try adding padding via the <a href='?page=wp-topbar.php&action=topbarcss&barid=".($wptb_barid_prefix+$wptbOptions['bar_id'])."'>TopBar CSS & HTML</a></em></br>&nbsp;&nbsp;&nbsp;e.g. <code>padding-right:10px;</code></p>
					</td>
				</tr>				
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150">Message:</label></td>
					<td>
						<input type="text" name="wptbbartext" id="bbartext" size="85" value="<?php echo stripslashes($wptbOptions['bar_text']); ?>" >
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
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
					 	<p id="radio2" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptblinktarget1" name="wptblinktarget" class="ui-helper-hidden-accessible" value="blank" <?php if ($wptbOptions['link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>><label for="wptblinktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptblinktarget2" name="wptblinktarget" class="ui-helper-hidden-accessible" value="self" <?php if ($wptbOptions['link_target'] == "self") { _e('checked="checked"', "wptb"); }?>><label for="wptblinktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptblinktarget3" name="wptblinktarget" class="ui-helper-hidden-accessible" value="parent" <?php if ($wptbOptions['link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>><label for="wptblinktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptblinktarget4" name="wptblinktarget" class="ui-helper-hidden-accessible" value="top" <?php if ($wptbOptions['link_target'] == "top") { _e('checked="checked"', "wptb"); }?>><label for="wptblinktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>						
					
							<p class="sub"><em>Select how you want the link to open:</p>
							<p><?php _e(" _blank - 	Opens the linked document in a new window or tab (this is default)") ?></p>
							<p><?php _e(" _self	-	Opens the linked document in the same frame as it was clicked") ?></p>
							<p><?php _e(" _parent -	Opens the linked document in the parent frame") ?></p>
							<p><?php _e(" _top	-	Opens the linked document in the full body of the windowtext to align.") ?></em></p>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="50">Enable image:</label></td>
					<td width="50">
				 	<p id="radio3" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbenableimage1" name="wptbenableimage" class="ui-helper-hidden-accessible" value="true" <?php if ($wptbOptions['enable_image'] == "true") { _e('checked="checked"', "wptb"); }?>><label for="wptbenableimage1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
						<input type="radio" id="wptbenableimage2" name="wptbenableimage" class="ui-helper-hidden-accessible" value="false" <?php if ($wptbOptions['enable_image'] == "false") { _e('checked="checked"', "wptb"); }?>><label for="wptbenableimage2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
					</p>					
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