<?php 

/*
Social Tab 
*/



//=========================================================================			
// Social Button Options
//=========================================================================			


function wptb_socialbutton_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Social Button Options</code>';

	?>

	<div class="postbox">
										
	<h3><a name="SocialButtons">Social Button Settings</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings for settings the Social Buttons.
		<br><br>You have four buttons that you can add to the TopBar.  Each allows you to set the image, link and CSS.  The CSS is applied the the <code>&lt img &gt</code> tag.
		<br>
		<br><em>Link Target Options:
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _blank - 	Opens the linked document in a new window or tab (this is default)
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _self	-	Opens the linked document in the same frame as it was clicked
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _parent -	Opens the linked document in the parent frame
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _top	-	Opens the linked document in the full body of the windowtext to align.</em></p>
		<br>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
					<th scope="row">Social Icons:</th>
				</tr>
				<tr>
				<td valign="top"> 
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 1:<br>	
					<?php if ( ! ($wptbOptions['social_icon1_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon1_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon1"><input type="checkbox" id="wptb_social_icon1" name="wptbsocialicon1" value="on" <?php if ($wptbOptions['social_icon1'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 1 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon1" type="text" size="85" name="wptbsocialicon1image" value="<?php echo $wptbOptions['social_icon1_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon2_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 1 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon1link" id="link" size="100" value="<?php echo stripslashes($wptbOptions['social_icon1_link']); ?>" >
				<br>Social Icon 1 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio1" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon1linktarget1" name="wptbicon1linktarget" class="ui-helper-hidden-accessible" value="blank" <?php if ($wptbOptions['social_icon1_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon1linktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptbicon1linktarget2" name="wptbicon1linktarget" class="ui-helper-hidden-accessible" value="self" <?php if ($wptbOptions['social_icon1_link_target'] == "self") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon1linktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptbicon1linktarget3" name="wptbicon1linktarget" class="ui-helper-hidden-accessible" value="parent" <?php if ($wptbOptions['social_icon1_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon1linktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptbicon1linktarget4" name="wptbicon1linktarget" class="ui-helper-hidden-accessible" value="top" <?php if ($wptbOptions['social_icon1_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon1linktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>				
				<br>Social Icon 1 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon1css" id="wptb_socialicon1_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon1_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon1_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon1_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 2:<br>	
					<?php if ( ! ($wptbOptions['social_icon2_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon2_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon2"><input type="checkbox" id="wptb_social_icon2" name="wptbsocialicon2" value="on" <?php if ($wptbOptions['social_icon2'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 2 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon2" type="text" size="85" name="wptbsocialicon2image" value="<?php echo $wptbOptions['social_icon2_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon2_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 2 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon2link" id="link" size="100" value="<?php echo stripslashes($wptbOptions['social_icon2_link']); ?>" >
				<br>Social Icon 2 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio2" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon2linktarget1" name="wptbicon2linktarget" class="ui-helper-hidden-accessible" value="blank" <?php if ($wptbOptions['social_icon2_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon2linktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptbicon2linktarget2" name="wptbicon2linktarget" class="ui-helper-hidden-accessible" value="self" <?php if ($wptbOptions['social_icon2_link_target'] == "self") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon2linktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptbicon2linktarget3" name="wptbicon2linktarget" class="ui-helper-hidden-accessible" value="parent" <?php if ($wptbOptions['social_icon2_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon2linktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptbicon2linktarget4" name="wptbicon2linktarget" class="ui-helper-hidden-accessible" value="top" <?php if ($wptbOptions['social_icon2_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon2linktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>						
				<br>Social Icon 2 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon2css" id="wptb_socialicon2_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon2_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon2_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon2_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 3:<br>	
					<?php if ( ! ($wptbOptions['social_icon3_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon3_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon3"><input type="checkbox" id="wptb_social_icon3" name="wptbsocialicon3" value="on" <?php if ($wptbOptions['social_icon3'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 3 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon3" type="text" size="85" name="wptbsocialicon3image" value="<?php echo $wptbOptions['social_icon3_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon3_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 3 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon3link" id="link" size="100" value="<?php echo stripslashes($wptbOptions['social_icon3_link']); ?>" >
				<br>Social Icon 3 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio3" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon3linktarget1" name="wptbicon3linktarget" class="ui-helper-hidden-accessible" value="blank" <?php if ($wptbOptions['social_icon3_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon3linktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptbicon3linktarget2" name="wptbicon3linktarget" class="ui-helper-hidden-accessible" value="self" <?php if ($wptbOptions['social_icon3_link_target'] == "self") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon3linktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptbicon3linktarget3" name="wptbicon3linktarget" class="ui-helper-hidden-accessible" value="parent" <?php if ($wptbOptions['social_icon3_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon3linktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptbicon3linktarget4" name="wptbicon3linktarget" class="ui-helper-hidden-accessible" value="top" <?php if ($wptbOptions['social_icon3_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon3linktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>								
				<br>Social Icon 3 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon3css" id="wptb_socialicon3_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon3_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon3_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon3_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 4:<br>	
					<?php if ( ! ($wptbOptions['social_icon4_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon4_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon4"><input type="checkbox" id="wptb_social_icon4" name="wptbsocialicon4" value="on" <?php if ($wptbOptions['social_icon4'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 4 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon4" type="text" size="85" name="wptbsocialicon4image" value="<?php echo $wptbOptions['social_icon4_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon4_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 4 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon4link" id="link" size="100" value="<?php echo stripslashes($wptbOptions['social_icon4_link']); ?>" >
				<br>Social Icon 4 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon4css" id="wptb_socialicon4_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon4_css']; ?></textarea>
				<br>Social Icon 4 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio4" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon4linktarget1" name="wptbicon4linktarget" class="ui-helper-hidden-accessible" value="blank" <?php if ($wptbOptions['social_icon4_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon4linktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptbicon4linktarget2" name="wptbicon4linktarget" class="ui-helper-hidden-accessible" value="self" <?php if ($wptbOptions['social_icon4_link_target'] == "self") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon4linktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptbicon4linktarget3" name="wptbicon4linktarget" class="ui-helper-hidden-accessible" value="parent" <?php if ($wptbOptions['social_icon4_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon4linktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptbicon4linktarget4" name="wptbicon4linktarget" class="ui-helper-hidden-accessible" value="top" <?php if ($wptbOptions['social_icon4_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>><label for="wptbicon4linktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>			
				<br>
					<?php if ( ! ($wptbOptions['social_icon4_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon4_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
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
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Social Button Settings -->
	
	<?php 	
}	// End of wptb_socialbutton_options






?>