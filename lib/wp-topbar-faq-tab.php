<?php 

/*
Plugin Name: WP-TopBar
FAQ Functions
*/


//=========================================================================			
// FAQ
//=========================================================================			

function wptb_faq_page($wptbOptions,$wptbShowLinks) {

	global 	$wptb_common_style, $wptb_button_style, $wptb_clear_style, $wptb_cssgradient_style, 
			$wptb_submit_style, $wptb_delete_style, $wptb_special_button_style;    

	$wptb_debug=get_transient( 'wptb_debug' );	

	if($wptb_debug)
		echo '<br><code>WP-TopBar Debug Mode: In FAQ</code>';
	?>
					
	<div class="postbox">
	<h3><a name="FAQ">WP-TopBar FAQ</a></h3>
	<div class="inside">		
	
	
	<ol type="square">

<li><strong>My TopBar is not working.  What should I do?</strong></li>
<p>Use the <a <?php if ( $wptbShowLinks ) echo 'href="?page=wp-topbar.php&action=debug&barid='.$wptbOptions['bar_id'].'"'; ?>>Debug tab</a> to see how the TopBar is being generated.</p>
<p>Check for any messages under the Live Preview heading on the Admin Page.  It will tell you if you have cookies or time settings that will prevent the TopBar from loading.
<p>You may have CSS settings that prevent the TopBar from loading.  If you entered any setting that are not valid, the TopBar will not load. Try deleting the settings and then re-entering your CSS until you find the one that is causing the issue.  Again, the <a <?php if ( $wptbShowLinks ) echo 'href="?page=wp-topbar.php&action=debug&barid='.$wptbOptions['bar_id'].'"'; ?>>Debug tab</a> can help you discover any issues.
<p>
<p>Finally, your Page IDs or Category selection may be preventing the TopBar from loading.  See how your settings are configured on the <a <?php if ( $wptbShowLinks ) echo 'href="?page=wp-topbar.php&action=control&barid='.$wptbOptions['bar_id'].'"'; ?>>Control tab</a>.
<p>
<li><strong>How do the new cookies (in version 3.04+) work behind the scenes?</strong></li>
<p>
If you allow the user to close the TopBar, then the plugin checks to see if you have enabled cookies.   If they are not enabled, it deletes any existing cookies.   If they are enabled, it looks to see if a cookie has been created.  A cookie is only created if the TopBar has been previously closed by the user.  If it finds a cookie and the cookie value matches the Cookie Value setting, it prevents the TopBar from showing.
<p>
If you change the Cookie Value to something new (<a <?php if ( $wptbShowLinks ) echo 'href="?page=wp-topbar.php&action=closebutton&barid='.$wptbOptions['bar_id'].'"'; ?>">on the Close Button tab</a>), the TopBar will show up again.  This is useful if you want to force the TopBar to show on new content.  Make sure to select something you haven't used before.  A good idea is to increment the value by one every time you want to force the TopBar to show.
<p>
<li><strong>What Social Button Icons are provided?</strong></li>
<p>
Look in this directory (<code><?PHP echo str_ireplace( 'https://','http://',plugins_url('/icon/', __FILE__) ) ?></code>) and you'll find two folders,  one with PNG files and one with a selection of PSD files.  Thanks to <a href="http://ElegantThemes.com" target="_blank">ElegantThemes.com</a> for providing the icon files!
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
To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page) and select Include/Exclude Logic to be "Page IDs". Then go to that Page to see how the TopBar is working.
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