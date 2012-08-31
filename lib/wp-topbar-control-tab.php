<?php 

/*
Plugin Name: WP-TopBar
Control Options Tab
*/



//=========================================================================			
// Main Options
//=========================================================================			

		
function wptb_control_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
	$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Control Options</code>';

	?>

	<script type='text/javascript'>
		jQuery(document).ready(function() {
	
		jQuery('#wptbstarttimebtn').datetimepicker();
		jQuery('#wptbendtimebtn').datetimepicker();
	
		jQuery('#wptbstarttimebtnClear').click( function(e) {jQuery('#wptbstarttimebtn').val('0').change(); } );
		jQuery('#wptbtimebtnClear').click( function(e) {jQuery('#wptbendtimebtn').val('0').change(); } );
				
	});
 	</script>

		 	
 	
 	<div class="postbox">
	<h3><a name=ControlOptions">Control Options</a></h3>
	<div class="inside">
			<p class="sub"><em>These are the options that allow you to control which pages your TopBar will be shown on.</em></p>

		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td>Show TopBar on<br>Home Page:</label><p>
					<td>
						<br>
						<label for="wptb_home_page_always"><input type="radio" id="wptb_home_page_always" name="wptbshowhomepage" value="always" <?php if ($wptbOptions['show_homepage'] == "always") { _e('checked="checked"', "wptb"); }?>/> A. Always</label>		
						<br>
						<label for="wptb_show_homepage_never"><input type="radio" id="wptb_home_page_never" name="wptbshowhomepage" value="never" <?php if ($wptbOptions['show_homepage'] == "never") { _e('checked="checked"', "wptb"); }?> /> B. Never</label>
						<br>
						<label for="wptb_home_page_conditionally"><input type="radio" id="wptb_home_page_conditionally" name="wptbshowhomepage" value="conditionally" <?php if ($wptbOptions['show_homepage'] == "conditionally") { _e('checked="checked"', "wptb"); }?> /> C. Conditionally</label>
					</td>
					<td>
						<p class="sub"><em>Select how you want the TopBar to show on the Home page.  Default is to <code>conditionally</code> show the TopBar on the Home Page</em>
						<br>A. <strong>Always</strong> shows the TopBar on the Home Page regardless of any other criteria entered on this page.
						<br>B. <strong>Never</strong> shows the TopBar on the Home Page regardless of any other criteria entered on this page.
						<br>C. <strong>Only</strong> shows the TopBar on the Home Page if the page matches the Page ID and/or Category criteria entered on this page.
						</p>
					</td>
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
					<td><p>
						<label for="wptb_invert_include_no"><input type="radio" id="wptb_invert_include_no" name="wptbinvertinclude" value="no" <?php if ($wptbOptions['invert_include'] == "no") { _e('checked="checked"', "wptb"); }?> /> Include</label>
						<label for="wptb_invert_include_yes"><input type="radio" id="wptb_invert_include_yes" name="wptbinvertinclude" value="yes" <?php if ($wptbOptions['invert_include'] == "yes") { _e('checked="checked"', "wptb"); }?>/> Exclude</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<p>
					<td>
						<p class="sub"><em>Select how you want to process the Page IDs entered above.  Default is <code>Include</code><br><code>Include</code> will have the TopBar show on those Page IDs<br><code>Exclude</code> will have the TopBar to not show up on those specific Page IDs.  </em></p>
					</td>
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
					<td><p>
						<label for="wptb_invert_categories_no"><input type="radio" id="wptb_invert_categories_no" name="wptbinvertcategories" value="no" <?php if ($wptbOptions['invert_categories'] == "no") { _e('checked="checked"', "wptb"); }?> /> Include</label>
						<label for="wptb_invert_categories_yes"><input type="radio" id="wptb_invert_categories_yes" name="wptbinvertcategories" value="yes" <?php if ($wptbOptions['invert_categories'] == "yes") { _e('checked="checked"', "wptb"); }?>/> Exclude</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<p>
					<td>
						<p class="sub"><em>Select how you want to process the Category IDs entered above.  Default is <code>Include</code><br><code>Include</code> will have the TopBar show on those Category IDs<br><code>Exclude</code> will have the TopBar to not show up on those specific Category IDs.  </em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td>Selection Criteria Logic:</label><p>
					<td>
						<br>
						<label for="wptb_include_logic_page_only"><input type="radio" id="wptb_include_logic_page_only" name="wptbincludelogic" value="page_only" <?php if ($wptbOptions['include_logic'] == "page_only") { _e('checked="checked"', "wptb"); }?>/> A. Page IDs only</label>		
						<br>
						<label for="wptb_include_logic_cat_only"><input type="radio" id="wptb_include_logic_cat_only" name="wptbincludelogic" value="cat_only" <?php if ($wptbOptions['include_logic'] == "cat_only") { _e('checked="checked"', "wptb"); }?> /> B. Category IDs</label>
						<br>
						<label for="wptb_include_logic_boolean_and"><input type="radio" id="wptb_include_logic_boolean_and" name="wptbincludelogic" value="boolean_and" <?php if ($wptbOptions['include_logic'] == "boolean_and") { _e('checked="checked"', "wptb"); }?> /> C. Both</label>
						<br>
						<label for="wptb_include_logic_boolean_or"><input type="radio" id="wptb_include_logic_boolean_or" name="wptbincludelogic" value="boolean_or" <?php if ($wptbOptions['include_logic'] == "boolean_or") { _e('checked="checked"', "wptb"); }?> /> D. Either</label>
						<p>
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