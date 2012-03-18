<?php 

/*
Plugin Name: WP-TopBar
Admin Page
*/


//=========================================================================			
//	Convert Date/Time to UTC - assumes offset is embedded as (+0800) or (-0100)
//=========================================================================			

function wptb_convert_time($wptb_time_value) {

	$wptb_time_offset=trim(substr($wptb_time_value,stripos($wptb_time_value,'(')+1),')'); //find offset
	$wptb_time_offset_numeric_in_secs=(substr($wptb_time_offset,1,2)*60*60)+substr($wptb_time_offset,3,2);
	if (substr($wptb_time_offset,0,1) == '-' ) $wptb_time_offset_numeric_in_secs = -$wptb_time_offset_numeric_in_secs;
				
	return strtotime(substr($wptb_time_value,0,stripos($wptb_time_value,'(')-1)) + $wptb_time_offset_numeric_in_secs;
				
} // End of function wptb_convert_time

	
//=========================================================================		
//Returns an array of admin options, but sets default values if none are loaded.
//=========================================================================		

function wptb_get_Plugin_Options() {

	$wptb_version_number = '3.01';
	
	$wptb_debug=get_transient( 'wptb_debug' );	
				
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
		'link_target' => 'blank',
		'bar_link' => 'http://wordpress.org/extend/plugins/wp-topbar/',
		'bar_text' => 'Get your own TopBar ',
		'bar_link_text' => 'from the Wordpress plugin repository',
		'text_align' => 'center',
		'bar_image' => '',
		'enable_image' => 'false',
		'custom_css_bar' => 'background:rgb(221,211,255);',
		'div_css' => '');

	$wptbOptions = get_option('wptbAdminOptions');

	if (!empty($wptbOptions)) {
		foreach ($wptbOptions as $key => $option)
			$wptbSetOptions[$key] = $option;
		wptb::wtpb_check_for_plugin_upgrade(1);	// call this in case the user did not use WP to upgrade/install plugin	
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
		if (wptb_check_time($wptb_current_time, $wptbSetOptions['start_time_utc'],$wptbSetOptions['end_time_utc']))
			if ($wptbSetOptions['enable_topbar'] == 'false') 
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display because it is not enabled, even though the time settings would allow it</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: TopBar will display due to time settings and because it is enabled</code>';
		else
			if ($wptbSetOptions['enable_topbar'] == 'false') 
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings and because it is not enabled</code>';
			else
				echo '<br><code>WP-TopBar Debug Mode: TopBar will <strong>NOT</strong> display due to time settings even though it is enabled</code>';
		
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


function wptb_options_page() {

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: ', date('D, d M Y H:i:s (e)',get_transient( 'wptb_debug' )),'</code>';
	
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Loading Options</code>';
	$wptbOptions = wptb_get_Plugin_Options();
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Updating Options</code>';
	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Version ',$wptbOptions['wptb_version'],'</code>';

								
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
				$wptbOptions['start_time_utc'] = wptb_convert_time($_POST['wptbstarttime']);
		}


		if (isset($_POST['wptbendtime'])) {

			$wptbOptions['end_time'] = $_POST['wptbendtime'];
			$wptbOptions['end_time_utc'] = wptb_convert_time($_POST['wptbendtime']);
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
		if (isset($_POST['wptblinktarget'])) {
			$wptbOptions['link_target'] = $_POST['wptblinktarget'];
		}
		if (isset($_POST['wptbtopbarpos'])) {
			$wptbOptions['topbar_pos'] = $_POST['wptbtopbarpos'];
		}
		
		update_option('wptbAdminOptions', $wptbOptions);
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Settings Updated</code>';
		echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
		$wptbOptions = wptb_get_Plugin_Options();


	}  // end of update_wptbSettings condition
	
	if (isset($_POST['delete_wptbSettings'])) { 
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Delete Settings</code>';
		delete_option('wptbAdminOptions');
		$wptbOptions = wptb_get_Plugin_Options();
		echo '<div class="updated"><p><strong>Settings Deleted.</strong></p></div>';
	} // end of delete_wptbSettings condition
	
	if ($wptbOptions['start_time_utc'] > $wptbOptions['end_time_utc'] && $wptbOptions['end_time_utc'] != 0 ) {
		echo '<div class="error"><strong>End Time is before Start Time - TopBar will not display.</strong></div>';
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: End Time Before Start Time Error</code>';
	}

	if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Displaying Options Page</code>';

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
	   color: white;'.$wptb_common_style; 
	
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
	// check for iPhone, iPad or iPod -- they can't use flash so the Copy button is hidden
	
	$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	
	if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) {
		
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: Not an iPhone/iPad/iPod Device</code>';
		$wptb_copy_style = "border-top: 1px solid #ea97f7;
		   background: #d065d6;
		   background: -webkit-gradient(linear, left top, left bottom, from(#9c3e9c), to(#d065d6));
		   background: -webkit-linear-gradient(top, #9c3e9c, #d065d6);
		   background: -moz-linear-gradient(top, #9c3e9c, #d065d6);
		   background: -ms-linear-gradient(top, #9c3e9c, #d065d6);
		   background: -o-linear-gradient(top, #9c3e9c, #d065d6);
		   padding: 3px 6px;
		   -webkit-border-radius: 13px;
		   -moz-border-radius: 13px;
		   border-radius: 13px;
		   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
		   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
		   box-shadow: rgba(0,0,0,1) 0 1px 0;
		   text-shadow: rgba(0,0,0,.4) 0 1px 0;
		   color: white;
		   font-size: 10px;
		   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
		   text-decoration: none;
		   vertical-align: middle;";
	   }
	else {
		if($wptb_debug) echo '<br><code>WP-TopBar Debug Mode: An iPhone/iPad/iPod Device</code>';
	    $wptb_copy_style = 'visibility:hidden';
	}
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
	<a name="Top">
		<div class=wrap>
		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<h2><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
		<a >WP-TopBar - Version 3.01</a></h1>
		<div class="postbox">
		<br>
		Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.  Includes Live Preview to see your TopBar.  Recent changes include:
		<p><em>
		<ol TYPE="I">
		<li>Version 3.01 adds the ability to set a start/end time for the TopBar to show.</li>
		<li>Version 2.1 is a minor bug fix for when the TopBar is in the footer and you are trying to exclude pages.</li>
		<li>Version 2.0 adds the ability to make the TopBar disappear after a set amount of time (See Display Time in Main options) and the ability to exclude pages from showing the Topbar.</li>
		</ol>
		</em>
		<hr>
		Please <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank">donate</a> if you find this plugin useful.
		<hr>
		<p></p>
		<center>
		<a class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" href="#MainOptions">Main Options</a>
		&nbsp;&nbsp;
		<a class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" href="#CustomCss">Custom CSS</a>
		&nbsp;&nbsp;
		<a class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" href="#ColorSelection">Color Selection</a>
		&nbsp;&nbsp;
		<a class="button" style="<?php _e( $wptb_button_style , 'wptb' ); ?>" href="#TopbarText">TopBar Text</a>
		&nbsp;&nbsp;
		<a class="button" style="<?php _e( $wptb_delete_style , 'wptb' ); ?>" href="#Uninstall">Delete Settings</a>
		<a class="button" style="<?php _e( $wptb_clear_style , 'wptb' ); ?>" href="http://wordpress.org/extend/plugins/wp-topbar/" target="_blank" >Plugin Home Page</a>
		<a id="wptbdonate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank"><img style="height:29px; vertical-align:middle;" src="<?php  echo plugins_url('/images/donate.gif', __FILE__)?>" /></a>
		</center>
		<p></p>
		</div>
		<div class="postbox">
		<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="error"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>
		<h3>Live Preview</h3>
		<div class="inside">
			<p class="sub">This is how the TopBar will appear on the website.
			<em>Based on your Start/End time settings below, the TopBar will <?php if (!wptb::wptb_check_time(gettimeofday(true),$wptbOptions['start_time_utc'],$wptbOptions['end_time_utc'])) echo "<strong>not</strong>"; ?> display (based on the current time.)</em>
			<br>To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.
			<br> The fist black line below represents the top of the screen.  The second black line represents the bottom of the TopBar.</p>
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
								<p class="sub"><em>Select where you want to TopBar to be located. Default is Above Header.</em></p>
						</td>
					</tr>	
					<tr valign="top">
						<td width="150">Start Delay:</label></td>
						<td>
							<input type="text" name="wptbdelayintime" id="delayintime" size="30" value="<?php echo $wptbOptions['delay_time']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the amount of time (in milliseconds) for the tobar to delay before appearing.  Enter 0 for no delay.</em></p>
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
								<p class="sub"><em>Enter the amount of time (in milliseconds) for the TopBar to show n on the page.  Enter 0 for the TopBar to not disappear.</em></p>
						</td>
					</tr>							
					<tr valign="top">
						<td width="150">Starting Time:</label></td>
						<td>
							<input type="text" id="wptbstarttimebtn" name="wptbstarttime" size="30" value="<?php echo $wptbOptions['start_time']; ?>"></label><p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbstarttimebtnClear">Set Start Time to Zero</p>									  
							<div id="wptb_start_time"></div>				    
						</td>
						<td>
								<p class="sub"><em>Pick the time for the TopBar to start showing.  Default is zero.</em></p>
						</td>
					</tr>							
					<tr valign="top">
						<td width="150">Ending Time:</label></td>
						<td>
							<input type="text" id="wptbendtimebtn" name="wptbendtime" size="30" value="<?php echo $wptbOptions['end_time']; ?>"></label>	<p class="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" id="wptbtimebtnClear">&nbspSet End Time to Zero</p>							  
							<div id="wptb_end_time"></div>				    
						</td>
						<td>
								<p class="sub"><em>Pick the time for the TopBar to stop showing.  Of course, it must be after the start time. Select 0 for the TopBar to never disappear.</em></p>
						</td>
					</tr>
					<tr valign="top">
						<td width="150">Bottom border height (px):</label></td>
						<td>
							<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the height of the bottom of the border.  Default is 3px.</em></p>
						</td>
					</tr>
					<tr valign="top">
						<td width="150">Top padding (px):</label></td>
						<td>
							<input type="text" name="wptbpaddingtop" id="paddingtop" size="5" value="<?php echo $wptbOptions['padding_top']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the top padding.  Default is 8px.</em></p>
						</td>
					</tr>			
					<tr valign="top">
						<td width="150">Bottom padding (px):</label></td>
						<td>
							<input type="text" name="wptbpaddingbottom" id="paddingbottom" size="5" value="<?php echo $wptbOptions['padding_bottom']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the bottom padding.  Default is 8px.</em></p>
						</td>
					</tr>		
					<tr valign="top">
						<td width="150">Top margin (px):</label></td>
						<td>
							<input type="text" name="wptbmargintop" id="margintop" size="5" value="<?php echo $wptbOptions['margin_top']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the top margin.  Default is 0px.</em></p>
						</td>
					</tr>			
					<tr valign="top">
						<td width="150">Bottom margin (px):</label></td>
						<td>
							<input type="text" name="wptbmarginbottom" id="marginbottom" size="5" value="<?php echo $wptbOptions['margin_bottom']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the bottom margin.  Default is 0px.</em></p>
						</td>
					</tr>				
					<tr valign="top">
						<td width="150">Font size (px):</label></td>
						<td>
							<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
						</td>
						<td>
								<p class="sub"><em>Enter the font size.  Default is 14px.</em></p>
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
								<p class="sub"><em>Select how you want the text to align. Default is center. When using right -- try adding padding via the Custom CSS box. e.g. padding-right:10px;</em></p>
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
							<p class="sub"><em>Select Yes if you want to exclude the Page IDs enter above.  This will cause the TopBar to <strong>not</strong> be shown on those specific Page IDs.  Default is No.</em></p>
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
		
		<div class="postbox">
		<h3><a name="CustomCss">Custom CSS</a></h3>
		<div class="inside">
			<em><p class="sub">Enter any custom CSS.  This allows you to add padding, font styles & more.  Be really careful here -- this could break your website!  Test this with multiple browsers to make sure it works across them all. Double-quotes are automatically replaced with single quotes.<p><strong>Don't forget the trailing semi-colon.</strong></p>
			Create a custom CSS gradient at colorzilla.com:
			<a class="button" style="<?php _e( $wptb_cssgradient_style , 'wptb' ); ?>" href="http://www.colorzilla.com/gradient-editor/" target="_blank">http://www.colorzilla.com/gradient-editor/</a>	
			<p class="sub">Examples:<p></p>
			</em>	
			<table>
				<tr>
					<td style="vertical-align:top" onmouseOver="wptb_copy_to_Clibboard(this,'<?php _e( addslashes($css_sample1) , 'wptb' ); ?>')"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">1.</td><td style="vertical-align:top"><code><?php _e( $css_sample1 , 'wptb' ); ?></code></td>
				</tr>
				<tr>
					<td style="vertical-align:top" onmouseOver="wptb_copy_to_Clibboard(this,'<?php _e( addslashes($css_sample2) , 'wptb' ); ?>')"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">2.</td><td style="vertical-align:top"><code><?php _e( $css_sample2 , 'wptb' ); ?></code></td>
				</tr>
				<tr>
					<td style="vertical-align:top" onmouseOver="wptb_copy_to_Clibboard(this,'<?php _e( bin2hex($css_sample3) , 'wptb' ); ?>', 1)"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">3.</td><td style="vertical-align:top"><code><?php _e( $css_sample3 , 'wptb' ); ?></code></td>
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
						<input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>" onmouseOver="wptb_copy_to_Clibboard(this,'<?php _e( addslashes($div_css_sample_top) , 'wptb' ); ?>')" />&nbsp&nbsp&nbsp<code><?php _e( $div_css_sample_top , 'wptb' ); ?></code>
						<p>Or this to fix the TopBar to the bottom of the page:<p>
						<input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>" onmouseOver="wptb_copy_to_Clibboard(this,'<?php _e( addslashes($div_css_sample_bot) , 'wptb' ); ?>')" />&nbsp&nbsp&nbsp<code><?php _e( $div_css_sample_bot , 'wptb' ); ?></code>
		
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
			</table>
			<div class="clear"></div>	
			</div>
		</div> <!-- end of CSS Settings -->
		
		<div class="postbox">
											
		<h3><a name="ColorSelection">Color Selection</a></h3>
		
		<div class="inside">
			<p class="sub"><em>Click the color box to select the color to use.  Bar color is NOT used if Image is enabled (in the next section.)</em></p>
			<div class="table">
				<table class="form-table">			
					<tr valign="top">
						<td width="200">Color of the Bar:</label></td>
						<td>
						  <label for="barcolor"><input type="text" id="barcolor" name="wptbbarcolor" value="<?php echo $wptbOptions['bar_color']; ?>"></label>
					      <div id="wptb_colorpicker_bar"></div>		
						</td>
					</tr>
					<tr valign="top">
						<td width="200">Color of the bottom border of the Bar:</label></td>
						<td>
					      <label for="bottomcolor"><input type="text" id="bottomcolor" name="wptbbottomcolor" value="<?php echo $wptbOptions['bottom_color']; ?>"></label>
					      <div id="wptb_colorpicker_bottom"></div>			
						</td>
					</tr>
					<tr valign="top">
						<td width="200">Color of the Message:</label></td>
						<td>
						    <label for="textcolor"><input type="text" id="textcolor" name="wptbtextcolor" value="<?php echo $wptbOptions['text_color']; ?>"></label>
						    <div id="wptb_colorpicker_text"></div>				    
						</td>
					</tr>
					<tr valign="top">
						<td width="200">Color of the Link:</label></td>
						<td>
						    <label for="linkcolor"><input type="text" id="linkcolor" name="wptblinkcolor" value="<?php echo $wptbOptions['link_color']; ?>"></label>
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
	
	<script type="text/javascript">			 
	  jQuery(document).ready(function() {
				   			
		//set path for ZeroClipboard
		ZeroClipboard.setMoviePath('<?php _e( plugins_url('/zeroclipboard/ZeroClipboard.swf', __FILE__), 'wptb' ); ?>');
	})
	</script>
	
	<div class="postbox">
										
	<h3><a name="TopbarText">TopBar Text, Image and Link</a></h3>
										
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
					<input class="button" id="wptbupload_image_button" type="button" style="<?php _e( $wptb_special_button_style , 'wptb' ); ?>" value="Upload Image" />
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
	</div> <!-- end of TopbarText Settings -->
				
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
}	// End of wptb_options_page
?>