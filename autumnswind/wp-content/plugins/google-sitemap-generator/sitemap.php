<?php

/*
 $Id: sitemap.php 420045 2011-08-06 14:19:03Z arnee $

 Google XML Sitemaps Generator for WordPress
 ==============================================================================
 
 This generator will create a sitemaps.org compliant sitemap of your WordPress blog.

 For additional details like installation instructions, please check the readme.txt and documentation.txt files.
 
 Have fun!
   Arne

 Info for WordPress:
 ==============================================================================
 Plugin Name: Google XML Sitemaps
 Plugin URI: http://www.arnebrachhold.de/redir/sitemap-home/
 Description: This plugin will generate a special XML sitemap which will help search engines like Google, Yahoo, Bing and Ask.com to better index your blog.
 Version: 4.0beta7
 Author: Arne Brachhold
 Author URI: http://www.arnebrachhold.de/
 Text Domain: sitemap
 Domain Path: /lang/
 
*/

/**
 * Check if the requirements of the sitemap plugin are met and loads the actual loader
 *
 * @package sitemap
 * @since 4.0
 */
function sm_Setup() {

	$fail = false;

	//Check minimum PHP requirements, which is 5.1 at the moment.
	if(version_compare(PHP_VERSION, "5.1", "<")) {
		add_action('admin_notices', 'sm_AddPhpVersionError');
		$fail = true;
	}

	//Check minimum WP requirements, which is 2.9 at the moment.
	if(version_compare($GLOBALS["wp_version"], "2.9", "<")) {
		add_action('admin_notices', 'sm_AddWpVersionError');
		$fail = true;
	}

	if(!$fail) require_once(trailingslashit(dirname(__FILE__)) . "sitemap-loader.php");
}

/**
 * Adds a notice to the admin interface that the WordPress version is too old for the plugin
 *
 * @package sitemap
 * @since 4.0
 */
function sm_AddWpVersionError() {
	echo "<div id='sm-version-error' class='error fade'><p><strong>" . __('Your WordPress version is too old for XML Sitemaps.', 'sitemap') . "</strong><br /> " . sprintf(__('Unfortunately this release of Google XML Sitemaps requires at least WordPress 2.9. You are using Wordpress %2$s, which is out-dated and insecure. Please upgrade or go to <a href="%1$s">active plugins</a> and deactivate the Google XML Sitemaps plugin to hide this message. You can download an older version of this plugin from the <a href="%3$s">plugin website</a>.', 'sitemap'), "plugins.php?plugin_status=active", $GLOBALS["wp_version"], "http://www.arnebrachhold.de/redir/sitemap-home/") . "</p></div>";
}

/**
 * Adds a notice to the admin interface that the WordPress version is too old for the plugin
 *
 * @package sitemap
 * @since 4.0
 */
function sm_AddPhpVersionError() {
	echo "<div id='sm-version-error' class='error fade'><p><strong>" . __('Your PHP version is too old for XML Sitemaps.', 'sitemap') . "</strong><br /> " . sprintf(__('Unfortunately this release of Google XML Sitemaps requires at least PHP 5.1. You are using PHP %2$s, which is out-dated and insecure. Please ask your web host to update your PHP installation or go to <a href="%1$s">active plugins</a> and deactivate the Google XML Sitemaps plugin to hide this message. You can download an older version of this plugin from the <a href="%3$s">plugin website</a>.', 'sitemap'), "plugins.php?plugin_status=active", PHP_VERSION, "http://www.arnebrachhold.de/redir/sitemap-home/") . "</p></div>";
}

/**
 * Returns the file used to load the sitemap plugin
 *
 * @package sitemap
 * @since 4.0
 * @return string The path and file of the sitemap plugin entry point
 */
function sm_GetInitFile() {
	return __FILE__;
}

//Don't do anything if this file was called directly
if(defined('ABSPATH') && defined('WPINC') && !class_exists("GoogleSitemapGeneratorLoader", false)) {
	sm_Setup();
}

