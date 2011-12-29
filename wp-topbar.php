<?php
/*
Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, image and link.
Version: 2.0
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
if (!class_exists("wptb")) {
	class wptb {
		var $adminOptionsName = "wptbAdminOptions";
		var $wptb_debug = 0;
		var $wptb_version_number = '2.0';


		function wptb() { //constructor	
		}
		
		function init() {
			$this->getWPTBPluginOptions();
	
		}
				
		//Returns an array of admin options, but sets default values if none are loaded.
		//=========================================================================		
		//=========================================================================		

		function getWPTBPluginOptions() {
		
			
			if($this->wptb_debug) echo "<p>Debug Mode - Version ",$this->wptb_version_number;
			
			$wptbAdminOptions = array(
				'wptb_version' => $this->wptb_version_number,
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
				'div_css' => ' ');

			$wptbOptions = get_option($this->adminOptionsName);

			if (!empty($wptbOptions)) {
				foreach ($wptbOptions as $key => $option)
					$wptbAdminOptions[$key] = $option;
				
			// code, if needed, to perform option table upgrades & updates version stored in database
	
				if ($wptbAdminOptions['wptb_version'] != $this->wptb_version_number) {
					$wptbAdminOptions['wptb_version'] = $this->wptb_version_number;
					update_option($this->adminOptionsName, $wptbAdminOptions);
				}
				
			}

			return $wptbAdminOptions;
		}


		// common code to display the TopBar
		//=========================================================================		
		//=========================================================================		
		
		function wptb_displayTopBar($visibility, $wptbOptions) {
 ?>
		<p id="wptbheadline" style="<?php echo $visibility ?>;
		<?php if ($wptbOptions['enable_image'] == "false") 
				echo "background: {$wptbOptions['bar_color']};";
			else 
		 		echo "background-image: url({$wptbOptions['bar_image']});	background-position:center;"; 
		?>
		margin:  <?php echo $wptbOptions['margin_top']; ?>px 0px <?php echo $wptbOptions['margin_bottom']; ?>px;
		text-align:<?php echo $wptbOptions['text_align']; ?>;
		font-size: <?php echo $wptbOptions['font_size']; ?>px; 	
		padding-top:<?php echo $wptbOptions['padding_top']; ?>px; 
		padding-bottom:<?php echo $wptbOptions['padding_bottom']; ?>px; 	
		color:<?php echo $wptbOptions['text_color']; ?>; display:block; 	
		border-bottom-color:<?php echo $wptbOptions['bottom_color']; ?>; 
		border-bottom-style: solid; 
		border-bottom-width: <?php echo $wptbOptions['bottom_border_height']; ?>px;
		border-bottom-width: <?php echo $wptbOptions['bottom_border_height']; ?>px;
		<?php if ($wptbOptions['custom_css_bar'] != "") 
				echo addslashes($wptbOptions['custom_css_bar']); ?>
	">
		<?php echo stripslashes_deep($wptbOptions['bar_text']); ?>
		<a style="color:<?php echo $wptbOptions['link_color']; ?>;
			<?php if ($wptbOptions['custom_css_text'] != "") 
				echo "{$wptbOptions['custom_css_text']}"; ?>
		"href="<?php echo $wptbOptions['bar_link']; ?>" target="_<?php echo $wptbOptions['link_target']; ?>"><?php echo stripslashes_deep($wptbOptions['bar_link_text']); ?></a>
		</p> 
		
<?php
		}
	
		//Puts the Top Bar above the Header
		//=========================================================================		
		//=========================================================================		

		function wptb_addHeaderCode() {
		
			global $wp_query;
	
			$wptbOptions = $this->getWPTBPluginOptions();						

			if (($wptbOptions['enable_topbar'] == "false") || ($wptbOptions['topbar_pos'] == "footer")){ return; }

			$thePostID = $wp_query->post->ID;
			
			
		// if invert_include is "yes", then use the exclude showing the Topbar on the inlcude_pages 
			if ( $wptbOptions['invert_include'] == "yes" ) {
				if ( in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) )
						{ return; }			
			}
			else {
				if ( ! in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) && ! in_array( 0, explode( ',', $wptbOptions['include_pages'] ) ) )
						{ return; }			
			}
			
			echo '<div id="topbar" style="',$wptbOptions['div_css'],'">';
		
				$vis = "visibility:hidden;";
 
				$this->wptb_displayTopBar($vis,$wptbOptions);
		
			echo '</div>';
		}
		

		//Puts the Top Bar below the Footer
		//=========================================================================		
		//=========================================================================		

		function wptb_addFooterCode() {
		
			global $wp_query;
	
			$wptbOptions = $this->getWPTBPluginOptions();						

			if (($wptbOptions['enable_topbar'] == "false") || ($wptbOptions['topbar_pos'] == "header")){ return; }
			

			$thePostID = $wp_query->post->ID;	

			if ( ! in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) && ! in_array( 0, explode( ',', $wptbOptions['include_pages'] ) ) )
					{ return; }
							
			echo '<div id="topbar" style="',$wptbOptions['div_css'],'">';
		
				$vis = "visibility:hidden;";
 
				$this->wptb_displayTopBar($vis,$wptbOptions);
		
			echo '</div>';
		}

		//Displays the Options Page
		//=========================================================================		
		//=========================================================================		

		function wptb_options_page() {
		
					$wptbOptions = $this->getWPTBPluginOptions();
										
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
    							echo '<div class="updated"><strong>Bottom border height is not numeric. Resetting to 3px.</strong></div>';
   								$wptbOptions['bottom_border_height'] = 3;
							} 
							else 	
								$wptbOptions['bottom_border_height'] = $_POST['wptbbottomborderheight']+0;
						}
						if (isset($_POST['wptbdelayintime'])) {
						
							if (!is_numeric($_POST['wptbdelayintime'])) {
    							echo '<div class="updated"><strong>Delay time is not numeric. Resetting to zero.</strong></div>';
   								$wptbOptions['delay_time'] = 0;
							} 
							else 	
								$wptbOptions['delay_time'] = $_POST['wptbdelayintime']+0;
						}
						if (isset($_POST['wptbslidetime'])) {
						
							if (!is_numeric($_POST['wptbslidetime'])) {
    							echo '<div class="updated"><strong>Slide time is not numeric. Resetting to zero.</strong></div>';
								$wptbOptions['slide_time'] = 0;
							} 
							else 	
								$wptbOptions['slide_time'] = $_POST['wptbslidetime']+0;
						}
						if (isset($_POST['wptbdisplaytime'])) {
						
							if (!is_numeric($_POST['wptbdisplaytime'])) {
    							echo '<div class="updated"><strong>Display time is not numeric. Resetting to zero.</strong></div>';
								$wptbOptions['display_time'] = 0;
							} 
							else 	
								$wptbOptions['display_time'] = $_POST['wptbdisplaytime']+0;
						}			
						if (isset($_POST['wptbfontsize'])) {
						
							if (!is_numeric($_POST['wptbfontsize'])) {
    							echo '<div class="updated"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
								$wptbOptions['font_size'] = 8;
							} 
							else 	
								$wptbOptions['font_size'] = $_POST['wptbfontsize']+0;
						}						
						if (isset($_POST['wptbpaddingtop'])) {
						
							if (!is_numeric($_POST['wptbpaddingtop'])) {
    							echo '<div class="updated"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
								$wptbOptions['padding_top'] = 8;
							} 
							else 	
								$wptbOptions['padding_top'] = $_POST['wptbpaddingtop']+0;
						}
						if (isset($_POST['wptbpaddingbottom'])) {
						
							if (!is_numeric($_POST['wptbpaddingbottom'])) {
    							echo '<div class="updated"><strong>Bottom padding is not numeric. Resetting to 8px.</strong></div>';
								$wptbOptions['padding_bottom'] = 8;
							} 
							else 	
								$wptbOptions['padding_bottom'] = $_POST['wptbpaddingbottom']+0;
						}						
						if (isset($_POST['wptbmargintop'])) {
						
							if (!is_numeric($_POST['wptbmargintop'])) {
    							echo '<div class="updated"><strong>Top margin is not numeric. Resetting to 0px.</strong></div>';
								$wptbOptions['margin_top'] = 0;
							} 
							else 	
								$wptbOptions['margin_top'] = $_POST['wptbmargintop']+0;
						}
						if (isset($_POST['wptbmarginbottom'])) {
						
							if (!is_numeric($_POST['wptbmarginbottom'])) {
    							echo '<div class="updated"><strong>Bottom margin is not numeric. Resetting to 0px.</strong></div>';
								$wptbOptions['margin_bottom'] = 0;
							} 
							else 	
								$wptbOptions['margin_bottom'] = $_POST['wptbmarginbottom']+0;
						}						
						if (isset($_POST['wptblink'])) {
							$wptbOptions['bar_link'] = $_POST['wptblink'];
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
							$wptbOptions['custom_css_bar']  = str_replace('"',"'",stripslashes_deep($_POST['wptbcustomcssbar']));
						}
						if (isset($_POST['wptbcustomcsstext'])) {
							$wptbOptions['custom_css_text'] = str_replace('"',"'",stripslashes_deep($_POST['wptbcustomcsstext']));
						}
						if (isset($_POST['wptbdivcss'])) {
							$wptbOptions['div_css'] = str_replace('"',"'",stripslashes_deep($_POST['wptbdivcss']));
						}
						if (isset($_POST['wptblinktarget'])) {
							$wptbOptions['link_target'] = $_POST['wptblinktarget'];
						}
						if (isset($_POST['wptbtopbarpos'])) {
							$wptbOptions['topbar_pos'] = $_POST['wptbtopbarpos'];
						}
						
						update_option($this->adminOptionsName, $wptbOptions);
						
						?>
<div class="updated"><p><strong><?php _e("Settings Updated.", "wptb");?></strong></p></div>
					<?php
					} 
					if (isset($_POST['delete_wptbSettings'])) { 
											
						delete_option($this->adminOptionsName);
						$wptbOptions = $this->getWPTBPluginOptions();
						?>
<div class="updated"><p><strong><?php _e("Settings Deleted.", "wptb");?></strong></p></div>
					<?php
					} ?>
					
<?php 

$wptb_button_style = "border-top:1px solid #96d1f8;
	background:#65a9d7;
	background:-webkit-gradient(linear, left top, left bottom, from(#215375), to(#65a9d7));
	background:-webkit-linear-gradient(top, #215375, #65a9d7);
	background:-moz-linear-gradient(top, #215375, #65a9d7);
	background:-ms-linear-gradient(top, #215375, #65a9d7);
	background:-o-linear-gradient(top, #215375, #65a9d7);
	padding:7.5px 15px;
	-webkit-border-radius:23px;
	-moz-border-radius:23px;
	border-radius:23px;
	-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
	box-shadow:rgba(0,0,0,1) 0 1px 0;
	text-shadow:rgba(0,0,0,.4) 0 1px 0;
	color:white;
	font-size:16px;
	font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
	text-decoration:none;
	vertical-align:middle;"; 

$wptb_clear_style = "border-top:1px solid #96d1f8;
	background:#FFFF90;
	padding:7.5px 15px;
	-webkit-border-radius:23px;
	-moz-border-radius:23px;
	border-radius:23px;
	-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
	box-shadow:rgba(0,0,0,1) 0 1px 0;
	text-shadow:rgba(0,0,0,.4) 0 1px 0;
	color:black;
	font-size:16px;
	font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
	text-decoration:none;
	vertical-align:middle;"; 

$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

if (!(stripos($browser,'iPod')) && !(stripos($browser,'iPhone')) && !(stripos($browser,'iPad'))) 
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
else
 $wptb_copy_style = "visibility:hidden";
  	


$wptb_cssgradient_style="border-top: 1px solid #c5f797;
   background: #92d665;
   background: -webkit-gradient(linear, left top, left bottom, from(#699c3e), to(#92d665));
   background: -webkit-linear-gradient(top, #699c3e, #92d665);
   background: -moz-linear-gradient(top, #699c3e, #92d665);
   background: -ms-linear-gradient(top, #699c3e, #92d665);
   background: -o-linear-gradient(top, #699c3e, #92d665);
   padding: 2.5px 5px;
   -webkit-border-radius: 9px;
   -moz-border-radius: 9px;
   border-radius: 9px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 13px;
   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
   text-decoration: none;
   vertical-align: middle;";


$wptb_submit_style = "border-top:1px solid #97f7c1;
	background:#65d67f;
	background:-webkit-gradient(linear, left top, left bottom, from(#217342), to(#65d67f));
	background:-webkit-linear-gradient(top, #217342, #65d67f);
	background:-moz-linear-gradient(top, #217342, #65d67f);
	background:-ms-linear-gradient(top, #217342, #65d67f);
	background:-o-linear-gradient(top, #217342, #65d67f);
	padding:7.5px 15px;
	-webkit-border-radius:23px;
	-moz-border-radius:23px;
	border-radius:23px;
	-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
	box-shadow:rgba(0,0,0,1) 0 1px 0;
	text-shadow:rgba(0,0,0,.4) 0 1px 0;
	color:white;
	font-size:16px;
	font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
	text-decoration:none;
	vertical-align:middle;"; 

$wptb_delete_style = "border-top:1px solid #f59898;
	background:#d46565;
	background:-webkit-gradient(linear, left top, left bottom, from(#732121), to(#d46565));
	background:-webkit-linear-gradient(top, #732121, #d46565);
	background:-moz-linear-gradient(top, #732121, #d46565);
	background:-ms-linear-gradient(top, #732121, #d46565);
	background:-o-linear-gradient(top, #732121, #d46565);
	padding:7.5px 15px;
	-webkit-border-radius:23px;
	-moz-border-radius:23px;
	border-radius:23px;
	-webkit-box-shadow:rgba(0,0,0,1) 0 1px 0;
	-moz-box-shadow:rgba(0,0,0,1) 0 1px 0;
	box-shadow:rgba(0,0,0,1) 0 1px 0;
	text-shadow:rgba(0,0,0,.4) 0 1px 0;
	color:#f2f2f2;
	font-size:16px;
	font-family:'Lucida Grande', Helvetica, Arial, Sans-Serif;
	text-decoration:none;
	vertical-align:middle;";

								
$div_css_sample_top="position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;";
$div_css_sample_bot="position:fixed; bottom: 0; padding:0; margin:0; width: 100%; z-index: 99999;";							

$css_sample1="text-transform:lowercase;";
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
<h1><img src="<?php _e( plugins_url('/images/banner-772x250.png', __FILE__), 'wptb' ); ?>" height="50" alt="TopBar Banner"/>
<a >WP-TopBar - Version <?php echo $wptbOptions['wptb_version']; ?></a></h1>
<div class="postbox">
<br>
Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.  Includes Live Preview to see your TopBar.  Recent changes include:
<p><em>
<ol TYPE="I">
<li>Version 2.0 adds the ability to make the TopBar disappear after a set amount of time (See Display Time in Main options) and the ability to exclude pages from showing the Topbar.  </li>
<li><p>Version 1.5 adds additional Link option (target), option to put TopBar at the footer, and new DIV-level CSS.  Also moved TopBar to the Body instead of the Header. <strong>With this update, it may change how your TopBar looks if you were using a previous version.</strong></p></li>
<li><p>Version 1.4 adds additional CSS options (margin).</li> 
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
<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="updated"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>



<h3>Live Preview</h3>


<div class="inside">
	<p class="sub"><em>This is how the TopBar will appear on the website. The fist black line represents the top of the screen.  The second black line represents the bottom of the TopBar.  To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.</em></p>

	<div class="table">
		<table class="form-table">
			
			<tr valign="top">
			
<div>
<hr style="margin: 0px; height: 1px; padding: 0px; background-color: #000; color: #000;" />


<?php $this->wptb_displayTopBar("",$wptbOptions); ?>

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
</div>



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
			<td style="vertical-align:top" onmouseOver="toClipboard(this,'<?php _e( addslashes($css_sample1) , 'wptb' ); ?>')"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">1.</td><td style="vertical-align:top"><code><?php _e( $css_sample1 , 'wptb' ); ?></code></td>
		</tr>
		<tr>
			<td style="vertical-align:top" onmouseOver="toClipboard(this,'<?php _e( addslashes($css_sample2) , 'wptb' ); ?>')"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">2.</td><td style="vertical-align:top"><code><?php _e( $css_sample2 , 'wptb' ); ?></code></td>
		</tr>
		<tr>
			<td style="vertical-align:top" onmouseOver="toClipboard(this,'<?php _e( bin2hex($css_sample3) , 'wptb' ); ?>', 1)"><input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>"/></td><td style="vertical-align:top">3.</td><td style="vertical-align:top"><code><?php _e( $css_sample3 , 'wptb' ); ?></code></td>
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
				<input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>" onmouseOver="toClipboard(this,'<?php _e( addslashes($div_css_sample_top) , 'wptb' ); ?>')" />&nbsp&nbsp&nbsp<code><?php _e( $div_css_sample_top , 'wptb' ); ?></code>
				<p>Or this to fix the TopBar to the bottom of the page:<p>
				<input type="button" value="Copy to Clipboard" style="<?php _e( $wptb_copy_style, 'wptb' ); ?>" onmouseOver="toClipboard(this,'<?php _e( addslashes($div_css_sample_bot) , 'wptb' ); ?>')" />&nbsp&nbsp&nbsp<code><?php _e( $div_css_sample_bot , 'wptb' ); ?></code>

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
</div>



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
</div>

<script type="text/javascript">
    
  jQuery(document).ready(function() {

    jQuery('#wptb_colorpicker_bar').hide();
    jQuery('#wptb_colorpicker_bar').farbtastic("#barcolor");
    jQuery("#barcolor").click(function(){jQuery('#wptb_colorpicker_bar').slideDown()});
    jQuery("#barcolor").blur(function(){jQuery('#wptb_colorpicker_bar').slideUp()});

    jQuery('#wptb_colorpicker_text').hide();
    jQuery('#wptb_colorpicker_text').farbtastic("#textcolor");
    jQuery("#textcolor").click(function(){jQuery('#wptb_colorpicker_text').slideDown()});
    jQuery("#textcolor").blur(function(){jQuery('#wptb_colorpicker_text').slideUp()});

    jQuery('#wptb_colorpicker_bottom').hide();
    jQuery('#wptb_colorpicker_bottom').farbtastic("#bottomcolor");
    jQuery("#bottomcolor").click(function(){jQuery('#wptb_colorpicker_bottom').slideDown()});
    jQuery("#bottomcolor").blur(function(){jQuery('#wptb_colorpicker_bottom').slideUp()});
    
    jQuery('#wptb_link_color').hide();
    jQuery('#wptb_link_color').farbtastic("#linkcolor");
    jQuery("#linkcolor").click(function(){jQuery('#wptb_link_color').slideDown()});
    jQuery("#linkcolor").blur(function(){jQuery('#wptb_link_color').slideUp()});

	//set path for ZeroClipboard
	ZeroClipboard.setMoviePath('<?php _e( plugins_url('/lib/zeroclipboard/ZeroClipboard.swf', __FILE__), 'wptb' ); ?>');
	
  });
 
 
 	//function to set string to copy. If conversion parm is set, then convert string from hex

   function toClipboard(me,strMsg,conversion) {
   
	var clip = new ZeroClipboard.Client();
	
	clip.setHandCursor( true );
	
	if(!conversion) {clip.setText(strMsg);}
	else {
	
	// strMsg must be in hex -- so decode it
	
		var bytes = [];
	
		for(var i=0; i< strMsg.length-1; i+=2){
		    bytes.push(parseInt(strMsg.substr(i, 2), 16));
		}
					    
		clip.setText(String.fromCharCode.apply(String, bytes));
	}  
	    	
	clip.addEventListener('complete', function (client, text) {
		alert("Copied this: "+text.substring(0,100)+"…");
	});
	clip.glue(me);
  }
	
  
 
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
					<input type="text" name="wptblink" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['bar_link']); ?>" >
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
				<input class="button" id="wptbupload_image_button" type="button" value="Upload Image" />
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
</div>



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
</div>

</form>
 </div>
<?php
		}//End function wptb_options_page()
	}
	
} //End Class wptb

if (class_exists("wptb")) {
	$wtpb_plugin = new wptb();
}

//Initialize the admin panel
if (!function_exists("wptb_options_panel")) {
	function wptb_options_panel() {
		global $wtpb_plugin;
		if (!isset($wtpb_plugin)) {
			return;
		}

		if (function_exists('add_options_page')) {
	add_menu_page('WP TopBar' , 'WP TopBar', 3          , basename(__FILE__), array(&$wtpb_plugin, 'wptb_options_page'),plugins_url('/images/icon.png', __FILE__));
	


	//add_submenu_page(basename(__FILE__), 'Delete Settings', 'Delete Settings', 3, "wp-topbar_delete.php", 'wptb_delete_options_page');

		}
	}	
}



//Enqueue Farbtastics for the color pickers
		//=========================================================================		
		//=========================================================================		

function wptb_enqueue_scripts() {
	if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') {

  		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_register_script( 'wptb_upload', plugins_url('/wp-topbar-load-image.js', __FILE__), array('jquery','media-upload','thickbox') );
		wp_enqueue_script( 'wptb_upload') ;
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style('thickbox');
		wp_register_script( 'wptb_zeroclip', plugins_url('/lib/zeroclipboard/ZeroClipboard.js', __FILE__), array('jquery') );
		wp_enqueue_script('wptb_zeroclip');

	}

}


//Puts javascript in the footer
//=========================================================================		
//=========================================================================		

function wptb_reveal_topbar() {
		
	$wptbOptions = get_option('wptbAdminOptions');
	if ($wptbOptions['enable_topbar'] == "false") { return; }


	 ?>

<script type="text/javascript">


	jQuery(document).ready(function() {
		jQuery('#wptbheadline').hide();
		jQuery('#wptbheadline').delay(<?php echo $wptbOptions['delay_time'];?>);
		jQuery('#wptbheadline').css("visibility","visible");
		jQuery('#wptbheadline').slideDown(<?php echo $wptbOptions['slide_time'];?>).fadeIn(1000);
		jQuery('#wptbheadline').show("slow");    
	
	 	<?php 
 			if (($wptbOptions['display_time']+0) != 0){
				echo "jQuery('#wptbheadline').delay(",$wptbOptions['display_time'],");";
				echo "jQuery('#wptbheadline').slideUp(",$wptbOptions['slide_time'],").fadeOut(1000);";
				echo "jQuery('#wptbheadline').hide();";
 			} 		
 		?>

	}); 
	
</script>


<?php }

//	add "Settings" link to plugin page
//=========================================================================			
//=========================================================================		

function wptb_plugin_action_links($links) {
	$wptb_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-topbar.php' ), __('Settings') );
	array_unshift($links, $wptb_settings_link);
	return $links;
}



//donate link on manage plugin page
//=========================================================================			
//=========================================================================			


function wptb_plugin_donate_link($links, $file) {
if ($file == plugin_basename(__FILE__)) {
		$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J" target="_blank">Donate</a>';
		$links[] = $donate_link;
	}
	return $links;
}

//Actions and Filters, if on plugin admin page	
if (isset($wtpb_plugin)) {
	//Actions
	add_action('admin_menu', 'wptb_options_panel');
	add_action('activate_wptb-plugin-series/wptb-plugin-series.php',  array(&$wtpb_plugin, 'init'));
	add_action('init', 'wptb_enqueue_scripts');
	//Filters
	add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'wptb_plugin_action_links');
	add_filter('plugin_row_meta', 'wptb_plugin_donate_link', 10, 2);
}	
	
//Actions and Filters, on all pages
if (isset($wtpb_plugin)) {
	add_action('wp_head', 	array(&$wtpb_plugin, 'wptb_addHeaderCode'), 15);
	add_action('wp_footer', array(&$wtpb_plugin, 'wptb_addFooterCode'), 15);
	add_action('wp_footer', 'wptb_reveal_topbar', 15);	
}



?>