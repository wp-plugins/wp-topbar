=== Plugin Name ===
Contributors: rfgoetz
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J
Tags: topbar, header bar,beforesite, heads up, fixed bar, link, heads up bar,attention, quick notice, bar, notification bar, popup, self promotion, toolbar, top of the page, plugin, important, message
Requires at least: 3.2.1
Tested up to: 3.3.1
Stable tag: 3.04

Creates a TopBar that will be shown at the top (or bottom) of your website.  Customizable and easy to change the color, text, image, link & more! 

== Description ==

Creates a TopBar that will be shown at the top (or bottom) of your website.  Customizable and easy to change the color, text, image, and link.  Live preview to see your TopBar from the Options page.

Version 3.04 adds the ability to allow the user to close the TopBar.

Version 3.02 adds the ability to set a start/end time for the TopBar to show.   It was re-worked to be smaller and faster.

Version 2.1 is a minor bug fix for when the TopBar is in the footer and you are trying to exclude pages.

Version 2.0 adds additional CSS options (Display Time) that allows you to make the TopBar disappear and the ability to exclude pages from showing the Topbar.

Various options allow you to:
<ol>
	<li>Enable/disable the TopBar without disabling the plugin.</li>
	<li>Place the TopBar Above the Header or Below the Footer</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to appear. Enter 0 for no delay.</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page. Enter 0 for no delay.</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to stay on the page.  Enter 0 for the TopBar to not disappear.</li>
	<li>Enter the height of the border. Default is 3px.</li>
	<li>Enter the top padding. Default is 8px.</li>
	<li>Enter the bottom padding. Default is 8px.</li>
	<li>Enter the top margin. Default is 0px.</li>
	<li>Enter the bottom margin. Default is 0px.</li>	
	<li>Enter the font size. Default is 14px.</li>
	<li>Align the text: left, center or right.  Default is Center.</li>
	<li>Enter the IDs of the pages and posts that you want the TopBar to appear on, separated by commas. The TopBar will only be shown on those pages. Leave blank or enter 0 to show the TopBar on all pages. e.g. 1,9,39,10</li>
	<li>Option to invert the Include Pages to actually be Exclude Pages</li>
</ol>
Set the color of the:
<ol>
	<li>The Bar</li>
	<li>The bottom border of the Bar</li>
	<li>The Message</li>
	<li>The Link</li>
</ol>
Enter custom CSS for the:
<ol>
	<li>The Bar</li>
	<li>The Message</li>
	<li>The Entire TopBar</li>
</ol>
Has separate fields for the:
<ol>
	<li>Message</li>
	<li>Link Text</li>
	<li>Link</li>
	<li>Link Target</li>
	<li>Background Image</li>
</ol>

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload all files in `wp-topbar.zip` to the `/wp-content/plugins/wp-topbar` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the options
4. Make sure to set "Enable" to yes to see the plugin on your website.

I've included a sample image for you to try on your website:  wp-topbar_sample_image.jpg.

== Frequently Asked Questions ==

= What CSS ID's are available? =

Use "#topbar"

= What if I fix the TopBar to the top or bottom of the page? = 

Use this CSS to fix the TopBar to the bottom of the page: 
	position:fixed; bottom: 0; padding: 0; margin: 0; width: 100%; z-index: 99999;

Or this to fix the TopBar to the top of the page (adjust the top value to be the height of your TopBar):
	position:fixed; top: 40; padding:0; margin:0; width: 100%; z-index: 99999;

Note that by putting your TopBar in a Fixed Position, you will overlay the content of your website by the TopBar.


= How to Find the Page ID = 

You can find the Page ID in the Edit Post or Edit Page URL. For example, the page ID for the following example is “1234.”

http://example.wordpress.com/wp-admin/page.php?action=edit&post=1234

= How do I test the TopBar? = 

To test the TopBar on your site, you can set the Page IDs (in General Options) to a single page (and not your home page.) Then go to that Page to see how the TopBar is working.

= Why does my TopBar look odd on Internet Explorer? = 

IE does not (yet) implement gradients like other browsers.  So, make sure you test your TopBar on all the major browswers.

= How dow I uninstall? = 

Scroll to the delete section or click the Delete Settings button at the top of the page.
Hit the Delete Settings Button. 
Click "OK" on the warning box.
Go to your Plugins page and delete the plugin or delete all the files in your `/wp-content/plugins/wp-topbar` directory 

== Upgrade Notice ==

= 3.04 = 

Version 3.04 fixes corrupts SVN files

= 3.03 = 

Version 3.03 allows users to close the TopBar

= 3.02 = 

Version 3.02 changed date/time picker to a GPL version to conform to Wordpress licensing

= 3.01 = 

Fixes bug in posting pages.

= 3.0 = 

Version 3.0 adds the ability to set a start/end time for the TopBar to show.  It was re-worked to be smaller and faster.

= 2.1 = 

Version 2.1 is a minor bug fix for when the TopBar is in the footer and you are trying to exclude pages.

= 2.0 = 

More options added -- should not change how your TopBar works since the new defaults are set to be how the TopBar previously operated.

= 1.5 = 

This version provides even more control over how the TopBar is placed. Test, Test Test it carefully on your beta site before upgrading.



== Screenshots ==

1. This is how it will look on your website.
2. Preview section.
3. Options section.
4. Custom CSS Options section.
5. The Color Selection and TopBar Text, Image & Link Options sections
6. The Close Button section - plus the uninstall option.

== Changelog ==

= 3.04 - 3/30/2012 = 

1. FIXED: Corrupt SVN files.

= 3.03 - 3/29/2012 = 

1. NEW: Allow users to close the TopBar
2. FIXED: Moved HTML out of HEAD tags and into the BODY tags

= 3.02 - 3/22/2012 = 

1. FIXED: Changed date/time picker to a GPL version to conform to Wordpress licensing

= 3.01 - 3/18/2012 = 

1. FIXED: Bug that caused wordpress post/pages not to load correctly

= 3.0 - 3/17/2012 = 

1. NEW: Added start/end times to limit when the TopBar shows.
2. FIXED: Updated deprecated functions
3. FIXED: Tightened code and made the code smaller 
4. FIXED: enqueues javascript, if necessary

= 2.1 - 12/30/2011 = 

1. FIXED: TopBar excludes PageIDs now work when TopBar is on footer pages.

= 2.0 - 12/26/2011 = 

1. NEW:Added option to make the TopBar disappear after a set amount of time.
2. NEW:Added copy buttons to copy code samples.
3. NEW:Added option to invert the Include Pages list to make it actually exclude pages.
4. FIXED:Cleaned up code to make it tighter.

= 1.5 - 12/23/2011 = 

1. FIXED: Moved TopBar to the Body instead of the Header and fixed missing close DIV.  That MAY break your site -- test carefully.
2. NEW:Adds additional Link option (target) which allows you to change how the link opens.
3. NEW:Added option to put TopBar at the footer. (Thanks, candace88, for the idea!)
4. NEW:Added and new DIV-level CSS. 

= 1.4 - 12/10/2011 = 

1. NEW:Added options to change the margin of the TopBar.
2. FIXED:Cleaned up the code.
3. Validated it works with 3.3.

= 1.3 - 12/05/2011 = 

1. NEW:Added easier navigation buttons.  Added more space to the CSS section.
2. NEW:Added code to allow you to use quotes in your text.
3. NEW:Added id="topbar" to the output.

= 1.2.1 - 10/08/2011 =

1. FIXED:Minor fix to allow settings page to display correctly.

= 1.2 - 10/08/2011 =

1. NEW:Add image background, custom css, and text alignment.

= 1.1 - 10/07/2011 =

1. FIXED:Cleaned up the code to make the TopBar be invisible upon first load.

= 1.0 - 9/25/2011 =

Initial public version

