=== Lightbox 2 ===
Contributors: Rupert Morris
Tags: AJAX, image, lightbox, photo, picture
Requires at least: 1.5
Tested up to: 2.9.1
Stable tag: 2.9.2

== Description ==

Used to overlay images on the current page. Lightbox JS v2.2 by Lokesh Dhakar ( http://www.huddletogether.com/projects/lightbox2/ ). Features 'auto-lightboxing' of image links, courtesy of Michael Tyson ( http://atastypixel.com ).

== Installation ==

To do a new installation of the plugin, please follow these steps

1. Download the zipped plugin file to your local machine.
2. Unzip the file.
3. Upload the `lightbox-2` folder to the `/wp-content/plugins/` directory.
4. Activate the plugin through the 'Plugins' menu in WordPress.
5. Optionally, go to the Options page and select a new Lightbox colour scheme.

To use, read http://www.stimuli.ca/lightbox/


If you have already installed the plugin

1. De-activate the plugin.
2. Download the latest files.
2. Follow the new installation steps.

Rupert Morris
rustyvespa@gmail.com
www.stimuli.ca/lightbox/

== Frequently Asked Questions ==

Q: Why doesn't it work for me?

A: Either:
    
1. You have changed the plugin folder's name to something other than "lightbox-2".

2. The problem is with your Wordpress theme, mangling image display properties. Use another theme, that doesn't interfere with posted images.

3. You have other plugins that conflict with Lightbox 2. Disable your other plugins and see if that helps. If it does, re-enable each plugin, one at a time to see which one is causing the conflict.

Q: It doesn't work properly in Browser X (Explorer 6, 7, etc)?

A: Yes it does. The problem is with your Wordpress theme, mangling image display properties. Use another theme, or hack your theme's Cascading Style Sheets (CSS). http://www.w3schools.com/css/

Q: I made my own Wordpress theme, or heavily hacked another one, and lightbox doesn't work at all, ever.

A: You forgot to include wp_header() in your header.php of your Wordpress theme. Be sure to look at the default theme, or other quality themes (eg: standards-compliant XHTML and CSS) to see how they work while hacking your own ;)

If you have read and tried the above, then, and ONLY then, I invite you to post your issues, in detail (include links) to my site. http://stimuli.ca/lightbox/
