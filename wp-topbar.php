<?php
/*

Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, image and link.
Version: 3.09
Author: Bob Goetz
Author URI: http://wordpress.org/extend/plugins/profile/rfgoetz

*/
/*  Copyright 2012  Bob Goetz  (email : rfgoetz at google's mail . com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if( ! class_exists( 'wptb' ) ):
class wptb {

	function init(){

		//=========================================================================			
		//Perform any onetime functions when plugin is activiated
		//=========================================================================			
		register_activation_hook( __FILE__,array( __CLASS__, 'wtpb_activate_plugin' ) );
		
		//=========================================================================			
		//Actions and Filters, if on plugin admin page	
		//=========================================================================	
		    	
		if (is_admin() )	 { // make sure we are on the admin page to minimize scripts loaded on the website
			
			require_once( dirname(__FILE__).'/lib/wp-topbar-admin.php');  //load admin page php
		
		//Actions
			add_action( 'init', array( __CLASS__, 'wptb_enqueue_admin_scripts' ) );
			add_action( 'init', array( __CLASS__, 'wptb_debug_check' ) );
			add_action( 'admin_menu', array( __CLASS__, 'wptb_options_panel' ) ); 
		
		//Filters
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__) , array( __CLASS__, 'wptb_plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( __CLASS__, 'wptb_plugin_donate_link' ), 10, 2 );
		}	
		else
		{
	
		//=========================================================================			
		//Actions and Filters, on all non-admin pages - these display the topbar
		//=========================================================================	
			
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wptb_enqueue_jquery' ) );
			add_action('wp_footer', array( __CLASS__, 'wptb_inject_TopBar_html_js' ), 9999999);
		}
		
	}


	//=========================================================================			
	// Enqueue jquery to get our javascripts to run -- just in case no other theme/plugin has
	//=========================================================================	
	
	function wptb_enqueue_jquery() {
    		wp_enqueue_script('jquery');     
		
	} // End of function wptb_enqueue_jquery


	//=========================================================================			
	// Enqueue Media Uploader, ZeroClipboard, Farbtastics for the color pickers, etc.
	//=========================================================================		
		
	function wptb_enqueue_admin_scripts() {
		
		if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') {  // only load these on the admin page
	  		wp_enqueue_script( 'farbtastic' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			
			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_style('thickbox');
	
			wp_register_script( 'wptb_upload', plugins_url('/lib/wp-topbar-load-image.js', __FILE__), array('jquery','media-upload','thickbox') );
			wp_enqueue_script( 'wptb_upload') ;
	
			wp_register_script( 'wptb_datepicker_ui', plugins_url('/lib/jquery-ui-1.8.16.custom.min.js', __FILE__), array('jquery') );
			wp_enqueue_script('wptb_datepicker_ui');
			wp_register_script( 'wptb_datepicker_slider', plugins_url('/lib/jquery-ui-sliderAccess.js', __FILE__), array('jquery') );
			wp_enqueue_script('wptb_datepicker_slider');
			wp_register_script( 'wptb_datepicker', plugins_url('/lib/jquery-ui-timepicker-addon.js', __FILE__), array('jquery') );
			wp_enqueue_script('wptb_datepicker');

			wp_register_style( 'wptb_datepicker_ui_css', plugins_url('/lib/jquery-ui-1.8.16.custom.css', __FILE__) );
			wp_enqueue_style('wptb_datepicker_ui_css');
			wp_register_style( 'wptb_datepicker_css', plugins_url('/lib/jquery-ui-timepicker-addon.css', __FILE__) );
			wp_enqueue_style('wptb_datepicker_css');		}
	
	} // End of function wptb_enqueue_admin_scripts
	
	
	//=========================================================================			
	//Debug & Cookie Check.  If &debug is appended to URL, then set transient variable for 60 seconds
	// this is checked by admin page and if set, echos debug statements
	// e.g. .../?page=wp-topbar.php&debug
	//=========================================================================			
	
	function wptb_debug_check() {	
		
		if ((isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') &&
	        isset( $_GET['debug'] ) && current_user_can( 'manage_options' ) ) {
		        set_transient( 'wptb_debug', gettimeofday(true), 60 );
	    }
	   
	    
	} // End of function wptb_debug_check	


	//=========================================================================			
	// Add 'Settings' link to plugin page
	//=========================================================================			
	
	function wptb_plugin_action_links($links) {
		$wptb_settings_link = '<a href="'.admin_url( 'admin.php?page=wp-topbar.php' ).'">Settings</a>';
		array_unshift($links, $wptb_settings_link);
		return $links;
	} // End of function wptb_plugin_action_links
	
	
	//=========================================================================			
	// Add donate link on manage plugin page
	//=========================================================================			
	
	function wptb_plugin_donate_link($links, $file) {
		if ($file == plugin_basename(__FILE__)) {
				$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank">Donate</a>';
				$links[] = $donate_link;
			}
			return $links;
	} // End of function wptb_plugin_donate_link
	
	
	//=========================================================================			
	// Initialize the admin panel, add main option menu and submenus
	//=========================================================================			
		
	function wptb_options_panel() { //create custom top-level menu 
		add_menu_page( 'WP TopBar', 'WP TopBar', 'manage_options', 'wp-topbar.php', 'wptb_options_page', plugins_url('/images/icon.png', __FILE__)); 	
		
		$tabs = array( 'main' => 'Main Options',  'topbartext' => 'TopBar Text & Image',  'topbarcss' => 'TopBar CSS', 'colorselection' => 'Color Selection','closebutton' => 'Close Button', 'socialbuttons' => 'Social Buttons','debug' => 'Debug', 'faq' => 'FAQ', 'delete' => 'Delete Settings' );

	    foreach( $tabs as $menu => $title ) {            
         	add_submenu_page( 'wp-topbar.php', 'wp-topbar-'.$menu, $title,  'manage_options', 'wp-topbar.php&tab='.$menu, 'wptb_options_page' );
        }
	} // End of function wptb_options_panel 	
	
	
	//=========================================================================			
	// Run this when plugin is activiated 
	//=========================================================================			
		
	function wtpb_activate_plugin() { 
	
			self::wtpb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
	
	} // End of function wtpb_activate_plugin 	
	
	
	//=========================================================================			
	// Run this when plugin is activiated or from options page to check
	// if upgrade functions need to run.
	// Parameter $wptb_echo_on is used for debugging:  
	//		1=use echo function, 0=use error_log function
	//=========================================================================			
		
	function wtpb_check_for_plugin_upgrade($wptb_echo_on) { 
	
		$wptb_this_version_number = '3.09';
	
		$wptbOptions = get_option('wptbAdminOptions');
		$wptb_debug=get_transient( 'wptb_debug' );	
		
		if($wptb_debug) {
			if($wptb_echo_on) {
				echo '<br><code>WP-TopBar Debug Mode: in wtpb_check_for_plugin_upgrade</code>' ;
				echo '<br><code>WP-TopBar Debug Mode: Version ',$wptb_this_version_number,'</code>';
			}
			else {
				error_log( 'WP-TopBar Debug Mode: in wtpb_check_for_plugin_upgrade' );
				error_Log( 'WP-TopBar Debug Mode: Version '.$wptb_this_version_number);
			}
		}		
	
		// code, if needed, to perform option table upgrades & updates version stored in database
	
			if (!empty($wptbOptions)) {
				if ($wptbOptions['wptb_version'] != $wptb_this_version_number) {
					if($wptb_debug) {
						if($wptb_echo_on) 
							echo '<br><code>WP-TopBar Debug Mode: Version Upgrade from ', $wptbOptions['wptb_version'] , ' to ',$wptb_this_version_number,'</code>';
						else
							error_Log ('WP-TopBar Debug Mode: Version Upgrade from ' . $wptbOptions['wptb_version'] . ' to '. $wptb_this_version_number);
					}
					
					// For v 3.03 force div_css to old default for existing users
					
//					if ($wptbOptions['wptb_version'] < '3.03') {
//						if ($wptbOptions['div_css'] == '') $wptbOptions['div_css'] = 'visibility:hidden;'; 
//					}									
					$wptbOptions['wptb_version'] = $wptb_this_version_number;
					update_option('wptbAdminOptions', $wptbOptions);
				}
			}
	
		if($wptb_debug) {
			if($wptb_echo_on) 
				echo '<br><code>WP-TopBar Debug Mode: end of wtpb_check_for_plugin_upgrade</code>' ;
			else
				error_log( 'WP-TopBar Debug Mode: end of wtpb_check_for_plugin_upgrade' );
		}
		
	} // End of function wtpb_check_for_plugin_upgrade 	


	//=========================================================================		
	// Common code to display the TopBar. Used on the Admin page and to display on the website
	// 
	// Parm $wptbaddslashes:
	//	True = then call addslashes to the string  
	//=========================================================================		
	
	function wptb_display_TopBar($wptb_visibility, $wptbOptions, $wptbaddslashes) {
	
		if ( ($wptbaddslashes) ) {
			$wtpbtextfields = array( '1' => 'custom_css_bar',  '2' => 'bar_text',  '3' => 'custom_css_text', '4' => 'bar_link_text','5' => 'social_icon1_css', '6' => 'social_icon2_css','7' => 'social_icon3_css', '8' => 'social_icon4_css', '9' => 'close_button_css', '10' => 'div_css' );
		  	foreach( $wtpbtextfields as $number => $field ) {				
		  		if ( isset($wptbOptions[$field]) )	 
		  			$wptbOptions[$field] = addslashes($wptbOptions[$field]);
			}
		}
		
		echo '<p id="wptbheadline" style="',$wptb_visibility;
		if ($wptbOptions['enable_image'] == 'false') 
			echo "background: {$wptbOptions['bar_color']};";
		else 
		 	echo "background-image: url({$wptbOptions['bar_image']});	background-position:center;"; 
		echo 'margin:  ',$wptbOptions['margin_top'],'px 0px ',$wptbOptions['margin_bottom'],'px;';
		echo 'text-align:',$wptbOptions['text_align'],';','font-size: ',$wptbOptions['font_size'],'px; ';	
		echo 'padding-top:',$wptbOptions['padding_top'],'px;','padding-bottom:',$wptbOptions['padding_bottom'],'px;'; 	
		echo 'color:',$wptbOptions['text_color'],'; display:block;';
		echo 'border-bottom-color:',$wptbOptions['bottom_color'],';','border-bottom-style: solid;';
		echo 'border-bottom-width: ',$wptbOptions['bottom_border_height'],'px;';
		if ($wptbOptions['custom_css_bar'] != '') 
				echo $wptbOptions['custom_css_bar'];
		echo '">',$wptbOptions['bar_text'],'<a style="color:',$wptbOptions['link_color'],';" ';
		if ($wptbOptions['custom_css_text'] != '')
			echo "{$wptbOptions['custom_css_text']}";
		echo 'href="',$wptbOptions['bar_link'],'" target="_',$wptbOptions['link_target'],'">';
		echo $wptbOptions['bar_link_text'],'</a>'; 
		if ( ($wptbOptions['social_icon1'] == 'on') && ($wptbOptions['social_icon1_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon1_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon1_image'].'" style="'.$wptbOptions['social_icon1_css'].'"/></a>';
		if ( ($wptbOptions['social_icon2'] == 'on') && ($wptbOptions['social_icon2_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon2_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon2_image'].'" style="'.$wptbOptions['social_icon2_css'].'"/></a>';
		if ( ($wptbOptions['social_icon3'] == 'on') && ($wptbOptions['social_icon3_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon3_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon3_image'].'" style="'.$wptbOptions['social_icon3_css'].'"/></a>';
		if ( ($wptbOptions['social_icon4'] == 'on') && ($wptbOptions['social_icon4_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon4_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon4_image'].'" style="'.$wptbOptions['social_icon4_css'].'"/></a>';
		if ($wptbOptions['allow_close'] == 'yes') {
			echo '<span style="">';
			echo '<img align="middle" border="0" onClick="close_wptobar()" src="'.$wptbOptions['close_button_image'].'" style="cursor:hand;cursor:pointer;'.$wptbOptions['close_button_css'].'"/></span>';
		}		
		echo '</p>';
	}  // end function wptb_display_TopBar
		
	
	//=========================================================================		
	//Adds the TopBar HTML and Javascript to the output
	//=========================================================================		
	
	function wptb_inject_TopBar_html_js() {
	
		$wptbOptions = get_option('wptbAdminOptions');
	
		if (! isset( $wptbOptions['enable_topbar'] ) ) {return; }
	
		if ( $wptbOptions['enable_topbar'] == 'false' ) { return; }
		
		if (!self::wptb_check_time(current_time('timestamp', 1), $wptbOptions['start_time_utc'],$wptbOptions['end_time_utc'])) { return; } // time check
		
		global $wp_query;
		$thePostID = $wp_query->post->ID;
		
	// if invert_include is 'yes', then exclude showing the Topbar using inlcude_pages values
		if ( $wptbOptions['invert_include'] == 'yes' ) {
			if ( in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) )
					{ return; }			
		}
		else {
			if ( ! in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) && ! in_array( 0, explode( ',', $wptbOptions['include_pages'] ) ) )
					{ return; }			
		}

	// use javascript to force the HTML to just before body tag if the topbar is at the top of the page
		if ( $wptbOptions['topbar_pos'] == 'header' ) { 	
			echo '
';
			echo "<script type='text/javascript'>";
			echo '
';
			echo "jQuery(document).ready(function() {";
			echo "jQuery('body').prepend('";
		}
				
		echo '<div id="topbar" style="',$wptbOptions['div_css'],'">';

		self::wptb_display_TopBar('visibility:hidden;',$wptbOptions, true);
	
		echo '</div>';
	
				
		if ( $wptbOptions['topbar_pos'] == 'header' )
			echo "');} );
";
		
		$wptb_cookie = "wptopbar_".COOKIEHASH;
		
		if ( $wptbOptions['topbar_pos'] == 'footer' ) {	
				echo '
';
				echo "<script type='text/javascript'>";

		}
				
		if  ($wptbOptions['respect_cookie'] == 'ignore')  { // destroy cookie
			echo '
';
			echo 'document.cookie="'.$wptb_cookie.'"'."+'=;expires=Thu, 01-Jan-70 00:00:01 GMT;';";
		}
		if ($wptbOptions['allow_close'] == 'yes') { 

			if  ( ($wptbOptions['respect_cookie'] == 'always') AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']) ) {
				echo '
';
				echo 'document.getElementById("wptbheadline").style.visibility = "hidden";';
				echo '
';				echo '</script>';
				return;  
			}
			
			echo '
';
			echo 'function close_wptobar() { document.getElementById("wptbheadline").style.visibility = "hidden";';
			if  ($wptbOptions['respect_cookie'] == 'always') { 
				
				echo 'var now= new Date();';
				echo 'var expDate = new Date();';
				echo 'expDate.setTime(now.getTime() + 3600000*24*30);';
				echo 'document.cookie="'.$wptb_cookie.'"+"="+escape('.$wptbOptions['cookie_value'].')+";expires="+expDate.toUTCString();';
			}
			echo ' };';	
		}
		
		echo '
';
		echo 'jQuery(document).ready(function() {',"jQuery('#wptbheadline').hide().delay(",$wptbOptions['delay_time'],").css('visibility','visible').slideDown(",$wptbOptions['slide_time'],").fadeIn(1000).show('slow');";
	
		if (($wptbOptions['display_time']+0) != 0) {
			echo "jQuery('#wptbheadline').delay(",$wptbOptions['display_time'],').slideUp(',$wptbOptions['slide_time'],').fadeOut(1000).hide();';
		} 		
		echo '});
';
		echo '</script>';

	}  // end function wptb_inject_TopBar_html_js
		 	
	
	//=========================================================================			
	//	Check start/end times to see if TopBar should load: 
	//     Returns 1 = yes, 0 = no
	//  Args:  current time, start time, end time
	//=========================================================================			
		
	function wptb_check_time($wptb_time, $wptb_check_start, $wptb_check_end) {				
		if ((($wptb_time - $wptb_check_start) >= 0) && 
			((($wptb_check_end - $wptb_time)) >=0) || ($wptb_check_end == 0))
				return 1;
			else 
				return 0;
	} // End of function wptb_check_time
		
}

wptb::init();
endif;
?>