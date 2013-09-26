<?php 

/*
Main Options Tab
*/


//=========================================================================			
// Main Options
//=========================================================================			


		
function wptb_main_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_main_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';
			    
	?>

 	<div class="postbox">
	<h3><a name="MainOptions">Main Options</a></h3>
	<div class="inside">
		<div class="table">
			<table class="form-table">
				<input name="wptb_update_setting_nonce" type="hidden" value="<?php wp_create_nonce('wptb_update_setting_nonce'); ?>" />			
				<tr valign="top">
					<td width="150">Enable TopBar:</td>
					<td>
				 	<p id="radio1" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbenabletopbar1" name="wptbenabletopbar" class="ui-helper-hidden-accessible" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { _e('checked="checked"', "wptb"); }?>><label for="wptbenabletopbar1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
						<input type="radio" id="wptbenabletopbar2" name="wptbenabletopbar" class="ui-helper-hidden-accessible" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { _e('checked="checked"', "wptb"); }?>><label for="wptbenabletopbar2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
					</p>
					</td>
					<td>
						<p class="sub"><em>This allows you to turn off the TopBar without disabling the plugin.</em></p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150" id="prioritytop"> Priority:</td>
					<td>
						<input type="text" name="wptbpriority" id="priority" size="4" value="<?php echo $wptbOptions['weighting_points']; ?>" >
						<div id="wtpb-priority"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the relative priorty (1 to 100) for the TopBar to show.  A higher number means this TopBar will be selected more frequently; a lower number means less frequently.  (See the <a <?php echo 'href="?page=wp-topbar.php&action=faq&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'"'; ?>>FAQ</a> for more details.) Default is <code>25</code>.</em></p>
					</td>
				</tr>			
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150" id="location">TopBar Location:</td>
					<td>
				 	<p id="radio2" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbtopbarpos1" name="wptbtopbarpos" class="ui-helper-hidden-accessible" value="header" <?php if ($wptbOptions['topbar_pos'] == "header") { _e('checked="checked"', "wptb"); }?>><label for="wptbtopbarpos1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Above Header</span></label>
						<input type="radio" id="wptbtopbarpos2" name="wptbtopbarpos" class="ui-helper-hidden-accessible" value="footer" <?php if ($wptbOptions['topbar_pos'] == "footer") { _e('checked="checked"', "wptb"); }?>><label for="wptbtopbarpos2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Below Footer</span></label>
				 	</p>
					</td>
					<td>
							<p class="sub"><em>Select where you want to TopBar to be located. Default is <code>Above Header</code></em></p>
					</td>
				</tr>	
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150" id="scrollaction">Scroll Action:</td>
					<td>
				 	<p id="radio4" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbscrollaction1" name="wptbscrollaction" class="ui-helper-hidden-accessible" value="on"  <?php if ($wptbOptions['scroll_action'] == "on") { _e('checked="checked"', "wptb"); }?>><label for="wptbscrollaction1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">On</span></label>
						<input type="radio" id="wptbscrollaction2" name="wptbscrollaction" class="ui-helper-hidden-accessible" value="off" <?php if ($wptbOptions['scroll_action'] != "on") { _e('checked="checked"', "wptb"); }?>><label for="wptbscrollaction2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Off</span></label>
				 	</p>
					</td>
					<td>
							<p class="sub"><em>Only show the TopBar when the user scrolls the page?  If the user scrolls back to the top of the page, the TopBar gracefully fades away.  Note, if this is to On, the TopBar ignores the Display Time value below.</br></br>Also, <strong>it works best</strong> when the <a <?php echo 'href="?page=wp-topbar.php&action=topbarcss&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'#divcss"'; ?>>TopBar CSS Option C</a> has it's <code>position</code> fixed: e.g. <code>position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code>.</br></br>Default is <code>Off</code>, this will show the scrollbar even if the user does not scroll the page.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Scroll Amount:</td>
					<td>
						<input type="text" name="wptbscrollamount" id="scrollamount" size="30" value="<?php echo $wptbOptions['scroll_amount']; ?>" >
						<div id="wtpb-scroll-amount"></div>
					</td>
					<td>
							<p class="sub"><em>This option allows you to adjust how far the user has to scroll the page before the Scrollable TopBar appears.   Selecting 0 (zero) will display the TopBar immediately after the user scrolls the page.</br></br>Default is <code>0</code>.</em></p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150">Start Delay:</td>
					<td>
						<input type="text" name="wptbdelayintime" id="delayintime" size="30" value="<?php echo $wptbOptions['delay_time']; ?>" >
						<div id="wtpb-delayintime"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to delay before appearing.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Slide Time:</td>
					<td>
						<input type="text" name="wptbslidetime" id="slidetime" size="30" value="<?php echo $wptbOptions['slide_time']; ?>" >
						<div id="wtpb-slidetime"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Display Time:</td>
					<td>
						<input type="text" name="wptbdisplaytime" id="displaytime" size="30" value="<?php echo $wptbOptions['display_time']; ?>" >
						<div id="wtpb-displaytime"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to remain on the page.  Enter 0 for the TopBar to not disappear.</em></p>
					</td>
				</tr>							
				<tr valign="top">
					<td width="150">Bottom border height (px):</td>
					<td>
						<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
						<div id="wtpb-bottomborderheight"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the height of the bottom of the border.  Default is <code>3px</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Top padding (px):</td>
					<td>
						<input type="text" name="wptbpaddingtop" id="paddingtop" size="5" value="<?php echo $wptbOptions['padding_top']; ?>" >
						<div id="wtpb-paddingtop"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the top padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom padding (px):</td>
					<td>
						<input type="text" name="wptbpaddingbottom" id="paddingbottom" size="5" value="<?php echo $wptbOptions['padding_bottom']; ?>" >
						<div id="wtpb-paddingbottom"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the bottom padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>		
				<tr valign="top">
					<td width="150">Top margin (px):</td>
					<td>
						<input type="text" name="wptbmargintop" id="margintop" size="5" value="<?php echo $wptbOptions['margin_top']; ?>" >
						<div id="wtpb-margintop"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the top margin.  Default is <code>0px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom margin (px):</td>
					<td>
						<input type="text" name="wptbmarginbottom" id="marginbottom" size="5" value="<?php echo $wptbOptions['margin_bottom']; ?>" >
						<div id="wtpb-marginbottom"></div>
					</td>
					<td>
							<p class="sub"><em>Enter the bottom margin.  Default is <code>0px</code></em></p>
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
	
	<?php
}	// End of wptb_main_options	



?>