<?php
/*
Plugin Name: WP-Topbar
Plugin URI: http://wordpress.org/extend/plugins/wp-topbar/
Description:  Creates a topbar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.
Version: 1.0
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
		
		//Returns an array of admin options
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
				'slide_time' => '2000',
				'font_size' => '14',
				'padding_top' => '8',
				'padding_bottom' => '8',
				'bar_link' => 'http://wordpress.org', 
				'bar_text' => 'Text Message: ',
				'bar_link_text' => 'Link Text');
			$wptbOptions = get_option($this->adminOptionsName);
			if (!empty($wptbOptions)) {
				foreach ($wptbOptions as $key => $option)
					$wptbAdminOptions[$key] = $option;
			}				
			update_option($this->adminOptionsName, $wptbAdminOptions);
			return $wptbAdminOptions;
		}

		//Puts the Top Bar above the Header

		function wptb_addHeaderCode() {
		
			global $wp_query;
			$wptbOptions = $this->getWPTBPluginOptions();						

			if ($wptbOptions['enable_topbar'] == "false") { return; }

			$thePostID = $wp_query->post->ID;	

			if ( ! in_array( $thePostID, explode( ',', $wptbOptions['include_pages'] ) ) && ! in_array( 0, explode( ',', $wptbOptions['include_pages'] ) ) )
					{ return; }
							
		?>
<div id="wptbheadline" class="wptbdelay">
<p style="text-align:center;font-size: <?php echo $wptbOptions['font_size']; ?>px; padding-top:<?php echo $wptbOptions['padding_top']; ?>px; padding-bottom:<?php echo $wptbOptions['padding_bottom']; ?>px; background:<?php echo $wptbOptions['bar_color']; ?>; color:<?php echo $wptbOptions['text_color']; ?> ;display:block; border-bottom-color:<?php echo $wptbOptions['bottom_color']; ?>; border-bottom-style: solid; border-bottom-width:  <?php echo $wptbOptions['bottom_border_height']; ?>px;"><?php echo $wptbOptions['bar_text']; ?><a style="color:<?php echo $wptbOptions['link_color']; ?>" title="<?php echo $wptbOptions['bar_link_text']; ?>"href="<?php echo $wptbOptions['bar_link']; ?>"target="_blank">
 <?php echo $wptbOptions['bar_link_text']; ?></a></p>
</div>
			<?php	
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
								$wptbOptions['font_size'] = 0;
							} 
							else 	
								$wptbOptions['font_size'] = $_POST['wptbfontsize']+0;
						}						
						if (isset($_POST['wptbpaddingtop'])) {
						
							if (!is_numeric($_POST['wptbpaddingtop'])) {
    							echo '<div class="updated"><strong>Top padding is not numeric. Resetting to 8px.</strong></div>';
								$wptbOptions['padding_top'] = 0;
							} 
							else 	
								$wptbOptions['padding_top'] = $_POST['wptbpaddingtop']+0;
						}
						if (isset($_POST['wptbpaddingbottom'])) {
						
							if (!is_numeric($_POST['wptbpaddingbottom'])) {
    							echo '<div class="updated"><strong>Bottom padding is not numeric. Resetting to 8px.</strong></div>';
								$wptbOptions['padding_bottom'] = 0;
							} 
							else 	
								$wptbOptions['padding_bottom'] = $_POST['wptbpaddingbottom']+0;
						}						
						if (isset($_POST['wptblink'])) {
							$wptbOptions['bar_link'] = $_POST['wptblink'];
						}	
						if (isset($_POST['wptbbartext'])) {
							$wptbOptions['bar_text'] = $_POST['wptbbartext'];
						}
						if (isset($_POST['wptbbartext'])) {
							$wptbOptions['bar_link_text'] = $_POST['wptblinktext'];
						}
						update_option($this->adminOptionsName, $wptbOptions);
						
						?>
<div class="updated"><p><strong><?php _e("Settings Updated.", "wptb");?></strong></p></div>
					<?php
					} 
					if (isset($_POST['delete_wptbSettings'])) { 

						delete_option($this->adminOptionsName);
						$wptbOptions = array(
							'enable_topbar' => 'false',
							'text_color' => '#000000',
							'bar_color' => '#ffffff',
							'bottom_color' => '#f90000',
							'link_color' => '#c00000',
							'bottom_border_height' => '3',  
							'include_pages' => '0',
							'delay_time' => '5000',
							'slide_time' => '2000',
							'font_size' => '14',
							'padding_top' => '8',
							'padding_bottom' => '8',
							'bar_link' => 'http://wordpress.org', 
							'bar_text' => 'Text Message: ',
							'bar_link_text' => 'Link Text');
						?>
<div class="updated"><p><strong><?php _e("Settings Deleted.", "wptb");?></strong></p></div>
					<?php
					} ?>
					
				
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

<h2><?php _e( 'WP-Topbar', 'wptb' ); ?></h2>
<div class="postbox">
<?php if ($wptbOptions['enable_topbar'] == "false") { _e( '<div class="updated"><strong>Topbar is not enabled.</strong></div>', 'wptb' ); } ?>

<h3><?php _e( 'Preview', 'wptb' ); ?></h3>


<div class="inside">
	<p class="sub"><em><?php _e( 'This is how the topbar will appear on the website.', 'wptb' ); ?></em></p>

	<div class="table">
		<table class="form-table">
			
			<tr valign="top">
<p style="text-align:center;font-size: <?php echo $wptbOptions['font_size']; ?>px; padding-top:<?php echo $wptbOptions['padding_top']; ?>px; padding-bottom:<?php echo $wptbOptions['padding_bottom']; ?>px; background:<?php echo $wptbOptions['bar_color']; ?>; color:<?php echo $wptbOptions['text_color']; ?> ;display:block; border-bottom-color:<?php echo $wptbOptions['bottom_color']; ?>; border-bottom-style: solid; border-bottom-width:  <?php echo $wptbOptions['bottom_border_height']; ?>px;"><?php echo $wptbOptions['bar_text']; ?><a style="color:<?php echo $wptbOptions['link_color']; ?>" title="<?php echo $wptbOptions['bar_link_text']; ?>"href="<?php echo $wptbOptions['bar_link']; ?>"target="_blank">
 <?php echo $wptbOptions['bar_link_text']; ?></a></p>
 
 
 				</td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>	
	</div>
</div>

<div class="postbox">
									
<h3><?php _e( 'Options', 'wptb' ); ?></h3>

<div class="inside">
	<div class="table">
		<table class="form-table">		
			<tr valign="top">
				<td width="150"><?php _e( 'Enable topbar:', 'wptb' ); ?></label></td>
				<td>
					<label for="wptb_enable_topbar"><input type="radio" id="wptb_enable_topbar" name="wptbenabletopbar" value="true" <?php if ($wptbOptions['enable_topbar'] == "true") { _e('checked="checked"', "wptb"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="wptbenabletopbar_no"><input type="radio" id="wptbenabletopbar_no" name="wptbenabletopbar" value="false" <?php if ($wptbOptions['enable_topbar'] == "false") { _e('checked="checked"', "wptb"); }?>/> No</label>				
				</td>
				<td>
					<p class="sub"><em><?php _e( 'This allows you to turn off the topbar without disabling the plugin.', 'wptb' ); ?></em></p>
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
						<p class="sub"><em><?php _e( 'Enter the amount of time (in milliseconds) for the topbar to take to slide down on the page.  Enter 0 for no delay.', 'wptb' ); ?></em></p>
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Bottom border height (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbbottomborderheight" id="bottomborderheight" size="5" value="<?php echo $wptbOptions['bottom_border_height']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the height of the border.  Default is 3px.', 'wptb' ); ?></em></p>
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
				<td width="150"><?php _e( 'Font size (px):', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbfontsize" id="fontsize" size="5" value="<?php echo $wptbOptions['font_size']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the font size.  Default is 14px.', 'wptb' ); ?></em></p>
				</td>
			</tr>			
			<tr valign="top">
				<td width="150"><?php _e( 'Page IDs:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbincludepages" id="includepages" size="30" value="<?php echo $wptbOptions['include_pages']; ?>" >
				</td>
				<td>
						<p class="sub"><em><?php _e( 'Enter the IDs of the pages and posts that you want the topbar to appear on, separated by commas. The topbar will only be shown on those pages. Leave blank or enter 0 to show the topbar on all pages.  e.g. 1,9,39,10', 'wptb' ); ?></em></p>
				</td>
			</tr>
		</table>
	</div>
	<p class="submit">
		<input type="submit" name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
	</p>
	<div class="clear"></div>	
	</div>
</div>


<div class="postbox">
									
<h3><?php _e( 'Color Selection', 'wptb' ); ?></h3>

<div class="inside">
	<p class="sub"><em><?php _e( 'Click the color box to select the color to use.', 'wptb' ); ?></em></p>
	
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
	<p class="submit">
		<input type="submit" name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
	</p>
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
									
<h3><?php _e( 'Topbar Text and Link', 'wptb' ); ?></h3>

<div class="inside">
	<p class="sub"><em><?php _e( 'These are the text and links to be used in the topbar.', 'wptb' ); ?></em></p>
	
	<div class="table">
		<table class="form-table">	
			<tr valign="top">
				<td width="150"><?php _e( 'Message:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptbbartext" id="bbartext" size="85" value="<?php echo $wptbOptions['bar_text']; ?>" >

				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Link:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptblink" id="link" size="100" value="<?php echo $wptbOptions['bar_link']; ?>" >
				</td>
			</tr>
			<tr valign="top">
				<td width="150"><?php _e( 'Link Text:', 'wptb' ); ?></label></td>
				<td>
					<input type="text" name="wptblinktext" id="link" size="100" value="<?php echo $wptbOptions['bar_link_text']; ?>" >
				</td>
			</tr>
		</table>
	</div>
	<p class="submit">
		<input type="submit" name="update_wptbSettings" value="<?php _e('Update Settings', 'wptb') ?>" />
	</p>
	<div class="clear"></div>	
	</div>
</div>
<div class="postbox">
									
<h3><?php _e( 'Uninstall', 'wptb' ); ?></h3>

<div class="inside">
	<p class="sub"><em><?php _e( 'Click here to delete the options from the wordpress database.  The next step is to uninstall the Plugin from the Plugin menu.', 'wptb' ); ?></em></p>
	
	
	<p class="submit">
		<input type="submit" name="delete_wptbSettings" value="<?php _e('Delete Settings', 'wptb') ?>" />
	</p>
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
	add_menu_page('WP Topbar', 'WP Topbar', 3, basename(__FILE__), array(&$wtpb_plugin, 'wptb_options_page'),plugins_url('/icon/icon.png', __FILE__));
		}
	}	
}


//Enqueue Farbtastics for the color pickers

function wptb_enqueue_scripts() {
  		wp_enqueue_style( 'farbtastic' );
  		wp_enqueue_script( 'farbtastic' );
}

//Puts javascript in the footer
function wptb_style() {
		
	$wptbOptions = get_option('wptbAdminOptions');
	if ($wptbOptions['enable_topbar'] == "false") { return; }

	 ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.wptbdelay').hide();
		jQuery('.wptbdelay').delay(<?php echo $wptbOptions['delay_time']; ?>).slideDown(<?php echo $wptbOptions['slide_time']; ?>).fadeIn(1000);
    }); 

</script>

<?php }

//	add "Settings" link to plugin page
function wptb_plugin_action_links($links) {
	$wptb_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-topbar.php' ), __('Settings') );
	array_unshift($links, $wptb_settings_link);
	return $links;
}


//Actions and Filters	
if (isset($wtpb_plugin)) {
	//Actions
	add_action('admin_menu', 'wptb_options_panel');
	add_action('wp_head', array(&$wtpb_plugin, 'wptb_addHeaderCode'), 1);
	add_action('activate_wptb-plugin-series/wptb-plugin-series.php',  array(&$wtpb_plugin, 'init'));
	add_action('init', 'wptb_enqueue_scripts');
	add_action('wp_footer', 'wptb_style', 15);	
	//Filters
	add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'wptb_plugin_action_links');

}
?>