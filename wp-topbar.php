<?php
/*

Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Create MULTIPLE TopBars that will be shown at the top of your website.  TopBars are selected by a variety of options - includes scheduler, custom PHP, custom CSS and more!
Version: 5.01
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



$WPTB_VERSION = "5.01";


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
			add_action( 'wp_footer', array( __CLASS__, 'wptb_activate_TopBar_html_js' ), 9999999);
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
		
	function wptb_activate_plugin() {   
	
	//		require_once( dirname(__FILE__).'/lib/wp-topbar-db-io.php');  //database and I-O functions php
	//		wptb::wptb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
		
	
	} // End of function wptb_activate_plugin 	
	

	//=========================================================================		
	//Adds the TopBar HTML and Javascript to the output
	//=========================================================================		
		
	function wptb_activate_TopBar_html_js() {

		// check for options using the old method, if used - honor it.  otherwise get a TopBar from the database	
		$wptbOptions = get_option('wptbAdminOptions');

		if ( isset( $wptbOptions['enable_topbar'] ) ) { // force database upgrade if still using options 
			echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: still using options table (version '.$wptbOptions['wptb_version'].') Forcing Conversion -->';
			require_once( dirname(__FILE__).'/lib/wp-topbar-db-io.php');  //database and I-O functions php
			wptb_check_for_plugin_upgrade(false);	// do not echo out parameters if debugging
		}
		wptb::wptb_build_cacheable_html_js(true);
	}  // end function wptb_activate_TopBar_html_js


	//=========================================================================		
	// Inject specific TopBar HTML; Also used on the admin (debug) pages
	//=========================================================================		

	function wptb_inject_TopBar_html_js($wptbOptions, $wptbTopBarNumber) {

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
				
		echo '<div id="topbar'.$wptbOptions['bar_id'].'" style="'.trim($wptbOptions['div_css']).'">';
		
		if (isset($wptbOptions['allow_reopen']) && ($wptbOptions['allow_reopen']) == "yes")
			wptb::wptb_display_TopBar('display:none;',$wptbOptions, true, $wptbTopBarNumber, true);
		else 
			wptb::wptb_display_TopBar('visibility:hidden;',$wptbOptions, true, $wptbTopBarNumber, false);

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

		$wptb_cookie = "wptopbar_".$wptbOptions['bar_id'].'_'.COOKIEHASH;
		
		if  ( ( $wptbOptions['allow_close'] == 'yes' ) && 
			  ( $wptbOptions['respect_cookie'] == 'always' ) && 
			  ( isset ($_COOKIE[$wptb_cookie])) &&
			  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value']) ) {
			echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: '. $wptbOptions['wptb_version'].' :: Valid Cookie ['.$wptb_cookie.'] Present ('.$_COOKIE[$wptb_cookie].')- not showing TopBar #: '.$wptbOptions['bar_id'].'-->
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
	
	function wptb_display_TopBar($wptb_visibility, $wptbOptions, $wptbaddslashes, $wptbTopBarNumber, $wptbReopen) {
	
		if ( $wptbaddslashes ) {
	  		if ( isset($wptbOptions['custom_css_bar']) )	 
	  			$wptbOptions['custom_css_bar'] = addslashes($wptbOptions['custom_css_bar']);
	  		if ( isset($wptbOptions['bar_text']) )	 
	  			$wptbOptions['bar_text'] = addslashes($wptbOptions['bar_text']);
	  		if ( isset($wptbOptions['custom_css_text']) )	 
	  			$wptbOptions['custom_css_text'] = addslashes($wptbOptions['custom_css_text']);
	  		if ( isset($wptbOptions['bar_link_text']) )	 
	  			$wptbOptions['bar_link_text'] = addslashes($wptbOptions['bar_link_text']);
	  		if ( isset($wptbOptions['close_button_css']) )	 
	  			$wptbOptions['close_button_css'] = addslashes($wptbOptions['close_button_css']);
	  		if ( isset($wptbOptions['reopen_button_css']) )	 
	  			$wptbOptions['reopen_button_css'] = addslashes($wptbOptions['reopen_button_css']);
	  		if ( isset($wptbOptions['div_css']) )	 
	  			$wptbOptions['div_css'] = addslashes($wptbOptions['div_css']);
			
		
			for ($i=1; $i<=10; $i++)  {
				if ( isset($wptbOptions[$field]) )	
					$wptbOptions['social_icon'.$i.'_css'] = addslashes($wptbOptions['social_icon'.$i.'_css']);
			}
		}
		
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
			$wptbOptions['bar_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_text']);
			$wptbOptions['bar_link_text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link_text']);
			$wptbOptions['bar_link'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($wptbOptions['bar_link']);
		}
		
// Setup DIV Container

		echo '<div id="wptbheadline'.$wptbTopBarNumber.'" class="wptbbar'.$wptbTopBarNumber.'" style="'.$wptb_visibility;
		if ($wptbOptions['enable_image'] == 'false') 
			echo "background: {$wptbOptions['bar_color']};";
		else 
		 	echo "background-color: {$wptbOptions['bar_color']};background-image: url({$wptbOptions['bar_image']}); background-position:center;"; 
		echo 'margin:  ',$wptbOptions['margin_top'],'px 0px ',$wptbOptions['margin_bottom'],'px;';
		echo 'text-align:',$wptbOptions['text_align'],';','font-size: ',$wptbOptions['font_size'],'px; ';	
		echo 'padding-top:',$wptbOptions['padding_top'],'px;','padding-bottom:',$wptbOptions['padding_bottom'],'px;'; 	
		echo 'color:',$wptbOptions['text_color'],'; display:block;';
		echo 'border-bottom-color:',$wptbOptions['bottom_color'],';','border-bottom-style: solid;';
		echo 'border-bottom-width: ',$wptbOptions['bottom_border_height'],'px;';
		if ($wptbOptions['custom_css_bar'] != '') 
				echo trim($wptbOptions['custom_css_bar'])." ";
		echo '">';

// Before Custom PHP

		if ($wptbOptions['php_text_prefix'] != "" ) {
			eval( stripslashes($wptbOptions['php_text_prefix'] ) );
		}			

// Left Social Buttons
		for ($i=1; $i<=10; $i++)  {
			if ( ($wptbOptions['social_icon'.$i.''] == 'on') && ($wptbOptions['social_icon'.$i.'_image'] !== '') && ($wptbOptions['social_icon'.$i.'_position'] == 'left') )
				echo '<a href="'.$wptbOptions['social_icon'.$i.'_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon'.$i.'_image'].'" style="'.trim($wptbOptions['social_icon'.$i.'_css']).'"/></a>';
		}

// bar & link		
		echo $wptbOptions['bar_text'],'<a style="color:',$wptbOptions['link_color'],'; ';
		if ($wptbOptions['custom_css_text'] != '')
			echo "{".trim($wptbOptions['custom_css_text'])."}";
		echo '" ';
		echo 'href="',$wptbOptions['bar_link'],'" target="_',$wptbOptions['link_target'],'">';
		echo $wptbOptions['bar_link_text'],'</a>'; 

// Right Social Buttons		
		for ($i=1; $i<=10; $i++)  {
			if ( ($wptbOptions['social_icon'.$i.''] == 'on') && ($wptbOptions['social_icon'.$i.'_image'] !== '') && ($wptbOptions['social_icon'.$i.'_position'] !== 'left') )
				echo '<a href="'.$wptbOptions['social_icon'.$i.'_link'].'" target="_'.$wptbOptions['link_target'].'"><img  src="'.$wptbOptions['social_icon'.$i.'_image'].'" style="'.trim($wptbOptions['social_icon'.$i.'_css']).'"/></a>';
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
	
	function wptb_destory_cookie_js($bar_id) {	
		
		$wptb_cookie = "wptopbar_".$bar_id.'_'.COOKIEHASH;
		return 'document.cookie="'.$wptb_cookie.'"'."+'=;expires=Thu, 01-Jan-70 00:00:01 GMT;';".'';
					
		
	}  // end function wptb_destory_cookie_js
	
	
	//=========================================================================		
	//Build Cookie
	//=========================================================================		
	
	function wptb_build_cookie_js($wptbOptions, $wptbTopBarNumber) {	
		
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
	
	function wptb_build_original_topbar_js($wptbOptions, $wptbTopBarNumber) {	
		
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
	
	function wptb_build_scrollable_topbar_js($wptbOptions, $wptbTopBarNumber) {	
		
		$html_out = "		".$wptbTopBarNumber.": function() {jQuery(window).scroll(function(){
				if(jQuery(window).scrollTop()> 0 ) {
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

	function wptb_build_reopenable_js($wptbOptions, $wptbTopBarNumber) {

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
	
	function wptb_build_reopenable__topbar_js ($wptbTopBarNumber) {	
		
		$html_out = "		".$wptbTopBarNumber.": function() {window.setTimeout(function() { wptbbar_show".$wptbTopBarNumber."();}, 0)}";

		return $html_out;
		
	}  // end function wptb_build_reopenable__topbar_js


	//=========================================================================		
	//Builds the javascript to Randomly Select a TopBar
	//=========================================================================		
	
	function wptb_random_selection_js ($wptbNumberSelected,$wptbTotalWeightingPoints) {	
	
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
	function wptb_build_cacheable_html_js($wptb_echo_on) {
	
		global $WPTB_VERSION;
	
		if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
		else $wptb_debug = false;			
	
		if($wptb_debug)
			echo '<br><code>WP-TopBar Debug Mode: Getting TopBars in Random Order</code>';
	
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
		
		echo '<!-- WP-TopBar_'.$WPTB_VERSION.' :: DB: '.get_option( "wptb_db_version" ).' :: Number of TopBars Selected: '.$wpdb->num_rows.'-->
';
		$wptbTopBarNumber=0;
		$html_part_1_out = "
jQuery(document).ready(function() {
";
		$html_part_2_out = "	
	var wptbPoints = [];
";
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
//			foreach ($all_rows as $wptbOptions) {
				
				$row_selected =  ( wptb::wptb_inject_TopBar_html_js($wptbOptions, $wptbTopBarNumber + 1) );
											
				if ( $row_selected ) {			
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
						$html_part_3_out .= wptb::wptb_build_reopenable__topbar_js($wptbTopBarNumber+1);			
					else if ( $wptbOptions['scroll_action'] != "on" ) 
						$html_part_3_out .= wptb::wptb_build_original_topbar_js($wptbOptions, ($wptbTopBarNumber+1));
					else  
						$html_part_3_out .= wptb::wptb_build_scrollable_topbar_js($wptbOptions, ($wptbTopBarNumber+1));
						
					if (($wptbTopBarNumber+1) < $wpdb->num_rows)
						$html_part_3_out .= ",
";
	
					$html_part_1_out .= '
	jQuery("#wptbheadline'.($wptbTopBarNumber + 1).'").hide();';		
					$html_part_2_out .= '
	wptbPoints[ '.$wptbTopBarNumber.' ] = '.$wptbOptions['weighting_points'].';';
					$wptbTopBarNumber = $wptbTopBarNumber + 1; 
					$wptbTotalWeightingPoints = $wptbTotalWeightingPoints + intval( $wptbOptions['weighting_points'] );
				}
			}
			$html_part_2_out .= wptb::wptb_random_selection_js ($wptbTopBarNumber, $wptbTotalWeightingPoints);
		
			$html_part_3_out .= "
	};

	// execute the one specified in the 'wptb_selected_row' variable:

	wptbSelectRow[wptb_selected_row]();
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

wptb::init();
endif;
?>