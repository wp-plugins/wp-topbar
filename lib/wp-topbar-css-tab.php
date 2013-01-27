<?php 

/*
CSS Options Tab
*/



//=========================================================================			
// TopBar CSS Options
//=========================================================================			

function wptb_topbarcss_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	
	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In TopBar CSS Options</code>';

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
					<td width="150">A. For the Bar:<br>(i.e. for the &lt;p&gt; Tag on the TopBar)</label></td>
					<td>
						<textarea name="wptbcustomcssbar" id="customcssbar" rows="10" cols="100"><?php echo stripslashes($wptbOptions['custom_css_bar']); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<td width="150">B. For the Text Message:<br>(i.e. for the &lt;a&gt; Tag on the TopBar)</label></td>
					<td>
						<textarea name="wptbcustomcsstext" id="customcsstext" rows="10" cols="100"><?php echo stripslashes($wptbOptions['custom_css_text']); ?></textarea>
					</td>
				</tr>	
				<tr valign="top">
					<td width="150">C. For the entire TopBar:<br>(i.e. at the TopBar's &lt;DIV&gt;)</label></td>
					<td><p>Try this CSS to fix the TopBar to the top of the page:<p>				
					<code><?php _e( $div_css_sample_top , 'wptb' ); ?></code>
					<p>Or this to fix the TopBar to the bottom of the page:<p>
					<code><?php _e( $div_css_sample_bot , 'wptb' ); ?></code>
	
					<p><strong>Note that by putting your TopBar in a Fixed position, you will overlay the content of your website by the TopBar.</strong></p>
					<textarea name="wptbdivcss" id="divcss" rows="2" cols="100"><?php echo stripslashes($wptbOptions['div_css']); ?></textarea>
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





?>