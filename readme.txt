=== EU Cookie Law ===
Contributors: alexmoss, Milmor, pleer, ShaneJones
Version:	2.5.6
Stable tag:	2.5.6
Author:		Alex Moss, Marco Milesi, Peadig, Shane Jones
Author URI:   https://profiles.wordpress.org/milmor/
Tags: eu cookie, cookies, law, analytics, european, italia, garante, privacy, eu cookie law, italy, cookie, consent, europe
Requires at least: 3.8
Tested up to: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

EU Cookie Law informs users that your site uses cookies, with option to lock scripts before consent. Light + Customizable style.

== Description ==

EU Cookie Law is a **light, elegant and powerful** solution that allows your website to comply the european cookie law by informing users that your site has cookies, with a popup for more information and option to lock scripts before acceptance (as required by  **Italian Law - Garante della Privacy** dispositions).

You can customise the style to perfectly fit your website and you have many options to control cookies behaviour after and before acceptance.

https://www.youtube.com/watch?v=6f2qxC3GZJ8

Demo: [www.sanpellegrinoterme.gov.it](http://www.sanpellegrinoterme.gov.it)

= Features =
* **Customizable banner**
* Option for consent by scrolling
* Option for acceptance if user continues navigation
* Set cookie expiry
* Fully **responsive** for tablets and smartphones
* Set banner position
* Compatible with **mobile** themes and plugins 
* Compatible with **multilanguage** plugins
* Certified for **WPML**
* 2-layer cookie prevention
* Works with Disqus

= Advanced Features =
* Block scripts if cookies are not accepted
* **Automatic block of iframes, embeds, scripts and objects**
* Complete set of developer Shortcodes and PHP Functions
* Manual and **Automatic** set width and height of blocked content

Simply install the plugin and follow the instructions on the Settings page.

= Cookie block =
You can lock cookies using `[cookie]` and `[/cookie]` shortcodes in every post, page and widget. You can use php functions too:
`if ( function_exists('cookie_accepted') && cookie_accepted() ) {
    // Your code
}`

**More Shortcodes & PHP Functions are available [in our faqs](//wordpress.org/plugins/eu-cookie-law/faq/).**

> EU Cookie Law started from [Peadig](http://peadig.com/wordpress-plugins/eu-cookie-law/) in 2012 and in june 2015 has became part of [WPGov.it](http://www.wpgov.it) that aims to give Italian Public Government powerful open source solutions for websites.

= Included Languages =

* English (default)
* Italian (it_IT)
* Dutch (nl_NL) - [Gerard Weijer](http://gerardweijer.nl)

If you want to help out, we have included the .pot file in /language folder.
You can send them to milesimarco@outlook.com

= Contributions =

* Italian community [Porte Aperte sul Web](http://www.porteapertesulweb.it) for beta-testing and ideas.
* This plugin was originally developed by [Peadig](http://peadig.com/wordpress-plugins/eu-cookie-law/).


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `eu-cookie-law` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the EU Cookie settings page
4. Go through the steps and hit update!

== Frequently Asked Questions ==

= Shortcodes available =

You can lock parts of code in posts, pages and widget with these shortcode:
`[cookie] ... [/cookie]`
Parameters:
`[cookie height="100px" width="100%" text="Hi <b>WordPress</b>"] //My code [/cookie]`

To display a box (in pages/posts) with ability to revoke consent (if cookies accepted) or accept cookies (if not done yet):
`[cookie-control]`

You can also create your own link that revokes cookie consent. Just append **?nocookie=1** to your url.
Ex. wordpress.org/**?nocookie=1** or wordpress.org/something/**?nocookie=1**

= PHP Functions available =
You can easily verify if cookies consent has been set with:
`if ( function_exists('cookie_accepted') && cookie_accepted() ) {
    // Your code
}`
However this will only hide wrapped code. If you want to display an info box, in php you have:
`generate_cookie_notice($height, $width);
generate_cookie_notice_text($height, $width, $text);

if ( function_exists('cookie_accepted') && cookie_accepted() ) {
    // Your code
} else {
	generate_cookie_notice($height, $width);
}`
(if you omit `$text` then the default one will be used)

Please note that **cookie_accepted** returns true if Eu Cookie Law plugin is set to disabled in settings panel.

If you think that we should provide more shortcodes, functions, or enhance what we already provide, please let us know in [our forum](https://wordpress.org/support/plugin/eu-cookie-law).

= Auto block (sperimental*) =
The plugin offers an exclusive function that allows you to block **iframes, embeds, objects and scripts** in posts, pages and widgets. This can be activated in the plugin options panel because is disabled by default.

If you want to exclude a page from being filtered, you can set custom post field name **eucookielaw_exclude** to **1**. To do this, enable "Custom Fields" in "Screen Options". Then in the "Custom Fields" box enter the name, the value, and hit "Add Custom Field".

= Cache =
We are working to get the plugin fully compatible with most cache plugins.
At the moment using a cache service could create conflicts with the plugin.

**WP Super Cache** (sperimental*): open the file wp-content/advanced-cache.php and add the following immediately after <?php opening:
`if ( !isset( $_COOKIE['euCookie'] ) ){ return; }`

So that you have:
`<?php
if ( !isset( $_COOKIE['euCookie'] ) ){ return; }
# WP SUPER CACHE 1.2
function wpcache_broken_message() {`

* = some features in this page are marked with "sperimental". It means that we are testing these functions. We highly suggest you to check this page regularly if you are using one of these.

== Screenshots ==

1. Banner example - [www.icscarpa.it](http://www.icscarpa.gov.it)
2. Autoblock feature (no consent) - [www.comune.carassai.ap.it](http://www.comune.carassai.ap.it)
3. Autoblock feature (no consent) - [www.sanpellegrinoterme.gov.it](http://www.sanpellegrinoterme.gov.it)
4. Autoblock feature (cookies accepted) - [www.sanpellegrinoterme.gov.it](http://www.sanpellegrinoterme.gov.it)
5. Banner example
6. Autoblock feature (iframe, embed, Google Maps, Disqus,...)
7. `[cookie-control]` shortcode
8. Options screen
9. Fully customizable

== Changelog ==

= 2.5.6 20.07.2015 =
* Improved translation system
* Improved compatibility with WPML
* Fixed some missing strings in admin panel
* Added es_ES, fr_FR, de_DE translation files (blank)

= 2.5.5 19.07.2015 =
* Added Dutch (nl_NL) by [Gerard Weijer](http://gerardweijer.nl)

= 2.5.4 17.07.2015 =
* Minor changes
* Added WP Super Cache tips in faqs (sperimental)
* Added Revoke Consent Link in faqs
* Improved faqs
* New banner

= 2.5.3 15.07.2015 =
* Improved navigation consent (now it doesn't reload the page)
* Improved performance (load twice faster than 2.5.2)
* Added parameter to allow you to create links to revoke cookie consent (sperimental)

= 2.5.2 05.07.2015 =
* Improved autoblock

= 2.5.1 03.07.2015 =
* Compatible with **WPML**
* Better AutoBlock function (Disqus block included!)
* Now scripts block doesn't generate the message (limited for iframe, object and embed)		
* Minor changes			

= 2.5 24.06.2015 =
* Removed acceptance on scroll while in cookie page
* Added Continue Navigation acceptance (beta)
* Added Multisite Support (beta)

= 2.4.2 11.06.2015 =
* Fixed occasional wrong date when setting cookies

= 2.4.1 10.06.2015 =
* Solved a conflict with "Register Plus Redux"
* Minor changes

= 2.4 09.06.2015 =
* Added `<objects>` to auto block feature
* Added ability to exclude pages from auto block feature (see our faqs) (beta)
* Added option to consider scrolling as acceptation (disabled by default)
* Improved style.css
* Remove inline javascript in favor of WordPress enqueue

= 2.3.1 08.06.2015 =
* Removed "hours" in expiration (it caused bugs with internationalizationation).
* **Please re-save the field. It will be considered as "days" while calculating expiration date of cookie.**

= 2.3 08.06.2015 =
* **Added automatic block of iframes, embeds, scripts** (beta)
* **Added** option to enable/disable tinymce button
* Performance improvements
* Minor changes

= 2.2.2 08.06.2015 =
* **Fixed** conflict with the_content filter

= 2.2.1 08.06.2015 =
* **Fixed** expire date bug
* **Fixed** shortcodes in widgets
* Minor improvements 

= 2.2 05.06.2015 =
* **Added** customization options (ex. background+font color)
* Added multilanguage support
* Added italian language
* Better UI for options panel
* Minor bugfixes

= 2.1.1 + 2.1.2 04.06.2015 =
* Fixed shortcodes in `[cookie]...[/cookie]` not being correctly rendered
* Best tinymce icon with windowmanager
* New and enhanced developer functions

= 2.1 03.06.2015 =
* Added option to link directly to a page instead of popup
* Added ability to change default cookie-lock message
* Added `[cookie-control]` shortcode
* Minor changes + bugfixes

= 2.0.3 + 2.0.4 + 2.0.5 - 03.06.2015 =
* Fixed cookie storing caused by wrong iso date
* Better css for small screens
* Fixed jquery enqueue 

= 2.0 + 2.0.1 + 2.0.2 - 02.06.2015 =
* Plugin reload

= 1.2 =
* Fixed cookie storing bug in Firefox

= 1.1 =
* Fixed cookie storing bug
* Added in CSS support for IE