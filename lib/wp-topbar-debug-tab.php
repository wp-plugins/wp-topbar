<?php 

/*
Debug Options Tab
*/


//=========================================================================			
// Debug Options
//=========================================================================			

function wptb_debug_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );


	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Debug Options</code>';

	$wptb_cookie = "wptopbar_".COOKIEHASH;
	
	?>
					
	<div class="postbox">
	<h3><a name="Debug">Debug Settings</a></h3>
	<div class="inside">
		<ul>
			<li><strong>Status:</strong>
			<br>
			<?php if ($wptbOptions['enable_topbar'] == "false") { _e( 'The TopBar is not enabled.  Enable it in the <a href="?page=wp-topbar.php&action=main&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">Main Options tab</a>.<br>', 'wptb' ); } ?>
Based on your Start/End time settings in the <a href="?page=wp-topbar.php&action=main&barid=<?php echo $wptbOptions['bar_id'];?>">Main Options tab</a>,<?php if ($wptbOptions['enable_topbar'] == "false") { _e( ' when enabled,', 'wptb' ); } ?> the TopBar will <?php if (!wptb_check_time($wptbOptions['bar_id'])) echo "<strong>not</strong>"; ?> display (based on the current time.)
		<br><?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo "<br>The plugin is not checking for the presence of cookies.  That is not preventing the TopBar from showing.";
				  else
						if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] )  
							echo "<br>The plugin is  checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies or you can change the Cookie Value or disable cookies in the <a href='?page=wp-topbar.php&action=closebutton&barid=".$wptbOptions['bar_id']."'>Close Button tab</a>."; 
						else 
							echo "The plugin is  checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.";
   				   if  ( get_magic_quotes_gpc() ) 
   				   		echo "<br>PHP Magic Quotes is ON.";
   				   else
   				   		echo "<br>PHP Magic Quotes is OFF.";  ?>
		</p>
</li>
<strong>Debug Helpers:</strong>

			<li>You can append <code>&debug</code> after the wp-topbar URL to turn on debugging messages. i.e. <code>admin.php?page=wp-topbar.php&debug</code> . These messages can help you see if you have a parameter that will cause the TopBar to break.</li>
			<li><code>&debug</code> will turn on an internal timer that will display debug messages for about one minute.  The timer is reset for every page refresh that has <code>&debug</code>.  If you have debuging turned on (in your wp-config.php), then the error messages will also be sent to the default wordpress logfile for any non-admin page views of your website. i.e. <code>define('WP_DEBUG', true);</code> and <code>define('WP_DEBUG_LOG', true);</code></li>
			<li>To turn off the debug messages, remove the <code>&debug</code> from the URL and wait about one minute.</li>
		</ul>
		<table>
		<tr>
		<td valign="top" style="valign:top; width:100%; border-top-style:solid !important; border-width:1px !important; border-color:black !important;">
		<p>Below is the actual code that will be generated by the plugin.  Look closely to determine if any of your custom HTML or CSS values are causing issues with the TopBar.
		<?php if ( $wptbOptions['topbar_pos'] == 'header' )
		echo "<br>Since you are putting the TopBar in the Header, the Plugin adds the following Javascript<code>&ltscript type='text/javascript'&gtjQuery(document).ready(function() {jQuery('body').prepend(…)});</code> to prepend the HTML to the top of the Body."; ?>
		</td>
		</tr>
		<tr>
		<td valign="top" style="valign:top; width:100%; border-style:solid !important; border-width:1px !important; border-color:black !important;">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<strong>The TopBar is not enabled.  Therefore no HTML will be generated. Enable it in the <a href="?page=wp-topbar.php&action=main&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">Main Options tab</a>.</strong><br>', 'wptb' ); }
		else {_e ('	<textarea rows="10" cols="150">', 'wptb');wptb::wptb_inject_specific_TopBar_html_js($wptbOptions, true ,"");_e('</textarea>', 'wptb');} ?>
		</td>
		<br>
		</tr>
		<table>
		<tr>
			<td style="valign:top; width:500px;">	
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>
		<div class="clear"></div>	
	</div> 
	</div> <!-- end of debug  -->
   </form>
 </div>	 
 
 <?php
 
}	// End of wptb_debug_options




?>