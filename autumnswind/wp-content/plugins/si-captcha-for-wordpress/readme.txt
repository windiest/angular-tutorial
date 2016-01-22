=== SI CAPTCHA Anti-Spam ===
Contributors: Mike Challis
Author URI: http://www.642weather.com/weather/scripts.php
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KXJWLPPWZG83S
Tags: akismet, captcha, comment, comments, login, anti-spam, spam, security, multilingual, buddypress, wpmu, wordpressmu
Requires at least: 2.9
Tested up to: 3.3
Stable tag: trunk

Adds CAPTCHA anti-spam methods to WordPress on the forms for comments, registration, lost password, login, or all. For WP, WPMU, and BuddyPress.

== Description ==

Adds CAPTCHA anti-spam methods to WordPress forms for comments, registration, lost password, login, or all.
In order to post comments or register, users will have to type in the code shown on the image.
This prevents spam from automated bots. Adds security. Works great with Akismet. Also is fully WP, WPMU, and BuddyPress compatible.

= Help Keep This Plugin Free =

If you find this plugin useful to you, please consider [__making a small donation__](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KXJWLPPWZG83S) to help contribute to my time invested and to further development. Thanks for your kind support! - [__Mike Challis__](http://profiles.wordpress.org/users/MikeChallis/)


Features:
--------
 * Configure from Admin panel
 * Valid HTML
 * Section 508 and WAI Accessibility Validation.
 * Allows Trackbacks and Pingbacks.
 * Setting to hide the CAPTCHA from logged in users and or admins
 * Setting to show the CAPTCHA on the forms for comments, registration, lost password, login, or all.
 * I18n language translation support. [See FAQ](http://wordpress.org/extend/plugins/si-captcha-for-wordpress/faq/).

Captcha Image Support:
---------------------
 * Open-source free PHP CAPTCHA library by www.phpcaptcha.org is included (customized version)
 * Abstract background with multi colored, angled, and transparent text
 * Arched lines through text
 * Refresh button to reload captcha if you cannot read it

Requirements/Restrictions:
-------------------------
 * Works with Wordpress 2.9+, WPMU, and BuddyPress (Wordpress 3.0+ is highly recommended)
 * PHP5 is highly recommended



== Installation ==

1. Install automatically through the `Plugins`, `Add New` menu in WordPress, or upload the `si-captcha-for-wordpress` folder to the `/wp-content/plugins/` directory.

2. Activate the plugin through the `Plugins` menu in WordPress

3. Updates are automatic. Click on "Upgrade Automatically" if prompted from the admin menu. If you ever have to manually upgrade, simply deactivate, uninstall, and repeat the installation steps with the new version. 



1. This is how to install SI Captcha globally on WPMU or BuddyPress:

2. Step 1: upload the `/si-captcha-for-wordpress/` folder and all it's contents to `/mu-plugins/`

3. Step 2: MOVE the si-captcha.php from the `/si-captcha-for-wordpress/` folder to the `/mu-plugins/` folder.

4. Site wide Settings are located in "Site Admin", "SI CAPTCHA Optioins" 



== Screenshots ==

1. screenshot-1.gif is the captcha on the comment form.

2. screenshot-2.gif is the captcha on the registration form.

3. screenshot-3.gif is the `Captcha options` tab on the `Admin Plugins` page.


== Configuration ==

After the plugin is activated, you can configure it by selecting the `SI Captcha options` tab on the `Admin Plugins` page.


== Usage ==

Once activated, a captcha image and captcha code entry is added to the comment and register forms. The Login form captcha is not enabled by default because it might be annoying to users. Only enable it if you are having spam problems related to bots automatically logging in.


== Frequently Asked Questions ==


= Troubleshooting if the CAPTCHA form fields and image is not being shown: =

Do this as a test:
Activate the SI CAPTCHA plugin. In Admin, click on Appearance, Themes. 
Temporarily change your theme to the "WordPress Default" theme (default for WP2), or "Twenty Ten" (default for WP3). 
It does not cause any harm to temporarily change the theme and change back. Does it work properly now?
If it does then the theme you are using is the cause. 

Missing CAPTCHA image and input field on comment form?
You may have a theme that has a not properly coded comments.php

When diagnosing missing CAPTCHA field on comment form....
The version of WP makes a difference...

(WP2 series) Your theme must have a `<?php do_action('comment_form', $post->ID); ?>` tag inside your `/wp-content/themes/[your_theme]/comments.php` file. 
Most WP2 themes already do. The best place to locate the tag is before the comment textarea, you may want to move it up if it is below the comment textarea.

(WP3 series) Since WP3 there is new function comment_form inside `/wp-includes/comment-template.php`. 
Your is theme probably not up to current code to call that function from inside comments.php.
WP3 theme does not need the `do_action('comment_form'`... code line inside `/wp-content/themes/[your_theme]/comments.php`.
Instead, it uses a new function call inside comments.php: `<?php comment_form(); ?>`
If you have WP3 and still have the missing captcha, make sure your theme has `<?php comment_form(); ?>`
inside `/wp-content/themes/[your_theme]/comments.php`. (look inside the Twenty Ten theme's comments.php for proper example)


= Troubleshooting if the CAPTCHA image itself is not being shown: =

By default, the admin will not see the CAPTCHA. If you click "log out", go look and it will be there.

If the image is broken and you have the CAPTCHA entry box:

This can happen if a server has folder permission problem, or the WordPress address (URL)
or Blog address (URL) are set incorrectly in WP settings: Admin,  Settings,  General

[See FAQ page on fixing this problem](http://www.fastsecurecontactform.com/captcha-image-not-showing-si-captcha-anti-spam)

This script can be used to test if your PHP installation will support the CAPTCHA:
Click on the "Test if your PHP installation will support the CAPTCHA" link on the Options page.
or open this URL in your web browser to run the test:
`/wp-content/plugins/si-captcha-for-wordpress/captcha/test/index.php`

= Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the WP2 comment form. =

WP2.0 themes must have a `<?php do_action('comment_form', $post->ID); ?>` tag inside the `/wp-content/themes/[your_theme]/comments.php` file. Most WP2 themes do.
The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea.
This tag is exactly where the captcha image and captcha code entry will display on the form, so
move the line to before the comment textarea, uncheck the 'Comment Form Rearrange' box on the 'Captcha options' page,
and the problem should be fixed. (WP3 with a WP3 proper theme will not have this problem)

= Alternate Fix for the captcha image display order =

You can just check the 'Comment Form Rearrange' box on the admin plugins 'Captcha options' page and javascript will attempt to rearrange it for you. Editing the comments.php, moving the tag, and uncheck the 'Comment Form Rearrange' box on the 'SI Captcha options' page is the best solution.(WP3 with a WP3 theme will not have this problem)

= Why is it better to uncheck the 'Comment Form Rearrange' box and move the tag? =
Because the XHTML will no longer validate if it is checked.

= Why do I get "ERROR: Could not read CAPTCHA cookie. Make sure you have cookies enabled and not blocking in your web browser settings. Or another plugin is conflicting."? =

Check your web browser settings and make sure you are not blocking cookies for your blog domain. Cookies have to be enabled in your web browser and not blocked for the blog web domain.


The Cookie Test can be used to test if your browser is accepting cookies from your site:
Click on the "Test if your PHP installation will support the CAPTCHA" link on the Options page.
or open this URL in your web browser to run the test: `/wp-content/plugins/si-captcha-for-wordpress/captcha/test/index.php`

= The CAPTCHA refresh button does not work =

Your theme could be missing the wp_footer PHP tag. Your theme should be considered broken if the wp_footer PHP tag is missing.

All WordPress themes should always have `<?php wp_footer(); ?>` PHP tag just before the closing `</body>` tag of your theme's footer.php, or you will break many plugins which generally use this hook to reference JavaScript files. The solution – edit your theme's footer.php and make sure this tag is there. If it is missing, add it. Next, be sure to test that the CAPTCHA refresh button works, if it does not work and you have performed this step correctly, you could have some other cause.

= Spammers have been able to bypass my CAPTCHA, what can I do? =

First check this: make sure the only other security plugins you have are Akismet or WP-spamFree. 
Akismet and WP-spamFree are the only other anti-spam plugins approved for use with SI CAPTCHA Anti-Spam, others can simply break the CAPTCHA validation so that the CAPTCHA is never checked.
If another security plugin is combined(not Akismet or WP-spamFree), the captcha may not work. Be sure to always test the CAPTCHA after installing new plugins. 

Sometimes your site becomes targeted by a spammer that uses a combination of a bot and human captcha solver. [See this help forum for a solution](http://wordpress.org/support/topic/plugin-si-captcha-for-wordpress-spammers-bypassed-captcha-registration-system?replies=13#post-2023124)

= How han I change the color of the CAPTCHA input field on the comment form? =
If you need to learn how to adjust the captcha input form colors, [See this FAQ](http://www.fastsecurecontactform.com/si-captcha-comment-form-css)


= Is this plugin available in other languages? =

Yes. To use a translated version, you need to obtain or make the language file for it. 
At this point it would be useful to read [Installing WordPress in Your Language](http://codex.wordpress.org/Installing_WordPress_in_Your_Language "Installing WordPress in Your Language") from the Codex.
You will need an .mo file for this plugin that corresponds with the "WPLANG" setting in your wp-config.php file.
Translations are listed below -- if a translation for your language is available, all you need to do is place it in the `/wp-content/plugins/si-captcha-for-wordpress/languages` directory of your WordPress installation.
If one is not available, and you also speak good English, please consider doing a translation yourself (see the next question).


The following translations are included in the download zip file:

* Albanian (sq_AL) - Translated by [Romeo Shuka](http://www.romeolab.com)
* Arabic (ar) - Translated by [Amine Roukh](http://amine27.zici.fr/)
* Belorussian (by_BY) - Translated by [Marcis Gasuns](http://www.comfi.com/)
* Chinese (zh_CN) - Translated by [Awu](http://www.awuit.cn/) 
* Czech (cs_CZ) - Translated by [Radovan](http://algymsa.cz)
* Danish (da_DK) - Translated by [Parry](http://www.detheltnyestore.dk/)
* Dutch (nl_NL) - Translated by [Robert Jan Lamers](http://www.salek.nl/)
* French (fr_FR) - Translated by [Pierre Sudarovich](http://pierre.sudarovich.free.fr/)
* German (de_DE) - Translated by [Sebastian Kreideweiss](http://sebastian.kreideweiss.info/)
* Greek (el) - Translated by [Ioannis](http://www.jbaron.gr/)
* Hungarian (hu_HU) - Translated by [Vil]
* Indonesian (id_ID) - Translated by [Masino Sinaga](http://www.openscriptsolution.com)
* Italian (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")
* Japanese (ja) - Translated by [Chestnut](http://staff.blog.bng.net/)
* Norwegian (nb_NO) - Translated by [Roger Sylte](http://roger.inro.net/)
* Polish (pl_PL) - Translated by [Tomasz](http://www.ziolczynski.pl/)
* Portuguese Brazil (pt_BR) - Translated by [Newton Dan Faoro]
* Portuguese Portugal (pt_PT) - Translated by [PL Monteiro](http://thepatientcapacitor.com/)
* Romanian (ro_RO) - Translated by [Laszlo SZOKE](http://www.naturaumana.ro)
* Russian (ru_RU) - Translated by [Neponyatka](http://www.free-lance.ru/users/neponyatka)
* Serbian (sr_SR) - Translated by [Milan Dinic]
* Slovakian (sk_SK) - Translated by [Marek Chochol]
* Spanish (en_ES) - Translated by [zinedine](http://www.informacioniphone.com/)
* Swedish (sv_SE) - Translated by [Benct]
* Traditional Chinese, Taiwan Language (zh_TW) - Translated by [Cjh]
* Turkish (tr_TR) - Translated by [Volkan](http://www.kirpininyeri.com/)
* More are needed... Please help translate.


= Can I provide a new translation? =

Yes, It will be very gratefully received. 
Please read [How to translate SI Captcha Anti-Spam for WordPress](http://www.fastsecurecontactform.com/translate-si-captcha-anti-spam) 

= Can I update a translation? =

Yes, It will be very gratefully received. 
Please read [How to update a translation of SI Captcha Anti-Spam for WordPress](http://www.fastsecurecontactform.com/update-translation-si-captcha-anti-spam) 


== Changelog ==

- Updated Dutch language (nl_NL)  - Translated by [Paul Backus](http://backups.nl/)
- Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 2.7.5 =
- (07 Dec 2011) - WP 3.3 compatibility fix for wp_enqueue_script was called incorrectly.
- Remove more leftover audio code.
- CAPTCHA code cache file performance improvement.

= 2.7.4 =
- (18 Jul 2011) - Fixed bug in CAPTCHA code reset reported by USSliberty, please update now for better spam protection.
- Fix CAPTCHA position on some themes like Suffusion.

= 2.7.3 =
- (05 Jul 2011) - Tested / fixed to be compatible with WP 3.2
- Fixed to be compatible with SFC Comments plugin.
- Fixed error: Undefined variable: securimage_url 
- CAPTCHA audio feature removed.
- Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 2.7.2 =
- (02 Jun 2011) - CAPTCHA Audio feature is disabled by Mike Challis until further notice because a proof of concept code CAPTCHA solving exploit was released - Security Advisory - SOS-11-007. CAPTCHA image is not involved.
- Fix javascript error when CAPTCHA audio is disabled.
- Fixed missing width/height attributes for CAPTCHA images.

= 2.7.1 =
- (26 Apr 2011) - Fix for users of the MU domain mapping plugin.

= 2.7 =
- (19 Feb 2011) - Modified the setting "CAPTCHA input label position on the comment form:" with more options for input and label positions for matching themes.
- Added new setting in the "Text Labels:" to allow you to change the required field indicator. The default is " *", but you can now change it to "(required)" or anything you want. 
- Added lost password CAPTCHA
- Fixed Valid HTML for BuddyPress
- Fixed sidebar logon for BuddyPress

= 2.6.5 =
- (12 Feb 2011) - New feature: New settings for "Internal Style Sheet CSS" or "External Style Sheet CSS". If you need to learn how to adjust the captcha form colors, [See FAQ](http://www.fastsecurecontactform.com/si-captcha-comment-form-css)
- Fix: one CAPTCHA random position always has to be a number so that a 4 letter swear word could never appear. 
- Improvement: javascript is only loaded on pages when it is conditionally needed.
- Updated Romanian (ro_RO) - Translated by [Anunturi Jibo](http://www.jibo.ro)
- Requires at least WordPress: 2.9

= 2.6.4 =
- (19 Jan 2011) - Added more settings for setting CAPTCHA input field and label CAPTCHA input field CSS. These settings can be used to adjust the CAPTCHA input field to match your theme. [See FAQ Page](http://www.fastsecurecontactform.com/si-captcha-comment-form-css)
- Added new setting: "CAPTCHA input label position on the comment form:" Changes position of the CAPTCHA input labels on the comment form. Some themes have different label positions on the comment form. On suffusion, set it to "right".
- Added Portuguese Portugal (pt_PT) - Translated by [PL Monteiro](http://thepatientcapacitor.com/)
- Added Serbian (sr_SR) - Translated by [Milan Dinic]
- Updated Spanish (en_ES) - Translated by [zinedine](http://www.informacioniphone.com/)
- Updated Romanian (ro_RO) - Translated by [Anunturi Jibo](http://www.jibo.ro/)

= 2.6.3.2 =
- (17 Dec 2010) - Rename CAPTCHA font files all lower case.
- Small changes to admin page.

= 2.6.3.1 =
- (19 Nov 2010) - Fixed WP 3.0 multi-site admin settings page 404 (hopefully).
- Updated Japanese

= 2.6.3 =
- (28 Sep 2010) - Improved transparent audio and refresh images for the CAPTCHA
- Added Japanese (ja) - Translated by [Chestnut](http://staff.blog.bng.net/)
- Added Persian Iran (fa_IR) - Translated by [najeekurd](http://www.najeekurd.net/)

= 2.6.2 =
- (19 Aug 2010) - Fixed error "WP_Error as array" recorded in error log when on register page. 
- Added Akismet spam prevention status to the contact form settings page, so you can know if Akismet is protecting or not.
- Added automatic SSL support for the CAPTCHA URL.
- Added download count and star rating on admin options page. 
- cleaned up options page.

= 2.6.1 =
- (11 Aug 2010) - Fixed critical error that broke comment replies from admin menu with "CAPTCHA ERROR".

= 2.6 =
- (09 Aug 2010) - PHP Sessions are no longer required for the CAPTCHA. The new method uses temporary files to store the CAPTCHA codes until validation. PHP sessions can still be reactivated by unchecking the setting: "Use CAPTCHA without PHP session".
- Added rel="nofollow" tag to CAPTCHA Audio and CAPTCHA Refresh links.
- Removed CAPTCHA WAV sound files, included mp3 ones take up 500k less space.
- Improved the CAPTCHA test page. 
- Added captcha-temp directory permission check to alert the admin if there is a problem. This check is on the admin settings page, the captcha test page, and when posting the captcha.
- Added more help notes to the admin settings page.

= 2.5.4 =
- (25 Jul 2010) - Added compatibility for WP 3.0 feature: "multisite user or blog marked as spammer".
- Fixed rare problem on some servers, CAPTCHA image had missing letters.

= 2.5.3 =
- (23 Jun 2010) - Fix placement of CAPTCHA on comment form.

= 2.5.2 =
- (15 May 2010) - Made WP3 Compatible.

= 2.5.1 =
- (11 May 2010) - Added option to disable audio.
- Fixed file path issue when installed in mu-plugins folder
- Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 2.5 =
- (23 Apr 2010) - Updated for latest version of buddypress 1.2.3 compatibility.
- Added setting to make the CAPTCHA image smaller.
- Fixed so multiple forms can be on the same page. 
- Split code into 2 smaller files for better performance.
- Updated Danish (da_DK) 

= 2.2.9 =
- (16 Feb 2010) - Fixed XMLRPC logins did not work when "Enable CAPTCHA on the login form" was enabled.

= 2.2.8 =
- (14 Jan 2010) - Added Dutch (nl_NL) - Translated by [Robert Jan Lamers](http://www.salek.nl/)

= 2.2.7 =
- (31 Dec 2009) - New setting for a few people who had problems with the text transparency "Disable CAPTCHA transparent text (only if captcha text is missing on the image, try this)". 
- Added Slovakian (sk_SK) - Translated by [Marek Chochol]
- Updated Arabic (ar) - Translated by [Amine Roukh](http://amine27.zici.fr/)

= 2.2.6 =
- (16 Dec 2009) - Added SSL compatibility.
- Added Hungarian (hu_HU) - Translated by [Vil]

= 2.2.5 =
- (06 Dec 2009) - More improvements for CAPTCHA images and fonts.

= 2.2.4 =
- (30 Nov 2009) - Fix blank CAPTCHA text issue some users were having.
- Added CAPTCHA difficulty level setting on the settings page (Low, Medium, Or High).
- Added Indonesian (id_ID) - Translated by [Masino Sinaga](http://www.openscriptsolution.com).
- Added Romanian (ro_RO) - Translated by [Laszlo SZOKE](http://www.naturaumana.ro).

= 2.2.3 =
- (23 Nov 2009) - Fix completely broke CAPTCHA, sorry about that

= 2.2.2 =
- (23 Nov 2009) - Added 5 random CAPTCHA fonts
- Fixed fail over to GD Fonts on the CAPTCHA when TTF Fonts are not enabled in PHP (it was broken)

= 2.2.1 =
- (21 Nov 2009) - Fixed Flash audio was not working.

= 2.2 =
- (20 Nov 2009) - Updated to SecureImage CAPTCHA library version 2.0
- New CAPTCHA features include: increased CAPTCHA difficulty using mathematical distortion, streaming MP3 audio of CAPTCHA code using Flash, random audio distortion, better distortion lines, random backgrounds and more.
- Other minor fixes.

= 2.1.1 =
- (10 Nov 2009) - Fix style and input alignments.

= 2.1 =
- (03 Nov 2009) - Fix for settings not being deleted when plugin is deleted from admin page.

= 2.0.9 =
- (30 Oct 2009) - Fixed issue on some sites with blank css fields that caused image misalignment.

= 2.0.8 =
- (29 Oct 2009) - Added new setting in advanced options: "CSS style for CAPTCHA div".

= 2.0.7 =
- (21 Oct 2009) - Added Chinese (zh_CN) - Translated by [Awu](http://www.awuit.cn/) 

= 2.0.6 =
- (13 Oct 2009) - Fixed array_merge error on WPMU, Buddypress.
- Added Czech (cs_CZ) - Translated by [Radovan](http://algymsa.cz)

= 2.0.5 =
- (09 Oct 2009) - Added Albanian (sq_AL) - Translated by [Romeo Shuka](http://www.romeolab.com)

= 2.0.4 =
- (03 Oct 2009) - Fixed session error on Buddypress versions.

= 2.0.3 =
- (01 Oct 2009) - Renamed to SI CAPTCHA Anti-Spam

= 2.0.2 =
- (30 Sep 2009) - Fixed settings were deleted at deactivation. Settings are now only deleted at uninstall.

= 2.0.1 =
- (25 Sep 2009) - BuddyPress 1.1 CSS fixes for the CAPTCHA position on the regstration form.

= 2.0 =
- (25 Sep 2009) - Added full WPMU and BuddyPress compatibility. WPMU and BuddyPress users can now protect comment form, registration, and login from spam.
- Added login form CAPTCHA. The Login form captcha is not enabled by default because it might be annoying to users. Only enable it if you are having spam problems related to bots automatically logging in.
- New feature: An "advanced options" section to the options page. Some people wanted to change the text labels for the CAPTCHA and code input field.
These advanced options fields can be filled in to override the standard included text labels.
- Added new advanced options for editing inline CSS style of captcha image, audio image, and reload image.
- Supports BuddyPress 1.0.3 and 1.1 
- Minor code cleanup.

= 1.8 =
- (15 Sep 2009) - Plugin options are now stored in a single database row instead of many. (and it will auto migrate/cleanup old options database rows).
- Language files are now stored in the `si-captcha-for-wordpress/languages` folder.
- Options are now deleted when this plugin is deleted.
- Added proper nonce protection to options forms.

= 1.7.12 =
- (08 Sep 2009) - Fixed redirect/logout problem on admin menu reported by a user.

= 1.7.11 =
- (03 Sep 2009) Updated German Language (de_DE) - Translated by [Sebastian Kreideweiss](http://sebastian.kreideweiss.info/)

= 1.7.10 =
- (02 Sep 2009) Updated Traditional Chinese, Taiwan Language (zh_TW) - Translated by [Cjh]

= 1.7.9 =
- (31 Aug 2009) Added more diagnostic test scripts: a Cookie Test, Captcha test, and a PHP Requirements Test.
Click on the "Test if your PHP installation will support the CAPTCHA" link on the Options page.
or open this URL in your web browser to run the test:
`/wp-content/plugins/si-captcha-for-wordpress/captcha-secureimage/test/index.php`
- Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 1.7.8 =
- (31 Aug 2009) Improved cookie error

= 1.7.7 =
- (30 Aug 2009) Added a `cookie_test.php` to help diagnose if a web browser has cookies disabled. (see the FAQ) 

= 1.7.6 =
- (29 Aug 2009) Added this script to test if your PHP installation will support the CAPTCHA:
Click on the "Test if your PHP installation will support the CAPTCHA" link on the Options page.
or open this URL in your web browser to run the test:
`/wp-content/plugins/si-captcha-for-wordpress/captcha-secureimage/test/index.php`

= 1.7.5 =
- (28 Aug 2009) Added Arabic Language (ar) - Translated by [Amine Roukh](http://amine27.zici.fr/)
- CAPTCHA fix - Added Automatic fail over from TTF Fonts to GD Fonts if the PHP installation is configured without "--with-ttf".
  Some users were reporting there was no error indicating this TTF Fonts not supported condition and the captcha was not working.

= 1.7.4 =
- (28 Aug 2009) Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 1.7.3 =
- (28 Aug 2009) Updated Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 1.7.2 =
- (28 Aug 2009) fix options permission bug introduced by last update, sorry

= 1.7.1 =
- (27 Aug 2009) added settings link to the plugin action links

= 1.7 =
- (26 Aug 2009) Added error code for when the user has cookies disabled (the CAPTCHA requires cookies)
- added setting to enable aria-required form tags for screen readers(disabled by default)
- added a donate button on the options page. If you find this plugin useful to you, please consider making a small donation to help contribute to further development. Thanks for your kind support! - Mike Challis

= 1.6.9 =
- (03 Aug 2009) Added Greek Language (el) - Translated by [Ioannis](http://www.jbaron.gr/)

= 1.6.8 =
- (29 Jul 2009) Added Polish Language (pl_PL) - Translated by [Tomasz](http://www.ziolczynski.pl/)

= 1.6.7 = 
- (12 Jun 2009) WP 2.8 Compatible

= 1.6.6 = 
- (10 Jun 2009) Updated Russian Language (ru_RU) - Translated by [Neponyatka](http://www.free-lance.ru/users/neponyatka)

= 1.6.5 = 
- (09 Jun 2009) Added Traditional Chinese, Taiwan Language (zh_TW) - Translated by [Cjh]

= 1.6.4 = 
- (15 May 2009) Added Swedish Language (sv_SE) - Translated by [Benct]

= 1.6.3 =
- (10 May 2009) Added Russian Language (ru_RU) - Translated by [Fat Cow](http://www.fatcow.com/)

= 1.6.2 =
- (05 May 2009) Added Spanish Language (en_ES) - Translated by [LoPsT](http://www.lopst.com/)

= 1.6.1 =
- (06 Apr 2009) Added Belorussian Language (by_BY) - Translated by [Marcis Gasuns](http://www.comfi.com/)
- Fixed audio CAPTCHA link URL, it did not work properly on Safari 3.2.1 (Mac OS X 10.5.6).
- Note: the proper way the audio CAPTCHA is supposed to work is like this: a dialog pops up, You have chosen to open:
secureimage.wav What should (Firefox, Safari, IE, etc.) do with this file? Open with: (Choose) OR Save File. Be sure to select open, then it will play in WMP, Quicktime, Itunes, etc.

= 1.6 =
- (23 Mar 2009) Added new option on configuration page: You can set a CSS class name for CAPTCHA input field on the comment form: 
(Enter a CSS class name only if your theme uses one for comment text inputs. Default is blank for none.)

= 1.5.4 =
- (19 Mar 2009) Updated Danish Language (da_DK) - Translated by [Parry](http://www.detheltnyestore.dk/)

= 1.5.3 =
- (12 Mar 2009) Added German Language (de_DE) - Translated by [Sebastian Kreideweiss](http://sebastian.kreideweiss.info/)
- Updated Danish Language (da_DK) - Translated by [Parry](http://www.detheltnyestore.dk/)

= 1.5.2 =
- (24 Feb 2009) Added Danish Language (da_DK) - Translated by [Parry](http://www.detheltnyestore.dk/)

= 1.5.1 =
- (11 Feb 2009) Added Portuguese_brazil Language (pt_BR) - Translated by [Newton Dan Faoro]

= 1.5 =
- (22 Jan 2009) Added fix for compatibility with WP Wall plugin. This does NOT add CAPTCHA to WP Wall plugin, it just prevents the "Error: You did not enter a Captcha phrase." when submitting a WP Wall comment.
- Added Norwegian language (nb_NO) - Translated by [Roger Sylte](http://roger.inro.net/)

= 1.4 = 
- (04 Jan 2009) Added Turkish language (tr_TR) - Translated by [Volkan](http://www.kirpininyeri.com/)

= 1.3.3 =
-  (02 Jan 2009) Fixed a missing "Refresh Image" language variable

= 1.3.2 =
-  (19 Dec 2008) Added WAI ARIA property aria-required to captcha input form for more accessibility

= 1.3.1 =
- (17 Dec 2008) Changed screenshots to WP 2.7
- Better detection of GD and a few misc. adjustments

= 1.3 =
- (14 Dec 2008) Added language translation to the permissions drop down select on the options admin page, thanks Pierre
- Added French language (fr_FR) - Translated by [Pierre Sudarovich](http://pierre.sudarovich.free.fr/)

= 1.2.1 =
- (23 Nov 2008) Fixed compatibility with custom `WP_PLUGIN_DIR` installations

= 1.2 =
- (23 Nov 2008) Fixed install path from `si-captcha` to `si-captcha-for-wordpress` so automatic update works correctly.

= 1.1.1 =
- (22 Nov 2008) Added Italian language (it_IT) - Translated by [Gianni Diurno](http://gidibao.net/ "Gianni Diurno")

= 1.1 =
- (21 Nov 2008) Added I18n language translation feature

= 1.0 =
- (21 Aug 2008) Initial Release



