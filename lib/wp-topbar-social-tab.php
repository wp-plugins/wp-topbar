<?php 

/*
Social Tab 
*/



//=========================================================================			
// Social Button Options
//=========================================================================			


function wptb_socialbutton_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_socialbutton_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

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

				<?php
				
			for ($i=1; $i<=10; $i++)  {
			
				if (! isset($wptbOptions['social_icon'.$i.'_position']) ) {
//					$wptbOptions['social_icon'.$i] = "off";
//					$wptbOptions['social_icon'.$i.'_link_target'] = "blank";
//					$wptbOptions['social_icon'.$i.'_image'] = "";
//					$wptbOptions['social_icon'.$i.'_link'] = "";
//					$wptbOptions['social_icon'.$i.'_css'] = "";
					$wptbOptions['social_icon'.$i.'_position'] = "right";
				}
				
				
				echo '
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon '.$i.':<br>';
					
				if ( ! ($wptbOptions['social_icon'.$i.'_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon'.$i.'_image'].'"/>', 'wptb' );

				
				echo '
				</td>
				<td valign="top" >
					<label for="wptb_social_icon'.$i.'"><input type="checkbox" id="wptb_social_icon'.$i.'" name="wptbsocialicon'.$i.'" value="on"';
					
				if ($wptbOptions['social_icon'.$i] == "on") { _e('checked="checked"', "wptb"); }
				echo '/> Enable</label>
				';
						
				echo '<br>Social Icon '.$i.' URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon'.$i.'" type="text" size="85" name="wptbsocialicon'.$i.'image" value="'.$wptbOptions['social_icon'.$i.'_image'].'" />
					<input class="browse_upload button" id="wptbupload_social_icon'.$i.'_button" type="button" style="'.$wptb_special_button_style.'" value="Upload Image" />
					';
					
//link
				echo '	
				<br>Social Icon '.$i.' Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon'.$i.'link" id="link" size="100" value="'.stripslashes($wptbOptions['social_icon'.$i.'_link']).'" >';
//link target				
				echo '	
				<br>Social Icon '.$i.' Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio'.$i.'" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon'.$i.'linktarget1" name="wptbicon'.$i.'linktarget" class="ui-helper-hidden-accessible" value="blank"';
						
				if ($wptbOptions['social_icon'.$i.'_link_target'] == "blank") { _e('checked="checked"', "wptb"); }
				echo '><label for="wptbicon'.$i.'linktarget1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_blank</span></label>
						<input type="radio" id="wptbicon'.$i.'linktarget2" name="wptbicon'.$i.'linktarget" class="ui-helper-hidden-accessible" value="self"';
				if ($wptbOptions['social_icon'.$i.'_link_target'] == "self") { _e('checked="checked"', "wptb"); };
				echo '><label for="wptbicon'.$i.'linktarget2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_self</span></label>
						<input type="radio" id="wptbicon'.$i.'linktarget3" name="wptbicon'.$i.'linktarget" class="ui-helper-hidden-accessible" value="parent"';
				if ($wptbOptions['social_icon'.$i.'_link_target'] == "parent") { _e('checked="checked"', "wptb"); };
				echo '><label for="wptbicon'.$i.'linktarget3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_parent</span></label>
						<input type="radio" id="wptbicon'.$i.'linktarget4" name="wptbicon'.$i.'linktarget" class="ui-helper-hidden-accessible" value="top"';
				if ($wptbOptions['social_icon'.$i.'_link_target'] == "top") { _e('checked="checked"', "wptb"); };
				echo '><label for="wptbicon'.$i.'linktarget4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">_top</span></label>
					 	</p>			
				<br>';

//css					
				echo '
				<br>Social Icon '.$i.' CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon'.$i.'css" id="wptb_socialicon'.$i.'_css" rows="2" cols="100">'.$wptbOptions['social_icon'.$i.'_css'].'</textarea>';
					
// position 

				echo '	
				<br>Social Icon '.$i.' Position:&nbsp;&nbsp;&nbsp;&nbsp;
					 	<p id="radio1'.$i.'" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbicon'.$i.'position1" name="wptbicon'.$i.'position" class="ui-helper-hidden-accessible" value="left"';
						
				if ($wptbOptions['social_icon'.$i.'_position'] == "left") { _e('checked="checked"', "wptb"); }
				echo '><label for="wptbicon'.$i.'position1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Left</span></label>
						<input type="radio" id="wptbicon'.$i.'position2" name="wptbicon'.$i.'position" class="ui-helper-hidden-accessible" value="right"';
				if ($wptbOptions['social_icon'.$i.'_position'] == "right") { _e('checked="checked"', "wptb"); };
				echo '><label for="wptbicon'.$i.'position2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Right</span></label>
					 	</p>			
				<br>';				
				
				if ( ! ($wptbOptions['social_icon'.$i.'_image'] == "") ) {
						if ( ini_get("allow_url_fopen") ) {
							list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon'.$i.'_image']);
							if ($width != '')
								echo "Image size: ".$width." px (w) x ".$height." px (h).";
						}
					}
				
				echo '
					</td>
				</tr>';


			}	
				
				
			?>
				
				
							
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