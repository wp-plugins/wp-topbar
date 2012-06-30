<?php 

/*
Plugin Name: WP-TopBar
Color Options Tab
*/



//=========================================================================			
// Color Selection Options
//=========================================================================			

function wptb_colorselection_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Color Selection Options</code>';

	?>
	
	<script type='text/javascript'>
	jQuery(document).ready(function() {

	jQuery('#wptb_colorpicker_bar').hide();
	jQuery('#wptb_colorpicker_bar').farbtastic('#barcolor');
	jQuery('#barcolor').click(function(){jQuery('#wptb_colorpicker_bar').slideDown()});
	jQuery('#barcolor').blur(function(){jQuery('#wptb_colorpicker_bar').slideUp()});

	jQuery('#wptb_colorpicker_text').hide();
	jQuery('#wptb_colorpicker_text').farbtastic('#textcolor');
	jQuery('#textcolor').click(function(){jQuery('#wptb_colorpicker_text').slideDown()});
	jQuery('#textcolor').blur(function(){jQuery('#wptb_colorpicker_text').slideUp()});

	jQuery('#wptb_colorpicker_bottom').hide();
	jQuery('#wptb_colorpicker_bottom').farbtastic('#bottomcolor');
	jQuery('#bottomcolor').click(function(){jQuery('#wptb_colorpicker_bottom').slideDown()});
	jQuery('#bottomcolor').blur(function(){jQuery('#wptb_colorpicker_bottom').slideUp()});
	
	jQuery('#wptb_link_color').hide();
	jQuery('#wptb_link_color').farbtastic('#linkcolor');
	jQuery('#linkcolor').click(function(){jQuery('#wptb_link_color').slideDown()});
	jQuery('#linkcolor').blur(function(){jQuery('#wptb_link_color').slideUp()});	
	
	});
 	</script>
	
	
	<div class="postbox">
										
	<h3><a name="ColorSelection">Color Selection</a></h3>
	
	<div class="inside">
		<p class="sub"><em>Click the color box to select the color to use.  Bar color is NOT used if Image is enabled (that is set on the <a href='?page=wp-topbar.php&action=topbartext&barid=<?php echo $wptbOptions['bar_id']; ?>'>TopBar Text and Image</a> tab.)</em></p>
		<div class="table">
			<table class="form-table">			
				<tr valign="top">
					<td width="200">Color of the Bar:</label></td>
					<td>
				      <input type="text" id="barcolor" name="wptbbarcolor" value="<?php echo $wptbOptions['bar_color']; ?>">
				      <div id="wptb_colorpicker_bar"></div>		
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the bottom border of the Bar:</label></td>
					<td>
				      <input type="text" id="bottomcolor" name="wptbbottomcolor" value="<?php echo $wptbOptions['bottom_color']; ?>">
				      <div id="wptb_colorpicker_bottom"></div>			
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the Message:</label></td>
					<td>
					    <input type="text" id="textcolor" name="wptbtextcolor" value="<?php echo $wptbOptions['text_color']; ?>">
					    <div id="wptb_colorpicker_text"></div>				    
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the Link:</label></td>
					<td>
					    <input type="text" id="linkcolor" name="wptblinkcolor" value="<?php echo $wptbOptions['link_color']; ?>">
					    <div id="wptb_link_color"></div>
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
	</div> <!-- end of ColorSelection Settings -->
	
	<?php

}	// End of wptb_colorselection_options




?>