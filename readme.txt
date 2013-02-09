=== Plugin Name ===
Contributors: rfgoetz
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YQQURY7VW2B2J
Tags: topbar, header bar,beforesite, heads up, fixed bar, link, heads up bar,attention, quick notice, bar, notification bar, popup, self promotion, toolbar, top of the page, plugin, important, message
Requires at least: 3.2.1
Tested up to: 3.5.1
Stable tag: 4.13

Create MULTIPLE TopBars that will be shown at the top of your website.  TopBars are selected by a variety of options - includes schedules! 

== Description ==

Create **MULTIPLE** (Whohoo!) TopBars that will be shown at the top (or bottom) of your website.  TopBars are randomly selected based on the criteria you select, including start time, stop time and more.  You can provide a weighting to skew selected TopBars to show up more often.  We made this so customizable and easy to change the color, text, image, link that you can easily lose track of time getting your TopBars perfect!

Version 4.10+ now statically creates the TopBar to allow you to take advantage of caching plugins.

**Superduper major re-write with Version 4.0.**  Refactored all the functions to use its own database table instead of WordPress options.  This allows you to create an unlimited number of TopBars.  This version is leaner, faster, smarter.   Quick links are added throughout to make editing your TopBars a breeze.

Want to see how this TopBar looks?   You can test how your TopBars show up to allow you to adjusting the selection factors on the fly.  You can even get a sampling of how 10 pageviews would render the TopBar -- *great for A/B testing*.

Want to create a lot of TopBars -- you can copy the existing ones with just a few clicks.   Know SQL?  You can even export the TopBars in three different formats (JSON, CSV or SQL).    Sorry, **no support** is given if you import directly to the database.

With so many option pages, I only included a few screen images.  More images can be found on [Zwebify.com](http://zwebify.com/wordpress-plugins/)

Hey! What happens if you were using a previous version of WP-TopBar?  We've got you covered!  Your old TopBar will be imported into the new database as the first TopBar.

Here is a crazy-long list of options you have for each TopBar -- and this is not even complete!

<ol>
	<li>Enable/disable the TopBar without disabling the plugin.</li>
	<li>Place the TopBar Above the Header or Below the Footer</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to appear. Enter 0 for no delay.</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to take to slide down on the page. Enter 0 for no delay.</li>
	<li>Enter the amount of time (in milliseconds) for the TopBar to stay on the page.  Enter 0 for the TopBar to not disappear.</li>
	<li>Pick the date/time for the TopBar to start showing.</li>
	<li>Pick the date/time for the TopBar to stop showing. Of course, it must be after the start time. Select 0 for the TopBar to never disappear.</li>
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
Has separate fields for the:
<ol>
	<li>Message</li>
	<li>Link Text</li>
	<li>Link</li>
	<li>Link Target</li>
	<li>Background Image</li>
</ol>
Enter custom CSS for the:
<ol>
	<li>The Bar</li>
	<li>The Message</li>
	<li>The Entire TopBar</li>
</ol>
Set the color of the:
<ol>
	<li>The Bar</li>
	<li>The bottom border of the Bar</li>
	<li>The Message</li>
	<li>The Link</li>
</ol>
Add a Close Button

Add up to four Social Icon buttons

Has explicit support for qTranslate -- translates the top bar text fields and link field.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload all files in `wp-topbar.zip` to the `/wp-content/plugins/wp-topbar` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the options
4. Make sure to set "Enable" to yes to see the plugin on your website.

I've included a sample image for you to try on your website:  wp-topbar_sample_image.jpg.

== Frequently Asked Questions ==

= My TopBar is not working. What should I do? =
Check for any messages under the Live Preview heading on the Admin Page. It will tell you if you have cookies or time settings that will prevent the TopBar from loading.

You may have CSS settings that prevent the TopBar from loading. If you entered any setting that are not valid, the TopBar will not load. Try deleting the settings and then re-entering your CSS until you find the one that is causing the issue.

You can also use the Debug page to see if you can see an error.

= How do the new Include/Exclude login (in version 3.10) work behind the scenes? = 

You have four choices to handle include (or exclude) the TopBar from showing:
 Page ID - this only checks the current page's ID against the list you entered.
 Category ID - this only checks the current category IDs against the list you entered.  The criteria is satisfied if any of the page's category IDs match what you entered.  We only check the default "category" taxonomy.
 Both - both the Page ID and Category criteria must match for the TopBar to show
 Either - either the Page ID or Category criteria need to match for the TopBar to show
 
The default is to check by PageId.


= How do the new cookies (in version 3.04) work behind the scenes? = 

If you allow the user to close the TopBar, then the plugin checks to see if you have enabled cookies.   If they are not enabled, it deletes any existing cookies.   If they are enabled, it looks to see if a cookie has been created.  A cookie is only created if the TopBar has been previously closed by the user.  If it finds a cookie, it prevents the TopBar from showing.

If you change the Cookie Value to something new, the TopBar will show up again.  This is useful if you want to force the TopBar to show on new content.  Make sure to select something you haven't used before.  A good idea is to increment the value by one every time you want to force the TopBar to show.

With Version 4.00+, all TopBars must share the same cookie settings for this to work. You can set the TopBars to be the same by using the new Close Button tab on the main page

= How does the Priority field (in version 4.00+) work? =

The Plugin randomly selects a valid TopBar to show using this field to skew how they are selected. The TopBar multiplies a random number (between 0 and 1) with the TopBar's Priority value (which is a number between 1 to 100). A higher number means this TopBar will be selected more frequently; a lower number means less frequently. 

= How so I delete a TopBar? =

On the All Tables view, select the TopBars via the Check Box and selete the "Delete" function from the Bulk Actions drop down list.

= How are TopBars selected to show? =

See the Priority question above to see how they are selected. The TopBar will select only those TopBars that are valid per the date/time criteria. Once a TopBar is selected to show, it then goes through the Control Options. That checks to see if the TopBar should be shown on the Home Page (or not) and which Page IDs or Category IDs the TopBar should show (or not).

The Final check is to see if the TopBar has cookie controls (see above). If the user is allowed to close the TopBar and cookies are enabled, then we look for a cookie. If one is found, and it matches the cookie value, then the TopBar is not shown.

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

To test the TopBar on your site, you can set the Page IDs (in Main Options) to a single page (and not your home page) and select Include/Exclude Logic to be "Page IDs". Then go to that Page to see how the TopBar is working.

= Why does my TopBar look odd on Internet Explorer? = 

IE does not (yet) implement gradients like other browsers.  So, make sure you test your TopBar on all the major browswers.

= How dow I uninstall? = 

Go to the Delete Settings tab and then click the Delete Settings button at the top of the page.
Hit the Delete Settings Button. 
Click "OK" on the warning box.
Go to your Plugins page and delete the plugin or delete all the files in your `/wp-content/plugins/wp-topbar` directory 

== Upgrade Notice ==


= 4.13 = 

Changed to use Wordpress' embedded jQuery UI & new Color Picker (on WP 3.5+), cleaned up CSS Options Page and other fixes

= 4.12 = 

Fixed issues that sometimes causes the plugin to not activate correctly

= 4.11 = 

Version 4.11 supports WordPress 3.5.1, updates jQuery UI to latest version, and fixes minor bugs

= 4.10 = 

Version 4.10 supports WordPress 3.5, fixes several defects, and now supports caching

= 4.03 = 

Version 4.03 supports WordPress 3.4.2, adds security features, and fixes a few bugs.

= 4.02 = 

Version 4.02 adds warning to update settings after upgrade and fixes a defect

= 4.01 = 

Version 4.01 add explicit support for the qtranslate plugin and a tab to bulk change all Close Button settings

= 4.00 = 

Version 4.00 Converted to using database to store MULTIPLE (yahoo!) TopBars.  Refactored to be leaner, faster, and smarter.  Your old TopBar will be imported into the new database.

= 3.10 = 

Version 3.10 supports Wordpress 3.4 and adds the capability to restrict the TopBar from showing by category.   You can also explicitly manage how it shows up on the Home Page.   Moved Control logic to its own options page.

= 3.09 = 

Version 3.09 fixed for use with multisite (network) and added submenus to the Admin bar.

= 3.08 = 

Version 3.08 changes how special characters are handles in the user defined CSS/text fields.

= 3.07 = 

Version 3.07 changes how the way jQuery is called to better support more installations.

= 3.06 = 

Version 3.06 adds the ability to add Social Icons to the TopBar.  

= 3.05 = 

Version 3.05 has a new admin page and fixes a few errors.  

= 3.04 = 

Version 3.04 fixes corrupts SVN files

= 3.03 = 

Version 3.03 allows users to close the TopBar

= 3.02 = 

Version 3.02 changed date/time picker to a GPL version to conform to Wordpress licensing

= 3.01 = 

Fixes bug in posting pages.

= 3.00 = 

Version 3.0 adds the ability to set a start/end time for the TopBar to show.  It was re-worked to be smaller and faster.

= 2.1 = 

Version 2.1 is a minor bug fix for when the TopBar is in the footer and you are trying to exclude pages.

= 2.0 = 

More options added -- should not change how your TopBar works since the new defaults are set to be how the TopBar previously operated.

= 1.5 = 

This version provides even more control over how the TopBar is placed. Test, Test Test it carefully on your beta site before upgrading.



== Screenshots ==

1. This is how it will look on your website
2. All TopBars Screen
3. Test Priority Screen
4. Export Options Screen
5. Main Options Screen for a single TopBar


== Changelog ==

= 4.13 - 02/9/2013 =

1. CHANGED: Changed to use Wordpress' embedded jQueryUI
2. CHANGED: Updated Color Picker from farbtastic to the new WordPress 3.5 Color Picker if using Wordpress 3.5+
3. UPDATED: timepicker.js updated to version 1.2 (future proof for jQueryUI 1.10 compatability) - http://trentrichardson.com/examples/timepicker/
4. CHANGED: CSS Options page changed to try to make it clearer how the various CSS options work
5. CHANGED: Removed URL check on the TopBar link so that qtranslate will process the link correctly
6. FIXED:   Minor display of error messages that check the div_css field

= 4.12 - 01/28/2013 =

1. FIXED: Issue that sometimes causes the plugin to not activate correctly.  Finally found it by using the Bitnami Wordpress Stack [http://bitnami.org/stack/wordpress]
2. FIXED: Plugin deletion messages
3. CHANGED: Removed the option to delete a TopBar from Options pages. Use the All Tables view and Delete using the Bulk Actions drop down list

= 4.11 - 01/26/2013 =

1. VALIDATED: Version 4.11 supports WordPress 3.5.1
2. UPDATED: jQuery UI to version 1.9.2
3. FIXED: Streamlined JavaScript when only one TopBar is selected
4. FIXED: Logic when no TopBars are selected

= 4.10 - 12/10/2012 =

1. VALIDATED: Version 4.10 supports WordPress 3.5
2. FIXED: Several defects found in 3.5 testing
3. NEW: Now supports caching plugins by generating HTML for all possible TopBars and using JavaScript to randomly select a TopBar

= 4.03 - 9/10/2012 =

1. VALIDATED: Version 4.04 supports Wordpress 3.4.2
2. NEW: Adds security features (nonces) to the admin pages (Thanks to Blake Entrekin)
3. FIXED: how the CSS for the link is rendered
4. FIXED: enable/disable social buttons work again

= 4.02 - 8/31/2012 =

1. NEW: Adds warning to update settings after upgrade
2. FIXED:  missing php closing tags

= 4.01 - 7/04/2012 =

1. NEW: Adds explicit support for the qtranslate plugin
2. FIX: No longer calls exception when the user has not set a default topbar
3. ADDED: Tab on main page to allow you to bulk set the Close Button settings
4. FIX: WordPress Export Functions -- workaround for core defect?

= 4.00 - 7/01/2012 = 

1. NEW: Version 4.0 Converted to using database to store MULTIPLE (yahoo!) TopBars.  Refactored to be leaner, faster, and smarter.  Your old TopBar will be imported into the new database.

= 3.10 - 6/05/2012 = 

1. VALIDATED: Version 3.10 supports Wordpress 3.4
2. FIXED: Removed PSD icons files to make plugin smaller to install
3. NEW: Adds the capability to restrict the TopBar from showing by category
4. NEW: You can also excplicity manage how it shows up on the Home Page
5. NEW: Moved Page ID and new Category ID/Home Page control logic to its own options page
6. CHANGED:  The labels and descriptions on the options page for selecting the Page ID include/exclude logic. 
 
= 3.09 - 4/26/2012 = 

1. NEW: Added submenus to the Admin bar.
2. FIXED: Code to support multisite (network) installs.

= 3.08 - 4/18/2012 = 

1. FIXED: Added more discrete handling of special characters if Magic Quotes is turned on in PHP.  So now can handle quote marks.

= 3.07 - 4/05/2012 = 

1. FIXED: Version 3.07 changes how jQuery is enqueued to better support more themes.

= 3.06 - 4/04/2012 = 

1. NEW: Version 3.06 adds the ability to add Social Icons to the TopBar.  
2. NEW: Added Debug page

= 3.05 - 3/31/2012 = 

1. FIXED: javascript error if "footer" is chosen as placement of TopBar
2. NEW: Redesigned admin page

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
3. VALIDATED: Version 1.4 supports Wordpress 3.3

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

Initial version

