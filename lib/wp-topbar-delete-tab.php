<?php 

/*
Delete Options Tab
*/


//=========================================================================			
// Delete Options
//=========================================================================			

function wptb_delete_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In Delete Options</code>';
		
	set_transient( 'wptb_delete_row', $wptbOptions['bar_id'], 30*60 );

	?>
					

	<div class="postbox">
	<h3><a name="Uninstall">Delete Settings</a></h3>
	<div class="inside">
		<p class="sub"><em>Click here to delete the this TopBar's settings.</em></p>
		

		   <form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/?page=wp-topbar.php&amp;action=dummy&amp;noheader=true"></form>
				<table>
		<tr>
		<div></div>
		<td style="valign:top; width:500px;">
	    <form method="post"    action="<?php echo get_option('siteurl'); ?>/wp-admin/?page=wp-topbar.php&amp;action=dummy&amp;noheader=true">
	        <p class="submit">
				<input type="submit" name=wptbDeleteBar class="button" style="<?php _e( $wptb_delete_style , 'wptb' ); ?>" value="<?php _e('Delete Settings', 'wptb') ?>" onClick="return confirm('Delete TopBar # <?php echo $wptbOptions['bar_id']; ?>?');">

	        </p>
	        </td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
	    		</tr>
	    </form>
		</table>
	</div>
	

 
 <?php
 
}	// End of wptb_delete_options


?>