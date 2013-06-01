<?php
/*

Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, image and link.
Version: 4.17
Author: Bob Goetz
Author URI: http://zwebify.com/wordpress-plugins/

*/
/*  Copyright 2013  Bob Goetz  (email : bob @ zwebify . dot . com)

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

$WPTB_VERSION = "4.17";


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
			
			require_once( dirname(__FILE__).'/lib/wp-topbar-admin.php');  //load admins page php
			require_once( dirname(__FILE__).'/lib/wp-topbar-pointer.php');  //load pointer pages php
		
		//Actions
			add_action( 'init', array( __CLASS__, 'wptb_enqueue_admin_scripts' ) );
			add_action( 'init', array( __CLASS__, 'wptb_debug_check' ) );
			add_action( 'admin_menu', array( __CLASS__, 'wptb_options_panel' ) ); 
			add_action( 'admin_notices', 'wptb_admin_notice' );
			add_action( 'admin_enqueue_scripts', 'wptb_pointer_load', 1000 );

		
		//Filters
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__) , array( __CLASS__, 'wptb_plugin_action_links' ) );
			add_filter( 'plugin_row_meta', array( __CLASS__, 'wptb_plugin_donate_link' ), 10, 2 );
			add_filter( 'wptb_admin_pointers-toplevel_page_wp-topbar', 'wptb_register_pointer' );

		}	
		else
		{
	
		//=========================================================================			
		//Actions and Filters, on all non-admin pages - these display the topbar
		//=========================================================================	
			
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wptb_enqueue_jquery' ) );
			add_action( 'wp_footer', array( __CLASS__, 'wptb_inject_TopBar_html_js' ), 9999999);
		}
		
	}

	//=========================================================================			
	// Enqueue jquery to get our javascripts to run -- just in case no other theme/plugin has
	//=========================================================================	
	
	function wptb_enqueue_jquery() {
    		wp_enqueue_script('jquery');     
		
	} // End of function wptb_enqueue_jquery

	//=========================================================================			
	// Enqueue Media Uploader, Farbtastics, etc. for the color pickers, etc.
	//=========================================================================		
		
	function wptb_enqueue_admin_scripts() {
		
		if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') {  // only load these on the admin page
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			
			wp_enqueue_style( 'thickbox' );
	
			wp_register_script( 'wptb_upload',        plugins_url('/lib/js/wp-topbar-load-image.js', __FILE__), array('jquery','media-upload','thickbox') );
			wp_enqueue_script(  'wptb_upload' ) ;
			
			wp_enqueue_script( 'jquery' );
			
			
			wp_register_script( 'wptb_jquery_ui_js',  plugins_url('/lib/js/jquery-ui-1.10.3.custom.min.js', __FILE__) );
			wp_enqueue_script(  'wptb_jquery_ui_js');  
			
//			wp_enqueue_script( 'jquery-ui-core' );
//			wp_enqueue_script( 'jquery-ui-datepicker' );
//			wp_enqueue_script( 'jquery-ui-slider');
						
			wp_register_script( 'wptb_timepicker_js',    plugins_url('/lib/js/jquery-ui-timepicker-addon.js', __FILE__), array('jquery') );
			wp_enqueue_script(  'wptb_timepicker_js' );

			wp_register_script( 'wptb_admin_js',    plugins_url('/lib/js/wp-topbar-admin.js', __FILE__), array('jquery') );
			wp_enqueue_script(  'wptb_admin_js' );
			
			wp_register_style( 'wptb_jquery_ui_css',  plugins_url('/lib/css/jquery-ui-1.10.3.custom.min.css', __FILE__) );
			wp_enqueue_style(  'wptb_jquery_ui_css' );
			wp_register_style( 'wptb_css',            plugins_url('/lib/css/wp-topbar-admin.css', __FILE__) );
			wp_enqueue_style(  'wptb_css' );			
			wp_register_style( 'wptb_timepicker_css', plugins_url('/lib/css/jquery-ui-timepicker-addon.css', __FILE__) );
			wp_enqueue_style(  'wptb_timepicker_css' );		

			global $wp_version;
			if ( version_compare( $wp_version, "3.5", '>=' ) ) {
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_style( 'wp-color-picker' );
			} 
			else 
			{
				// <WP3.5
				wp_enqueue_style( 'farbtastic' );
				wp_enqueue_script( 'farbtastic' );
			}

		}
				
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
		
		$tabs = array( 'table' => 'All TopBars', 'testpriority' => 'Test Priority', 'bulkclosebutton'=> 'Close Button', 'export' => 'Export', 'mainfaq' => 'FAQ' );

	    foreach( $tabs as $menu => $title ) {            
         	add_submenu_page( 'wp-topbar.php', 'wp-topbar-'.$menu, $title,  'manage_options', 'wp-topbar.php&action='.$menu, 'wptb_options_page' );
        }
	} // End of function wptb_options_panel 	
	
	
	//=========================================================================			
	// Run this when plugin is activiated 
	//=========================================================================			
		
	function wtpb_activate_plugin() { 
	
//			self::wtpb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
	
	} // End of function wtpb_activate_plugin 	
	

	//=========================================================================		
	//Adds the TopBar HTML and Javascript to the output
	//=========================================================================		
		
	function wptb_inject_TopBar_html_js() {

		// check for options using the old method, if used - honor it.  otherwise get a TopBar from the database	
		$wptbOptions = get_option('wptbAdminOptions');

		if ( isset( $wptbOptions['enable_topbar'] ) ) {
			echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: still using options table (version '.$wptbOptions['wptb_version'].') -->';
			wptb::wptb_inject_specific_TopBar_html_js($wptbOptions, true, "");
		}
		else { 
			wptb::wptb_build_cacheable_html_js(true);
		}
	}  // end function wptb_inject_TopBar_html_js


	//=========================================================================		
	// Inject specific TopBar HTML-- used also on the admin (debug) pages
	//=========================================================================		

	function wptb_inject_specific_TopBar_html_js($wptbOptions, $wptbRenderJS, $wptbTopBarNumber) {

		if ( wptb::wptb_check_options_to_show_row($wptbOptions) == false ) { return false; }
			
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
				
		echo '<div id="topbar'.$wptbTopBarNumber.'" style="'.trim($wptbOptions['div_css']).'">';
		
	
		self::wptb_display_TopBar('visibility:hidden;',$wptbOptions, true, $wptbTopBarNumber);

		echo '</div>';
				
		if ( $wptbOptions['topbar_pos'] == 'header' )
			echo "');} );
";

		if ( $wptbRenderJS ) {
		
			echo "// Rendering JS = [".$wptbTopBarNumber."]";
		
			if ( $wptbOptions['topbar_pos'] == 'footer' ) {	
					echo '
	';
					echo "<script type='text/javascript'>";
	
			}
					
			if  ($wptbOptions['respect_cookie'] == 'ignore')  { // destroy cookie
				$wptb_cookie = "wptopbar_".COOKIEHASH;
	
				echo '
	';
				echo '	document.cookie="'.$wptb_cookie.'"'."+'=;expires=Thu, 01-Jan-70 00:00:01 GMT;';";
			}
			if ($wptbOptions['allow_close'] == 'yes') {
				echo '
	';
				echo '	function close_wptopbar'.$wptbTopBarNumber.'() { document.getElementById("wptbheadline'.$wptbTopBarNumber.'").style.visibility = "hidden";';
				if  ($wptbOptions['respect_cookie'] == 'always') { 
					$wptb_cookie = "wptopbar_".COOKIEHASH;
					echo 'var now= new Date();';
					echo 'var expDate = new Date('.(date('Y') + 1).', 12, 31 );';
					echo 'document.cookie="'.$wptb_cookie.'"+"="+escape('.$wptbOptions['cookie_value'].')+";expires="+expDate.toUTCString();';
				}
				echo ' };';	
			}
			
			echo '
	';
	
			echo 'jQuery(document).ready(function() {',"jQuery('#wptbheadline".$wptbTopBarNumber."').hide().delay(",$wptbOptions['delay_time'],").css('visibility','visible').slideDown(",$wptbOptions['slide_time'],").fadeIn(1000).show('slow');";
		
			if (($wptbOptions['display_time']+0) != 0) {
				echo "jQuery('#wptbheadline".$wptbTopBarNumber."').delay(",$wptbOptions['display_time'],').slideUp(',$wptbOptions['slide_time'],').fadeOut(1000).hide();';
			} 		
			echo '});
	';
			echo '</script>';
			
		}
	else 
		if ( $wptbOptions['topbar_pos'] == 'header' ) 	
				echo '</script>';

		return true;

	}  // end function wptb_inject_specific_TopBar_html_js	
	
	
	// checks all the options, returns TRUE if TopBar should show, FALSE if not
	
	function wptb_check_options_to_show_row($wptbOptions) {
	
				if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') 
						$thePostID = "";
				else {
						global $wp_query;
						$thePostID = $wp_query->post->ID;
				}
				
				if ( is_home() && ( $wptbOptions['show_homepage'] == "never" ) ) { return false; }		
	
				if ( ! ( is_home() && ( $wptbOptions['show_homepage'] == "always" ) ) ) {	

					if (     is_user_logged_in()   && ( $wptbOptions['only_logged_in'] == "no"  )) { return false; } 
					if (  ( !is_user_logged_in() ) && ( $wptbOptions['only_logged_in'] == "yes" )) { return false; } 

					if ( $wptbOptions['include_pages'] == 0 )
						$page_id_found = true;
					else {
						$page_id_found = false;
						if ( $wptbOptions['include_logic'] != 'cat_only' ) {   //skip this logic if we are only checking categories
							if ( in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) )
								 $page_id_found = true;
							if ( $wptbOptions['invert_include'] == 'yes' )
								 $page_id_found = ! $page_id_found;	
						}
					}
			
					if ( $wptbOptions['include_categories'] == 0 )
						$category_id_found = true; 
					else {
						$category_id_found = false;
						if ( $wptbOptions['include_logic'] != 'page_only' ) {   //skip this logic if we are only checking pages
							foreach((get_the_category($thePostID)) as $category) {
								if ( in_array( $category->cat_ID, explode( ',', $wptbOptions['include_categories'] ) ) ) {
									  $category_id_found = true;
									  break;
								}
							}
							if ( $wptbOptions['invert_categories'] == 'yes' )
								 $category_id_found = ! $category_id_found;
						}
					}
					// check the logic the user selected if not on debug page
							
					if ( ! ( isset( $_GET['page'] ) && $_GET['page'] == 'wp-topbar.php') ) 
						switch ( $wptbOptions['include_logic'] ) {
							
						case 'page_only':
				
							if ( ! $page_id_found ) {return false;}		
							break;
							
						case 'cat_only':
						
							if ( ! $category_id_found ) {return false;}
							break;
							
						case 'boolean_and':
							
							if ( ( ! $page_id_found ) || ( ! $category_id_found ) ) {return false;}			
							break;
							
						case 'boolean_or':
								
							if ( ( ! $page_id_found ) && ( ! $category_id_found ) ) {return false;}
							
						}
				}
		
				$wptb_cookie = "wptopbar_".COOKIEHASH;
				
				if  ( ( $wptbOptions['allow_close'] == 'yes' ) && 
					  ( $wptbOptions['respect_cookie'] == 'always' ) && 
					  ( isset ($_COOKIE[$wptb_cookie])) &&
					  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']) ) {
					echo '<!-- WP-TopBar_'.$wptbOptions['wptb_version'].' :: Valid Cookie Present - not showing TopBar -->
		';
					return false;  
				}
				
				return true;

	}	// End of wptb_check_options_to_show_row
	
	
	
	//=========================================================================		
	// Code to display the TopBar.
	// 
	// Parm $wptbaddslashes:
	//	True = then call addslashes to the string  
	//=========================================================================		
	
	function wptb_display_TopBar($wptb_visibility, $wptbOptions, $wptbaddslashes, $wptbTopBarNumber) {
	
		if ( ($wptbaddslashes) ) {
			$wptbtextfields = array( '1' => 'custom_css_bar',  '2' => 'bar_text',  '3' => 'custom_css_text', '4' => 'bar_link_text','5' => 'social_icon1_css', '6' => 'social_icon2_css','7' => 'social_icon3_css', '8' => 'social_icon4_css', '9' => 'close_button_css', '10' => 'div_css' );
		  	foreach( $wptbtextfields as $number => $field ) {				
		  		if ( isset($wptbOptions[$field]) )	 
		  			$wptbOptions[$field] = addslashes($wptbOptions[$field]);
			}
		}
		
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
			$wptbOptions['bar_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_text']);
			$wptbOptions['bar_link_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link_text']);
			$wptbOptions['bar_link'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link']);
		}


		echo '<p id="wptbheadline'.$wptbTopBarNumber.'" style="'.$wptb_visibility.';';
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
				echo trim($wptbOptions['custom_css_bar'])." ";
		echo '">';
		if ($wptbOptions['php_text_prefix'] != "" ) {
			eval( stripslashes($wptbOptions['php_text_prefix'] ) );
		}			
		echo $wptbOptions['bar_text'],'<a style="color:',$wptbOptions['link_color'],'; ';
		if ($wptbOptions['custom_css_text'] != '')
			echo "{".trim($wptbOptions['custom_css_text'])."}";
		echo '" ';
		echo 'href="',$wptbOptions['bar_link'],'" target="_',$wptbOptions['link_target'],'">';
		echo $wptbOptions['bar_link_text'],'</a>'; 
		if ( ($wptbOptions['social_icon1'] == 'on') && ($wptbOptions['social_icon1_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon1_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon1_image'].'" style="'.trim($wptbOptions['social_icon1_css']).'"/></a>';
		if ( ($wptbOptions['social_icon2'] == 'on') && ($wptbOptions['social_icon2_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon2_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon2_image'].'" style="'.trim($wptbOptions['social_icon2_css']).'"/></a>';
		if ( ($wptbOptions['social_icon3'] == 'on') && ($wptbOptions['social_icon3_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon3_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon3_image'].'" style="'.trim($wptbOptions['social_icon3_css']).'"/></a>';
		if ( ($wptbOptions['social_icon4'] == 'on') && ($wptbOptions['social_icon4_image'] !== '') )
			echo '<a href="'.$wptbOptions['social_icon4_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon4_image'].'" style="'.trim($wptbOptions['social_icon4_css']).'"/></a>';
		if ($wptbOptions['allow_close'] == 'yes') {
			echo '<span style="">';
			echo '<img align="middle" border="0" onClick="close_wptopbar'.$wptbTopBarNumber.'()" src="'.$wptbOptions['close_button_image'].'" style="cursor:hand;cursor:pointer;'.$wptbOptions['close_button_css'].'"/></span>';
		}
		if ($wptbOptions['php_text_suffix'] != "" ) {
			eval( stripslashes($wptbOptions['php_text_suffix'] ) );
		}		
		echo '</p>';
	}  // end function wptb_display_TopBar
				

	//=========================================================================		
	//Builds the cacheable topbars; using one loop building all parts at once
	//=========================================================================		
	function wptb_build_cacheable_html_js($wptb_echo_on) {
	
		if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
		else $wptb_debug = false;			
	
		if($wptb_debug)
			echo '<br><code>WP-TopBar Debug Mode: Getting Random TopBar</code>';
	
		global $wpdb;
		$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	
	
		$sql="SELECT * FROM ".$wptb_table_name." 
				WHERE  `enable_topbar` =  'true'
					AND COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
												COALESCE(STR_TO_DATE( `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) <= 0 
					AND	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
												COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) <=0
				ORDER BY `topbar_pos`
				";		

		$all_rows = $wpdb->get_results( $sql, ARRAY_A );
		
		echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: Number of TopBars Selected: '.$wpdb->num_rows.'-->
';
		$x=0;
		$html_part_1_out = "
<script type='text/javascript'>
		
		
jQuery(document).ready(function() {
";
		$html_part_2_out = "	
	var wtpbPoints = [];
";
			
		$html_part_3_out = "
	var wptbSelectRow = {
";
		$html_cookie_out = "
<script type='text/javascript'>

";
		$cookie_destroyed = false;
		$output_cookie_html = false;
		
		if ( $wpdb->num_rows != 0 ) {

			$x = 0;
			$max = 0;
			foreach ($all_rows as $one_row) {
			    foreach ($one_row as $key => $option){
					$wptbOptions[$key] = $option;
				}
				if ( wptb::wptb_inject_specific_TopBar_html_js($wptbOptions, false, $x + 1) ) {		
				
					if  ( !( $cookie_destroyed ) && $wptbOptions['respect_cookie'] == 'ignore')  { // destroy cookie
						$cookie_destroyed = true;
						$output_cookie_html = true;
						$wptb_cookie = "wptopbar_".COOKIEHASH;
						$html_cookie_out .= '	document.cookie="'.$wptb_cookie.'"'."+'=;expires=Thu, 01-Jan-70 00:00:01 GMT;';";			
						$html_cookie_out .= '
';
					}
					if ($wptbOptions['allow_close'] == 'yes') {
						$output_cookie_html = true;

						$html_cookie_out .= '
';
						$html_cookie_out .= '	function close_wptopbar'.($x+1).'() { document.getElementById("wptbheadline'.($x+1).'").style.visibility = "hidden";';
						if  ($wptbOptions['respect_cookie'] == 'always') { 
							$wptb_cookie = "wptopbar_".COOKIEHASH;
							$html_cookie_out .= 'var now= new Date();';
							$html_cookie_out .= 'var expDate = new Date('.(date('Y') + 1).', 12, 31 );';
							$html_cookie_out .= 'document.cookie="'.$wptb_cookie.'"+"="+escape('.$wptbOptions['cookie_value'].')+";expires="+expDate.toUTCString();';
						}
						$html_cookie_out .= ' };';	
					}
									
					if ( $wptbOptions['scroll_action'] != "on") {
						$html_part_3_out .= "		".($x + 1).": function() {jQuery(".'"#wptbheadline'.($x + 1).'").hide().delay('.$wptbOptions['delay_time'].').css("visibility","visible").slideDown('.$wptbOptions['slide_time'].').fadeIn(1000).show("slow");';
						if (($wptbOptions['display_time']+0) != 0) {
							$html_part_3_out .= "
		                   jQuery('#wptbheadline".($x + 1)."').delay(".$wptbOptions['display_time'].').slideUp('.$wptbOptions['slide_time'].').fadeOut(1000).hide();';
						}
					}
					else {
						$html_part_3_out .= "		".($x + 1).": function() {jQuery(window).scroll(function(){
       			if(jQuery(window).scrollTop()> 0 ) {
       				jQuery('#wptbheadline".($x + 1)."').css('visibility','visible').slideDown('".$wptbOptions['slide_time']."').fadeIn(1000).show('slow');	
       			} else {
       				jQuery('#wptbheadline".($x + 1)."').fadeOut('slow');
      			}
   		});"; 		
				   	}	

					$html_part_3_out .=  "}";
	//				$html_part_3_out .=  " alert(".($x+1).")}";
	
					if (($x+1) < $wpdb->num_rows)
						$html_part_3_out .= ",
";
	
					$html_part_1_out .= '
	jQuery("#wptbheadline'.($x + 1).'").hide();';		
					$html_part_2_out .= '
	wtpbPoints[ '.$x.' ] = '.$wptbOptions['weighting_points'].';';
					$x = $x + 1; 
					$max = $max + intval( $wptbOptions['weighting_points'] );
				}
			}
			
			if ( $x == 1) 
				$html_part_2_out .=  '
	wptb_selected_row = 1;';
			else 
				$html_part_2_out .=  '
	random_priority = 0;
	random_priority = Math.floor(Math.random()*'.$max.'); 
	total_points = 0;
	wptb_selected_row = 0;
	
	for ( var i = 0; i < wtpbPoints.length; i = i + 1 ) {
		total_points = total_points + wtpbPoints[i]; 
	
		if (random_priority <= total_points) {
				wptb_selected_row = (i + 1);
				i = wtpbPoints.length + 1;
		} 
	} 				 
';
			
			$html_part_3_out .= "
	};

	// execute the one specified in the 'wptb_selected_row' variable:

	wptbSelectRow[wptb_selected_row]();
}
);
</script>
";	
			$html_cookie_out .= "
</script>
";
			if ( $x > 0) {
				if ( $output_cookie_html )
					echo $html_cookie_out;

				echo $html_part_1_out;			
				echo $html_part_2_out;			
				echo $html_part_3_out;
			}
		}
		else {
			echo '<!-- WP-TopBar_'.$wptbOptions['wptb_version'].' :: not using options nor database -->
';
		}
				
		return;
		
	}	// End of wptb_build_cacheable_html_js

}

wptb::init();
endif;
?>