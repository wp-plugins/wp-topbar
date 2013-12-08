<?php 

/*
Network Admin Page
*/

//=========================================================================		
//
//  Future Enhancements:
//   
//
//
//
//
//=========================================================================		


//=========================================================================			
// Options Page
//=========================================================================			


function wptb_network_options_page() {
	

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	global $WPTB_VERSION;
	
	$wptbOptions = "";

	require_once( dirname(__FILE__).'/wp-topbar-faq-tab.php');  //load faq page php	
	require_once( dirname(__FILE__).'/wp-topbar-uninstall-tab.php');  //load uninstall pages php

	
	// $wptb_common_style is used by all buttons except the Copy & Special buttons
		
	$wptb_common_style = "padding:2px 15px;
		-webkit-border-radius:23px;
		-moz-border-radius:23px;
		border-radius:23px;
		-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
		-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
		box-shadow:rgba(0,0,0,1) 0 1px 0;
		text-shadow:rgba(0,0,0,.4) 0 1px 0;
		font-size:16px;
		font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
		text-decoration:none;
		vertical-align:middle;";
			
	$wptb_button_style = 'border-top:1px solid #96d1f8;
		background:#65a9d7;
		background:-webkit-gradient(linear, left top, left bottom, from(#215375), to(#65a9d7));
		background:-webkit-linear-gradient(top, #215375, #65a9d7);
		background:-moz-linear-gradient(top, #215375, #65a9d7);
		background:-ms-linear-gradient(top, #215375, #65a9d7);
		background:-o-linear-gradient(top, #215375, #65a9d7);
		color:white;'.$wptb_common_style; 
	
	$wptb_clear_style = 'border-top:1px solid #96d1f8;
		background:#FFFF90;
		color:black;'.$wptb_common_style; 
		
	$wptb_cssgradient_style='border-top: 1px solid #c5f797;
	   background: #92d665;
	   background: -webkit-gradient(linear, left top, left bottom, from(#699c3e), to(#92d665));
	   background: -webkit-linear-gradient(top, #699c3e, #92d665);
	   background: -moz-linear-gradient(top, #699c3e, #92d665);
	   background: -ms-linear-gradient(top, #699c3e, #92d665);
	   background: -o-linear-gradient(top, #699c3e, #92d665);
	   color: white;'.$wptb_common_style.'font-size:12px;'; 
	
	$wptb_submit_style = 'border-top:1px solid #97f7c1;
		background:#65d67f;
		background:-webkit-gradient(linear, left top, left bottom, from(#217342), to(#65d67f));
		background:-webkit-linear-gradient(top, #217342, #65d67f);
		background:-moz-linear-gradient(top, #217342, #65d67f);
		background:-ms-linear-gradient(top, #217342, #65d67f);
		background:-o-linear-gradient(top, #217342, #65d67f);
		color: white;'.$wptb_common_style;  
	
	$wptb_special_button_style = "border-top: 1px solid #d7ddcb;
		   background: #ebf3df;
		   color: black;
		   margin-left:auto;
		   margin-right:auto;
		   width:130px;
		   font-size: 10px;
		   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
		   text-decoration: none;
		   vertical-align: middle;";


    if ( isset ( $_GET['action'] ) )
        $action = $_GET['action'];
    else
        $action = 'networksettings';    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug) {
		echo '</br><code>WP-TopBar Debug Mode: wptb_network_options_page() - Action: '.$action.'</code>';
		echo '</br><code>WP-TopBar Debug Mode: Debug Until:', date('D, d M Y H:i:s (e)',get_transient( 'wptb_debug' )),'</code>';	
	}
	
	if ( isset (  $_POST['update_wptbGlobalSettings'] ) ) {			
		wptb_update_NetworkSettings();
	}
	else if ( isset (  $_POST['uninstall_Network_wptbSettings'] ) ) {			
		wptb_uninstall_wptbSettings();
		wp_redirect(get_option('siteurl').'/wp-admin/network/plugins.php');
		exit;				
	}
	else if ( isset (  $_POST['nouninstall_Network_wptbSettings'] ) ) {			
		wp_redirect(get_option('siteurl').'/wp-admin/network/?page=wp-topbar.php');
		exit;
	}

	
	if($wptb_debug && isset($wptbOptions['wptb_version'])) echo '<br><code>WP-TopBar Debug Mode: Version ',$WPTB_VERSION,'</code>';
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: WP-TopBar Debug Mode: Action: ',$action,'</code>';
	if($wptb_debug && isset($wptb_barid)) echo '<br><code>WP-TopBar Debug Mode: BarID: ',$wptb_barid,'</code>';
	if($wptb_debug && isset($wptb_barid_prefix)) echo '<br><code>WP-TopBar Debug Mode: BarID Prefix: ',$wptb_barid_prefix,'</code>';

    switch ( $action ) :

        case 'networkfaq' :
			wptb_display_network_admin_header();
            wptb_faq_page($wptbOptions,false);
            break;
        case 'networkuninstall' :
			wptb_display_network_admin_header();
			wptb_uninstall_options();
            break;
        default :
			wptb_display_network_admin_header();
        	wptb_network_settings();
            break;
        endswitch;

}  // end function wptb_options_page

function wptb_display_network_admin_header() {
		
	global $WPTB_VERSION;
		
	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_display_admin_header()</code>';
		
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		WP-TopBar - Version <?php _e($WPTB_VERSION); ?></h2>
		<h3>Network / Multi-Site Admin Page</h3>
		<div class="postbox">
		<br>
		Creates TopBars that can be shown at the top of your website.  Version 5 adds ability to close TopBars and also gives you a Sample TopBar Tab that has starter TopBars that you can customize.
		<br><br>
		Please <a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:20px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
if you find this plugin useful.
		</br>
		<p class="wptb-pointer"></p>
		<hr>
		</div>
		<?php wp_nonce_field('wptb_update_setting_nonce','wptbupdatesettingnonce'); ?> 	

	<?php 
	
}  // end function wptb_display_admin_header

function wptb_network_settings() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;   
			
	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_globalsettings_options()</code>';
	
	$wptbNetworkGlobalOptions = get_site_option( 'wptb_network_global_options' );
	
	if ( ! isset($wptbNetworkGlobalOptions [ 'multisite_super_admin_only' ] )) {
		$wptbMultiSuperAdminOnly = "no";
		$wptbNetworkGlobalOptions = array(
		  'multisite_super_admin_only'	=> $wptbMultiSuperAdminOnly
		);
		update_site_option( 'wptb_network_global_options' , $wptbNetworkGlobalOptions );
	}
	else
		$wptbMultiSuperAdminOnly = $wptbNetworkGlobalOptions [ 'multisite_super_admin_only' ];
		
	?>
	
	<div class="postbox">
										
	<h3><a name="CloseButton">Network/Multisite Settings</a></h3>
										
	<div class="inside">
		<p class="sub"><em>This page contains the Network/Multisite Settings that effect all TopBars.</em>
		<br>
		</p>
		
		<div class="table">
			<table class="form-table">	
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150">ONLY Show Admin Pages for Multi-Site Network Admins:</label></td>
					<td>
					 	<p id="radio4" class="ui-button ui-button-wptbset">
							<input type="radio" id="wptbmultisiteadminonly1" name="wptbmultisiteadminonly" class="ui-helper-hidden-accessible" value="yes" <?php if ($wptbMultiSuperAdminOnly == "yes") { _e('checked="checked"', "wptb"); }?>><label for="wptbmultisiteadminonly1" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-left" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">Yes</span></label>
							<input type="radio" id="wptbmultisiteadminonly2" name="wptbmultisiteadminonly" class="ui-helper-hidden-accessible" value="no" <?php if ($wptbMultiSuperAdminOnly == "no") { _e('checked="checked"', "wptb"); }?>><label for="wptbmultisiteadminonly2" class="ui-button ui-button-wptb ui-widget ui-state-default ui-button ui-button-wptb-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button ui-button-wptb-text">No</span></label>
						</p>						
					</td>
					<td>
						<p class="sub"><em>If you are using MultiSite, this will allow you to control if only the Network Admins will have access to the Admin Pages.<br/>The Admin must have the <code>manage_network_plugins</code> role assigned.  Default is <code>No</code></em></p>
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>	
			</table>
		</div>
		<table>
		<tr>
			<td style="valign:top; width:500px;"><p class="submit">
				<input type="submit" style="<?php _e( $wptb_submit_style, 'wptb' ); ?>" name="update_wptbGlobalSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Close Button Settings -->
						
	<div class="postbox">
	<h3><a name="Debug">Server/Install Info</a></h3>
	<div class="inside">
		<ul>
			<li><strong>Database/Column Check:</strong></br>
<?php


	global $wpdb;
	$wptb_table_name = $wpdb->prefix . "wp_topbar_data";

	$wptb_bar_text_encoding=$wpdb->get_col(  
	"
		SELECT 
		  COLLATION_NAME
		  FROM information_schema.COLUMNS
		  where TABLE_NAME = '".$wptb_table_name."'
		  	AND COLUMN_NAME = 'bar_text';
		  	"
	); 	
	
	$wptb_bar_link_text_encoding=$wpdb->get_col(  
	"
		SELECT 
		  COLLATION_NAME
		  FROM information_schema.COLUMNS
		  where TABLE_NAME = '".$wptb_table_name."'
		  	AND COLUMN_NAME = 'bar_link_text';
		  	"
	); 	
	
	echo "Charset <small><i>(DB_CHARSET)</i></small>: <strong>".DB_CHARSET."</strong></br>";
	echo "Collation <small><i>(DB_COLLATE)</i></small>: <strong>".DB_COLLATE."</strong></br>";
	if (isset($wptb_bar_text_encoding[0])) echo "bar_text encoding: <strong>".$wptb_bar_text_encoding[0]."</strong></br>";
	if (isset($wptb_bar_link_encoding[0])) echo "bar_link_text encoding: <strong>".$wptb_bar_link_text_encoding[0]."</strong></br>";
	echo "wp-tobar internal db version: <strong>".get_option( "wptb_db_version" )."</strong></br>";
	echo "</br>";
	?>
				</li>
				<li><strong>Time Check:</strong></br>
	<?php
	$wptb_current_time=current_time('timestamp', 1);
	echo 'Server Timezone:   <strong>',date_default_timezone_get(),'</strong></br>';
	echo 'Current Time:      <strong>',date('m/d/Y H:i (e)',$wptb_current_time),'</strong></br>';		
	echo "</br>";
	?>
				</li>
				<li><strong>Multisite Check:</strong></br>
	<?php
	if ( is_multisite() ) 
		echo "Multisite:		<strong>Yes</strong><br>"; 
	else
		echo "Multisite:		<strong>No</strong><br>"; 
	if ( current_user_can( 'manage_network_plugins' )  )  
		echo "manage_network_plugins:		<strong>Yes</strong><br>"; 
	else
		echo "manage_network_plugins:		<strong>No</strong><br>"; 
	echo "</br>";
	?>
				</li>
	
	<?php	

	
	
}	// End of wptb_network_settings
//=========================================================================			
// Update Global Settings 
//=========================================================================			


function wptb_update_NetworkSettings() {

	$wptb_debug=get_transient( 'wptb_debug' );	
		
	if($wptb_debug) 
		echo '<br><code>WP-TopBar Debug Mode: wptb_update_NetworkSettings()</code>';
	
	if ( isset($_POST [ 'wptbmultisiteadminonly' ]) ) {
		$wptbMultiSuperAdminOnly = $_POST [ 'wptbmultisiteadminonly' ];
	}
	$wptbNetworkGlobalOptions = array(
	  'multisite_super_admin_only'	=> $wptbMultiSuperAdminOnly
	);
	
	update_site_option( 'wptb_network_global_options' , $wptbNetworkGlobalOptions );
	
}	// End of wptb_update_GlobalSettings


?>