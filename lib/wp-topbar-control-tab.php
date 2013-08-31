<?php 

/*
Control Options Tab
*/



//=========================================================================			
// Main Options
//=========================================================================			

		
function wptb_control_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_control_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

	?>

 	<div class="postbox">
	<h3><a name="ControlOptions">Control Options</a></h3>
	<div class="inside">
			<p class="sub"><em>These are the options that allow you to control which pages your TopBar will be shown on.</em></p>

		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td>Show TopBar on<br>Home Page:</label><p>
					<td>
						<br>
						
					 	<p id="radio1" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbshowhomepage1" name="wptbshowhomepage" class="ui-helper-hidden-accessible" value="always" <?php if ($wptbOptions['show_homepage'] == "always") { _e('checked="checked"', "wptb"); }?>><label for="wptbshowhomepage1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">A</span></label>
						<input type="radio" id="wptbshowhomepage2" name="wptbshowhomepage" class="ui-helper-hidden-accessible" value="never" <?php if ($wptbOptions['show_homepage'] == "never") { _e('checked="checked"', "wptb"); }?>><label for="wptbshowhomepage2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">B</span></label>
						<input type="radio" id="wptbshowhomepage3" name="wptbshowhomepage" class="ui-helper-hidden-accessible" value="conditionally" <?php if ($wptbOptions['show_homepage'] == "conditionally") { _e('checked="checked"', "wptb"); }?>><label for="wptbshowhomepage3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">C</span></label>
						<input type="radio" id="wptbshowhomepage4" name="wptbshowhomepage" class="ui-helper-hidden-accessible" value="only" <?php if ($wptbOptions['show_homepage'] == "only") { _e('checked="checked"', "wptb"); }?>><label for="wptbshowhomepage4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">D</span></label>
					 	</p>	
					</td>
					<td>
						<p class="sub"><em>Select how you want the TopBar to show on the Home page.  Default is to <code>conditionally</code> show the TopBar on the Home Page</em>
						<br>A. <strong>Always</strong> shows the TopBar on the Home Page regardless of any other criteria entered on this page.
						<br>B. <strong>Never</strong> shows the TopBar on the Home Page regardless of any other criteria entered on this page.
						<br>C. <strong>Conditionally</strong> shows the TopBar on the Home Page if the page matches the Page ID and/or Category criteria entered on this page.
						<br>D. <strong>Only</strong> shows the TopBar on the Home Page and not other pages.
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td>Logged In Users:</td>
					<td>
						<br>
						
					 	<p id="radio2" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbonlyloggedin1" name="wptbonlyloggedin" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbOptions['only_logged_in'] == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptbonlyloggedin1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">A</span></label>
						<input type="radio" id="wptbonlyloggedin2" name="wptbonlyloggedin" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbOptions['only_logged_in'] == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptbonlyloggedin2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">B</span></label>
						<input type="radio" id="wptbonlyloggedin3" name="wptbonlyloggedin" class="ui-helper-hidden-accessible" value="all" <?php if ($wptbOptions['only_logged_in'] == "all") { _e('checked="checked"', "wptb"); }?>><label for="wptbonlyloggedin3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">C</span></label>
					 	</p>						
						
					</td>
					<td>
						<p class="sub"><em>Select how you want the TopBar to show for users.  Default is to <code>Allways</code> show the TopBar, regardless if they are logged in</em>
						<br>A. <strong>Not Logged In</strong> shows the TopBar only for users not logged in.
						<br>B. <strong>Logged In</strong> shows the TopBar only for users logged in.
						<br>C. <strong>Always</strong> shows the TopBar for all users, logged in or not.
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
					<tr valign="top">
					<td width="150">Page IDs:</label></td>
					<td>
						<input type="text" name="wptbincludepages" id="includepages" size="30" value="<?php echo $wptbOptions['include_pages']; ?>" >
					</td>
					<td>
						<p class="sub"><em>Enter the IDs of the pages and posts that you want the TopBar to appear on, separated by commas. The TopBar will only be shown on those pages by using the <code>Page ID Criteria</code> option you select below. Leave blank or enter 0 to show the TopBar on all pages.  e.g. 1,9,39,10</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td>Page ID Criteria:</td>
					<td>
				 	<p id="radio3" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbinvertinclude1" name="wptbinvertinclude" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbOptions['invert_include'] == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptbinvertinclude1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Include</span></label>
						<input type="radio" id="wptbinvertinclude2" name="wptbinvertinclude" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbOptions['invert_include'] == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptbinvertinclude2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Exclude</span></label>
					</p>
					<td>
						<p class="sub"><em>Select how you want to process the Page IDs entered above.  Default is <code>Include</code><br><code>Include</code> will have the TopBar show on those Page IDs<br><code>Exclude</code> will have the TopBar to not show up on those specific Page IDs.  </em></p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
					<tr valign="top">
					<td width="150">Category IDs:</label></td>
					<td>
						<input type="text" name="wptbincludecategories" id="includecategories" size="30" value="<?php echo $wptbOptions['include_categories']; ?>" >
					</td>
					<td>
						<p class="sub"><em>Enter the IDs of the categories that you want the TopBar to test for, separated by commas. The TopBar will only be shown on those categories in the default "category" taxonomy by using the <code>Categegory ID Criteria</code> option you select below. Leave blank or enter 0 to show the TopBar on all categories.  e.g. 9,10,2,12</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td>Category ID Criteria:</label><p>
</td>
					<td>
					
				 	<p id="radio4" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbinvertcategories1" name="wptbinvertcategories" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbOptions['invert_categories'] == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptbinvertcategories1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Include</span></label>
						<input type="radio" id="wptbinvertcategories2" name="wptbinvertcategories" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbOptions['invert_categories'] == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptbinvertcategories2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Exclude</span></label>
					</p>					
					
					<td>
						<p class="sub"><em>Select how you want to process the Category IDs entered above.  Default is <code>Include</code><br><code>Include</code> will have the TopBar show on those Category IDs<br><code>Exclude</code> will have the TopBar to not show up on those specific Category IDs.  </em></p>
					</td>
				</tr>			
				<tr>
					<td colspan="3"><hr></td>
				</tr>
					<tr valign="top">
					<td>Selection Criteria Logic:</label><p>
					<td>
						</br>
					 	<p id="radio5" class="ui-button ui-button-wptbset">
						<input type="radio" id="wptbincludelogic1" name="wptbincludelogic" class="ui-helper-hidden-accessible" value="page_only" <?php if ($wptbOptions['include_logic'] == "page_only") { _e('checked="checked"', "wptb"); }?>><label for="wptbincludelogic1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">A</span></label>
						<input type="radio" id="wptbincludelogic2" name="wptbincludelogic" class="ui-helper-hidden-accessible" value="cat_only" <?php if ($wptbOptions['include_logic'] == "cat_only") { _e('checked="checked"', "wptb"); }?>><label for="wptbincludelogic2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">B</span></label>
						<input type="radio" id="wptbincludelogic3" name="wptbincludelogic" class="ui-helper-hidden-accessible" value="boolean_and" <?php if ($wptbOptions['include_logic'] == "boolean_and") { _e('checked="checked"', "wptb"); }?>><label for="wptbincludelogic3" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">C</span></label>
						<input type="radio" id="wptbincludelogic4" name="wptbincludelogic" class="ui-helper-hidden-accessible" value="boolean_or" <?php if ($wptbOptions['include_logic'] == "boolean_or") { _e('checked="checked"', "wptb"); }?>><label for="wptbincludelogic4" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">D</span></label>
					 	</p>						
					</td>
					<td>
						<p class="sub"><em>Select how you want the TopBar to use the selection criteria you set above.  Default is to check only the <code>Page IDs</code></em>
						<br>A. Checks only Page IDs (ignore Category ID criteria)
						<br>B. Checks only Category IDs (ignore Page ID criteria)
						<br>C. <strong>BOTH</strong> Page ID <strong>and</strong> Category ID must match the criteria above for the TopBar to show
						<br>D. <strong>EITHER</strong> Page ID <strong>or</strong> Category ID must match the criteria above for the TopBar to show
						</p>
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
}	// End of wptb_control_options


?>