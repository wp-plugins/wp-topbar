<?php 

/*
Plugin Name: WP-TopBar
Admin Page
*/


//=========================================================================		
//Returns an array of admin options, but sets default values if none are loaded.
//
// Parameter $wptb_echo_on is used for debugging:  
//		True=check for debuging flag, 0=don't check for debugging flag
//=========================================================================		

function wptb_get_Plugin_Options($wptb_echo_on) {

	$wptb_version_number = '3.06';
	
	if ( $wptb_echo_on ) $wptb_debug=get_transient( 'wptb_debug' );	
	else $wptb_debug = false;			
				
	$wptbSetOptions = array(
		'wptb_version' => $wptb_version_number,
		'enable_topbar' => 'false',
		'topbar_pos' => 'header',
		'text_color' => '#000000',
		'bar_color' => '#ffffff',
		'bottom_color' => '#f90000',
		'link_color' => '#c00000',
		'bottom_border_height' => '3', 
		'include_pages' => '0',
		'invert_include' => 'no',
		'delay_time' => '5000',
		'slide_time' => '200',
		'display_time' => '0',
		'start_time' => '0',
		'end_time' => '0',
		'start_time_utc' => '0',
		'end_time_utc' => '0',
		'font_size' => '14',
		'padding_top' => '8',
		'padding_bottom' => '8',
		'margin_top' => '0',
		'margin_bottom' => '0',
		'respect_cookie' => 'ignore',
		'cookie_value' => '1',
		'past_cookie_values' => array('1'),
		'allow_close' => 'no',
		'close_button_image' => str_ireplace( 'https://','http://',plugins_url('/images/close.png', __FILE__) ),
		'close_button_css' => 'vertical-align:text-bottom;float:right;',
		'link_target' => 'blank',
		'bar_link' => 'http://wordpress.org/extend/plugins/wp-topbar/',
		'bar_text' => 'Get your own TopBar ',
		'bar_link_text' => 'from the Wordpress plugin repository',
		'text_align' => 'center',
		'bar_image' => '',
		'enable_image' => 'false',
		'custom_css_bar' => '',
		'social_icon1' => 'off',
		'social_icon2' => 'off', 
		'social_icon3' => 'off',
		'social_icon4' => 'off',
		'social_icon1_image' => str_ireplace( 'https://','http://',plugins_url('/icons/png/twitter.png', __FILE__) ),
		'social_icon2_image' => str_ireplace( 'https://','http://',plugins_url('/icons/png/facebook.png', __FILE__) ),
		'social_icon3_image' => str_ireplace( 'https://','http://',plugins_url('/icons/png/google.png', __FILE__) ),
		'social_icon4_image' => '',
		'social_icon1_link' => 'http://twitter.com/#!/wordpress',
		'social_icon2_link' => 'http://www.facebook.com/WordPress', 
		'social_icon3_link' => 'http://plus.google.com/s/wordpress',
		'social_icon4_link' => '',
		'social_icon1_css' => 'height:23px; vertical-align:text-bottom;',
		'social_icon2_css' => 'height:23px; vertical-align:text-bottom;',
		'social_icon3_css' => 'height:23px; vertical-align:text-bottom;',
		'social_icon4_css' => '',
		'social_icon1_link_target' => 'blank',
		'social_icon2_link_target' => 'blank',
		'social_icon3_link_target' => 'blank',
		'social_icon4_link_target' => 'blank',
		'div_css' => 'position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;');

	$wptbOptions = get_option('wptbAdminOptions');

	if (!empty($wptbOptions)) {
		foreach ($wptbOptions as $key => $option)
			$wptbSetOptions[$key] = $option;
		wptb::wtpb_check_for_plugin_upgrade($wptb_echo_on);	// call this in case the user did not use WP to upgrade/install plugin	
	}
	else 
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: <strong>No</strong> "wptbAdminOptions" in WP Options table, taking defaults</code>';

	if($wptb_debug){
		$wptb_current_time=current_time('timestamp', 1);

		echo '<br><code>WP-TopBar Debug Mode: Server Timezone:',date_default_timezone_get(),'</code>';
		echo '<br><code>WP-TopBar Debug Mode: Current Time&nbsp:',$wptb_current_time,'-',date('Y-m-d H:i:s (e)',$wptb_current_time),'</code>';				
		echo '<br><code>WP-TopBar Debug Mode: Starting Time:',$wptbSetOptions['start_time_utc'],'-',$wptbSetOptions['start_time'],'-',date('Y-m-d H:i:s (e)',$wptbSetOptions['start_time_utc']),'</code>';
		echo '<br><code>WP-TopBar Debug Mode: Ending Time&nbsp&nbsp:',$wptbSetOptions['end_time_utc'],'-',$wptbSetOptions['end_time'],'-',date('Y-m-d H:i:s (e)',$wptbSetOptions['end_time_utc']),'</code>';
		
		if ($wptbSetOptions['start_time_utc'] == 0) 
			echo '<br><code>WP-TopBar Debug Mode: Start Time is zero</code>';
		else
			if (($wptb_current_time - $wptbSetOptions['start_time_utc']) >= 0)
				echo '<br><code>WP-TopBar Debug Mode: Start Time is before or equal Current Time</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: Start Time is in the future</code>';

		if ($wptbSetOptions['end_time_utc'] == 0) 
			echo '<br><code>WP-TopBar Debug Mode: End Time is zero</code>';
		else {
			if ($wptbSetOptions['start_time_utc'] > $wptbSetOptions['end_time_utc']) 
				echo '<br><code>WP-TopBar Debug Mode: End Time is before Start Time - Error - TopBar will <strong>NOT</strong> display</code>';
			if (($wptbSetOptions['end_time_utc'] - $wptb_current_time) >= 0)
				echo '<br><code>WP-TopBar Debug Mode: End Time is after or equal to Current Time</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: End Time is in the past</code>';
		}
		if (wptb::wptb_check_time($wptb_current_time, $wptbSetOptions['start_time_utc'],$wptbSetOptions['end_time_utc']))
			if ($wptbSetOptions['enable_topbar'] == 'false') 
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display because it is not enabled, even though the time settings would allow it</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: TopBar will display due to time settings and because it is enabled</code>';
		else
			if ($wptbSetOptions['enable_topbar'] == 'false') 
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings and because it is not enabled</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings even though it is enabled</code>';
		
		$wptb_cookie = "wptopbar_".COOKIEHASH;

		echo "<br><code>WP-TopBar Debug Mode: Cookie Name: ".$wptb_cookie."</code>";
		if (isset($_COOKIE[$wptb_cookie]) && ($wptbOptions['respect_cookie'] = "always"))
			echo "<br><code>WP-TopBar Debug Mode: Cookie Value: ". $_COOKIE[$wptb_cookie]."</code>"; 
		else
			echo "<br><code>WP-TopBar Debug Mode: Cookie not found</code>";
		
		if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) {
			echo "<br><code>WP-TopBar Debug Mode: TopBar will not show</code>";

		}	
		
		// check for iPhone, iPad or iPod -- they can't use flash 
		
		$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		
		if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) 
			if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Not an iPhone/iPad/iPod Device</code>';
		else 
			if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: An iPhone/iPad/iPod Device</code>';

		echo '<br><code>WP-TopBar Debug Mode: Filename:',plugin_dir_path(__FILE__),'</code>';
		echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
		echo '<br><code>WP-TopBar Debug Mode: Using these "wptbAdminOptions" Values:</code>';
		foreach ($wptbSetOptions as $i => $value) {
			  	echo '<br><code>WP-TopBar Debug Mode:&nbsp&nbsp[',$i,']: ',$value,'</code>';
			}
		echo '<br><code>WP-TopBar Debug Mode: --------------------------------------</code>';
	
	}

	return $wptbSetOptions;
}  // end function wptb_get_Plugin_Options


//=========================================================================			
// Options Page
//=========================================================================			


function wptb_options_page() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    
	
	// $wptb_common_style is used by all buttons except the Copy & Special buttons
		
	$wptb_common_style = "padding:7.5px 15px;
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
	
	$wptb_delete_style = 'border-top:1px solid #f59898;
		background:#d46565;
		background:-webkit-gradient(linear, left top, left bottom, from(#732121), to(#d46565));
		background:-webkit-linear-gradient(top, #732121, #d46565);
		background:-moz-linear-gradient(top, #732121, #d46565);
		background:-ms-linear-gradient(top, #732121, #d46565);
		background:-o-linear-gradient(top, #732121, #d46565);
		color:#f2f2f2;'.$wptb_common_style;
	
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

//	first time through, check for updated settings

	wptb_update_settings();	

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: ', date('D, d M Y H:i:s (e)',get_transient( 'wptb_debug' )),'</code>';	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Loading Options</code>';
	
	$wptbOptions = wptb_get_Plugin_Options(false);
	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Completed Updating Options</code>';
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Version ',$wptbOptions['wptb_version'],'</code>';

//  output the top of the page

	wptb_display_common_info();

//  now build the right tab to display

    if ( isset ( $_GET['tab'] ) )
        $tab = $_GET['tab'];
    else
        $tab = 'main';

	wptb_options_tabs($tab);

    switch ( $tab ) :
        case 'main' :
            wptb_main_options();
            break;
        case 'topbarcss' :
            wptb_topbarcss_options();
            break;
        case 'colorselection' :
            wptb_colorselection_options();
            break;
        case 'topbartext' :
            wptb_topbartext_options();
            break;
        case 'closebutton' :
            wptb_closebutton_options();
            break;
        case 'delete' :
            wptb_delete_options();
            break;
        case 'faq' :
            wptb_faq_page();
            break;
        case 'socialbuttons' :
            wptb_socialbutton_options();
            break;
        case 'debug' :
            wptb_debug_options();
            break;
        endswitch;

}  // end function wptb_options_page

//=========================================================================			
// Build the tabs on top of the Admin page 
//=========================================================================			


function wptb_options_tabs( $current = 'main' ) {
    $tabs = array( 'main' => 'Main&nbspOptions',  'topbartext' => 'TopBar&nbspText&nbsp&&nbspImage',  'topbarcss' => 'TopBar&nbspCSS', 'colorselection' => 'Color&nbspSelection','closebutton' => 'Close&nbspButton', 'socialbuttons' => 'Social&nbspButtons','debug' => 'Debug', 'delete' => 'Delete&nbspSettings', 'faq' => 'FAQ' );
    $links = array();
    foreach( $tabs as $tab => $name ) {
    	if ( $tab == "faq" ) {
    		$css="ui-widget-content"; 
    		$font="18px;";
    	}
    	else {
    		$css="ui-state-default"; 
    		$font="20px;"; 
    	}
        if ( $tab == $current ) 
            $links[] = "<a class='".$css." ui-corner-top ui-tabs-selected ui-state-active ui-state-hover' style='text-decoration:none; padding: 0 10px 0 10px;' href='?page=wp-topbar.php&tab=$tab'>$name</a>";
        else 
            $links[] = "<a class='".$css." ui-corner-top' style='font-size:".$font." font-weight:normal; padding: 0 10px 0 10px; text-decoration:none' href='?page=wp-topbar.php&tab=$tab'>$name</a>";
        
    }
    echo '<h2>';
	foreach ($links as $i => $value) {
        echo $value;
		if ( $i == "3") echo "<br>";
	}
        
// add plugin home page link       
    echo "<a class='ui-widget-content ui-corner-top' style='font-size:18px; font-weight:normal; padding: 0 10px 0 10px; text-decoration:none'  href='http://wordpress.org/extend/plugins/wp-topbar/' target='_blank'>Plugin Homepage</a>";
    echo '</h2>';

}  // end function wptb_options_tabs


//=========================================================================			
// Update Settings 
//=========================================================================			

function wptb_update_settings() {	

	$wptb_debug=get_transient( 'wptb_debug' );	
	$wptbOptions = wptb_get_Plugin_Options(true);
							
	if (isset($_POST['update_wptbSettings'])) { 
		if (isset($_POST['wptbenabletopbar'])) {
			$wptbOptions['enable_topbar'] = $_POST['wptbenabletopbar'];
		}
		if (isset($_POST['wptbtextcolor'])) {
			$wptbOptions['text_color'] = $_POST['wptbtextcolor'];
		}	
		if (isset($_POST['wptbbarcolor'])) {
			$wptbOptions['bar_color'] = $_POST['wptbbarcolor'];
		}
		if (isset($_POST['wptbbottomcolor'])) {
			$wptbOptions['bottom_color'] = $_POST['wptbbottomcolor'];
		}	
		if (isset($_POST['wptblinkcolor'])) {
			$wptbOptions['link_color'] = $_POST['wptblinkcolor'];
		}
		if (isset($_POST['wptbincludepages'])) {
			$wptbOptions['include_pages'] = $_POST['wptbincludepages'];
		}
		if (isset($_POST['wptbinvertinclude'])) {
			$wptbOptions['invert_include'] = $_POST['wptbinvertinclude'];
		}
		if (isset($_POST['wptbbottomborderheight'])) {
		
			if (!is_numeric($_POST['wptbbottomborderheight'])) {
				echo '<div class="error"><strong>Bottom border height is not numeric. Resetting to 3px.</strong></div>';
					$wptbOptions['bottom_border_height'] = 3;
			} 
			else 	
				$wptbOptions['bottom_border_height'] = $_POST['wptbbottomborderheight']+0;
		}
		if (isset($_POST['wptbdelayintime'])) {
		
			if (!is_numeric($_POST['wptbdelayintime'])) {
				echo '<div class="error"><strong>Delay time is not numeric. Resetting to zero.</strong></div>';
					$wptbOptions['delay_time'] = 0;
			} 
			else 	
				$wptbOptions['delay_time'] = $_POST['wptbdelayintime']+0;
		}
		if (isset($_POST['wptbslidetime'])) {
		
			if (!is_numeric($_POST['wptbslidetime'])) {
				echo '<div class="error"><strong>Slide time is not numeric. Resetting to zero.</strong></div>';
				$wptbOptions['slide_time'] = 0;
			} 
			else 	
				$wptbOptions['slide_time'] = $_POST['wptbslidetime']+0;
		}
		if (isset($_POST['wptbdisplaytime'])) {
		
			if (!is_numeric($_POST['wptbdisplaytime'])) {
				echo '<div class="error"><strong>Display time is not numeric. Resetting to zero.</strong></div>';
				$wptbOptions['display_time'] = 0;
			} 
			else 	
				$wptbOptions['display_time'] = $_POST['wptbdisplaytime']+0;
		}			
		if (isset($_POST['wptbstarttime'])) {
					
				$wptbOptions['start_time'] = $_POST['wptbstarttime'];
				$wptbOptions['start_time_utc'] = $_POST['wptbstarttime'];
		}
		if (isset($_POST['wptbendtime'])) {

			$wptbOptions['end_time'] = $_POST['wptbendtime'];
			$wptbOptions['end_time_utc'] = $_POST['wptbendtime'];
		}
		if (isset($_POST['wptbfontsize'])) {
		
			if (!is_numeric($_POST['wptbfontsize'])) {
				echo '<div class="error"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
				$wptbOptions['font_size'] = 8;
			} 
			else 	
				$wptbOptions['font_size'] = $_POST['wptbfontsize']+0;
		}						
		if (isset($_POST['wptbpaddingtop'])) {
		
			if (!is_numeric($_POST['wptbpaddingtop'])) {
				echo '<div class="error"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
				$wptbOptions['padding_top'] = 8;
			} 
			else 	
				$wptbOptions['padding_top'] = $_POST['wptbpaddingtop']+0;
		}
		if (isset($_POST['wptbpaddingbottom'])) {
		
			if (!is_numeric($_POST['wptbpaddingbottom'])) {
				echo '<div class="error"><strong>Bottom padding is not numeric. Resetting to 8px.</strong></div>';
				$wptbOptions['padding_bottom'] = 8;
			} 
			else 	
				$wptbOptions['padding_bottom'] = $_POST['wptbpaddingbottom']+0;
		}						
		if (isset($_POST['wptbmargintop'])) {
		
			if (!is_numeric($_POST['wptbmargintop'])) {
				echo '<div class="error"><strong>Top margin is not numeric. Resetting to 0px.</strong></div>';
				$wptbOptions['margin_top'] = 0;
			} 
			else 	
				$wptbOptions['margin_top'] = $_POST['wptbmargintop']+0;
		}
		if (isset($_POST['wptbmarginbottom'])) {
		
			if (!is_numeric($_POST['wptbmarginbottom'])) {
				echo '<div class="error"><strong>Bottom margin is not numeric. Resetting to 0px.</strong></div>';
				$wptbOptions['margin_bottom'] = 0;
			} 
			else 	
				$wptbOptions['margin_bottom'] = $_POST['wptbmarginbottom']+0;
		}						
		if (isset($_POST['wptblinkurl'])) {
			$wptbOptions['bar_link'] = esc_url($_POST['wptblinkurl']);
		}			
		if (isset($_POST['wptbbartext'])) {
			$wptbOptions['bar_text'] = $_POST['wptbbartext'];
		}
		if (isset($_POST['wptblinktext'])) {
			$wptbOptions['bar_link_text'] = $_POST['wptblinktext'];
		}
		if (isset($_POST['wptbtextalign'])) {
			$wptbOptions['text_align'] = $_POST['wptbtextalign'];
		}
		if (isset($_POST['wptbbarimage'])) {
			$wptbOptions['bar_image'] = $_POST['wptbbarimage'];
		}
		if (isset($_POST['wptbenableimage'])) {
			$wptbOptions['enable_image'] = $_POST['wptbenableimage'];
		}
		if (isset($_POST['wptbcustomcssbar'])) {
			$wptbOptions['custom_css_bar']  = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbcustomcssbar'])));
		}
		if (isset($_POST['wptbcustomcsstext'])) {
			$wptbOptions['custom_css_text'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbcustomcsstext'])));
		}
		if (isset($_POST['wptbdivcss'])) {
			$wptbOptions['div_css'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbdivcss'])));
		}
		if (isset($_POST['wptballowclose'])) {
			$wptbOptions['allow_close'] = $_POST['wptballowclose'];
		}
		if (isset($_POST['wptbrespectcookie'])) {
			$wptbOptions['respect_cookie'] = $_POST['wptbrespectcookie'];
		}
		if (isset($_POST['wptbcookievalue'])) {
		
			$wptbOldCookieValue = $wptbOptions['cookie_value'];
			
			$wptbOptions['cookie_value'] = $_POST['wptbcookievalue'];
			
			$wptbNewCookieValue = $wptbOptions['cookie_value'];

			if (! ($wptbNewCookieValue == $wptbOldCookieValue ) ) {

				$wptbPastValues = $wptbOptions['past_cookie_values'];

				if ( !( is_array( $wptbPastValues ) ) )
					$wptbPastValues = array('');
				else
					if ( count( $wptbPastValues ) >= 10 )
						array_shift( $wptbPastValues );
				
				$wptbPastValues[]=$wptbNewCookieValue;	
				
				$wptbOptions['past_cookie_values']=	$wptbPastValues;	
			}
		}
		if (isset($_POST['wptbcloseimage'])) {
			$wptbOptions['close_button_image'] = esc_url($_POST['wptbcloseimage']);
		}	
		if (isset($_POST['wptbclosecss'])) {
			$wptbOptions['close_button_css']  = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbclosecss'])));
		}
		if (isset($_POST['wptblinktarget'])) {
			$wptbOptions['link_target'] = $_POST['wptblinktarget'];
		}
		if (isset($_POST['wptbtopbarpos'])) {
			$wptbOptions['topbar_pos'] = $_POST['wptbtopbarpos'];
		}
		
		// need to check the make sure we are the right tab to correctly handle the toggle buttons
		
		if ( $_GET['tab'] == 'socialbuttons') {
			if (isset($_POST['wptbsocialicon1'])) 
				$wptbOptions['social_icon1'] = 'on';
			else
				$wptbOptions['social_icon1'] = 'off';

			if (isset($_POST['wptbsocialicon2'])) 
				$wptbOptions['social_icon2'] = 'on';
			else
				$wptbOptions['social_icon2'] = 'off';

			if (isset($_POST['wptbsocialicon3'])) 
				$wptbOptions['social_icon3'] = 'on';
			else
				$wptbOptions['social_icon3'] = 'off';

			if (isset($_POST['wptbsocialicon4'])) 
				$wptbOptions['social_icon4'] = 'on';
			else
				$wptbOptions['social_icon4'] = 'off';
		}
			
		if (isset($_POST['wptbsocialicon1image'])) {
			$wptbOptions['social_icon1_image'] = $_POST['wptbsocialicon1image'];
		}
		if (isset($_POST['wptbsocialicon2image'])) {
			$wptbOptions['social_icon2_image'] = $_POST['wptbsocialicon2image'];
		}
		if (isset($_POST['wptbsocialicon3image'])) {
			$wptbOptions['social_icon3_image'] = $_POST['wptbsocialicon3image'];
		}
		if (isset($_POST['wptbsocialicon4image'])) {
			$wptbOptions['social_icon4_image'] = $_POST['wptbsocialicon4image'];
		}
		if (isset($_POST['wptbsocialicon1link'])) {
			$wptbOptions['social_icon1_link'] = $_POST['wptbsocialicon1link'];
		}
		if (isset($_POST['wptbsocialicon2link'])) {
			$wptbOptions['social_icon2_link'] = $_POST['wptbsocialicon2link'];
		}
		if (isset($_POST['wptbsocialicon3link'])) {
			$wptbOptions['social_icon3_link'] = $_POST['wptbsocialicon3link'];
		}
		if (isset($_POST['wptbsocialicon4link'])) {
			$wptbOptions['social_icon4_link'] = $_POST['wptbsocialicon4link'];
		}
		if (isset($_POST['wptbsocialicon1css'])) {
			$wptbOptions['social_icon1_css'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbsocialicon1css'])));
		}			
		if (isset($_POST['wptbsocialicon2css'])) {
			$wptbOptions['social_icon2_css'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbsocialicon2css'])));
		}			
		if (isset($_POST['wptbsocialicon3css'])) {
			$wptbOptions['social_icon3_css'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbsocialicon3css'])));
		}			
		if (isset($_POST['wptbsocialicon4css'])) {
			$wptbOptions['social_icon4_css'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbsocialicon4css'])));
		}			
		if (isset($_POST['wptbicon1linktarget'])) {
			$wptbOptions['social_icon1_link_target'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbicon1linktarget'])));
		}			
		if (isset($_POST['wptbicon2linktarget'])) {
			$wptbOptions['social_icon2_link_target'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbicon2linktarget'])));
		}			
		if (isset($_POST['wptbicon3linktarget'])) {
			$wptbOptions['social_icon3_link_target'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbicon3linktarget'])));
		}			
		if (isset($_POST['wptbicon4linktarget'])) {
			$wptbOptions['social_icon4_link_target'] = trim(str_replace('"',"'",stripslashes_deep($_POST['wptbicon4linktarget'])));
		}			
		
		

		

		update_option('wptbAdminOptions', $wptbOptions);
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Settings Updated</code>';
		echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
		$wptbOptions = wptb_get_Plugin_Options(false);
	}  // end of update_wptbSettings condition
	
	if (isset($_POST['delete_wptbSettings'])) { 
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Delete Settings</code>';
		delete_option('wptbAdminOptions');
		$wptbOptions = wptb_get_Plugin_Options(false);
		echo '<div class="updated"><p><strong>Settings Deleted.</strong></p></div>';
	} // end of delete_wptbSettings condition
	
}	// End of wptb_update_settings



//=========================================================================			
// Display Top Of Admin Page
//=========================================================================			


function wptb_display_common_info() {
		
	$wptb_debug=get_transient( 'wptb_debug' );	
	$wptbOptions = wptb_get_Plugin_Options(false);
		
	if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc'] && $wptbOptions['end_time_utc'] != 0 ) {
		echo '<div class="error"><strong>End Time is before Start Time - TopBar will not display.</strong></div>';
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: End Time Before Start Time Error</code>';
	}

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Displaying Options Page</code>';
		   
	$wptb_cookie = "wptopbar_".COOKIEHASH;
	if  ( ($wptbOptions['respect_cookie'] == 'always' ) AND  ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] ) ) 
		 _e( "<div class='error'><strong>You have a cookie with this browser that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the Close Button tab.</strong></div>", 'wptb' ); 
	?>  

	<a name="Top"></a>
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		WP-TopBar - Version 3.06</h2>
		<div class="postbox">
		<br>
		Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.
		<br><br>
		Please <a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:20px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
if you find this plugin useful.

		<hr>

		</div>
				<div class="postbox">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="error"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>
		<h3>Live Preview<em><p style="font-weight:normal;">Time check: Based on your Start/End time settings in the Main Options,<?php if ($wptbOptions['enable_topbar'] == "false") { _e( ' when enabled,', 'wptb' ); } ?> the TopBar will <?php if (!wptb::wptb_check_time(gettimeofday(true),$wptbOptions['start_time_utc'],$wptbOptions['end_time_utc'])) echo "<strong>not</strong>"; ?> display (based on the current time.)
		<br><?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo "<br>Cookie check: The plugin is not checking for the presence of cookies.";
				  else
						if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] )  
							echo "<br>Cookie check: The plugin is  checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the Close Button tab."; 
						else 
							echo "<br>Cookie check: The plugin is  checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.";?>
		</p>
		</em></h3>

		<div class="inside">
			<p class="sub">This is how the TopBar will appear on the website.
			<br>To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
			<br> The first black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>
			<div class="table">
				<table class="form-table">
					<tr valign="top">
							<div>
							<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />
							<?php wptb::wptb_display_TopBar("",$wptbOptions); ?>
							<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />
							</div> 
		 				</td>
					</tr>
				</table>
			</div>
			<div class="clear"></div>	
			</div>
		</div>
		<?php
}	// End of wptb_display_common_info
	

//=========================================================================			
// Main Options
//=========================================================================			

		
function wptb_main_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
	$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);

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
	<h3><a name="MainOptions">Main Options</a></h3>
	<div class="inside">
		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td width="150">Enable TopBar:</label></td>
					<td>
						<label for="wptb_enable_topbar"><input type="radio" id="wptb_enable_topbar" name="wptbenabletopbar" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenabletopbar_no"><input type="radio" id="wptbenabletopbar_no" name="wptbenabletopbar" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>				
					</td>
					<td>
						<p class="sub"><em>This allows you to turn off the TopBar without disabling the plugin.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">TopBar Location:</label></td>
					<td>
					<label for="wptb_topbar_pos_header"><input type="radio" id="wptb_topbar_pos_header" name="wptbtopbarpos" value="header" <?php if ($wptbOptions['topbar_pos'] == "header") { _e('checked="checked"', "wptb"); }?>/> Above Header</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_topbar_pos_footer"><input type="radio" id="wptb_topbar_pos_footer" name="wptbtopbarpos" value="footer" <?php if ($wptbOptions['topbar_pos'] == "footer") { _e('checked="checked"', "wptb"); }?> /> Below Footer</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
							<p class="sub"><em>Select where you want to TopBar to be located. Default is <code>Above Header</code></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">Start Delay:</label></td>
					<td>
						<input type="text" name="wptbdelayintime" id="delayintime" size="30" value="<?php echo $wptbOptions['delay_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to delay before appearing.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Slide Time:</label></td>
					<td>
						<input type="text" name="wptbslidetime" id="slidetime" size="30" value="<?php echo $wptbOptions['slide_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page.  Enter 0 for no delay.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Display Time:</label></td>
					<td>
						<input type="text" name="wptbdisplaytime" id="displaytime" size="30" value="<?php echo $wptbOptions['display_time']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to remain on the page.  Enter 0 for the TopBar to not disappear.</em></p>
					</td>
				</tr>							
				<tr valign="top">
					<td width="150">Starting Time:</label></td>
					<td>
						<div class="wptb-date-picker-container"> <input type="text" id="wptbstarttimebtn" name="wptbstarttime" size="30" value="<?php echo $wptbOptions['start_time']; ?>"></label></div><p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbstarttimebtnClear">Set Start Time to Zero</p>									  
						<div id="wptb_start_time"></div>				    
					</td>
					<td>
							<p class="sub"><em>Pick the date/time for the TopBar to start showing.  Default is <code>zero</code>.</em></p>
					</td>
				</tr>							
				<tr valign="top">
					<td width="150">Ending Time:</label></td>
					<td>
						<input type="text" id="wptbendtimebtn" name="wptbendtime" size="30" value="<?php echo $wptbOptions['end_time']; ?>"></label>	<p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbtimebtnClear">&nbspSet End Time to Zero</p>							  
						<div id="wptb_end_time"></div>				    
					</td>
					<td>
							<p class="sub"><em>Pick the date/time for the TopBar to stop showing.  Of course, it must be after the start time. Select 0 for the TopBar to never disappear.</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Bottom border height (px):</label></td>
					<td>
						<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the height of the bottom of the border.  Default is <code>3px</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Top padding (px):</label></td>
					<td>
						<input type="text" name="wptbpaddingtop" id="paddingtop" size="5" value="<?php echo $wptbOptions['padding_top']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the top padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom padding (px):</label></td>
					<td>
						<input type="text" name="wptbpaddingbottom" id="paddingbottom" size="5" value="<?php echo $wptbOptions['padding_bottom']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the bottom padding.  Default is <code>8px</code></em></p>
					</td>
				</tr>		
				<tr valign="top">
					<td width="150">Top margin (px):</label></td>
					<td>
						<input type="text" name="wptbmargintop" id="margintop" size="5" value="<?php echo $wptbOptions['margin_top']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the top margin.  Default is <code>0px</code></em></p>
					</td>
				</tr>			
				<tr valign="top">
					<td width="150">Bottom margin (px):</label></td>
					<td>
						<input type="text" name="wptbmarginbottom" id="marginbottom" size="5" value="<?php echo $wptbOptions['margin_bottom']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the bottom margin.  Default is <code>0px</code></em></p>
					</td>
				</tr>				
				<tr valign="top">
					<td width="150">Font size (px):</label></td>
					<td>
						<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
					</td>
					<td>
							<p class="sub"><em>Enter the font size.  Default is <code>14px</code></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">Text alignment:</label></td>
					<td>
					<label for="wptb_text_align_left"><input type="radio" id="wptb_text_align_left" name="wptbtextalign" value="left" <?php if ($wptbOptions['text_align'] == "left") { _e('checked="checked"', "wptb"); }?>/> Left</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_text_align"><input type="radio" id="wptb_text_align" name="wptbtextalign" value="center" <?php if ($wptbOptions['text_align'] == "center") { _e('checked="checked"', "wptb"); }?> /> Center</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_text_align_right"><input type="radio" id="wptb_text_align_right" name="wptbtextalign" value="right" <?php if ($wptbOptions['text_align'] == "right") { _e('checked="checked"', "wptb"); }?>/> Right</label>	
					</td>
					<td>
							<p class="sub"><em>Select how you want the text to align. Default is <code>center</code> When using right -- try adding padding via the TopBar CSS tab. e.g. </em><code>padding-right:10px;</code></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">Include Page IDs:</label></td>
					<td>
						<input type="text" name="wptbincludepages" id="includepages" size="30" value="<?php echo $wptbOptions['include_pages']; ?>" >
					</td>
					<td>
						<p class="sub"><em>Enter the IDs of the pages and posts that you want the TopBar to appear on, separated by commas. The TopBar will only be shown on those pages. Leave blank or enter 0 to show the TopBar on all pages.  e.g. 1,9,39,10</em></p>
					</td>
				</tr>
				<tr valign="top">
					<td></td>
					<td>Exclude these pages instead?</label><p>
						<label for="wptb_invert_include_yes"><input type="radio" id="wptb_invert_include_yes" name="wptbinvertinclude" value="yes" <?php if ($wptbOptions['invert_include'] == "yes") { _e('checked="checked"', "wptb"); }?>/> Yes</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="wptb_invert_include_no"><input type="radio" id="wptb_invert_include_no" name="wptbinvertinclude" value="no" <?php if ($wptbOptions['invert_include'] == "no") { _e('checked="checked"', "wptb"); }?> /> No</label>
						<p>
					<td>
						<p class="sub"><em>Select Yes if you want to exclude the Page IDs enter above.  This will cause the TopBar to <strong>not</strong> be shown on those specific Page IDs.  Default is <code>No</code></em></p>
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
	
	<?
}	// End of wptb_main_options


//=========================================================================			
// TopBar CSS Options
//=========================================================================			




function wptb_topbarcss_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);

	// following variables are used to store the sample code that can be copied via ZeroClipboard
									
	$div_css_sample_top='position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;';
	$div_css_sample_bot='position:fixed; bottom: 0; padding:0; margin:0; width: 100%; z-index: 99999;';							
	
	$css_sample1='text-transform:lowercase;';
	$css_sample2="text-transform:uppercase;font-family:'georgia';padding-right:10px;";
	$css_sample3="background: rgb(109,179,242);
	background: -moz-linear-gradient(top,  rgba(109,179,242,1) 0%, rgba(84,163,238,1) 50%, rgba(54,144,240,1) 51%, rgba(30,105,222,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(109,179,242,1)), color-stop(50%,rgba(84,163,238,1)), color-stop(51%,rgba(54,144,240,1)), color-stop(100%,rgba(30,105,222,1)));
	background: -webkit-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
	background: -o-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
	background: -ms-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
	background: linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6db3f2', endColorstr='#1e69de',GradientType=0 );";

	?>
	
	<div class="postbox">
	<h3><a name="topbarcss">TopBar CSS</a></h3>
	<div class="inside">
		<em><p class="sub">Enter any custom CSS for the TopBar.  This allows you to add padding, font styles & more.  Be really careful here -- this could break your website!  Test this with multiple browsers to make sure it works across them all. Double-quotes are automatically replaced with single quotes.<p><strong>Don't forget the trailing semi-colon.</strong></p>
		Create a custom CSS gradient at colorzilla.com:
		<a class="button" style="<?php _e( $wptb_cssgradient_style , 'wptb' ); ?>" href="http://www.colorzilla.com/gradient-editor/" target="_blank">http://www.colorzilla.com/gradient-editor/</a>	
		<p class="sub"><br>Examples:<p></p>
		</em>	
		<table>
			<tr>
				<td style="vertical-align:top">1.</td><td style="vertical-align:top"><code><?php _e( $css_sample1 , 'wptb' ); ?></code></td>
			</tr>
			<tr>
				<td style="vertical-align:top">2.</td><td style="vertical-align:top"><code><?php _e( $css_sample2 , 'wptb' ); ?></code></td>
			</tr>
			<tr>
				<td style="vertical-align:top">3.</td><td style="vertical-align:top"><code><?php _e( $css_sample3 , 'wptb' ); ?></code></td>
			</tr>
			</table>	
		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td width="150">For the Bar:</label></td>
					<td>
						<textarea name="wptbcustomcssbar" id="customcssbar" rows="10" cols="100"><?php echo $wptbOptions['custom_css_bar']; ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">For the Text Message:</label></td>
					<td>
						<textarea name="wptbcustomcsstext" id="customcsstext" rows="10" cols="100"><?php echo $wptbOptions['custom_css_text']; ?></textarea>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">For the entire TopBar:<br>(i.e. at the TopBar's DIV)</label></td>
					<td><p>Try this CSS to fix the TopBar to the top of the page:<p>				
					<code><?php _e( $div_css_sample_top , 'wptb' ); ?></code>
					<p>Or this to fix the TopBar to the bottom of the page:<p>
					<code><?php _e( $div_css_sample_bot , 'wptb' ); ?></code>
	
					<p><strong>Note that by putting your TopBar in a Fixed position, you will overlay the content of your website by the TopBar.</strong></p>
					<textarea name="wptbdivcss" id="divcss" rows="2" cols="100"><?php echo $wptbOptions['div_css']; ?></textarea>
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
		</table
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of CSS Settings -->
	
	<?php
}	// End of wptb_topbarcss_options


//=========================================================================			
// Color Selection Options
//=========================================================================			

function wptb_colorselection_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);
	
	?>
	
	<script type='text/javascript'>
	jQuery(document).ready(function() {

	jQuery('#wptb_colorpicker_bar').hide();
	jQuery('#wptb_colorpicker_bar').farbtastic('#barcolor');
	jQuery('#barcolor').click(function(){jQuery('#wptb_colorpicker_bar').slideDown()});
	jQuery('#barcolor').blur(function(){jQuery('#wptb_colorpicker_bar').slideUp()});

	jQuery('#wptb_colorpicker_text').hide();
	jQuery('#wptb_colorpicker_text').farbtastic('#textcolor');
	jQuery('#textcolor').click(function(){jQuery('#wptb_colorpicker_text').slideDown()});
	jQuery('#textcolor').blur(function(){jQuery('#wptb_colorpicker_text').slideUp()});

	jQuery('#wptb_colorpicker_bottom').hide();
	jQuery('#wptb_colorpicker_bottom').farbtastic('#bottomcolor');
	jQuery('#bottomcolor').click(function(){jQuery('#wptb_colorpicker_bottom').slideDown()});
	jQuery('#bottomcolor').blur(function(){jQuery('#wptb_colorpicker_bottom').slideUp()});
	
	jQuery('#wptb_link_color').hide();
	jQuery('#wptb_link_color').farbtastic('#linkcolor');
	jQuery('#linkcolor').click(function(){jQuery('#wptb_link_color').slideDown()});
	jQuery('#linkcolor').blur(function(){jQuery('#wptb_link_color').slideUp()});	
	
	});
 	</script>
	
	
	<div class="postbox">
										
	<h3><a name="ColorSelection">Color Selection</a></h3>
	
	<div class="inside">
		<p class="sub"><em>Click the color box to select the color to use.  Bar color is NOT used if Image is enabled (that is set on the <a href='?page=wp-topbar.php&tab=topbartext'>TopBar Text and Image</a> tab.)</em></p>
		<div class="table">
			<table class="form-table">			
				<tr valign="top">
					<td width="200">Color of the Bar:</label></td>
					<td>
				      <input type="text" id="barcolor" name="wptbbarcolor" value="<?php echo $wptbOptions['bar_color']; ?>">
				      <div id="wptb_colorpicker_bar"></div>		
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the bottom border of the Bar:</label></td>
					<td>
				      <input type="text" id="bottomcolor" name="wptbbottomcolor" value="<?php echo $wptbOptions['bottom_color']; ?>">
				      <div id="wptb_colorpicker_bottom"></div>			
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the Message:</label></td>
					<td>
					    <input type="text" id="textcolor" name="wptbtextcolor" value="<?php echo $wptbOptions['text_color']; ?>">
					    <div id="wptb_colorpicker_text"></div>				    
					</td>
				</tr>
				<tr valign="top">
					<td width="200">Color of the Link:</label></td>
					<td>
					    <input type="text" id="linkcolor" name="wptblinkcolor" value="<?php echo $wptbOptions['link_color']; ?>">
					    <div id="wptb_link_color"></div>
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
		</table>
		<div class="clear"></div>	
		</div>
	</div> <!-- end of ColorSelection Settings -->
	
	<?php

}	// End of wptb_colorselection_options

//=========================================================================			
// TopBar Text Options
//=========================================================================			


function wptb_topbartext_options() {
	
	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);


	?>

	<div class="postbox">
										
	<h3><a name="TopBarText">TopBar Text, Image and Link</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the text, image and links to be used in the TopBar. The image is placed first (if any), then the text (if any) is overlaid on it.  Scale the image to fix your website.  If you enable the image (by selecting "Yes"), then the image will be used and the bar color will be ignored.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
					<td width="150">Message:</label></td>
					<td>
						<input type="text" name="wptbbartext" id="bbartext" size="85" value="<?php echo stripslashes_deep($wptbOptions['bar_text']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Link Text:</label></td>
					<td>
						<input type="text" name="wptblinktext" id="linktext" size="85" value="<?php echo stripslashes_deep($wptbOptions['bar_link_text']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Link:</label></td>
					<td>
						<input type="text" name="wptblinkurl" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['bar_link']); ?>" >
					</td>
				</tr>
				<tr valign="top">
					<td width="50">Link Target:</label></td>
					<td>
					<label for="wptb_link_target_blank"><input type="radio" id="wptb_link_target_blank" name="wptblinktarget" value="blank" <?php if ($wptbOptions['link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_self"><input type="radio" id="wptb_link_target_self" name="wptblinktarget" value="self" <?php if ($wptbOptions['link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_parent"><input type="radio" id="wptb_link_target_parent" name="wptblinktarget" value="parent" <?php if ($wptbOptions['link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_link_target_top"><input type="radio" id="wptb_link_target_top" name="wptblinktarget" value="top" <?php if ($wptbOptions['link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>	
					<p></p>
							<p class="sub"><em>Select how you want the link to open:</p>
							<p><?php _e(" _blank - 	Opens the linked document in a new window or tab (this is default)") ?></p>
							<p><?php _e(" _self	-	Opens the linked document in the same frame as it was clicked") ?></p>
							<p><?php _e(" _parent -	Opens the linked document in the parent frame") ?></p>
							<p><?php _e(" _top	-	Opens the linked document in the full body of the windowtext to align.") ?></em></p>
					</td>
				</tr>	
				<tr valign="top">
					<td width="50">Enable image:</label></td>
					<td width="50">
						<label for="wptb_enable_image"><input type="radio" id="wptb_enable_image" name="wptbenableimage" value="true" <?php if ($wptbOptions['enable_image'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenableimage_no"><input type="radio" id="wptbenableimage_no" name="wptbenableimage" value="false" <?php if ($wptbOptions['enable_image'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Image URL:</th>
					<td><label for="wptbupload_image">
					<input id="wptbupload_image" type="text" size="85" name="wptbbarimage" value="<?php echo $wptbOptions['bar_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_image_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
					<br /><em>Enter an URL or upload an image for the TopBar.</em)
					</label></td>
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
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of TopBarText Settings -->
	
	<?php 	
}	// End of wptb_topbartext_options



//=========================================================================			
// Social Button Options
//=========================================================================			


function wptb_socialbutton_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);


	?>
		
	<div class="postbox">
										
	<h3><a name="SocialButtons">Social Button Settings</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings for settings the Social Buttons.
		<br><br>You have four buttons that you can add to the TopBar.  Each allows you to set the image, link and CSS.  The CSS is applied the the <code>&lt img &gt</code> tag.
		<br>
		<br><em>Link Target Options:
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _blank - 	Opens the linked document in a new window or tab (this is default)
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _self	-	Opens the linked document in the same frame as it was clicked
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _parent -	Opens the linked document in the parent frame
		<br>&nbsp;&nbsp;&nbsp;&nbsp; _top	-	Opens the linked document in the full body of the windowtext to align.</em></p>
		<br>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
					<th scope="row">Social Icons:</th>
				</tr>
				<tr>
				<td valign="top"> 
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 1:<br>	
					<?php if ( ! ($wptbOptions['social_icon1_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon1_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon1"><input type="checkbox" id="wptb_social_icon1" name="wptbsocialicon1" value="on" <?php if ($wptbOptions['social_icon1'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 1 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon1" type="text" size="85" name="wptbsocialicon1image" value="<?php echo $wptbOptions['social_icon1_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon2_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 1 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon1link" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['social_icon1_link']); ?>" >
				<br>Social Icon 1 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon1_link_target_blank"><input type="radio" id="wptb_icon1_link_target_blank" name="wptbicon1linktarget" value="blank" <?php if ($wptbOptions['social_icon1_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon1_link_target_self"><input type="radio" id="wptb_icon1_link_target_self" name="wptbicon1linktarget" value="self" <?php if ($wptbOptions['social_icon1_link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon1_link_target_parent"><input type="radio" id="wptb_icon1_link_target_parent" name="wptbicon1linktarget" value="parent" <?php if ($wptbOptions['social_icon1_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon1_link_target_top"><input type="radio" id="wptb_icon1_link_target_top" name="wptbicon1linktarget" value="top" <?php if ($wptbOptions['social_icon1_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>	
				<br>Social Icon 1 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon1css" id="wptb_socialicon1_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon1_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon1_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon1_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 2:<br>	
					<?php if ( ! ($wptbOptions['social_icon2_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon2_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon2"><input type="checkbox" id="wptb_social_icon2" name="wptbsocialicon2" value="on" <?php if ($wptbOptions['social_icon2'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 2 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon2" type="text" size="85" name="wptbsocialicon2image" value="<?php echo $wptbOptions['social_icon2_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon2_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 2 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon2link" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['social_icon2_link']); ?>" >
				<br>Social Icon 2 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon2_link_target_blank"><input type="radio" id="wptb_icon2_link_target_blank" name="wptbicon2linktarget" value="blank" <?php if ($wptbOptions['social_icon2_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon2_link_target_self"><input type="radio" id="wptb_icon2_link_target_self" name="wptbicon2linktarget" value="self" <?php if ($wptbOptions['social_icon2_link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon2_link_target_parent"><input type="radio" id="wptb_icon2_link_target_parent" name="wptbicon2linktarget" value="parent" <?php if ($wptbOptions['social_icon2_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon2_link_target_top"><input type="radio" id="wptb_icon2_link_target_top" name="wptbicon2linktarget" value="top" <?php if ($wptbOptions['social_icon2_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>
				<br>Social Icon 2 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon2css" id="wptb_socialicon2_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon2_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon2_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon2_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 3:<br>	
					<?php if ( ! ($wptbOptions['social_icon3_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon3_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon3"><input type="checkbox" id="wptb_social_icon3" name="wptbsocialicon3" value="on" <?php if ($wptbOptions['social_icon3'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 3 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon3" type="text" size="85" name="wptbsocialicon3image" value="<?php echo $wptbOptions['social_icon3_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon3_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 3 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon3link" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['social_icon3_link']); ?>" >
				<br>Social Icon 3 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon3_link_target_blank"><input type="radio" id="wptb_icon3_link_target_blank" name="wptbicon3linktarget" value="blank" <?php if ($wptbOptions['social_icon3_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon3_link_target_self"><input type="radio" id="wptb_icon3_link_target_self" name="wptbicon3linktarget" value="self" <?php if ($wptbOptions['social_icon3_link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon3_link_target_parent"><input type="radio" id="wptb_icon3_link_target_parent" name="wptbicon3linktarget" value="parent" <?php if ($wptbOptions['social_icon3_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon3_link_target_top"><input type="radio" id="wptb_icon3_link_target_top" name="wptbicon3linktarget" value="top" <?php if ($wptbOptions['social_icon3_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>									
				<br>Social Icon 3 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon3css" id="wptb_socialicon3_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon3_css']; ?></textarea>
				<br>
					<?php if ( ! ($wptbOptions['social_icon3_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon3_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
					</td>
				</tr>
				<tr>
				<td valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;Social Icon 4:<br>	
					<?php if ( ! ($wptbOptions['social_icon4_image'] == "") )  _e('<img style="float:right; margin: 0 0 15px 15px;" src="'.$wptbOptions['social_icon4_image'].'"/>', 'wptb' ); ?>
				</td>
				<td valign="top" style="border-top-style:solid !important; border-width:1px !important; border-top-color:black !important;">
					<label for="wptb_social_icon4"><input type="checkbox" id="wptb_social_icon4" name="wptbsocialicon4" value="on" <?php if ($wptbOptions['social_icon4'] == "on") { _e('checked="checked"', "wptb"); }?>/> Enable</label>	
				<br>Social Icon 4 URL:&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="wptbupload_social_icon4" type="text" size="85" name="wptbsocialicon4image" value="<?php echo $wptbOptions['social_icon4_image']; ?>" />
					<input class="browse_upload button" id="wptbupload_social_icon4_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
				<br>Social Icon 4 Link:&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="wptbsocialicon4link" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['social_icon4_link']); ?>" >
				<br>Social Icon 4 CSS:&nbsp;&nbsp;&nbsp;&nbsp;
					<textarea name="wptbsocialicon4css" id="wptb_socialicon4_css" rows="2" cols="100"><?php echo $wptbOptions['social_icon4_css']; ?></textarea>
				<br>Social Icon 4 Link Target:&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon4_link_target_blank"><input type="radio" id="wptb_icon4_link_target_blank" name="wptbicon4linktarget" value="blank" <?php if ($wptbOptions['social_icon4_link_target'] == "blank") { _e('checked="checked"', "wptb"); }?>/> _blank</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon4_link_target_self"><input type="radio" id="wptb_icon4_link_target_self" name="wptbicon4linktarget" value="self" <?php if ($wptbOptions['social_icon4_link_target'] == "self") { _e('checked="checked"', "wptb"); }?> /> _self</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon4_link_target_parent"><input type="radio" id="wptb_icon4_link_target_parent" name="wptbicon4linktarget" value="parent" <?php if ($wptbOptions['social_icon4_link_target'] == "parent") { _e('checked="checked"', "wptb"); }?>/> _parent</label>	
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_icon4_link_target_top"><input type="radio" id="wptb_icon4_link_target_top" name="wptbicon4linktarget" value="top" <?php if ($wptbOptions['social_icon4_link_target'] == "top") { _e('checked="checked"', "wptb"); }?>/> _top</label>					
				<br>
					<?php if ( ! ($wptbOptions['social_icon4_image'] == "") ) {
						list($width, $height, $type, $attr) = getimagesize($wptbOptions['social_icon4_image']);
						echo "Image size: ".$width." px (w) x ".$height." px (h).";
					}
					?>
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
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Social Button Settings -->
	
	<?php 	
}	// End of wptb_socialbutton_options


//=========================================================================			
// Close Button Options
//=========================================================================			


function wptb_closebutton_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);


	?>
		
	<div class="postbox">
										
	<h3><a name="CloseButton">Close Button</a></h3>
										
	<div class="inside">
		<p class="sub"><em>These are the settings to allow the user to close the TopBar.
		<br><br>This plugin can use a cookie to remember if the user closed the TopBar.   If you enable cookies, then a cookie is created if the user closes the TopBar.  If the value stored in the cookie matches the Cookie Value (below), then the TopBar will not be shown on subsequent page views.  If you disable the use of cookies, then the plugin will delete the users cookies the next time the page is loaded.</em></p>
		
		<div class="table">
			<table class="form-table">	
				<tr valign="top">
						<td width="150">Allow TopBar to be closed by user:</label></td>
						<td>
						<label for="wptb_allow_close_yes"><input type="radio" id="allow_close_yes" name="wptballowclose" value="yes" <?php if ($wptbOptions['allow_close'] == "yes") { _e('checked="checked"', "wptb"); }?>/> Yes</label>		
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="wptb_allow_close_no"><input type="radio" id="allow_close_no" name="wptballowclose" value="no" <?php if ($wptbOptions['allow_close'] == "no") { _e('checked="checked"', "wptb"); }?> /> No</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
								<p class="sub"><em>Allows the user to close the TopBar.  Default is <code>No</code></em></p>
						</td>
				</tr>					
				<tr valign="top">
					<td width="150">Enable Cookies:</label></td>
					<td>
					<label for="wptb_respect_cookie_use"><input type="radio" id="respect_cookie_use" name="wptbrespectcookie" value="always" <?php if ($wptbOptions['respect_cookie'] == "always") { _e('checked="checked"', "wptb"); }?> /> Yes</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="wptb_respect_cookie_ignore"><input type="radio" id="respect_cookie_ignore" name="wptbrespectcookie" value="ignore" <?php if ($wptbOptions['respect_cookie'] == "ignore") { _e('checked="checked"', "wptb"); }?>/> No</label>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
							<p class="sub"><em>Enable use of cookies to control TopBar behavior.  Default is <code>No</code></em></p>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">Cookie Value:</label></td>
					<td>
						<input type="text" name="wptbcookievalue" id="cookievalue" size="10" value="<?php echo stripslashes_deep($wptbOptions['cookie_value']); ?>" >
					<?php	  $wptbPastValues = $wptbOptions['past_cookie_values'];
						if ( count ( $wptbPastValues ) > 0 ) {
							echo "<p>Your past ".count ( $wptbPastValues )." previous cookie value(s) are:";
							foreach ($wptbPastValues as $i => $value) {
			  					echo '<br>[',$i+1,']: <code>',$value.'</code>';
							}
					    }
					?>
					</td>
					<td>
							<p class="sub"><em>Change this value to force the cookie to reshow.  See <a href='?page=wp-topbar.php&tab=faq'>FAQ</a>.  Default is <code>1</code></em></p>
					</td>
				</tr>				
				<tr valign="top">
					<td width="150">Enter the CSS for the Close Button:</label></td>
					<td>
					<textarea name="wptbclosecss" id="clsoecss" rows="2" cols="100"><?php echo $wptbOptions['close_button_css']; ?></textarea>
					</td>
					<td>
						<p class="sub"><em>Default is <code>vertical-align:text-bottom;float:right;</code></em></p>
					</td>
				</tr>	
		
				<tr valign="top">
					<th scope="row">Close Button Image URL:</th>
					<td><label for="wptbupload_closebutton">
					<input id="wptbupload_closebutton" type="text" size="85" name="wptbcloseimage" value="<?php echo $wptbOptions['close_button_image']; ?>" />
					<input class="browse_upload button" name="wptbcloseimage" id="wptbupload_closebutton_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
					
					</td><td><p class="sub"><em>Enter a URL or upload an image for the close button on the TopBar.</em></p>
					</label></td>
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
		</table>
		
		<div class="clear"></div>	
		</div>
	</div> <!-- end of Close Button Settings -->
	
	<?php 
}	// End of wptb_closebutton_options



//=========================================================================			
// Delete Options
//=========================================================================			

function wptb_delete_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	?>
					
	<div class="postbox">
	<h3><a name="Uninstall">Delete Settings</a></h3>
	<div class="inside">
		<p class="sub"><em>Click here to delete the plugin settings from the Wordpress database.  The next step is to uninstall the plugin from the Plugin menu.</em></p>
		
		<table>
		<tr>
			<td style="valign:top; width:500px;"><p class="submit">
				<input type="submit" class="button" style="<?php _e( $wptb_delete_style , 'wptb' ); ?>" name="delete_wptbSettings" value="<?php _e('Delete Settings', 'wptb') ?>" onClick="return confirm('Remove plugin settings from the database?');">
	
			</td>
			<td style="valign:top;">
				<input type="button" class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
			</td>
		</tr>
		</table>
		<div class="clear"></div>	
	</div> 
	</div> <!-- end of Delete Settings -->
   </form>
 </div>	 
 
 <?php
 
}	// End of wptb_delete_options//=========================================================================			
// Delete Options
//=========================================================================			

function wptb_debug_options() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptbOptions = wptb_get_Plugin_Options(false);
	$wptb_cookie = "wptopbar_".COOKIEHASH;

	
	?>
					
	<div class="postbox">
	<h3><a name="Debug">Debug Settings</a></h3>
	<div class="inside">
		<ul>
			<li><strong>Status:</strong>
			<br>
			<?php if ($wptbOptions['enable_topbar'] == "false") { _e( 'The TopBar is not enabled.  Enable it in the <a href="?page=wp-topbar.php&tab=main">Main Options tab</a>.<br>', 'wptb' ); } ?>
Based on your Start/End time settings in the <a href="?page=wp-topbar.php&tab=main">Main Options tab</a>,<?php if ($wptbOptions['enable_topbar'] == "false") { _e( ' when enabled,', 'wptb' ); } ?> the TopBar will <?php if (!wptb::wptb_check_time(gettimeofday(true),$wptbOptions['start_time_utc'],$wptbOptions['end_time_utc'])) echo "<strong>not</strong>"; ?> display (based on the current time.)
		<br><?php if ( $wptbOptions['respect_cookie'] == 'ignore' ) 
					echo "<br>The plugin is not checking for the presence of cookies.  That is not preventing the TopBar from showing.";
				  else
						if ( $_COOKIE[$wptb_cookie] == $wptbOptions['cookie_value'] )  
							echo "<br>The plugin is  checking for the presence of cookies. You have a cookie that will prevent the TopBar from showing.  To show the TopBar, clear your browser's cookies, change the Cookie Value, or disable cookies in the <a href='?page=wp-topbar.php&tab=main'>Close Button tab</a>."; 
						else 
							echo "The plugin is  checking for the presence of cookies. You do not have a cookie that will prevent the TopBar from showing.";?>
		</p>
</li>
<strong>Debug Helpers:</strong>

			<li>You can append <code>&debug</code> after the wp-topbar URL to turn on debugging messages. i.e. <code>admin.php?page=wp-topbar.php&debug</code> . These messages can help you see if you have a parameter that will cause the TopBar to break.</li>
			<li><code>&debug</code> will turn on an internal timer that will display debug messages for about one minute.  The timer is reset for every page refresh that has <code>&debug</code>.  If you have debuging turned on (in your wp-config.php), then the error messages will also be sent to the default wordpress logfile for any page views of your website. i.e. <code>define('WP_DEBUG', true);</code> and <code>define('WP_DEBUG_LOG', true);</code></li>
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
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<strong>The TopBar is not enabled.  Therefore no HTML will be generated. Enable it in the <a href="?page=wp-topbar.php&tab=main">Main Options tab</a>.</strong><br>', 'wptb' ); }
		else {_e ('	<textarea rows="10" cols="150">', wptb);wptb::wptb_inject_TopBar_html_js();_e('</textarea>', wptb);} ?>
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
	</div> <!-- end of Delete Settings -->
   </form>
 </div>	 
 
 <?php
 
}	// End of wptb_debug_options

//=========================================================================			
// FAQ
//=========================================================================			

function wptb_faq_page() {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    
	$wptbOptions = wptb_get_Plugin_Options(false);

	?>
					
	<div class="postbox">
	<h3><a name="FAQ">WP-TopBar FAQ</a></h3>
	<div class="inside">		
	
	
	<ol type="square">

<li><strong>My TopBar is not working.  What should I do?</strong></li>
<p>Use the <a href="?page=wp-topbar.php&tab=debug">Debug tab</a> to see how the TopBar is being generated.</p>
<p>Check for any messages under the Live Preview heading on the Admin Page.  It will tell you if you have cookies or time settings that will prevent the TopBar from loading.
<p>You may have CSS settings that prevent the TopBar from loading.  If you entered any setting that are not valid, the TopBar will not load. Try deleting the settings and then re-entering your CSS until you find the one that is causing the issue.  Again, the <a href="?page=wp-topbar.php&tab=debug">Debug tab</a> can help you discover any issues.
<p>
<li><strong>How do the new cookies (in version 3.04+) work behind the scenes?</strong></li>
<p>
If you allow the user to close the TopBar, then the plugin checks to see if you have enabled cookies.   If they are not enabled, it deletes any existing cookies.   If they are enabled, it looks to see if a cookie has been created.  A cookie is only created if the TopBar has been previously closed by the user.  If it finds a cookie and the cookie value matches the Cookie Value setting, it prevents the TopBar from showing.
<p>
If you change the Cookie Value to something new, the TopBar will show up again.  This is useful if you want to force the TopBar to show on new content.  Make sure to select something you haven't used before.  A good idea is to increment the value by one every time you want to force the TopBar to show.
<p>
<li><strong>What Social Button Icons are provided?</strong></li>
<p>
Look in this directory (<code><?PHP echo str_ireplace( 'https://','http://',plugins_url('/icon/', __FILE__) ) ?></code>) and you'll find two folders,  one with PNG files and one with PSD files.  Thanks to <a href="http://ElegantThemes.com" target="_blank">ElegantThemes.com</a> for providing the icon files!
<p>
<li><strong>What CSS ID's are available?</strong></li>
<p>
Use <code>#topbar</code>
<p>
<li><strong>What if I fix the TopBar to the top or bottom of the page?</strong></li>
<p>
Use this CSS to fix the TopBar to the bottom of the page: 
<p>	<code>position:fixed; bottom: 0; padding: 0; margin: 0; width: 100%; z-index: 99999;</code>
<p>
Or this to fix the TopBar to the top of the page (adjust the top value to be the height of your TopBar):
<p>	<code>position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</code>
<p>
Note that by putting your TopBar in a Fixed Position, you will overlay the content of your website by the TopBar.
<p>
<li><strong>How to Find the Page ID</strong></li>
<p>
You can find the Page ID in the Edit Post or Edit Page URL. For example, the page ID for the following example is “1234.”
<p>
<code>http://example.wordpress.com/wp-admin/page.php?action=edit&post=1234</code>
<p>
<li><strong>How do I test the TopBar?</strong></li>
<p>
To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
<br>
<li><strong>Why does my TopBar look odd on Internet Explorer?</strong></li> 
<p>
IE does not (yet) implement gradients like other browsers.  So, make sure you test your TopBar on all the major browswers.
<br>
<li><strong>How dow I uninstall?</strong></li> 
<p> <ul>
<li>Go to the Delete Settings tab and then click the Delete Settings button at the top of the page.</li>
<li>Hit the Delete Settings Button.</li>
<li>Click "OK" on the warning box.</li>
<li>Go to your Plugins page and delete the plugin or delete all the files in your `/wp-content/plugins/wp-topbar` directory</li> 		
</ul>
<p>
	</ol>

<div class="clear"></div>	
	</div> 
	</div> <!-- end of FAQ -->
   </form>
 </div>	 
 
 <?php
 
}	// End of wptb_faq_page



?>