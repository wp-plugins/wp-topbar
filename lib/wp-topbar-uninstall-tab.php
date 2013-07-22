<?php 

/*
Uninstall Option Tab
*/



//=========================================================================			
// TopBar Uninstall Option
//=========================================================================			

function wptb_uninstall_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	
	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_uninstall_options()</code>';

	$url=get_option('siteurl');
	$url=get_option('siteurl')."/wp-admin/?page=wp-topbar.php&amp;action=uninstall&amp;noheader=true";

	if ( is_ssl() AND (substr($url, 0, 5) != "https" ) AND ( substr($url, 0, 4) == "http" ) ) {
		$url="https".substr($url,4);
	}

	?>
	

	
	<div class="wrap">
    <h2>Uninstall Options</h2>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
This operation deletes ALL TopBar data. If you continue, You will not be able to retrieve or restore your TopBars.</br>
</br>
<strong>If you elect to uninstall, you will be redirected to the WordPress Plugin page so that you can de-activate and uninstall the Plugin.</strong></br>
  			</br>	      
  	      
  	      </p> 
        </div>
		<div>
		   <form method="post" action="<?php echo $url;?>"></form>
		</div>
	    <form method="post"    action="<?php echo $url;?>">
	        <p class="submit">
	            <input type="submit" name="uninstall_wptbSettings" class="button-primary" value="Uninstall" />
	            <input type="submit" name="nouninstall_wptbSettings"  class="button-primary"  value="Cancel" />
	        </p>
	    </form>
	</div>	
	
	
	
	<?php
}	// End of wptb_uninstall_options

function wptb_uninstall_wptbSettings() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	

	$wptb_debug=get_transient( 'wptb_debug' );	
	
	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_uninstall_wptbSettings()</code>';
	
	delete_option( 'wptbAdminOptions');
	delete_option( 'wptb_db_version' );


	$query = "drop table  ".$wptb_table_name.";";

	$data = $wpdb->get_results($query, ARRAY_A);   


}	// End of wptb_uninstall_wptbSettings



?>