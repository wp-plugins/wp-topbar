<?php
/*
Plugin Name: WP-TopBar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, image and link.
Version: 1.4
Author: Bob Goetz
Author URI: http://wordpress.org/extend/plugins/profile/rfgoetz

*/
/*  Copyright 2011  Bob Goetz  (email : rfgoetz at google's mail . com)

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
		function wptb() { //constructor	
		}
		
		function init() {
			$this->getWPTBPluginOptions();
		}
				
		//Returns an array of admin options, but sets default values if none are loaded.
		function getWPTBPluginOptions() {
			
			$wptbAdminOptions = array(
				'enable_topbar' => 'false',
				'text_color' => '#000000',
				'bar_color' => '#ffffff',
				'bottom_color' => '#f90000',
				'link_color' => '#c00000',
				'bottom_border_height' => '3', 
				'include_pages' => '0',
				'delay_time' => '5000',
				'slide_time' => '200',
				'font_size' => '14',
				'padding_top' => '8',
				'padding_bottom' => '8',
				'bar_link' => 'http://wordpress.org/extend/plugins/wp-topbar/', 
				'bar_text' => 'Get your own TopBar ',
				'bar_link_text' => 'from the Wordpress plugin repository',
				'text_align' => 'center',
				'bar_image' => '',
				'enable_image' => 'false',
				'custom_css_bar' => 'background:rgb(254,255,255);background:-moz-linear-gradient(top,rgba(254,255,255,1)0%,rgba(221,241,249,1)35%,rgba(160,216,239,1)100%);background:-webkit-gradient(linear,lefttop,leftbottom,color-stop(0%,rgba(254,255,255,1)),color-stop(35%,rgba(221,241,249,1)),color-stop(100%,rgba(160,216,239,1)));background:-webkit-linear-gradient(top,rgba(254,255,255,1)0%,rgba(221,241,249,1)35%,rgba(160,216,239,1)100%);background:-o-linear-gradient(top,rgba(254,255,255,1)0%,rgba(221,241,249,1)35%,rgba(160,216,239,1)100%);background:-ms-linear-gradient(top,rgba(254,255,255,1)0%,rgba(221,241,249,1)35%,rgba(160,216,239,1)100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#feffff",endColorstr="#a0d8ef",GradientType=0);background:linear-gradient(top,rgba(254,255,255,1)0%,rgba(221,241,249,1)35%,rgba(160,216,239,1)100%);',
				'custom_css_text' => 'font-family:georgia;padding-right:10px;',
				'margin_top' => '0',
				'margin_bottom' => '0');
			$wptbOptions = get_option($this->adminOptionsName);
			if (!empty($wptbOptions)) {
				foreach ($wptbOptions as $key => $option)
					$wptbAdminOptions[$key] = $option;
			}
	
			return $wptbAdminOptions;
		}


		// common code to display the TopBar
		
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
		"href="<?php echo $wptbOptions['bar_link']; ?>"target="_blank"><?php echo stripslashes_deep($wptbOptions['bar_link_text']); ?></a>
		</p> 
		
<?php
		}
	
		//Puts the Top Bar above the Header

		function wptb_addHeaderCode() {
		
			global $wp_query;
	
			$wptbOptions = $this->getWPTBPluginOptions();						

			if ($wptbOptions['enable_topbar'] == "false") { return; }

			$thePostID = $wp_query->post->ID;	

			if ( ! in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) && ! in_array( 0, explode( ',', $wptbOptions['include_pages'] ) ) )
					{ return; }
							
			echo '<div id="topbar">';
		
				$vis = "visibility:hidden;";
 
				$this->wptb_displayTopBar($vis,$wptbOptions);
		
			echo '</div';
		}


		//Displays the Options Page
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

$wptb_button_style = "font-weight:bold;color:black;background:rgb(178,225,255);background:-moz-linear-gradient(top,rgba(178,225,255,1)0%,rgba(102,182,252,1)100%);background:-webkit-gradient(linear,lefttop,leftbottom,color-stop(0%,rgba(178,225,255,1)),color-stop(100%,rgba(102,182,252,1)));background:-webkit-linear-gradient(top,rgba(178,225,255,1)0%,rgba(102,182,252,1)100%);background:-o-linear-gradient(top,rgba(178,225,255,1)0%,rgba(102,182,252,1)100%);background:-ms-linear-gradient(top,rgba(178,225,255,1)0%,rgba(102,182,252,1)100%);
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b2e1ff',endColorstr='#66b6fc',GradientType=0);background:linear-gradient(top,rgba(178,225,255,1)0%,rgba(102,182,252,1)100%);"; 

$wptb_submit_style = "padding-bottom:5px;text-shadow:none;font-family:'sans-serif';font-weight:bold;color:white;background:rgb(180,221,180);background:-moz-linear-gradient(top,rgba(180,221,180,1)0%,rgba(131,199,131,1)17%,rgba(82,177,82,1)33%,rgba(0,138,0,1)67%,rgba(0,87,0,1)83%,rgba(0,36,0,1)100%);background:-webkit-gradient(linear,lefttop,leftbottom,color-stop(0%,rgba(180,221,180,1)),color-stop(17%,rgba(131,199,131,1)),color-stop(33%,rgba(82,177,82,1)),color-stop(67%,rgba(0,138,0,1)),color-stop(83%,rgba(0,87,0,1)),color-stop(100%,rgba(0,36,0,1)));background:-webkit-linear-gradient(top,rgba(180,221,180,1)0%,rgba(131,199,131,1)17%,rgba(82,177,82,1)33%,rgba(0,138,0,1)67%,rgba(0,87,0,1)83%,rgba(0,36,0,1)100%);background:-o-linear-gradient(top,rgba(180,221,180,1)0%,rgba(131,199,131,1)17%,rgba(82,177,82,1)33%,rgba(0,138,0,1)67%,rgba(0,87,0,1)83%,rgba(0,36,0,1)100%);background:-ms-linear-gradient(top,rgba(180,221,180,1)0%,rgba(131,199,131,1)17%,rgba(82,177,82,1)33%,rgba(0,138,0,1)67%,rgba(0,87,0,1)83%,rgba(0,36,0,1)100%);
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b4ddb4',endColorstr='#002400',GradientType=0);background:linear-gradient(top,rgba(180,221,180,1)0%,rgba(131,199,131,1)17%,rgba(82,177,82,1)33%,rgba(0,138,0,1)67%,rgba(0,87,0,1)83%,rgba(0,36,0,1)100%);"; 

$wptb_delete_style = "padding-bottom:5px;text-shadow:none;font-family:'Sans-serif';font-weight:bold;color:white;background:rgb(255,26,0);background:-moz-linear-gradient(top,rgba(255,26,0,1)0%,rgba(255,26,0,1)100%);background:-webkit-gradient(linear,lefttop,leftbottom,color-stop(0%,rgba(255,26,0,1)),color-stop(100%,rgba(255,26,0,1)));background:-webkit-linear-gradient(top,rgba(255,26,0,1)0%,rgba(255,26,0,1)100%);background:-o-linear-gradient(top,rgba(255,26,0,1)0%,rgba(255,26,0,1)100%);background:-ms-linear-gradient(top,rgba(255,26,0,1)0%,rgba(255,26,0,1)100%);
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff1a00',endColorstr='#ff1a00',GradientType=0);background:linear-gradient(top,rgba(255,26,0,1)0%,rgba(255,26,0,1)100%);";

?>								
								
								
								
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

<h2><a name="Top"><?php _e( 'WP-Topbar - Version 1.4', 'wptb' ); ?></a></h2>
<div class="postbox">
<br>
Creates a TopBar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.  Live preview to see your TopBar from the Options page.
<p>Version 1.4 adds additional CSS options (margin). <strong>With this update, it may change how your TopBar looks if you were using a previous version.</strong></p>
<p>Version 1.3 adds navigation buttons and allows for more control over the custom CSS.  You can also now use single quotes in your text.</p>
Three new features with version 1.2:
<ol>
	<li>Set a background image, instead of a background color.  With a toggle to turn that on or off.  I've included a sample image for you to try on your website:  wp-topbar_sample_image.jpg.</li>
	<li>Set custom CSS for the message and the link text</li>
	<li>Set how to align the text:  left, center or right</li>
</ol>
<hr>
<p></p>
<center>

<a class="button" style=<?php echo $wptb_button_style ?> href="#MainOptions">Main Options</a>
&nbsp;&nbsp;
<a class="button" style=<?php echo $wptb_button_style ?> href="#CustomCss">Custom CSS</a>
&nbsp;&nbsp;
<a class="button" style=<?php echo $wptb_button_style ?> href="#ColorSelection">Color Selection</a>
&nbsp;&nbsp;
<a class="button" style=<?php echo $wptb_button_style ?> href="#TopbarText">TopBar Text</a>
&nbsp;&nbsp;
<a class="button" style=<?php echo $wptb_delete_style ?> href="#Uninstall">Delete Settings</a>
</center>
<p></p>
</div>
<div class="postbox">
<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="updated"><strong>TopBar is not enabled.</strong></div>', 'wptb' ); } ?>


<h3><?php _e( 'Preview', 'wptb' ); ?></h3>


<div class="inside">
	<p class="sub"><em><?php _e( 'This is how the TopBar will appear on the website. The fist black line represents the top of the screen.  The second black line represents the bottom of the TopBar', 'wptb' ); ?></em></p>

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
									
<h3><a name="MainOptions"><?php _e( 'Main Options', 'wptb' ); ?></a></h3>

<div class="inside">
	<div class="table">
		<table class="form-table">		
			<tr valign="top">
				<td width="150"><?php _e( 'Enable TopBar:', 'wptb' ); ?></label></td>
				<td>
					<label for="wptb_enable_topbar"><input type="radio" id="wptb_enable_topbar" name="wptbenabletopbar" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenabletopbar_no"><input type="radio" id="wptbenabletopbar_no" name="wptbenabletopbar" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>				
				</td>
				<td>
					<p class="sub"><em><?php _e( 'This allows you to turn off the TopBar without disabling the plugin.', 'wptb' ); ?></em></p>
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Start Delay:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbdelayintime" id="delayintime" size="30" value="<?php echo $wptbOptions['delay_time']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the amount of time (in milliseconds) for the tobar to appear.  Enter 0 for no delay.', 'wptb' ); ?></em></p>

				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Slide Time:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbslidetime" id="slidetime" size="30" value="<?php echo $wptbOptions['slide_time']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page.  Enter 0 for no delay.', 'wptb' ); ?></em></p>
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Bottom border height (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the height of the bottom of the border.  Default is 3px.', 'wptb' ); ?></em></p>
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Top padding (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbpaddingtop" id="paddingtop" size="5" value="<?php echo $wptbOptions['padding_top']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the top padding.  Default is 8px.', 'wptb' ); ?></em></p>
				</td>
			</tr>			
			<tr valign="top">
				<td width="150"><?php _e( 'Bottom padding (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbpaddingbottom" id="paddingbottom" size="5" value="<?php echo $wptbOptions['padding_bottom']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the bottom padding.  Default is 8px.', 'wptb' ); ?></em></p>
				</td>
			</tr>		
			<tr valign="top">
				<td width="150"><?php _e( 'Top margin (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbmargintop" id="margintop" size="5" value="<?php echo $wptbOptions['margin_top']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the top margin.  Default is 0px.', 'wptb' ); ?></em></p>
				</td>
			</tr>			
			<tr valign="top">
				<td width="150"><?php _e( 'Bottom margin (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbmarginbottom" id="marginbottom" size="5" value="<?php echo $wptbOptions['margin_bottom']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the bottom margin.  Default is 0px.', 'wptb' ); ?></em></p>
				</td>
			</tr>				
			<tr valign="top">
				<td width="150"><?php _e( 'Font size (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the font size.  Default is 14px.', 'wptb' ); ?></em></p>
				</td>
			</tr>	
			
			<tr valign="top">
				<td width="150"><?php _e( 'Text alignment:', 'wptb' ); ?></label></td>
				<td>
				<label for="wptb_text_align_left"><input type="radio" id="wptb_text_align_left" name="wptbtextalign" value="left" <?php if ($wptbOptions['text_align'] == "left") { _e('checked="checked"', "wptb"); }?>/> Left</label>		
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="wptb_text_align"><input type="radio" id="wptb_text_align" name="wptbtextalign" value="center" <?php if ($wptbOptions['text_align'] == "center") { _e('checked="checked"', "wptb"); }?> /> Center</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="wptb_text_align_right"><input type="radio" id="wptb_text_align_right" name="wptbtextalign" value="right" <?php if ($wptbOptions['text_align'] == "right") { _e('checked="checked"', "wptb"); }?>/> Right</label>	
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter how you want the text to align. Default is center. When using right -- try adding padding via the Custom CSS box. e.g. padding-right:10px;', 'wptb' ); ?></em></p>
				</td>
			</tr>	
			<tr valign="top">
				<td width="150"><?php _e( 'Page IDs:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbincludepages" id="includepages" size="30" value="<?php echo $wptbOptions['include_pages']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the IDs of the pages and posts that you want the TopBar to appear on, separated by commas. The TopBar will only be shown on those pages. Leave blank or enter 0 to show the TopBar on all pages.  e.g. 1,9,39,10', 'wptb' ); ?></em></p>
				</td>
			</tr>
		</table>
	</div>
	<table>
	<tr>
		<td style="valign:top; width:500px;"><p class="submit">
			<input type="submit" style=<?php echo $wptb_submit_style ?> name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
		</td>
		<td style="valign:top;">
			<input type="button" class="button" style=<?php echo $wptb_button_style ?> value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
		</td>
	</tr>
	</table>	<div class="clear"></div>	
	</div>
</div>



<div class="postbox">

<h3><a name="CustomCss"><?php _e( 'Custom CSS', 'wptb' ); ?></a></h3>
									
<div class="inside">
	<em><p class="sub"><?php _e( "Enter any custom CSS.  This allows you to add padding, font styles & more.  Be really careful here -- this could break your website!  Test this with multiple browsers to make sure it works across them all. Double-quotes are automatically replaced with single quotes.<p><strong>Don't forget the trailing semi-colon.</strong>", 'wptb' ); ?></p>
	<?php _e( "Create a custom CSS gradient at colorzilla.com:", 'wptb' );?>
	<a class="button" href="http://www.colorzilla.com/gradient-editor/" target="_blank">http://www.colorzilla.com/gradient-editor/</a>	
	<p class="sub"><?php _e( "Examples:<p>", 'wptb' ); ?></p>
	</em>	
	<table>
		<tr><td style="vertical-align:top">1.</td><td><?php _e( "text-transform:lowercase;", 'wptb' ); ?><p></p></td></tr>
		<tr><td style="vertical-align:top">2.</td><td><?php _e( "text-transform:uppercase;font-family:'georgia';padding-right:10px;", 'wptb' ); ?><p></p></td></tr>
		<tr><td style="vertical-align:top">3.</td><td><?php _e( "background: rgb(254,255,255);
background: -moz-linear-gradient(top, rgba(254,255,255,1) 0%, rgba(221,241,249,1) 35%, rgba(160,216,239,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,255,255,1)), color-stop(35%,rgba(221,241,249,1)), color-stop(100%,rgba(160,216,239,1)));
background: -webkit-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%);
background: -o-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%);
background: -ms-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#feffff', endColorstr='#a0d8ef',GradientType=0 );
background: linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%);", 'wptb' ); ?></td></tr>
	</table>	
	<div class="table">
		<table class="form-table">		
			<tr valign="top">
				<td width="150"><?php _e( 'For the Bar:', 'wptb' ); ?></label></td>
				<td>
					<textarea name="wptbcustomcssbar" id="customcssbar" rows="10" cols="100"><?php echo $wptbOptions['custom_css_bar']; ?></textarea>

				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'For the Text Message:', 'wptb' ); ?></label></td>
				<td>
					<textarea name="wptbcustomcsstext" id="customcsstext" rows="10" cols="100"><?php echo $wptbOptions['custom_css_text']; ?></textarea>
				</td>
			</tr>		
		</table>
	</div>
	<table>
	<tr>
		<td style="valign:top; width:500px;"><p class="submit">
			<input type="submit" style=<?php echo $wptb_submit_style ?> name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
		</td>
		<td style="valign:top;">
			<input type="button" class="button" style=<?php echo $wptb_button_style ?> value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
		</td>
	</tr>
	</table>
	<div class="clear"></div>	
	</div>
</div>



<div class="postbox">
									
<h3><a name="ColorSelection"><?php _e( 'Color Selection', 'wptb' ); ?></a></h3>

<div class="inside">
	<p class="sub"><em><?php _e( 'Click the color box to select the color to use.  Bar color is NOT used if Image is enabled (in the next section.)', 'wptb' ); ?></em></p>
	
	<div class="table">
		<table class="form-table">			
			<tr valign="top">
				<td width="200"><?php _e( 'Color of the Bar:', 'wptb' ); ?></label></td>
				<td>
				  <label for="barcolor"><input type="text" id="barcolor" name="wptbbarcolor" value="<?php echo $wptbOptions['bar_color']; ?>"></label>
			      <div id="wptb_colorpicker_bar"></div>		
				</td>
			</tr>
			<tr valign="top">
				<td width="200"><?php _e( 'Color of the bottom border of the Bar:', 'wptb' ); ?></label></td>
				<td>
			      <label for="bottomcolor"><input type="text" id="bottomcolor" name="wptbbottomcolor" value="<?php echo $wptbOptions['bottom_color']; ?>"></label>
			      <div id="wptb_colorpicker_bottom"></div>			
				</td>
			</tr>
			<tr valign="top">
				<td width="200"><?php _e( 'Color of the Message:', 'wptb' ); ?></label></td>
				<td>
				    <label for="textcolor"><input type="text" id="textcolor" name="wptbtextcolor" value="<?php echo $wptbOptions['text_color']; ?>"></label>
				    <div id="wptb_colorpicker_text"></div>				    
				</td>
			</tr>
			<tr valign="top">
				<td width="200"><?php _e( 'Color of the Link:', 'wptb' ); ?></label></td>
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
			<input type="submit" style=<?php echo $wptb_submit_style ?> name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
		</td>
		<td style="valign:top;">
			<input type="button" class="button" style=<?php echo $wptb_button_style ?> value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
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

  });
 
</script>



<div class="postbox">
									
<h3><a name="TopbarText"><?php _e( 'TopBar Text, Image and Link', 'wptb' ); ?></a></h3>
									
<div class="inside">
	<p class="sub"><em><?php _e( 'These are the text, image and links to be used in the TopBar. The image is placed first (if any), then the text (if any) is overlaid on it.  Scale the image to fix your website.  If you enable the image (by selecting "Yes"), then the image will be used and the bar color will be ignored.', 'wptb' ); ?></em></p>
	
	<div class="table">
		<table class="form-table">	
			<tr valign="top">
				<td width="150"><?php _e( 'Message:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbbartext" id="bbartext" size="85" value="<?php echo stripslashes_deep($wptbOptions['bar_text']); ?>" >
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Link Text:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptblinktext" id="linktext" size="85" value="<?php echo stripslashes_deep($wptbOptions['bar_link_text']); ?>" >
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Link:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptblink" id="link" size="100" value="<?php echo stripslashes_deep($wptbOptions['bar_link']); ?>" >
				</td>
			</tr>
			<tr valign="top">
				<td width="50"><?php _e( 'Enable image:', 'wptb' ); ?></label></td>
				<td width="50">
					<label for="wptb_enable_image"><input type="radio" id="wptb_enable_image" name="wptbenableimage" value="true" <?php if ($wptbOptions['enable_image'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenableimage_no"><input type="radio" id="wptbenableimage_no" name="wptbenableimage" value="false" <?php if ($wptbOptions['enable_image'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Image URL:', 'wptb' ); ?></th>
				<td><label for="wptbupload_image">
				<input id="wptbupload_image" type="text" size="85" name="wptbbarimage" value="<?php echo $wptbOptions['bar_image']; ?>" />
				<input class="button" id="wptbupload_image_button" type="button" value="Upload Image" />
				<br /><em><?php _e( 'Enter an URL or upload an image for the TopBar.'); ?></em)
				</label></td>
			</tr>
		</table>
	</div>
	<table>
	<tr>
		<td style="valign:top; width:500px;"><p class="submit">
			<input type="submit" style=<?php echo $wptb_submit_style ?> name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
		</td>
		<td style="valign:top;">
			<input type="button" class="button" style=<?php echo $wptb_button_style ?> value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
		</td>
	</tr>
	</table>
	
	<div class="clear"></div>	
	</div>
</div>



<div class="postbox">
						
<h3><a name="Uninstall"><?php _e( 'Delete Settings', 'wptb' ); ?></a></h3>
									
<div class="inside">
	<p class="sub"><em><?php _e( 'Click here to delete the plugin settings from the Wordpress database.  The next step is to uninstall the plugin from the Plugin menu.', 'wptb' ); ?></em></p>
	
	<table>
	<tr>
		<td style="valign:top; width:500px;"><p class="submit">
			<input type="submit" class="button" style=<?php echo $wptb_delete_style ?> name="delete_wptbSettings" value="<?php _e('Delete Settings', 'wptb') ?>" onClick="return confirm('Remove plugin settings from the database?');">

		</td>
		<td style="valign:top;">
			<input type="button" class="button" style=<?php echo $wptb_button_style ?> value="<?php _e('Back to Top', 'wptb') ?>" onClick="parent.location='#Top'">
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
	add_menu_page('WP TopBar', 'WP TopBar', 3, basename(__FILE__), array(&$wtpb_plugin, 'wptb_options_page'),plugins_url('/icon/icon.png', __FILE__));
		}
	}	
}


//Enqueue Farbtastics for the color pickers

function wptb_enqueue_scripts() {
	if (isset($_GET['page']) && $_GET['page'] == 'wp-topbar.php') {

  		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_register_script( 'wptb_upload', plugins_url('/wp-topbar-load-image.js', __FILE__), array('jquery','media-upload','thickbox') );
		wp_enqueue_script( 'wptb_upload') ;
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style('thickbox');

	}
}


//Puts javascript in the footer

function wptb_reveal_topbar() {
		
	$wptbOptions = get_option('wptbAdminOptions');
	if ($wptbOptions['enable_topbar'] == "false") { return; }

	 ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#wptbheadline').hide();
		jQuery('#wptbheadline').delay(<?php echo $wptbOptions['delay_time']; ?>);
		jQuery('#wptbheadline').css("visibility","visible");
		jQuery('#wptbheadline').slideDown(<?php echo $wptbOptions['slide_time']; ?>).fadeIn(1000);
		jQuery('#wptbheadline').show("slow");
    }); 

</script>

<?php }

//	add "Settings" link to plugin page
function wptb_plugin_action_links($links) {
	$wptb_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-topbar.php' ), __('Settings') );
	array_unshift($links, $wptb_settings_link);
	return $links;
}

// donate link on manage plugin page
//function wptb_plugin_donate_link($links, $file) {
//	if ($file == plugin_basename(__FILE__)) {
//		$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=dev@null.com">Donate</a>';
//		$links[] = $donate_link;
//	}
//	return $links;
//}

//Actions and Filters, if on plugin admin page	
if (isset($wtpb_plugin)) {
	//Actions
	add_action('admin_menu', 'wptb_options_panel');
	add_action('activate_wptb-plugin-series/wptb-plugin-series.php',  array(&$wtpb_plugin, 'init'));
	add_action('init', 'wptb_enqueue_scripts');
	//Filters
	add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'wptb_plugin_action_links');
//	add_filter('plugin_row_meta', 'wptb_plugin_donate_link', 10, 2);

	
}

//Actions and Filters, on all pages
if (isset($wtpb_plugin)) {
	add_action('wp_head', array(&$wtpb_plugin, 'wptb_addHeaderCode'), 1);
	add_action('wp_footer', 'wptb_reveal_topbar', 15);	
}



?>