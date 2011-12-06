=== Plugin Name ===
Contributors: rfgoetz
Donate link: N/A
Tags: topbar, header bar,beforesite, heads up, heads up bar,attention, quick notice, bar, notification bar, popup, self promotion, toolbar, top of the page, plugin, important, message
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 1.2.2

Creates a topbar that will be shown at the top of your website.  Customizable and easy to change the color, text, image, and link.  Live preview!

== Description ==

Creates a topbar that will be shown at the top of your website.  Customizable and easy to change the color, text, and link.  Live preview to see your topbar from the Options page.

Version 1.3 adds navigation buttons and allows for more control over the custom CSS.

Three new features with version 1.2:
<ol>
	<li>Set a background image, instead of a background color.  With a toggle to turn that on or off.  I've included a sample image for you to try on your website:  wp-topbar_sample_image.jpg.</li>
	<li>Set custom CSS for the message and the link text</li>
	<li>Set how to align the text:  left, center or right</li>
</ol>
Various options allow you to:
<ol>
	<li>Enable/disable the topbar without disabling the plugin.</li>
	<li>Enter the amount of time (in milliseconds) for the tobar to appear. Enter 0 for no delay.</li>
	<li>Enter the amount of time (in milliseconds) for the topbar to take to slide down on the page. Enter 0 for no delay.</li>
	<li>Enter the height of the border. Default is 3px.</li>
	<li>Enter the top padding. Default is 8px.</li>
	<li>Enter the bottom padding. Default is 8px.</li>
	<li>Enter the font size. Default is 14px.</li>
	<li>Align the text: left, center or right.  Default is Center.</li>
	<li>Enter the IDs of the pages and posts that you want the topbar to appear on, separated by commas. The topbar will only be shown on those pages. Leave blank or enter 0 to show the topbar on all pages. e.g. 1,9,39,10</li>
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
</ol>
Has separate fields for the:
<ol>
	<li>Message</li>
	<li>Link</li>
	<li>Link Text</li>
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

None yet

== Upgrade Notice ==

None

== Screenshots ==

1. This is how it will look on your website.
2. This is the full options page.
3. Preview section.
4. Options section.
5. Custom CSS Options section.
6. Topbar Text, Image & Link Options section - plus the uninstall option.

== Changelog ==

= 1.3  - 12/05/2011 = 

Added easier navigation buttons.  Added more space to the CSS section.

Added code to allow you to use quotes in your text.

Added <div id="topbar"> to the output.

You can try adding this to our CSS (thanks to douglaskarr): 

#topbar {
position:fixed;
top: 0;
padding: 0;
margin: 0;
width: 100%;
z-index: 99999;
}`

= 1.2.1  -  10/08/2011 =

Minor fix to allow settings page to display correctly.

= 1.2  -  10/08/2011 =

Add image background, custom css, and text alignment.

= 1.1  -  10/07/2011 =

Cleaned up the code to make the topbar be invisible upon first load.

= 1.0  -  9/25/2011 =

Initial public version

