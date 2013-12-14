<?php
/*

Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Create MULTIPLE TopBars that will be shown at the top of your website.  TopBars are selected by a variety of options - includes scheduler, custom PHP, custom CSS and more!
Version: 5.15
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


$WPTB_VERSION = "5.15";
$WPTB_DB_VERSION = "5.06";  // rev this only when this changes

if( ! class_exists( 'wptb' ) ):
class wptb {

	 function init(){
	 

		//=========================================================================			
		//Perform any onetime functions when plugin is activiated
		//=========================================================================			
		register_activation_hook( __FILE__,array( __CLASS__, 'wptb_activate_plugin' ) );
		
		//=========================================================================			
		//Actions and Filters, if on plugin admin page	
		//=========================================================================	
		    	
		if (is_admin() )	 { // make sure we are on the admin page to minimize scripts loaded on the website
			
			add_action('init', array( __CLASS__, 'wptb_admin_init' ) );

		}	
		else
		{
	
		//=========================================================================			
		//Actions and Filters, on all non-admin pages - these display the topbar
		//=========================================================================	
			
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wptb_enqueue_jquery' ) );
			add_action( 'wp_footer', array( __CLASS__, 'wptb_activate_TopBar_html_js' ), 9999999);
		}
		
	}

	public static function wptb_admin_init() {

		require_once( dirname(__FILE__).'/lib/wp-topbar-admin.php');  			//load admins page php
		require_once( dirname(__FILE__).'/lib/wp-topbar-network-admin.php');  	//load network admins page php

		//Actions
		add_action( 'admin_menu', array( __CLASS__, 'wptb_register_options_menu' ) ); 

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( __CLASS__, 'wptb_register_network_options_menu' ) ); 
		}
		else {
			add_action( 'admin_notices', 'wptb_admin_notice' );

		}
		require_once( dirname(__FILE__).'/lib/wp-topbar-pointer.php');  		//load pointer pages php
			
		add_action( 'init', array( __CLASS__, 'wptb_debug_check' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wptb_enqueue_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', 'wptb_pointer_load' );
			
			
		//Filters
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__) , array( __CLASS__, 'wptb_plugin_action_links' ) );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'wptb_plugin_donate_link' ), 10, 2 );
		add_filter( 'wptb_admin_pointers-toplevel_page_wp-topbar', 'wptb_register_pointer' );


	} // End of function wptb_admin_init

	//=========================================================================			
	// Enqueue jquery to get our javascripts to run -- just in case no other theme/plugin has
	//=========================================================================	
	
	public static function wptb_enqueue_jquery() {
    		wp_enqueue_script('jquery');     
		
	} // End of function wptb_enqueue_jquery

	//=========================================================================			
	// Enqueue Media Uploader, Farbtastics, etc. for the color pickers, etc.
	//=========================================================================		
		
	public static function wptb_enqueue_admin_scripts() {
		
		if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') {  // only load these on the admin page

			wp_enqueue_script( 'jquery' );			

			wp_enqueue_script( 'jquery-ui-core' );
		    wp_enqueue_script( 'jquery-ui-slider' );
		    wp_enqueue_script( 'jquery-ui-datepicker' );
		    wp_enqueue_script( 'jquery-ui-button' );

			wp_enqueue_script( 'media-upload' );

			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );
				
			wp_register_script( 'wptb_upload',        plugins_url('/lib/js/wp-topbar-load-image.js', __FILE__), array('jquery','media-upload','thickbox') );
			wp_enqueue_script(  'wptb_upload' ) ;
			
			wp_register_script( 'wptb_timepicker_js',    plugins_url('/lib/js/jquery-ui-timepicker-addon.js', __FILE__), array('jquery') );
			wp_enqueue_script(  'wptb_timepicker_js' );

			wp_register_script( 'wptb_admin_js',    plugins_url('/lib/js/wp-topbar-admin.js', __FILE__), array('jquery') );
			wp_enqueue_script(  'wptb_admin_js' );
			
			wp_register_style( 'wptb_jquery_ui_css',  plugins_url('/lib/css/jquery-ui-1.10.3.custom.min.css', __FILE__) );
			wp_enqueue_style(  'wptb_jquery_ui_css' );
			wp_register_style( 'wptb_timepicker_css', plugins_url('/lib/css/jquery-ui-timepicker-addon.css', __FILE__) );
			wp_enqueue_style(  'wptb_timepicker_css' );		

			global $wp_version;
			if ( version_compare( $wp_version, "3.8", '<' ) ) {
				wp_register_style( 'wptb_css',            plugins_url('/lib/css/wp-topbar-admin.css', __FILE__) );
				wp_enqueue_style(  'wptb_css' );			
			}
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
	
	public static function wptb_debug_check() {	
		
		if ((isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') &&
	        isset( $_GET['debug'] ) && current_user_can( 'manage_options' ) ) {
		        set_transient( 'wptb_debug', gettimeofday(true), 60 );
	    }
	} // End of function wptb_debug_check	


	//=========================================================================			
	// Add 'Settings' link to plugin page
	//=========================================================================			
	
	public static function wptb_plugin_action_links($links) {
		$wptb_settings_link = '<a href="'.admin_url( 'admin.php?page=wp-topbar.php' ).'">Settings</a>';
		array_unshift($links, $wptb_settings_link);
		return $links;
	} // End of function wptb_plugin_action_links
	
	
	//=========================================================================			
	// Add donate link on manage plugin page
	//=========================================================================			
	
	public static function wptb_plugin_donate_link($links, $file) {
		if ($file == plugin_basename(__FILE__)) {
				$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank">Donate</a>';
				$links[] = $donate_link;
			}
			return $links;
	} // End of function wptb_plugin_donate_link
	
	
	//=========================================================================			
	// Initialize the admin panel, add main option menu and submenus
	//=========================================================================			
		
	public static function wptb_register_options_menu() { //create custom top-level menu 
	
		if ( is_multisite() ) { // check if on multi-site and if so, check if plugin shows only on Admin pages
			if ( ! current_user_can( 'manage_network_plugins' )  ) {
				$wptbNetworkGlobalOptions = get_site_option( 'wptb_network_global_options' );
				if (( isset($wptbNetworkGlobalOptions [ 'multisite_super_admin_only' ] )) && ($wptbNetworkGlobalOptions [ 'multisite_super_admin_only' ] == "yes"))
					return;
			}
		}
	
	
		add_menu_page( 'WP TopBar', 'WP TopBar', 'manage_options', 'wp-topbar.php', 'wptb_options_page', plugins_url('/images/icon.png', __FILE__)); 	
		
		$tabs = array( 'table' => 'All TopBars', 'globalsettings' => 'Global Settings', 'testpriority' => 'Test Priority', 'bulkclosebutton'=> 'Close Button', 'export' => 'Export', 'mainfaq' => 'FAQ' );

	    foreach( $tabs as $menu => $title ) {            
         	add_submenu_page( 'wp-topbar.php', 'wp-topbar-'.$menu, $title,  'manage_options', 'wp-topbar.php&action='.$menu, 'wptb_options_page' );
        }
	} // End of function wptb_register_options_menu 	
	
	//=========================================================================			
	// Initialize the Netork (Multi Site) admin panel, add main option menu and submenus
	//=========================================================================			
		
	public static function wptb_register_network_options_menu() { //create custom top-level menu 
		add_menu_page( 'WP TopBar', 'WP TopBar', 'manage_options', 'wp-topbar.php', 'wptb_network_options_page', plugins_url('/images/icon.png', __FILE__)); 	
		
		$tabs = array( 'networksettings' => 'Settings', 'networkuninstall' => 'Uninstall', 'networkfaq' => 'FAQ' );

	    foreach( $tabs as $menu => $title ) {            
         	add_submenu_page( 'wp-topbar.php', 'wp-topbar-'.$menu, $title,  'manage_options', 'wp-topbar.php&action='.$menu, 'wptb_network_options_page' );
        }
	} // End of function wptb_register_network_options_menu 	
	
	//=========================================================================			
	// Run this when plugin is activiated 
	//=========================================================================			
		
	public static function wptb_activate_plugin() {   
	
	//		require_once( dirname(__FILE__).'/lib/wp-topbar-db-io.php');  //database and I-O functions php
	//		wptb::wptb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
		
	
	} // End of function wptb_activate_plugin 	
	

	//=========================================================================			
	// Get Global Settings, set them if they do not exist
	//=========================================================================			
		
	public static function wptb_get_GlobalSettings() {   

		$wptbGlobalOptions = get_option( "wptb_global_options" );
		
		if (! $wptbGlobalOptions) {
			$wptbRotateTopbars = "no";
			$wptbRotateDisplayTime = 9000;
			$wptbRotateStartDelay = 1000;
			$wptbRotateOrder = "priority";
			$wptbRotateCount = 0;
			$wptbRotateHideLastTopBar = "yes";
			
			// setup GlobalOptions for the first time
			$wptbGlobalOptions = array(
			  'rotate_topbars'			=> $wptbRotateTopbars,
			  'rotate_display_time' 	=> $wptbRotateDisplayTime,
			  'rotate_start_delay' 		=> $wptbRotateStartDelay,
			  'rotate_order'			=> $wptbRotateOrder,
			  'rotate_count'	 		=> $wptbRotateCount,
			  'rotate_hide_last'		=> $wptbRotateHideLastTopBar			);

			update_option( "wptb_global_options", $wptbGlobalOptions );
		}	
				
		// force these to default values if they don't exist - since this is called from the frontside, we don't want to break any pageviews
		$wptbUpdateGlobalOptions = false;
		
		if ( ! isset($wptbGlobalOptions [ 'rotate_topbars' ]) ) {
			$wptbGlobalOptions [ 'rotate_topbars' ] = "no";
			$wptbUpdateGlobalOptions = true;
		}
		if ( ! isset($wptbGlobalOptions [ 'rotate_display_time' ]) ) { 
			$wptbGlobalOptions [ 'rotate_display_time' ] = 9000;
			$wptbUpdateGlobalOptions = true;
		}
		if ( ! isset($wptbGlobalOptions [ 'rotate_start_delay' ]) ) {
			$wptbGlobalOptions [ 'rotate_start_delay' ] = 1000;
			$wptbUpdateGlobalOptions = true;
		}
		if ( ! isset($wptbGlobalOptions [ 'rotate_order' ]) ) {
			$wptbGlobalOptions [ 'rotate_order' ] = "priority";
			$wptbUpdateGlobalOptions = true;
		}
		if ( ! isset($wptbGlobalOptions [ 'rotate_count' ]) ) {
			$wptbGlobalOptions [ 'rotate_count' ] = 0;
			$wptbUpdateGlobalOptions = true;
		}
		if ( ! isset($wptbGlobalOptions [ 'rotate_hide_last' ]) ) {
			$wptbGlobalOptions [ 'rotate_hide_last' ] = "yes";
			$wptbUpdateGlobalOptions = true;
		}

		if ($wptbUpdateGlobalOptions)
			update_option( "wptb_global_options", $wptbGlobalOptions );
	
		return $wptbGlobalOptions;

	} // End of function wptb_get_GlobalSettings 	


	//=========================================================================		
	//Adds the TopBar HTML and Javascript to the output
	//=========================================================================		
		
	public static function wptb_activate_TopBar_html_js() {

		// check for options using the old method, if used - honor it.  otherwise get a TopBar from the database	
		$wptbOptions = get_option('wptbAdminOptions');

		if ( isset( $wptbOptions['enable_topbar'] ) ) { // force database upgrade if still using options 
			echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: still using options table (version '.$wptbOptions['wptb_version'].') Forcing Conversion -->';
			require_once( dirname(__FILE__).'/lib/wp-topbar-db-io.php');  //database and I-O functions php
			wptb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
		}
		wptb::wptb_build_cacheable_html_js();
	}  // end function wptb_activate_TopBar_html_js


	//=========================================================================		
	// Inject specific TopBar HTML; Also used on the admin (debug) pages
	//=========================================================================		

	public static function wptb_inject_TopBar_html_js($wptbOptions, $wptbTopBarNumber) {

		if ( wptb::wptb_check_options_to_show_row($wptbOptions) == false ) { return false; }

		$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();
		$wptbRotateTopbars = $wptbGlobalOptions [ 'rotate_topbars' ];
			
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
				
		echo '<div id="topbar'.$wptbOptions['bar_id'].'" style="'.trim($wptbOptions['div_css']).'" '.stripslashes($wptbOptions['div_custom_html']).' >';
		
		if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('display:none;',$wptbOptions, true, $wptbTopBarNumber, true);
		else {
			if ($wptbRotateTopbars == "yes" )
				$wptbDisplay='display:none;';
			else
				$wptbDisplay='visibility:hidden;';
		
			wptb::wptb_display_TopBar($wptbDisplay,$wptbOptions, true, $wptbTopBarNumber, false);
		}
		echo '</div>';
				
		if ( $wptbOptions['topbar_pos'] == 'header' ) {
				echo "');} );
";
				echo '</script>';
		}
		return true;

	}  // end function wptb_inject_TopBar_html_js	


	
	
	//=========================================================================		
	// checks all the options, returns TRUE if TopBar should show, FALSE if not
	//=========================================================================		
	
	public static function wptb_check_options_to_show_row($wptbOptions) {
	
		if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') 
				$thePostID = "";
		else {
				global $wp_query;
				$thePostID = $wp_query->post->ID;
		}
		
		if (   is_home() && ( $wptbOptions['show_homepage'] == "never" ) ) { return false; }			
		if ( ! is_home() && ( $wptbOptions['show_homepage'] == "only"  ) ) { return false; }		
	

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

		$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;
		
		if  ( ( $wptbOptions['allow_close'] == 'yes' ) && 
			  ( $wptbOptions['respect_cookie'] == 'always' ) && 
			  ( isset ($_COOKIE[$wptb_cookie])) &&
			  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']) ) {
			echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: '. $wptbOptions['wptb_version'].' :: Valid Cookie ['.$wptb_cookie.'] Present ('.$_COOKIE[$wptb_cookie].')- not showing TopBar #: '.$wptbOptions['bar_id'].'-->
';
			return false;  
		}
		
		// if we have the mobile_check field set, then check to see if the user is coming from a mobile device then process it appropriately
		if (isset( $wptbOptions['mobile_check'] )) {
	
			switch ( $wptbOptions['mobile_check'] ) {
				
			case 'only_mobile':
	
				if ( ! ( wp_is_mobile() )) {return false;}		
				break;
				
			case 'not_mobile':
			
				if (  wp_is_mobile() ) {return false;}		
				break;
				
			case 'all_devices':
					
				break;				
			}
		
		}
				
		return true;

	}	// End of wptb_check_options_to_show_row
	
	
	
	//=========================================================================		
	// Code to display the TopBar.
	// 
	// Parm $wptbaddslashes:
	//	True = then call addslashes to the string  
	//=========================================================================		
	
	public static function wptb_display_TopBar($wptb_visibility, $wptbOptions, $wptbaddslashes, $wptbTopBarNumber, $wptbReopen) {


		if ( $wptbaddslashes ) {

			$wtpbtextfields = array( '1' => 'custom_css_bar',  '2' => 'bar_text',  '3' => 'custom_css_text', '4' => 'bar_link_text', '5' => 'close_button_css', '6' => 'reopen_button_css' , '7' => 'div_css' );
		
		  	foreach( $wtpbtextfields as $number => $field ) {
		  			$wptbOptions[$field] = addslashes($wptbOptions[$field]);
		    }			
		
			for ($i=1; $i<=10; $i++)  {
				if ( isset($wptbOptions['social_icon'.$i.'_css']) )	
					$wptbOptions['social_icon'.$i.'_css'] = addslashes($wptbOptions['social_icon'.$i.'_css']);
			}
		}
		
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
			$wptbOptions['bar_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_text']);
			$wptbOptions['bar_link_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link_text']);
			$wptbOptions['bar_link'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link']);
		}
		
		if (! isset($wptbOptions['margin_right'] )) $wptbOptions['margin_right'] = 0;
		if (! isset($wptbOptions['margin_left'] )) $wptbOptions['margin_left'] = 0;
		
		
// Setup DIV Container

		echo '<div id="wptbheadline'.$wptbTopBarNumber.'" class="wptbbar'.$wptbTopBarNumber.'" style="'.$wptb_visibility;
		if ($wptbOptions['enable_image'] == 'false') 
			echo "background: {$wptbOptions['bar_color']};";
		else 
		 	echo "background-color: {$wptbOptions['bar_color']};background-image: url({$wptbOptions['bar_image']}); background-position:center;"; 
		echo 'margin:  '.$wptbOptions['margin_top'],'px '.$wptbOptions['margin_right'].'px '.$wptbOptions['margin_bottom'].'px '.$wptbOptions['margin_left'].'px ;';
		echo 'text-align:',$wptbOptions['text_align'],';','font-size: ',$wptbOptions['font_size'],'px; ';	
		echo 'padding-top:',$wptbOptions['padding_top'],'px;','padding-bottom:',$wptbOptions['padding_bottom'],'px;'; 	
		echo 'color:',$wptbOptions['text_color'],'; display:block;';
		echo 'border-bottom-color:',$wptbOptions['bottom_color'],';','border-bottom-style: solid;';
		echo 'border-bottom-width: ',$wptbOptions['bottom_border_height'],'px;';
		if ($wptbOptions['custom_css_bar'] != '') 
				echo trim($wptbOptions['custom_css_bar'])." ";
		echo '" '.stripslashes($wptbOptions['bar_custom_html']).' >';

// Before Custom PHP

		if ($wptbOptions['php_text_prefix'] != "" ) {
			eval( stripslashes($wptbOptions['php_text_prefix'] ) );
		}			

// Left Social Buttons
		for ($i=1; $i<=10; $i++)  {
			if ( ($wptbOptions['social_icon'.$i.''] == 'on') && ($wptbOptions['social_icon'.$i.'_image'] !== '') && ($wptbOptions['social_icon'.$i.'_position'] == 'left') )
				echo '<a href="'.$wptbOptions['social_icon'.$i.'_link'].'" target="_'.$wptbOptions['social_icon'.$i.'_link_target'].'"><img  src="'.$wptbOptions['social_icon'.$i.'_image'].'" style="'.trim($wptbOptions['social_icon'.$i.'_css']).'"/></a>';
		}

// bar & link		
		echo $wptbOptions['bar_text'],'<a style="color:',$wptbOptions['link_color'],'; ';
		if ($wptbOptions['custom_css_text'] != '')
			echo trim($wptbOptions['custom_css_text']);
		echo '" '.stripslashes($wptbOptions['bar_link_custom_html']).' ';
		echo 'href="',$wptbOptions['bar_link'],'" target="_',$wptbOptions['link_target'],'">';
		echo $wptbOptions['bar_link_text'].'</a>'; 

// Right Social Buttons		
		for ($i=1; $i<=10; $i++)  {
			if ( ($wptbOptions['social_icon'.$i.''] == 'on') && ($wptbOptions['social_icon'.$i.'_image'] !== '') && ($wptbOptions['social_icon'.$i.'_position'] !== 'left') )
				echo '<a href="'.$wptbOptions['social_icon'.$i.'_link'].'" target="_'.$wptbOptions['social_icon'.$i.'_link_target'].'"><img  src="'.$wptbOptions['social_icon'.$i.'_image'].'" style="'.trim($wptbOptions['social_icon'.$i.'_css']).'"/></a>';
		}
			
// Close Button			
		if ($wptbReopen) 
			echo '<span style=""><img align="middle" border="0" onClick="wptbbar_hide'.$wptbTopBarNumber.'()" src="'.$wptbOptions['close_button_image'].'" style="'.$wptbOptions['close_button_css'].'"/></span>';
		else 
			if ($wptbOptions['allow_close'] == 'yes') {
				echo '<span style=""><img align="middle" border="0" onClick="close_wptopbar'.$wptbTopBarNumber.'()" src="'.$wptbOptions['close_button_image'].'" style="'.$wptbOptions['close_button_css'].'"/></span>';
		}
		
// After Custom PHP		
		if ($wptbOptions['php_text_suffix'] != "" ) {
			eval( stripslashes($wptbOptions['php_text_suffix'] ) );
		}		
		
// Close DIV Container
		echo '</div>';
		
// Reopen Button 		
		if ($wptbReopen)  {
		echo '<div id="wptb-open-close-bar-stub'.$wptbTopBarNumber.'" class="wptbbar-stub'.$wptbTopBarNumber.'" style="'.$wptbOptions['reopen_button_css'].'"><a class="show-notify" onclick="wptbbar_show'.$wptbTopBarNumber.'();"><img class="wptbbar-down-arrow" align="middle" border="0" src="'.$wptbOptions['reopen_button_image'].'" /></div>';
		}
	}  // end function wptb_display_TopBar
	
	
	//=========================================================================		
	//Destroy Cookie
	//=========================================================================		
	
	public static function wptb_destory_cookie_js($bar_id) {	
		
		$wptb_cookie = "wptopbar_".$bar_id.'_'.COOKIEHASH;
		return 'document.cookie="'.$wptb_cookie.'"'."+'=;expires=Thu, 01-Jan-70 00:00:01 GMT;';".'';
					
		
	}  // end function wptb_destory_cookie_js
	
	
	//=========================================================================		
	//Build Cookie
	//=========================================================================		
	
	public static function wptb_build_cookie_js($wptbOptions, $wptbTopBarNumber) {	
		
		if  ($wptbOptions['respect_cookie'] == 'always') { 
			$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;
			$html_out = '
';
			$html_out .= '		var expDate = new Date('.(date('Y') + 1).', 12, 31 );
';
			$html_out .= '		document.cookie="'.$wptb_cookie.'"+"="+escape('.$wptbOptions['cookie_value'].')+";expires="+expDate.toUTCString();';
		}

		return $html_out;
		
	}  // end function wptb_build_cookie_js
				
	//=========================================================================		
	//Build Original TopBar
	//=========================================================================		
	
	public static function wptb_build_original_topbar_js($wptbOptions, $wptbTopBarNumber) {	
		
		$html_out = "		".$wptbTopBarNumber.": function() {jQuery(".'"#wptbheadline'.$wptbTopBarNumber.'").hide().delay('.$wptbOptions['delay_time'].').css("visibility","visible").slideDown('.$wptbOptions['slide_time'].').fadeIn(1000).show("slow");';
		if (($wptbOptions['display_time']+0) != 0) {
			$html_out .= "
           jQuery('#wptbheadline".$wptbTopBarNumber."').delay(".$wptbOptions['display_time'].').slideUp('.$wptbOptions['slide_time'].').fadeOut(1000).hide();';
		}

		$html_out .= "}";
		
		return $html_out;
		
	}  // end function wptb_build_original_topbar_js
				
	//=========================================================================		
	//Build Scrollable TopBar
	//=========================================================================		
	
	public static function wptb_build_scrollable_topbar_js($wptbOptions, $wptbTopBarNumber) {	
	
		if (!isset($wptbOptions[ 'scroll_amount' ]) || !is_numeric($wptbOptions[ 'scroll_amount' ]))
			$wptbOptions[ 'scroll_amount' ] = 0;
		
		$html_out = "		".$wptbTopBarNumber.": function() {jQuery(window).scroll(function(){
				if(jQuery(window).scrollTop()> ".$wptbOptions['scroll_amount'].") {
					jQuery('#wptbheadline".$wptbTopBarNumber."').css('visibility','visible').slideDown('".$wptbOptions['slide_time']."').fadeIn(1000).show('slow');	
				} else {
					jQuery('#wptbheadline".$wptbTopBarNumber."').fadeOut('slow');
				}
		});}"; 		

		return $html_out;
		
	}  // end function wptb_build_scrollable_topbar_js

	//=========================================================================		
	//Builds the javascript to close/Reopen the TopBar
	//=========================================================================		

// NOTE - marginTop ? does that need to change as the size of the image changes? dynamically change this?

	public static function wptb_build_reopenable_js($wptbOptions, $wptbTopBarNumber) {

	return  "
var wptbshow_open_button".$wptbTopBarNumber." = false;
						 
function wptbbar_show".$wptbTopBarNumber."() { 
    if(wptbshow_open_button".$wptbTopBarNumber.") {
      jQuery('.wptbbar-stub".$wptbTopBarNumber."').slideUp('fast', function() {
        jQuery('.wptbbar".$wptbTopBarNumber."').toggle();
      }); 
    }
    else {
      jQuery('.wptbbar".$wptbTopBarNumber."').delay(".$wptbOptions['delay_time'].").css('visibility','visible').slideDown(".$wptbOptions['slide_time'].").fadeIn(1000).show('slow');
    }
}

function wptbbar_hide".$wptbTopBarNumber."() { 
    jQuery('.wptbbar".$wptbTopBarNumber."').slideUp('fast', function() {
      jQuery('.wptbbar-stub".$wptbTopBarNumber."').slideDown(".$wptbOptions['slide_time'].").fadeIn(1000).show('slow');

      wptbshow_open_button".$wptbTopBarNumber." = true;
    }); 

    if( jQuery(window).width() > 1024 ) {
      jQuery('body').animate({'marginTop': '0px'}, 250); // if width greater than 1024 pull up the body
    }
}
";

	}  // end function wptb_build_reopenable_js

	//=========================================================================		
	//Builds the javascript to close/Reopen the TopBar (part 2)
	//=========================================================================		
	
	public static function wptb_build_reopenable__topbar_js ($wptbOptions, $wptbTopBarNumber) {	
		
		if (isset($wptbOptions['reopen_position']) && ($wptbOptions['reopen_position']) == "closed")
			$html_out = "		".$wptbTopBarNumber.": function() {window.setTimeout(function() { wptbbar_hide".$wptbTopBarNumber."();}, 0)}";
		else
			$html_out = "		".$wptbTopBarNumber.": function() {window.setTimeout(function() { wptbbar_show".$wptbTopBarNumber."();}, 0)}";
		
		return $html_out;
		
	}  // end function wptb_build_reopenable__topbar_js


	//=========================================================================		
	//Builds the javascript to Randomly Select a TopBar
	//=========================================================================		
	
	public static function wptb_random_selection_js ($wptbNumberSelected,$wptbTotalWeightingPoints) {	
	
		if ( $wptbNumberSelected == 1) 
			return '
	wptb_selected_row = 1;';
		else 
			return '
	random_priority = 0;
	random_priority = Math.floor(Math.random()*'.$wptbTotalWeightingPoints.'); 
	total_points = 0;
	wptb_selected_row = 0;
	
	for ( var i = 0; i < wptbPoints.length; i = i + 1 ) {
		total_points = total_points + wptbPoints[i]; 
	
		if (random_priority <= total_points) {
				wptb_selected_row = (i + 1);
				i = wptbPoints.length + 1;
		} 
	} 				 
';
	

	}  // end function wptb_random_selection_js


	//=========================================================================		
	//Builds the cacheable topbars; using one loop building all parts at once
	//=========================================================================		
	public static function wptb_build_cacheable_html_js() {
	
		global $WPTB_VERSION;

		$wptbGlobalOptions = wptb::wptb_get_GlobalSettings();		
		$wptbRotateTopbars 			= $wptbGlobalOptions [ 'rotate_topbars' ];
		$wptbRotateDisplayTime 		= $wptbGlobalOptions [ 'rotate_display_time' ];
		$wptbRotateStartDelay 		= $wptbGlobalOptions [ 'rotate_start_delay' ];
		$wptbRotateOrder 			= $wptbGlobalOptions [ 'rotate_order' ];
		$wptbRotateCount 			= $wptbGlobalOptions [ 'rotate_count' ];
		$wptbRotateHideLastTopBar 	= $wptbGlobalOptions [ 'rotate_hide_last' ];
		
		$wptb_debug=get_transient( 'wptb_debug' );	
	
		if($wptb_debug)
			echo '<br><code>WP-TopBar Debug Mode: wptb_build_cacheable_html_js() - Getting TopBars in Random Order</code>';
	
		global $wpdb;
		$wptb_table_name = $wpdb->prefix . "wp_topbar_data";	
	
		$sql="SELECT * FROM ".$wptb_table_name." 
				WHERE  `enable_topbar` =  'true'
					AND COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0), 
												COALESCE(STR_TO_DATE( `start_time_utc`,  '%m/%d/%Y %H:%i'     ), 0)),0) <= 0 
					AND	COALESCE(TIMESTAMPDIFF( MINUTE, 	COALESCE(STR_TO_DATE(  `end_time_utc` ,  '%m/%d/%Y %H:%i'       ), 0), 					
												COALESCE(STR_TO_DATE(  '".current_time('mysql', 1)."',  '%Y-%m-%d %H:%i' ), 0)),0) <=0
		";
		if ( $wptbRotateOrder = "random" )
			$sql.="		ORDER BY RAND()
				";		
		else
			$sql.="		ORDER BY `weighting_points` DESC
				";		

		$all_rows = $wpdb->get_results( $sql, ARRAY_A );
		
		echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: DB: '.get_option( "wptb_db_version" ).' :: Number of TopBars Selected: '.$wpdb->num_rows.' :: Rotate TopBars: '.$wptbRotateTopbars.' -->
';
		$wptbTopBarNumber=0;
		$html_part_1_out = "
jQuery(document).ready(function() {
";

		if ( $wptbRotateTopbars == "no" )
			$html_part_2_out = "	
	var wptbPoints = [];
";
		else
			$html_part_2_out = "";
			
		$html_part_3_out = "
	var wptbSelectRow = {
";
		$html_cookie_out = "
";
		$html_part_4_out = "
";
		$cookie_destroyed = false;
		
		if ( $wpdb->num_rows != 0 ) {

			$wptbTopBarNumber = 0;
			$wptbTotalWeightingPoints = 0;
			foreach ($all_rows as $one_row) {
			    foreach ($one_row as $key => $option){
					$wptbOptions[$key] = $option;
				}

				if ( $wptbRotateTopbars == "yes" ) {				// force these to off/no if Rotate is turned on
					$wptbOptions['scroll_action'] = "off";
					$wptbOptions['allow_reopen'] = "no";
					$wptbOptions['allow_close'] = "no";
				}
				
				$row_selected =  ( wptb::wptb_inject_TopBar_html_js($wptbOptions, $wptbTopBarNumber + 1) );
											
				if ( $row_selected ) {			
					if ( $wptbRotateTopbars == "no" ) {
					
						if  ( !( $cookie_destroyed ) && $wptbOptions['respect_cookie'] == 'ignore')  {
							$cookie_destroyed = true;
							$html_cookie_out .= wptb::wptb_destory_cookie_js($wptbOptions['bar_id']);
						}
							
						if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
							$html_part_4_out .= wptb::wptb_build_reopenable_js($wptbOptions, $wptbTopBarNumber+1);
						else if ($wptbOptions['allow_close'] == 'yes')	{
							$html_part_4_out .= 'function close_wptopbar'.($wptbTopBarNumber+1).'() { jQuery("#wptbheadline'.($wptbTopBarNumber+1).'").toggle();';
							if ( $wptbOptions['respect_cookie'] == 'always' ) 
								$html_part_4_out .= wptb::wptb_build_cookie_js($wptbOptions, ($wptbTopBarNumber+1));
							$html_part_4_out .= "}";
						}

						if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
							$html_part_3_out .= wptb::wptb_build_reopenable__topbar_js($wptbOptions, ($wptbTopBarNumber+1));			
						else if ( $wptbOptions['scroll_action'] != "on" ) 
							$html_part_3_out .= wptb::wptb_build_original_topbar_js($wptbOptions, ($wptbTopBarNumber+1));
						else  
							$html_part_3_out .= wptb::wptb_build_scrollable_topbar_js($wptbOptions, ($wptbTopBarNumber+1));

						
						if (($wptbTopBarNumber+1) < $wpdb->num_rows)
							$html_part_3_out .= ",
";
						$html_part_2_out .= '
	wptbPoints[ '.$wptbTopBarNumber.' ] = '.$wptbOptions['weighting_points'].';';

					}
	
					$html_part_1_out .= '
	jQuery("#wptbheadline'.($wptbTopBarNumber + 1).'").hide();';		

					$wptbTopBarNumber = $wptbTopBarNumber + 1; 
					$wptbTotalWeightingPoints = $wptbTotalWeightingPoints + intval( $wptbOptions['weighting_points'] );
								
				}
			}
			$html_part_3_out .= "
	};

";
			if ( $wptbRotateTopbars == "yes" ) {

				if ( $wptbRotateCount > 0 ) {
				$html_part_3_out = "
				
	// execute all TopBars sequentially for a count of ".$wptbRotateCount." - Hide Last: ".$wptbRotateHideLastTopBar."
	
	var j = 1;
	var k = 0;
	
	wptbSequence(j,k);
	
	function wptbSequence(j,k) {
		j = j + 1;
		if (j > ".$wptbTopBarNumber.") {
			j = 1;
		}
		k = k + 1;
";
		if ( $wptbRotateHideLastTopBar == "yes" ) 
			$html_part_3_out .= "		if (k <= ".$wptbRotateCount.") {
			jQuery('#wptbheadline' + j).delay(".$wptbRotateStartDelay.").slideDown(200).delay(".$wptbRotateDisplayTime.").slideUp(200);
			setTimeout(function(){wptbSequence(j,k)},".(400+$wptbRotateDisplayTime+$wptbRotateStartDelay).");
		}
";
		else {
			$html_part_3_out .= "		if (k < ".$wptbRotateCount.") {
			jQuery('#wptbheadline' + j).delay(".$wptbRotateStartDelay.").slideDown(200).delay(".$wptbRotateDisplayTime.").slideUp(200);
			setTimeout(function(){wptbSequence(j,k)},".(400+$wptbRotateDisplayTime+$wptbRotateStartDelay).");
		}	
		else {
			jQuery('#wptbheadline' + j).delay(".$wptbRotateStartDelay.").slideDown(200);
		}";	
		
		}

	$html_part_3_out .= "	
	}
";			
				}
				else { 
				$html_part_3_out = "
				
	// execute all TopBars sequentially (rotating forever) - Hide Last: ".$wptbRotateHideLastTopBar."
	
	var j = 1;
	
	wptbSequence(j);
	
	function wptbSequence(j,k) {
		jQuery('#wptbheadline' + j).delay(".$wptbRotateStartDelay.").slideDown(200).delay(".$wptbRotateDisplayTime.").slideUp(200);
		j = j + 1;
		if (j > ".$wptbTopBarNumber.") {
			j = 1;
		}
		setTimeout(function(){wptbSequence(j,k)},".(400+$wptbRotateDisplayTime+$wptbRotateStartDelay).");
	}";
					
				}
			}
			else {
				$html_part_2_out .= wptb::wptb_random_selection_js ($wptbTopBarNumber, $wptbTotalWeightingPoints);

				$html_part_3_out .= "
	// execute the one specified in the 'wptb_selected_row' variable:

	wptbSelectRow[wptb_selected_row]();
";
			}
			
			$html_part_3_out .= "
}
);
";

			$html_part_4_out .= "
";
			$html_cookie_out .= "
";
			if ( $wptbTopBarNumber > 0) {
			
				echo "<script type='text/javascript'>
";
				echo $html_cookie_out;
				echo $html_part_1_out;			
				echo $html_part_2_out;			
				echo $html_part_3_out;
				echo $html_part_4_out;
				
				echo '</script>';
			}
		}
		else {
			echo '<!-- WP-TopBar_'.$wptbOptions['wptb_version'].' :: not using options nor database -->
';
		}
				
		return;
		
	}	// End of wptb_build_cacheable_html_js

}

$wptb = new wptb();
$wptb->init();

endif;
?>