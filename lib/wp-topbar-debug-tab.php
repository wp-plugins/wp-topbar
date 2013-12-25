<?php 

/*
Debug Options Tab

i18n Compatible

*/


//=========================================================================			
// Debug Options
//=========================================================================			

function wptb_debug_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

   	$wptb_barid_prefix=get_transient( 'wptb_barid_prefix' );	
   	if (!$wptb_barid_prefix) $wptb_barid_prefix=rand(100000,899999);
   	set_transient( 'wptb_barid_prefix', $wptb_barid_prefix, 60*60*24 );

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_debug_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

	$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
	$wptbGSRotateTopbars 		= $wptbGlobalOptions [ 'rotate_topbars' ];
	$wptbGSRotateDisplayTime 	= $wptbGlobalOptions [ 'rotate_display_time' ];
	$wptbGSRotateStartDelay 	= $wptbGlobalOptions [ 'rotate_start_delay' ];
	
	if ( $wptbGSRotateTopbars == "yes" ) {				// force these to off/no if Rotate is turned on
		$wptbOptions['scroll_action'] = "off";
		$wptbOptions['allow_reopen'] = "no";
		$wptbOptions['allow_close'] = "no";
	}
			
	$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;	
	
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
	
	?>
					
	<div class="postbox">
	<h3><a name="Debug"><?php _e('Debug Settings','wp-topbar'); ?></a></h3>
	<div class="inside">
		<ul>
			<li><strong><?php _e('Database/Column Check','wp-topbar'); ?>:</strong></br>
<?php
echo "Charset <small><i>(DB_CHARSET)</i></small>: <strong>".DB_CHARSET."</strong></br>";
echo "Collation <small><i>(DB_COLLATE)</i></small>: <strong>".DB_COLLATE."</strong></br>";
echo "bar_text encoding: <strong>".$wptb_bar_text_encoding[0]."</strong></br>";
echo "bar_link_text encoding: <strong>".$wptb_bar_link_text_encoding[0]."</strong></br>";
echo "wp-tobar internal db version: <strong>".get_option( "wptb_db_version" )."</strong></br>";
echo "</br>";
?>
			</li>
			<li><strong><?php _e('Time Check','wp-topbar'); ?>:</strong></br>
<?php
$wptb_current_time=current_time('timestamp', 1);
echo __('Server Timezone','wp-topbar').':   <strong>'.date_default_timezone_get().'</strong></br>';
echo __('Current Time','wp-topbar').':      <strong>'.date('m/d/Y H:i (e)',$wptb_current_time).'</strong></br>';		
if ($wptbOptions['start_time'] != 0) 		
	echo __('Starting Time','wp-topbar').': <strong>'.$wptbOptions['start_time_utc'].'</strong> '.__('(UTC) - As entered:','wp-topbar').'<strong> '.$wptbOptions['start_time'],'</strong></br>';
if ($wptbOptions['end_time'] != 0) 		
	echo __('Ending Time','wp-topbar').':   <strong>'.$wptbOptions['end_time_utc'].'</strong> '.__('(UTC) - As entered:','wp-topbar').'<strong> '.$wptbOptions['end_time'],'</strong></br>';
echo "</br>";
?>
			</li>
			
			<li><strong><?php _e('Server Check','wp-topbar'); ?>:</strong></br>					
			<?php 
			if (ini_get('allow_url_fopen') == 1)
		    	echo __('fopen setting is ').'<strong>'.__('ON').'</strong><br>';
			else 
			    echo __('fopen setting is').'<strong>'.__('OFF').'</strong><br>';
			if  ( get_magic_quotes_gpc() ) 
		   		echo "PHP Magic Quotes is <strong>ON</strong><br>";
		   	else
		   		echo "PHP Magic Quotes is <strong>OFF</strong><br>";  			
		   	?>
			<br>
			</li>			
			<li><strong><?php _e('Global Settings Check','wp-topbar'); ?>:</strong></br>
<?php

echo __('Rotate TopBars','wp-topbar').':&nbsp;<strong>'.$wptbGSRotateTopbars.'</strong></br>';
echo __('Rotation Start Delay','wp-topbar').':&nbsp;<strong>'.$wptbGSRotateStartDelay.'</strong></br>';		
echo __('Rotation Display Time','wp-topbar').':&nbsp;<strong>'.$wptbGSRotateDisplayTime.'</strong></br>';		
echo "</br>";

?>			
			</li>
			<li><strong><?php 
				  echo __('Status','wp-topbar')."</strong>:<br>"; 
				  if ($wptbOptions['enable_topbar'] == "false") { echo __( 'The TopBar is not enabled.  Enable it in the <a href="?page=wp-topbar.php&action=main&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">Main Options tab</a>.', 'wp-topbar' )."<br>"; } ?>

			<?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo __('The plugin is not checking for the presence of cookies.  That is not preventing the TopBar from showing.','wp-topbar')."<br>";
				  else
						if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] )  
							echo __('The plugin is checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser\'s cookies or you can change the Cookie Value or disable cookies in the','wp-topbar')." <a href='?page=wp-topbar.php&action=closebutton&barid=".$wptbOptions['bar_id']."'>".__('Close Button tab','wp-topbar').'</a>.<br>'; 
						else 
							echo __('The plugin is checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.','wp-topbar')."<br>";;
			?>
   			</p>
			</li>

<strong><?php _e('Debug Helpers','wp-topbar'); ?>:</strong>

			<?php _e('<li>You can append <code>&debug</code> after the wp-topbar URL to turn on debugging messages. i.e. <code>admin.php?page=wp-topbar.php&debug</code> . These messages can help you see if you have a parameter that will cause the TopBar to break.</li>'.
			'<li><code>&debug</code> will turn on an internal timer that will display debug messages for about one minute.  The timer is reset for every page refresh that has <code>&debug</code>.  If you have debugging turned on (in your wp-config.php), then the error messages will also be sent to the default WordPress logfile for any non-admin page views of your website. i.e. <code>define(\'WP_DEBUG\', true);</code> and <code>define(\'WP_DEBUG_LOG\', true);</code></li>'.
			'<li>To turn off the debug messages, remove the <code>&debug</code> from the URL and wait about one minute.</li>','wp-topbar'); ?>
		</ul>
		<table>
		<tr>
		<td valign="top" style="valign:top; width:100%; border-top-style:solid !important; border-width:1px !important; border-color:black !important;">
		<p><?php _e('Below is the actual code that will be generated by the plugin.  Look closely to determine if any of your custom HTML or CSS values are causing issues with the TopBar.','wp-topbar'); ?>
		<?php if ( $wptbOptions['topbar_pos'] == 'header' )
			echo '</br></br>'.__('Since you are putting the TopBar in the Header, the Plugin adds the following Javascript to prepend the HTML to the top of the Body:','wp-topbar').'</br><code>&ltscript type=\'text/javascript\'&gtjQuery(document).ready(function() {jQuery(\'body\').prepend(…)});</code>';
		?>
		<?php if ( $wptbGSRotateTopbars == "yes" ) 
			echo '</br></br>'.__('The <strong>Rotate TopBars</strong> option is turned on.  With this turned ON, the Scrollable, Close Button, and Re-Open options are <strong>ignored and turned off</strong>.  To turn off Rotate TopBars, go to the', 'wp-topbar')." <a href='?page=wp-topbar.php&action=globalsettings'>".__('Global Settings tab','wp-topbar').'</a>';

			
			
		?>
		</td>
		</tr>
		<tr>
		<td valign="top" style="valign:top; width:100%; border-style:solid !important; border-width:1px !important; border-color:black !important;">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<strong>The TopBar is not enabled.  Therefore no HTML will be generated. Enable it in the <a href="?page=wp-topbar.php&action=main&barid='.($wptb_barid_prefix+$wptbOptions['bar_id']).'">Main Options tab</a>.</strong><br>', 'wp-topbar' ); }
		else 
			{echo '	<textarea rows="20" cols="150">';wptb::wptb_inject_TopBar_html_js($wptbOptions, 1); echo '</textarea>';} ?>
		</td>
		<br>
		</tr>
		<table>
		<tr>
			<td style="valign:top; width:500px;">	
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php echo $wptb_button_style; ?>" value="<?php _e('Back to Top', 'wp-topbar') ?>" onClick="parent.location='#Top'">
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