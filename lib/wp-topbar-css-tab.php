<?php 

/*
CSS & HTML Options Tab
*/



//=========================================================================			
// TopBar CSS & HTML Options
//=========================================================================			

function wptb_topbarcss_options($wptbOptions) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '</br><code>WP-TopBar Debug Mode: wptb_topbarcss_options() for ID: '.$wptbOptions[ 'bar_id' ].'</code>';

	?>
	
	<div class="postbox">
	<h3><a name="topbarcss">TopBar CSS & HTML</a></h3>
	<div class="inside">
		<em><p class="sub">Enter any custom CSS and HTML for the TopBar.  This allows you to add padding, font styles & more.  Be really careful here -- this could break your website!  Test this with multiple browsers to make sure it works across them all. Double-quotes are automatically replaced with single quotes.<p><strong>Don't forget the trailing semi-colon.</strong></p>
		Create a custom CSS gradient at colorzilla.com:
		<a class="button" style="<?php _e( $wptb_cssgradient_style , 'wptb' ); ?>" href="http://www.colorzilla.com/gradient-editor/" target="_blank">http://www.colorzilla.com/gradient-editor/</a>	
		</p>
		</em>
		<em><p><strong>How these options work:</strong>
		</br>
		The TopBar is displayed within it's own <em>div</em> containers:
		</br>
		<p style="padding-left:5em">
		&lt;div id="topbar" style="<strong>CSS Option C</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option C</strong>&gt;</br>
		&nbsp;&nbsp;&nbsp;&lt;div id="wptbheadline1" style="<strong>CSS Option A</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option A</strong>&gt;Your TopBar Text Goes Here</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a style="<strong>CSS Option B</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option B</strong>&lt;/a&gt;</br>
		&nbsp;&nbsp;&nbsp;&lt;/div&gt;</br>
		&lt;/div&gt;</br></p>
		</em>	
		</br>You have separate fields to enter your custom CSS and HTML below:
	</div>
	</div>
	<div class="postbox">
	<div class="inside">
		<p class="sub">
		<div class="table">
			<table class="form-table">		
				<tr valign="top">
					<td width="150"><strong>CSS Option A</strong></br>For the Bar/Background Image:</br>(i.e. for the second &lt;DIV&gt; Tag for the TopBar)</td>
					<td>
						<strong>Examples:</strong></br>
						1. To make all text lowercase:&nbsp;&nbsp;&nbsp;<textarea rows="1" cols="50" style="background-color:lightyellow;">text-transform:lowercase;</textarea></br>
						2. To make all text uppercase using the Georgia Font:&nbsp;&nbsp;&nbsp;<textarea rows="1" cols="50" style="background-color:lightyellow;">text-transform:uppercase;font-family:'georgia';padding-right:10px;</textarea></br>
						3. To add a gradient bar:&nbsp;&nbsp;&nbsp;<textarea rows="9" cols="120" style="background-color:lightyellow;">background: rgb(109,179,242);
background: -moz-linear-gradient(top,  rgba(109,179,242,1) 0%, rgba(84,163,238,1) 50%, rgba(54,144,240,1) 51%, rgba(30,105,222,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(109,179,242,1)), color-stop(50%,rgba(84,163,238,1)), color-stop(51%,rgba(54,144,240,1)), color-stop(100%,rgba(30,105,222,1)));
background: -webkit-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
background: -o-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
background: -ms-linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
background: linear-gradient(top,  rgba(109,179,242,1) 0%,rgba(84,163,238,1) 50%,rgba(54,144,240,1) 51%,rgba(30,105,222,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6db3f2', endColorstr='#1e69de',GradientType=0 );</textarea></br>
						4. To made the TopBar partially opaque:&nbsp;&nbsp;&nbsp;<textarea rows="1" cols="60" style="background-color:lightyellow;">background: transparent filter: alpha(opacity=90); opacity: 0.9;</textarea></br>
						5. To not repeat Background Image, make the TopBar 100px high & vertically center the text in the TopBar:&nbsp;&nbsp;&nbsp;<textarea rows="2" cols="60" style="background-color:lightyellow;">background-repeat:no-repeat; height:100px; line-height:100px; vertical-align:middle;</textarea></br></br>
						<strong>Enter CSS Option A Here:</strong></br>
						<textarea name="wptbcustomcssbar" id="customcssbar" rows="10" cols="100"><?php echo stripslashes($wptbOptions['custom_css_bar']); ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150"><strong>CSS Option B</strong></br>For the Text Message:</br>(i.e. for the &lt;a&gt; Tag on the TopBar)</td>
					<td>
						<strong>Enter CSS Option B Here:</strong></br>
						<textarea name="wptbcustomcsstext" id="customcsstext" rows="10" cols="100"><?php echo stripslashes($wptbOptions['custom_css_text']); ?></textarea>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150"><strong>CSS Option C</strong></br>For the entire TopBar:</br>(i.e. at the TopBar's &lt;DIV&gt;)</td>
					<td><p>Use this CSS to fix the TopBar to the top of the page and <strong>OVERLAY</strong> the contents of the page:<p>				
					<textarea rows="1" cols="80" style="background-color:lightyellow;">position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</textarea>
					<p>Or this CSS to fix the TopBar to the top of the page and <strong>PUSH</strong> the contents down:<p>				
					<textarea rows="1" cols="80" style="background-color:lightyellow;">top: 40; padding:0; margin:0; width: 100%; z-index: 99999;</textarea>
					<p>Or this to fix the TopBar to the bottom of the page:<p>
					<textarea rows="1" cols="80" style="background-color:lightyellow;">position:fixed; bottom: 0; padding:0; margin:0; width: 100%; z-index: 99999;</textarea>
	
					<p><strong>Note that by putting your TopBar in a Fixed position, you will overlay the content of your website by the TopBar.</strong></p>
					<strong>Enter CSS Option C Here:</strong></br>
					<textarea name="wptbdivcss" id="divcss" rows="10" cols="100"><?php echo stripslashes($wptbOptions['div_css']); ?></textarea>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2">
					    <br/>Enter your custom HTML below.  Note you <strong>MUST</strong> use only double quotes ("); do <strong>NOT</strong> use single quotes (') for they will break the TopBar:<br/>
						<em><p><strong>How these options work:</strong>
						</br>
						The TopBar is displayed within it's own <em>div</em> containers:
						</br>
						<p style="padding-left:5em">
						&lt;div id="topbar" style="<strong>CSS Option C</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option C</strong>&gt;</br>
						&nbsp;&nbsp;&nbsp;&lt;div id="wptbheadline1" style="<strong>CSS Option A</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option A</strong>&gt;Your TopBar Text Goes Here</br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a style="<strong>CSS Option B</strong>"&nbsp;&nbsp;&nbsp;<strong>HTML Option B</strong>&lt;/a&gt;</br>
						&nbsp;&nbsp;&nbsp;&lt;/div&gt;</br>
						&lt;/div&gt;</br></p>
						</em>	
				</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150"><strong>HTML Option A</strong></br>For the Bar/Background Image:</br>(i.e. for the second &lt;DIV&gt; Tag on the TopBar)</td>
					<td><p>Use this add custom HTML to the second DIV tag for the TopBar:
					<p><strong>Example:</strong></p><p>			
					<textarea rows="1" cols="80" style="background-color:lightyellow;">name="mytopbarname"</textarea>
					</p>
					<strong>Enter HTML Option A Here:</strong></br>
					<textarea name="wptbbarcustomhtml" id="htmla" rows="5" cols="100"><?php echo stripslashes($wptbOptions['bar_custom_html']); ?></textarea>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150"><strong>HTML Option B</strong></br>For the Link:</br>(i.e. for the &lt;a&gt; Tag on the TopBar)</td>
					<td><p>Use this add custom HTML to the link tag (&lt;a&gt;):
					<p><strong>Example:</strong></p><p>	
					<textarea rows="1" cols="80" style="background-color:lightyellow;">rel="lightbox"</textarea>
					</p>
					<strong>Enter HTML Option B Here:</strong></br>
					<textarea name="wptblinkcustomhtml" id="htmlb" rows="5" cols="100"><?php echo stripslashes($wptbOptions['bar_link_custom_html']); ?></textarea>
					</td>
				</tr>	
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr valign="top">
					<td width="150"><strong>HTML Option C</strong></br>For the entire TopBar:</br>(i.e. at the TopBar's &lt;DIV&gt;)</td>
					<td><p>Use this add custom HTML to the main DIV tag for the TopBar:
					<p><strong>Example:</strong></p><p>
					This will trigger the <em>onmouseover</em> DOM event and execute custom JavaScript code.  That code needs to be loaded by your theme or another method.</p><p>			
					<textarea rows="1" cols="80" style="background-color:lightyellow;">onmouseover="YourCustomJavaScriptCode"</textarea>
					</p>
					<strong>Enter HTML Option C Here:</strong></br>
					<textarea name="wptbdivcustomhtml" id="htmlc" rows="5" cols="100"><?php echo stripslashes($wptbOptions['div_custom_html']); ?></textarea>
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