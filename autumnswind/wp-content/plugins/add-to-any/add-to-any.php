<?php
/*
Plugin Name: AddToAny: Share/Bookmark/Email Buttons
Plugin URI: http://www.addtoany.com/
Description: Help people share, bookmark, and email your posts & pages using any service, such as Facebook, Twitter, Google, StumbleUpon, Digg and many more.  [<a href="options-general.php?page=add-to-any.php">Settings</a>]
Version: .9.9.9.5
Author: AddToAny
Author URI: http://www.addtoany.com/
*/

if( !isset($A2A_locale) )
	$A2A_locale = '';
	
// Pre-2.6 compatibility
if ( ! defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );
	
$A2A_SHARE_SAVE_plugin_basename = plugin_basename(dirname(__FILE__));

// WordPress Must-Use?
if ( basename(dirname(__FILE__)) == "mu-plugins" ) {
	// __FILE__ expected in /wp-content/mu-plugins (parent directory for auto-execution)
	// /wp-content/mu-plugins/add-to-any
	$A2A_SHARE_SAVE_plugin_url_path = WPMU_PLUGIN_URL . '/add-to-any';
	$A2A_SHARE_SAVE_plugin_dir = WPMU_PLUGIN_DIR . '/add-to-any';
} 
else {
	// /wp-content/plugins/add-to-any
	$A2A_SHARE_SAVE_plugin_url_path = WP_PLUGIN_URL . '/' . $A2A_SHARE_SAVE_plugin_basename;
	$A2A_SHARE_SAVE_plugin_dir = WP_PLUGIN_DIR . '/' . $A2A_SHARE_SAVE_plugin_basename;
}
	

// Fix SSL
if (is_ssl())
	$A2A_SHARE_SAVE_plugin_url_path = str_replace('http:', 'https:', $A2A_SHARE_SAVE_plugin_url_path);

$A2A_SHARE_SAVE_options = get_option('addtoany_options');

function A2A_SHARE_SAVE_init() {
	global $A2A_SHARE_SAVE_plugin_url_path,
		$A2A_SHARE_SAVE_plugin_basename, 
		$A2A_SHARE_SAVE_options;
	
	if (get_option('A2A_SHARE_SAVE_button')) {
	    A2A_SHARE_SAVE_migrate_options();
	    $A2A_SHARE_SAVE_options = get_option('addtoany_options');
	}
  
	load_plugin_textdomain('add-to-any',
		$A2A_SHARE_SAVE_plugin_url_path.'/languages',
		$A2A_SHARE_SAVE_plugin_basename.'/languages');
		
	if ($A2A_SHARE_SAVE_options['display_in_excerpts'] != '-1') {
		// Excerpts use strip_tags() for the_content, so cancel if Excerpt and append to the_excerpt instead
		add_filter('get_the_excerpt', 'A2A_SHARE_SAVE_remove_from_content', 9);
		add_filter('the_excerpt', 'A2A_SHARE_SAVE_add_to_content', 98);
	}
}
add_filter('init', 'A2A_SHARE_SAVE_init');

function A2A_SHARE_SAVE_link_vars($linkname = FALSE, $linkurl = FALSE) {
	global $post;
	
	$linkname		= ($linkname) ? $linkname : get_the_title($post->ID);
	$linkname_enc	= rawurlencode( $linkname );
	$linkurl		= ($linkurl) ? $linkurl : get_permalink($post->ID);
	$linkurl_enc	= rawurlencode( $linkurl );	
	
	return compact( 'linkname', 'linkname_enc', 'linkurl', 'linkurl_enc' );
}

include_once($A2A_SHARE_SAVE_plugin_dir . '/services.php');

// Combine ADDTOANY_SHARE_SAVE_ICONS and ADDTOANY_SHARE_SAVE_BUTTON
function ADDTOANY_SHARE_SAVE_KIT( $args = false ) {
	global $_addtoany_counter;
	
	$_addtoany_counter++;
	
	if ( ! isset($args['html_container_open'])) {
		$args['html_container_open'] = '<div class="a2a_kit a2a_target addtoany_list" id="wpa2a_' . $_addtoany_counter . '">';
		$args['is_kit'] = TRUE;
	}
	if ( ! isset($args['html_container_close']))
		$args['html_container_close'] = "</div>";
	// Close container element in ADDTOANY_SHARE_SAVE_BUTTON, not prematurely in ADDTOANY_SHARE_SAVE_ICONS
	$html_container_close = $args['html_container_close']; // Cache for _BUTTON
	unset($args['html_container_close']); // Avoid passing to ADDTOANY_SHARE_SAVE_ICONS since set in _BUTTON
				
	if ( ! isset($args['html_wrap_open']))
		$args['html_wrap_open'] = "";
	if ( ! isset($args['html_wrap_close']))
		$args['html_wrap_close'] = "";
	
    $kit_html = ADDTOANY_SHARE_SAVE_ICONS($args);
	
	$args['html_container_close'] = $html_container_close; // Re-set because unset above for _ICONS
	unset($args['html_container_open']);  // Avoid passing to ADDTOANY_SHARE_SAVE_BUTTON since set in _ICONS
    
	$kit_html .= ADDTOANY_SHARE_SAVE_BUTTON($args);
	
	if (isset($args['output_later']) && $args['output_later'])
		return $kit_html;
	else
		echo $kit_html;
}

function ADDTOANY_SHARE_SAVE_ICONS( $args = array() ) {
	// $args array: output_later, html_container_open, html_container_close, html_wrap_open, html_wrap_close, linkname, linkurl
	
	global $A2A_SHARE_SAVE_plugin_url_path, 
		$A2A_SHARE_SAVE_services;
	
	$linkname = (isset($args['linkname'])) ? $args['linkname'] : FALSE;
	$linkurl = (isset($args['linkurl'])) ? $args['linkurl'] : FALSE;
	
	$args = array_merge($args, A2A_SHARE_SAVE_link_vars($linkname, $linkurl)); // linkname_enc, etc.
	
	$defaults = array(
		'linkname' => '',
		'linkurl' => '',
		'linkname_enc' => '',
		'linkurl_enc' => '',
		'output_later' => FALSE,
		'html_container_open' => '',
		'html_container_close' => '',
		'html_wrap_open' => '',
		'html_wrap_close' => '',
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	// Make available services extensible via plugins, themes (functions.php), etc.
	$A2A_SHARE_SAVE_services = apply_filters('A2A_SHARE_SAVE_services', $A2A_SHARE_SAVE_services);
	
	$service_codes = array_keys($A2A_SHARE_SAVE_services);
	
	// Include Facebook Like and Twitter Tweet
	array_unshift($service_codes, 'facebook_like', 'twitter_tweet', 'google_plusone');
	
	$options = get_option('addtoany_options');
  
	$active_services = $options['active_services'];
	
	$ind_html = "" . $html_container_open;
	
	if( !$active_services )
		$active_services = Array();
	
	foreach($active_services as $active_service) {
		
		if ( !in_array($active_service, $service_codes) )
			continue;

		if ($active_service == 'facebook_like' || $active_service == 'twitter_tweet' || $active_service == 'google_plusone') {
			$link = ADDTOANY_SHARE_SAVE_SPECIAL($active_service, $args);
		}
		else {
			$service = $A2A_SHARE_SAVE_services[$active_service];
			$safe_name = $active_service;
			$name = $service['name'];
			
			if (isset($service['href'])) {
				$custom_service = TRUE;
				$href = $service['href'];
				if (isset($service['href_js_esc'])) {
					$href_linkurl = str_replace("'", "\'", $linkurl);
					$href_linkname = str_replace("'", "\'", $linkname);
				} else {
					$href_linkurl = $linkurl_enc;
					$href_linkname = $linkname_enc;
				}
				$href = str_replace("A2A_LINKURL", $href_linkurl, $href);
				$href = str_replace("A2A_LINKNAME", $href_linkname, $href);
				$href = str_replace(" ", "%20", $href);
			} else {
				$custom_service = FALSE;
			}
	
			$icon_url = (isset($service['icon_url'])) ? $service['icon_url'] : FALSE;
			$icon = (isset($service['icon'])) ? $service['icon'] : 'default'; // Just the icon filename
			$width = (isset($service['icon_width'])) ? $service['icon_width'] : '16';
			$height = (isset($service['icon_height'])) ? $service['icon_height'] : '16';
			
			$url = ($custom_service) ? $href : "http://www.addtoany.com/add_to/" . $safe_name . "?linkurl=" . $linkurl_enc . "&amp;linkname=" . $linkname_enc;
			$src = ($icon_url) ? $icon_url : $A2A_SHARE_SAVE_plugin_url_path."/icons/".$icon.".png";
			$class_attr = ($custom_service) ? "" : " class=\"a2a_button_$safe_name\"";
			
			$link = $html_wrap_open."<a$class_attr href=\"$url\" title=\"$name\" rel=\"nofollow\" target=\"_blank\">";
			$link .= "<img src=\"$src\" width=\"$width\" height=\"$height\" alt=\"$name\"/>";
			$link .= "</a>".$html_wrap_close;
		}
		
		$ind_html .= $link;
	}
	
	$ind_html .= $html_container_close;
	
	if ( $output_later )
		return $ind_html;
	else
		echo $ind_html;
}

function ADDTOANY_SHARE_SAVE_BUTTON( $args = array() ) {
	
	// $args array = output_later, html_container_open, html_container_close, html_wrap_open, html_wrap_close, linkname, linkurl

	global $A2A_SHARE_SAVE_plugin_url_path, $_addtoany_targets, $_addtoany_counter, $_addtoany_init;
	
	$linkname = (isset($args['linkname'])) ? $args['linkname'] : FALSE;
	$linkurl = (isset($args['linkurl'])) ? $args['linkurl'] : FALSE;
	$_addtoany_targets = (isset($_addtoany_targets)) ? $_addtoany_targets : array();

	$args = array_merge($args, A2A_SHARE_SAVE_link_vars($linkname, $linkurl)); // linkname_enc, etc.
	
	$defaults = array(
		'linkname' => '',
		'linkurl' => '',
		'linkname_enc' => '',
		'linkurl_enc' => '',
		'use_current_page' => FALSE,
		'output_later' => FALSE,
		'is_kit' => FALSE,
		'html_container_open' => '',
		'html_container_close' => '',
		'html_wrap_open' => '',
		'html_wrap_close' => '',
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	// If not enclosed in an AddToAny Kit, count & target this button (instead of Kit) for async loading
	if ( ! $args['is_kit']) {
		$_addtoany_counter++;
		$button_class = ' a2a_target';
		$button_id = ' id="wpa2a_' . $_addtoany_counter . '"';
	} else {
		$button_class = '';
		$button_id = '';
	}
	
	/* AddToAny button */
	
	$is_feed = is_feed();
	$button_target = '';
	$button_href_querystring = ($is_feed) ? '#url=' . $linkurl_enc . '&amp;title=' . $linkname_enc  : '';
	$options = get_option('addtoany_options');
	
	if( ! $options['button'] ) {
		$button_fname	= 'share_save_171_16.png';
		$button_width	= ' width="171"';
		$button_height	= ' height="16"';
		$button_src		= $A2A_SHARE_SAVE_plugin_url_path.'/'.$button_fname;
	} else if( $options['button'] == 'CUSTOM' ) {
		$button_src		= $options['button_custom'];
		$button_width	= '';
		$button_height	= '';
	} else if( $options['button'] == 'TEXT' ) {
		$button_text	= stripslashes($options['button_text']);
	} else {
		$button_attrs	= explode( '|', $options['button'] );
		$button_fname	= $button_attrs[0];
		$button_width	= ' width="'.$button_attrs[1].'"';
		$button_height	= ' height="'.$button_attrs[2].'"';
		$button_src		= $A2A_SHARE_SAVE_plugin_url_path.'/'.$button_fname;
		$button_text	= stripslashes($options['button_text']);
	}
	
	$style = '';
	
	if( isset($button_fname) && ($button_fname == 'favicon.png' || $button_fname == 'share_16_16.png') ) {
		if( ! $is_feed) {
			$style_bg	= 'background:url('.$A2A_SHARE_SAVE_plugin_url_path.'/'.$button_fname.') no-repeat scroll 9px 0px !important;';
			$style		= ' style="'.$style_bg.'padding:0 0 0 30px;display:inline-block;height:16px;line-height:16px;vertical-align:middle"'; // padding-left:30+9 (9=other icons padding)
		}
	}
	
	if( isset($button_text) && $button_text && ( ! isset($button_fname) || ! $button_fname || $button_fname == 'favicon.png' || $button_fname == 'share_16_16.png') ) {
		$button			= $button_text;
	} else {
		$style = '';
		$button			= '<img src="'.$button_src.'"'.$button_width.$button_height.' alt="Share"/>';
	}
	
	$button_html = $html_container_open . $html_wrap_open . '<a class="a2a_dd' . $button_class . ' addtoany_share_save" href="http://www.addtoany.com/share_save' .$button_href_querystring . '"' . $button_id
		. $style . $button_target
		. '>' . $button . '</a>' . $html_wrap_close . $html_container_close;
	
	// If not a feed
	if( ! $is_feed ) {
		if ($use_current_page) {
			$_addtoany_targets[] = "\n{title:document.title,"
				. "url:location.href}";
		} else {
			$_addtoany_targets[] = "\n{title:'". esc_js($linkname) . "',"
				. "url:'" . $linkurl . "'}";
		}
		
		if ( ! $_addtoany_init) {
			$javascript_load_early = "\n<script type=\"text/javascript\"><!--\n"
				. "wpa2a.script_load();"			
				. "\n//--></script>\n";
		}
		else
			$javascript_load_early = "";
		
		$button_html .= $javascript_load_early;
		$_addtoany_init = TRUE;
	}
	
	if ( $output_later )
		return $button_html;
	else
		echo $button_html;
}

function ADDTOANY_SHARE_SAVE_SPECIAL($special_service_code, $args = array() ) {
	// $args array = output_later, linkname, linkurl
	
	$options = get_option('addtoany_options');
	
	$linkname = (isset($args['linkname'])) ? $args['linkname'] : FALSE;
	$linkurl = (isset($args['linkurl'])) ? $args['linkurl'] : FALSE;
	
	$args = array_merge($args, A2A_SHARE_SAVE_link_vars($linkname, $linkurl)); // linkname_enc, etc.
	extract( $args );
	
	$http_or_https = (is_ssl()) ? 'https' : 'http';
	$iframe_template_begin = '<iframe';
	$iframe_template_end = ' class="addtoany_special_service %1$s" src="%2$s" scrolling="no" style="border:none;overflow:hidden;width:%3$dpx;height:%4$dpx"></iframe>';
	$iframe_template = $iframe_template_begin . $iframe_template_end;
	
	// IE ridiculousness to support transparent iframes while maintaining W3C validity
	$iframe_template = '<!--[if IE]>'
		. $iframe_template_begin . ' frameborder="0" allowTransparency="true"' . $iframe_template_end
		. '<![endif]--><!--[if !IE]><!-->' . $iframe_template . '<!--<![endif]-->';
	
	if ($special_service_code == 'facebook_like') {
		if ($options['special_facebook_like_options']['verb'] == 'recommend') {
			$action_param_value = 'recommend';
		} else {
			$action_param_value = 'like';
		}
		$special_html = sprintf($iframe_template, $special_service_code, $http_or_https . '://www.facebook.com/plugins/like.php?href=' . $linkurl_enc . '&amp;layout=button_count&amp;show_faces=false&amp;width=75&amp;action=' . $action_param_value . '&amp;colorscheme=light&amp;height=20&amp;ref=addtoany', 90, 21);
	}
	elseif ($special_service_code == 'twitter_tweet') {
		if ($options['special_twitter_tweet_options']['show_count'] == '1') {
			$count_param_value = 'horizontal';
			$width = 130;
		} else {
			$count_param_value = 'none';
			$width = 55;
		}
		$special_html = sprintf($iframe_template, $special_service_code, $http_or_https . '://platform.twitter.com/widgets/tweet_button.html?url=' . $linkurl_enc . '&amp;counturl=' . $linkurl_enc . '&amp;count=' . $count_param_value . '&amp;text=' . $linkname_enc, $width, 20);
	}
	elseif ($special_service_code == 'google_plusone') {
		if ($options['special_google_plusone_options']['show_count'] == '1') {
			$count_param_value = 'true';
			$width = 90;
		} else {
			$count_param_value = 'false';
			$width = 32;
		}
		$special_html = sprintf($iframe_template, $special_service_code, 'https://plusone.google.com/u/0/_/%2B1/fastbutton?url=' . $linkurl_enc . '&amp;size=medium&amp;count=' . $count_param_value, $width, 20);
	}		
	
	if ( $output_later )
		return $special_html;
	else
		echo $special_html;
}

if (!function_exists('A2A_menu_locale')) {
	function A2A_menu_locale() {
		global $A2A_locale;
		$locale = get_locale();
		if($locale  == 'en_US' || $locale == 'en' || $A2A_locale != '' )
			return false;
			
		$A2A_locale = 'a2a_localize = {
	Share: "' . __("Share", "add-to-any") . '",
	Save: "' . __("Save", "add-to-any") . '",
	Subscribe: "' . __("Subscribe", "add-to-any") . '",
	Email: "' . __("E-mail", "add-to-any") . '",
    Bookmark: "' . __("Bookmark", "add-to-any") . '",
	ShowAll: "' . __("Show all", "add-to-any") . '",
	ShowLess: "' . __("Show less", "add-to-any") . '",
	FindServices: "' . __("Find service(s)", "add-to-any") . '",
	FindAnyServiceToAddTo: "' . __("Instantly find any service to add to", "add-to-any") . '",
	PoweredBy: "' . __("Powered by", "add-to-any") . '",
	ShareViaEmail: "' . __("Share via e-mail", "add-to-any") . '",
	SubscribeViaEmail: "' . __("Subscribe via e-mail", "add-to-any") . '",
	BookmarkInYourBrowser: "' . __("Bookmark in your browser", "add-to-any") . '",
	BookmarkInstructions: "' . __("Press Ctrl+D or &#8984;+D to bookmark this page", "add-to-any") . '",
	AddToYourFavorites: "' . __("Add to your favorites", "add-to-any") . '",
	SendFromWebOrProgram: "' . __("Send from any e-mail address or e-mail program", "add-to-any") . '",
    EmailProgram: "' . __("E-mail program", "add-to-any") . '"
};
';
		return $A2A_locale;
	}
}


function A2A_SHARE_SAVE_head_script() {
	if (is_admin())
		return;
		
	$options = get_option('addtoany_options');
	
	$http_or_https = (is_ssl()) ? 'https' : 'http';
	
	global $A2A_SHARE_SAVE_external_script_called;
	if ( ! $A2A_SHARE_SAVE_external_script_called ) {
		// Use local cache?
		$cache = ($options['cache']=='1') ? TRUE : FALSE;
		$upload_dir = wp_upload_dir();
		$static_server = ($cache) ? $upload_dir['baseurl'] . '/addtoany' : $http_or_https . '://static.addtoany.com/menu';
		
		// Enternal script call + initial JS + set-once variables
		$additional_js = $options['additional_js_variables'];
		$script_configs = (($cache) ? "\n" . 'a2a_config.static_server="' . $static_server . '";' : '' )
			. (($options['onclick']=='1') ? "\n" . 'a2a_config.onclick=1;' : '')
			. (($options['show_title']=='1') ? "\n" . 'a2a_config.show_title=1;' : '')
			. (($additional_js) ? "\n" . stripslashes($additional_js)  : '');
		$A2A_SHARE_SAVE_external_script_called = true;
	}
	else {
		$script_configs = "";
	}
	
	$javascript_header = "\n" . '<script type="text/javascript">' . "<!--\n"
			. "var a2a_config=a2a_config||{},"
			. "wpa2a={done:false,"
			. "html_done:false,"
			. "script_ready:false,"
			. "script_load:function(){"
				. "var a=document.createElement('script'),"
					. "s=document.getElementsByTagName('script')[0];"
				. "a.type='text/javascript';a.async=true;"
				. "a.src='" . $static_server . "/page.js';"
				. "s.parentNode.insertBefore(a,s);"
				. "wpa2a.script_load=function(){};"
			. "},"
			. "script_onready:function(){"
				. "if(a2a.type=='page'){" // Check a2a internal var to ensure script loaded is page.js not feed.js
					. "wpa2a.script_ready=true;"
					. "if(wpa2a.html_done)wpa2a.init();"
				. "}"
			. "},"
			. "init:function(){"
				. "for(var i=0,el,target,targets=wpa2a.targets,length=targets.length;i<length;i++){"
					. "el=document.getElementById('wpa2a_'+(i+1));"
					. "target=targets[i];"
					. "a2a_config.linkname=target.title;"
					. "a2a_config.linkurl=target.url;"
					. "if(el)a2a.init('page',{target:el});wpa2a.done=true;"
				. "}"
			. "}"
		. "};"
		. "a2a_config.tracking_callback=['ready',wpa2a.script_onready];"
		. A2A_menu_locale()
		. $script_configs
		. "\n//--></script>\n";
	
	 echo $javascript_header;
}

add_action('wp_head', 'A2A_SHARE_SAVE_head_script');

function A2A_SHARE_SAVE_footer_script() {
	global $_addtoany_targets;
	
	if (is_admin())
		return;
		
	$_addtoany_targets = (isset($_addtoany_targets)) ? $_addtoany_targets : array();
	
	$javascript_footer = "\n" . '<script type="text/javascript">' . "<!--\n"
		. "wpa2a.targets=["
			. implode(",", $_addtoany_targets)
		. "];\n"
		. "wpa2a.html_done=true;"
		. "if(wpa2a.script_ready&&!wpa2a.done)wpa2a.init();" // External script may load before html_done=true, but will only init if html_done=true.  So call wpa2a.init() if external script is ready, and if wpa2a.init() hasn't been called already.  Otherwise, wait for callback to call wpa2a.init()
		. "wpa2a.script_load();" // Load external script if not already called with the first AddToAny button.  Fixes issues where first button code is processed internally but without actual code output
		. "\n//--></script>\n";
	echo $javascript_footer;
}

add_action('wp_footer', 'A2A_SHARE_SAVE_footer_script');



function A2A_SHARE_SAVE_theme_hooks_check() {
	$template_directory = get_template_directory();
	
	// If footer.php exists in the current theme, scan for "wp_footer"
	$file = $template_directory . '/footer.php';
	if (is_file($file)) {
		$search_string = "wp_footer";
		$file_lines = @file($file);
		
		foreach ($file_lines as $line) {
			$searchCount = substr_count($line, $search_string);
			if ($searchCount > 0) {
				return true;
			}
		}
		
		// wp_footer() not found:
		echo "<div class=\"update-nag\">" . __("Your theme needs to be fixed. To fix your theme, use the <a href=\"theme-editor.php\">Theme Editor</a> to insert <code>&lt;?php wp_footer(); ?&gt;</code> just before the <code>&lt;/body&gt;</code> line of your theme's <code>footer.php</code> file.") . "</div>";
	}
	
	// If header.php exists in the current theme, scan for "wp_head"
	$file = $template_directory . '/header.php';
	if (is_file($file)) {
		$search_string = "wp_head";
		$file_lines = @file($file);
		
		foreach ($file_lines as $line) {
			$searchCount = substr_count($line, $search_string);
			if ($searchCount > 0) {
				return true;
			}
		}
		
		// wp_footer() not found:
		echo "<div class=\"update-nag\">" . __("Your theme needs to be fixed. To fix your theme, use the <a href=\"theme-editor.php\">Theme Editor</a> to insert <code>&lt;?php wp_head(); ?&gt;</code> just before the <code>&lt;/head&gt;</code> line of your theme's <code>header.php</code> file.") . "</div>";
	}
}

function A2A_SHARE_SAVE_auto_placement($title) {
	global $A2A_SHARE_SAVE_auto_placement_ready;
	$A2A_SHARE_SAVE_auto_placement_ready = true;
	
	return $title;
}


/**
 * Remove the_content filter and add it for next time 
 */
function A2A_SHARE_SAVE_remove_from_content($content) {
	remove_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
	add_filter('the_content', 'A2A_SHARE_SAVE_add_to_content_next_time', 98);
	
	return $content;
}

/**
 * Apply the_content filter "next time"
 */
function A2A_SHARE_SAVE_add_to_content_next_time($content) {
	add_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);
	
	return $content;
}


function A2A_SHARE_SAVE_add_to_content($content) {
	global $A2A_SHARE_SAVE_auto_placement_ready;
	
	$is_feed = is_feed();
	$options = get_option('addtoany_options');
  
	if( ! $A2A_SHARE_SAVE_auto_placement_ready)
		return $content;
		
	if (get_post_status(get_the_ID()) == 'private')
		return $content;
	
	if ( 
		( 
			// Tags
			// <!--sharesave--> tag
			strpos($content, '<!--sharesave-->')===false || 
			// <!--nosharesave--> tag
			strpos($content, '<!--nosharesave-->')!==false
		) &&
		(
			// Posts
			// All posts
			( ! is_page() && $options['display_in_posts']=='-1' ) ||
			// Front page posts		
			( is_home() && $options['display_in_posts_on_front_page']=='-1' ) ||
			// Category posts (same as Front page option)
			( is_category() && $options['display_in_posts_on_front_page']=='-1' ) ||
			// Tag Cloud posts (same as Front page option) - WP version 2.3+ only
			( function_exists('is_tag') && is_tag() && $options['display_in_posts_on_front_page']=='-1' ) ||
			// Date-based archives posts (same as Front page option)
			( is_date() && $options['display_in_posts_on_front_page']=='-1' ) ||
			// Author posts (same as Front page option)	
			( is_author() && $options['display_in_posts_on_front_page']=='-1' ) ||
			// Search results posts (same as Front page option)
			( is_search() && $options['display_in_posts_on_front_page']=='-1' ) || 
			// Posts in feed
			( $is_feed && ($options['display_in_feed']=='-1' ) ||
			
			// Pages
			// Individual pages
			( is_page() && $options['display_in_pages']=='-1' ) ||
			// <!--nosharesave-->						
			( (strpos($content, '<!--nosharesave-->')!==false) )
		)
		)
	)	
		return $content;
	
	$kit_args = array(
		"output_later" => true,
		"is_kit" => ($is_feed) ? FALSE : TRUE,
	);
	
	if ( ! $is_feed ) {
		$container_wrap_open = '<div class="addtoany_share_save_container">';
		$container_wrap_close = '</div>';
	} else { // Is feed
		$container_wrap_open = '<p>';
		$container_wrap_close = '</p>';
		$kit_args['html_container_open'] = '';
		$kit_args['html_container_close'] = '';
		$kit_args['html_wrap_open'] = '';
		$kit_args['html_wrap_close'] = '';
	}
	
	$options['position'] = isset($options['position']) ? $options['position'] : 'bottom';
	
	if ($options['position'] == 'both' || $options['position'] == 'top') {
		// Prepend to content
		$content = $container_wrap_open.ADDTOANY_SHARE_SAVE_KIT($kit_args) . $container_wrap_close . $content;
	}
	if ( $options['position'] == 'bottom' || $options['position'] == 'both') {
		// Append to content
		$content .= $container_wrap_open.ADDTOANY_SHARE_SAVE_KIT($kit_args) . $container_wrap_close;
	}
	
	return $content;
}

// Only automatically output button code after the_title has been called - to avoid premature calling from misc. the_content filters (especially meta description)
add_filter('the_title', 'A2A_SHARE_SAVE_auto_placement', 9);
add_filter('the_content', 'A2A_SHARE_SAVE_add_to_content', 98);


// [addtoany url="http://example.com/page.html" title="Some Example Page"]
function A2A_SHARE_SAVE_shortcode( $attributes ) {
	extract( shortcode_atts( array(
		'url' => 'something',
		'title' => 'something else',
	), $attributes ) );
	
	$linkname = (isset($attributes['title'])) ? $attributes['title'] : FALSE;
	$linkurl = (isset($attributes['url'])) ? $attributes['url'] : FALSE;
	$output_later = TRUE;

	return ADDTOANY_SHARE_SAVE_KIT( compact('linkname', 'linkurl', 'output_later') );
}

add_shortcode( 'addtoany', 'A2A_SHARE_SAVE_shortcode' );



function A2A_SHARE_SAVE_button_css_IE() {
/* IE support for opacity: */ ?>
<!--[if IE]>
<style type="text/css">
.addtoany_list a img{filter:alpha(opacity=70)}
.addtoany_list a:hover img,.addtoany_list a.addtoany_share_save img{filter:alpha(opacity=100)}
</style>
<![endif]-->
<?php
}

function A2A_SHARE_SAVE_stylesheet() {
	global $A2A_SHARE_SAVE_options, $A2A_SHARE_SAVE_plugin_url_path;
	
	// Use stylesheet?
	if ($A2A_SHARE_SAVE_options['inline_css'] != '-1' && ! is_admin()) {
		wp_enqueue_style('A2A_SHARE_SAVE', $A2A_SHARE_SAVE_plugin_url_path . '/addtoany.min.css', false, '1.3');
		
		// Conditional inline CSS stylesheet for IE
		add_filter('wp_head', 'A2A_SHARE_SAVE_button_css_IE');
	}
}

add_action('wp_print_styles', 'A2A_SHARE_SAVE_stylesheet');



/*****************************
		CACHE ADDTOANY
******************************/

function A2A_SHARE_SAVE_refresh_cache() {
	$contents = wp_remote_fopen("http://www.addtoany.com/ext/updater/files_list/");
	$file_urls = explode("\n", $contents, 20);
	$upload_dir = wp_upload_dir();
	
	// Make directory if needed
	if ( ! wp_mkdir_p( dirname( $upload_dir['basedir'] . '/addtoany/foo' ) ) ) {
		$message = sprintf( __( 'Unable to create directory %s. Is its parent directory writable by the server?' ), dirname( $new_file ) );
		return array( 'error' => $message );
	}
	
	if (count($file_urls) > 0) {
		for ($i = 0; $i < count($file_urls); $i++) {
			// Download files
			$file_url = $file_urls[$i];
			$file_name = substr(strrchr($file_url, '/'), 1, 99);
			
			// Place files in uploads/addtoany directory
			wp_get_http($file_url, $upload_dir['basedir'] . '/addtoany/' . $file_name);
		}
	}
}

function A2A_SHARE_SAVE_schedule_cache() {
	// WP "Cron" requires WP version 2.1
	$timestamp = wp_next_scheduled('A2A_SHARE_SAVE_refresh_cache');
	if ( ! $timestamp) {
		// Only schedule if currently unscheduled
		wp_schedule_event(time(), 'daily', 'A2A_SHARE_SAVE_refresh_cache');
	}
}

function A2A_SHARE_SAVE_unschedule_cache() {
	$timestamp = wp_next_scheduled('A2A_SHARE_SAVE_refresh_cache');
	wp_unschedule_event($timestamp, 'A2A_SHARE_SAVE_refresh_cache');
}



/*****************************
		OPTIONS
******************************/


function A2A_SHARE_SAVE_migrate_options() {
	
	$options = array(
		'inline_css' => '1', // Modernly used for "Use CSS Stylesheet?"
		'cache' => '-1',
		'display_in_posts_on_front_page' => '1',
		'display_in_posts' => '1',
		'display_in_pages' => '1',
		'display_in_feed' => '1',
		'show_title' => '-1',
		'onclick' => '-1',
		'button' => 'share_save_171_16.png|171|16',
		'button_custom' => '',
		'additional_js_variables' => '',
		'button_text' => 'Share/Bookmark',
		'display_in_excerpts' => '1',
		'active_services' => Array(),
	);
	
	$namespace = 'A2A_SHARE_SAVE_';
  
	foreach ($options as $option_name => $option_value) {
		$old_option_name = $namespace . $option_name;  
		$old_option_value = get_option($old_option_name);
		
		if($old_option_value === FALSE) {
			// Default value
		    $options[$option_name] = $option_value;
		} else {
			// Old value
		    $options[$option_name] = $old_option_value;
		}
		
		delete_option($old_option_name);
	}
	
	update_option('addtoany_options', $options);
	
	$deprecated_options = array(
		'button_opens_new_window',
		'hide_embeds',
	);
	
	foreach ($deprecated_options as $option_name) {
		delete_option($namespace . $option_name);
	}
	
}

function A2A_SHARE_SAVE_options_page() {

	global $A2A_SHARE_SAVE_plugin_url_path,
		$A2A_SHARE_SAVE_services;
	
	// Require admin privs
	if ( ! current_user_can('manage_options') )
		return false;
	
  $new_options = array();
  
  $namespace = 'A2A_SHARE_SAVE_';
  
	// Make available services extensible via plugins, themes (functions.php), etc.
	$A2A_SHARE_SAVE_services = apply_filters('A2A_SHARE_SAVE_services', $A2A_SHARE_SAVE_services);

    if (isset($_POST['Submit'])) {
		
		// Nonce verification 
		check_admin_referer('add-to-any-update-options');

		$new_options['position'] = ($_POST['A2A_SHARE_SAVE_position']) ? @$_POST['A2A_SHARE_SAVE_position'] : 'bottom';
		$new_options['display_in_posts_on_front_page'] = (@$_POST['A2A_SHARE_SAVE_display_in_posts_on_front_page']=='1') ? '1':'-1';
		$new_options['display_in_excerpts'] = (@$_POST['A2A_SHARE_SAVE_display_in_excerpts']=='1') ? '1':'-1';
		$new_options['display_in_posts'] = (@$_POST['A2A_SHARE_SAVE_display_in_posts']=='1') ? '1':'-1';
		$new_options['display_in_pages'] = (@$_POST['A2A_SHARE_SAVE_display_in_pages']=='1') ? '1':'-1';
		$new_options['display_in_feed'] = (@$_POST['A2A_SHARE_SAVE_display_in_feed']=='1') ? '1':'-1';
		$new_options['show_title'] = (@$_POST['A2A_SHARE_SAVE_show_title']=='1') ? '1':'-1';
		$new_options['onclick'] = (@$_POST['A2A_SHARE_SAVE_onclick']=='1') ? '1':'-1';
		$new_options['button'] = @$_POST['A2A_SHARE_SAVE_button'];
		$new_options['button_custom'] = @$_POST['A2A_SHARE_SAVE_button_custom'];
		$new_options['additional_js_variables'] = trim(@$_POST['A2A_SHARE_SAVE_additional_js_variables']);
		$new_options['inline_css'] = (@$_POST['A2A_SHARE_SAVE_inline_css']=='1') ? '1':'-1';
		$new_options['cache'] = (@$_POST['A2A_SHARE_SAVE_cache']=='1') ? '1':'-1';
		
		// Schedule cache refresh?
		if (@$_POST['A2A_SHARE_SAVE_cache']=='1') {
			A2A_SHARE_SAVE_schedule_cache();
			A2A_SHARE_SAVE_refresh_cache();
		} else {
			A2A_SHARE_SAVE_unschedule_cache();
		}
		
		// Store desired text if 16 x 16px buttons or text-only is chosen:
		if( $new_options['button'] == 'favicon.png|16|16' )
			$new_options['button_text'] = $_POST['A2A_SHARE_SAVE_button_favicon_16_16_text'];
		elseif( $new_options['button'] == 'share_16_16.png|16|16' )
			$new_options['button_text'] = $_POST['A2A_SHARE_SAVE_button_share_16_16_text'];
		else
			$new_options['button_text'] = ( trim($_POST['A2A_SHARE_SAVE_button_text']) != '' ) ? $_POST['A2A_SHARE_SAVE_button_text'] : __('Share/Bookmark','add-to-any');
			
		// Store chosen individual services to make active
		$active_services = Array();
		if ( ! isset($_POST['A2A_SHARE_SAVE_active_services']))
			$_POST['A2A_SHARE_SAVE_active_services'] = Array();
		foreach ( $_POST['A2A_SHARE_SAVE_active_services'] as $dummy=>$sitename )
			$active_services[] = substr($sitename, 7);
		$new_options['active_services'] = $active_services;
		
		// Store special service options
		$new_options['special_facebook_like_options'] = array(
			'verb' => ((@$_POST['addtoany_facebook_like_verb'] == 'recommend') ? 'recommend' : 'like')
		);
		$new_options['special_twitter_tweet_options'] = array(
			'show_count' => ((@$_POST['addtoany_twitter_tweet_show_count'] == '1') ? '1' : '-1')
		);
		$new_options['special_google_plusone_options'] = array(
			'show_count' => ((@$_POST['addtoany_google_plusone_show_count'] == '1') ? '1' : '-1')
		);
		
    	update_option('addtoany_options', $new_options);
    
		?>
    	<div class="updated fade"><p><strong><?php _e('Settings saved.'); ?></strong></p></div>
		<?php
		
    } else if (isset($_POST['Reset'])) {
    	// Nonce verification 
		  check_admin_referer('add-to-any-update-options');
		  
		  delete_option('addtoany_options');
    }

    $options = get_option('addtoany_options');
	
	function position_in_content($options, $option_box = FALSE) {
		
		if ( ! isset($options['position'])) {
			$options['position'] = 'bottom';
		}
		
		$positions = array(
			'bottom' => array(
				'selected' => ('bottom' == $options['position']) ? ' selected="selected"' : '',
				'string' => __('bottom', 'add-to-any')
			),
			'top' => array(
				'selected' => ('top' == $options['position']) ? ' selected="selected"' : '',
				'string' => __('top', 'add-to-any')
			),
			'both' => array(
				'selected' => ('both' == $options['position']) ? ' selected="selected"' : '',
				'string' => __('top &amp; bottom', 'add-to-any')
			)
		);
		
		if ($option_box) {
			$html = '</label>';
			$html .= '<label>'; // Label needed to prevent checkmark toggle on SELECT click 
		    $html .= '<select name="A2A_SHARE_SAVE_position">';
		    $html .= '<option value="bottom"' . $positions['bottom']['selected'] . '>' . $positions['bottom']['string'] . '</option>';
		    $html .= '<option value="top"' . $positions['top']['selected'] . '>' . $positions['top']['string'] . '</option>';
		    $html .= '<option value="both"' . $positions['both']['selected'] . '>' . $positions['both']['string'] . '</option>';
			$html .= '</select>';
		    
		    return $html;
		} else {
			$html = '<span class="A2A_SHARE_SAVE_position">';
			$html .= $positions[$options['position']]['string'];
			$html .= '</span>';
			
			return $html;
		}
	}
	
    ?>
    
    <?php A2A_SHARE_SAVE_theme_hooks_check(); ?>
    
    <div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	
	<h2><?php _e( 'AddToAny: Share/Save ', 'add-to-any' ) . _e( 'Settings' ); ?></h2>

    <form method="post" action="">
    
	<?php wp_nonce_field('add-to-any-update-options'); ?>
    
        <table class="form-table">
        	<tr valign="top">
            <th scope="row"><?php _e("Standalone Services", "add-to-any"); ?></th>
			<td><fieldset>
            	<ul id="addtoany_services_sortable" class="addtoany_admin_list">
                	<li class="dummy"><img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path; ?>/icons/transparent.gif" width="16" height="16" alt="" /></li>
                </ul>
                <p id="addtoany_services_info"><?php _e("Choose the services you want below. &nbsp;Click a chosen service again to remove. &nbsp;Reorder services by dragging and dropping as they appear above.", "add-to-any"); ?></p>
            	<ul id="addtoany_services_selectable" class="addtoany_admin_list">
            		<li id="a2a_wp_facebook_like" class="addtoany_special_service" title="Facebook Like button">
                        <span><img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/icons/facebook_like.png'; ?>" width="50" height="20" alt="Facebook Like" /></span>
                    </li>
					<li id="a2a_wp_twitter_tweet" class="addtoany_special_service" title="Twitter Tweet button">
                        <span><img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/icons/twitter_tweet.png'; ?>" width="55" height="20" alt="Twitter Tweet" /></span>
                    </li>
                    <li id="a2a_wp_google_plusone" class="addtoany_special_service" title="Google +1 button">
                        <span><img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/icons/google_plusone.png'; ?>" width="32" height="20" alt="Google +1" /></span>
                    </li>
				<?php
					// Show all services
					$active_services = $options['active_services'];
					if( !$active_services )
						$active_services = Array();
					
                    foreach ($A2A_SHARE_SAVE_services as $service_safe_name=>$site) { 
						if (isset($site['href']))
							$custom_service = TRUE;
						else
							$custom_service = FALSE;
						if ( ! isset($site['icon']))
							$site['icon'] = 'default';
					?>
                        <li id="a2a_wp_<?php echo $service_safe_name; ?>" title="<?php echo $site['name']; ?>">
                            <span><img src="<?php echo ($site['icon_url']) ? $site['icon_url'] : $A2A_SHARE_SAVE_plugin_url_path.'/icons/'.$site['icon'].'.png'; ?>" width="<?php echo (isset($site['icon_width'])) ? $site['icon_width'] : '16'; ?>" height="<?php echo (isset($site['icon_height'])) ? $site['icon_height'] : '16'; ?>" alt="" /><?php echo $site['name']; ?></span>
                        </li>
				<?php
                    } ?>
                </ul>
            </fieldset></td>
            </tr>
        	<tr valign="top">
            <th scope="row"><?php _e("Button", "add-to-any"); ?></th>
            <td><fieldset>
            	<label>
                	<input name="A2A_SHARE_SAVE_button" value="favicon.png|16|16" type="radio"<?php if($options['button']=='favicon.png|16|16') echo ' checked="checked"'; ?>
                    	 style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/favicon.png'; ?>" width="16" height="16" border="0" style="padding:9px;vertical-align:middle" alt="+ <?php _e('Share/Bookmark','add-to-any'); ?>" title="+ <?php _e('Share/Bookmark','add-to-any'); ?>"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label>
                <input name="A2A_SHARE_SAVE_button_favicon_16_16_text" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SHARE_SAVE_button');e[e.length-7].checked=true" style="vertical-align:middle;width:150px"
                	value="<?php echo ( trim($options['button_text']) != '' ) ? stripslashes($options['button_text']) : __('Share/Bookmark','add-to-any'); ?>" />
                <label style="padding-left:9px">
                	<input name="A2A_SHARE_SAVE_button" value="share_16_16.png|16|16" type="radio"<?php if($options['button']=='share_16_16.png|16|16') echo ' checked="checked"'; ?>
                    	 style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/share_16_16.png'; ?>" width="16" height="16" border="0" style="padding:9px;vertical-align:middle" alt="+ <?php _e('Share/Bookmark','add-to-any'); ?>" title="+ <?php _e('Share/Bookmark','add-to-any'); ?>"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label>
                <input name="A2A_SHARE_SAVE_button_share_16_16_text" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SHARE_SAVE_button');e[e.length-6].checked=true" style="vertical-align:middle;width:150px"
                	value="<?php echo ( trim($options['button_text']) != '' ) ? stripslashes($options['button_text']) : __('Share/Bookmark','add-to-any'); ?>" /><br>
                <label>
                	<input name="A2A_SHARE_SAVE_button" value="share_save_120_16.png|120|16" type="radio"<?php if($options['button']=='share_save_120_16.png|120|16') echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/share_save_120_16.png'; ?>" width="120" height="16" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label><br>
                <label>
                	<input name="A2A_SHARE_SAVE_button" value="share_save_171_16.png|171|16" type="radio"<?php if( !$options['button'] || $options['button']=='share_save_171_16.png|171|16' ) echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/share_save_171_16.png'; ?>" width="171" height="16" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label><br>
                <label>
                	<input name="A2A_SHARE_SAVE_button" value="share_save_256_24.png|256|24" type="radio"<?php if($options['button']=='share_save_256_24.png|256|24') echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo $A2A_SHARE_SAVE_plugin_url_path.'/share_save_256_24.png'; ?>" width="256" height="24" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
				</label><br>
                <label>
                	<input name="A2A_SHARE_SAVE_button" value="CUSTOM" type="radio"<?php if( $options['button'] == 'CUSTOM' ) echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
					<span style="margin:0 9px;vertical-align:middle"><?php _e("Image URL"); ?>:</span>
				</label>
  				<input name="A2A_SHARE_SAVE_button_custom" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SHARE_SAVE_button');e[e.length-2].checked=true" style="vertical-align:middle"
                	value="<?php echo $options['button_custom']; ?>" /><br>
				<label>
                	<input name="A2A_SHARE_SAVE_button" value="TEXT" type="radio"<?php if( $options['button'] == 'TEXT' ) echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
					<span style="margin:0 9px;vertical-align:middle"><?php _e("Text only"); ?>:</span>
				</label>
                <input name="A2A_SHARE_SAVE_button_text" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SHARE_SAVE_button');e[e.length-1].checked=true" style="vertical-align:middle;width:150px"
                	value="<?php echo ( trim($options['button_text']) != '' ) ? stripslashes($options['button_text']) : __('Share/Bookmark','add-to-any'); ?>" />
                
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Placement', 'add-to-any'); ?></th>
            <td><fieldset>
                <label>
                	<input id="A2A_SHARE_SAVE_display_in_posts" name="A2A_SHARE_SAVE_display_in_posts" type="checkbox"<?php 
						if($options['display_in_posts']!='-1') echo ' checked="checked"'; ?> value="1"/>
                	<?php printf(__('Display at the %s of posts', 'add-to-any'), position_in_content($options, TRUE)); ?> <strong>*</strong>
                </label><br/>
                <label>
                	&nbsp; &nbsp; &nbsp; <input class="A2A_SHARE_SAVE_child_of_display_in_posts" name="A2A_SHARE_SAVE_display_in_excerpts" type="checkbox"<?php 
						if($options['display_in_excerpts']!='-1') echo ' checked="checked"';
						if($options['display_in_posts']=='-1') echo ' disabled="disabled"';
						?> value="1"/>
					<?php printf(__('Display at the %s of post excerpts', 'add-to-any'), position_in_content($options)); ?>
				</label><br/>
				<label>
                	&nbsp; &nbsp; &nbsp; <input class="A2A_SHARE_SAVE_child_of_display_in_posts" name="A2A_SHARE_SAVE_display_in_posts_on_front_page" type="checkbox"<?php 
						if($options['display_in_posts_on_front_page']!='-1') echo ' checked="checked"';
						if($options['display_in_posts']=='-1') echo ' disabled="disabled"';
						?> value="1"/>
                    <?php printf(__('Display at the %s of posts on the front page', 'add-to-any'), position_in_content($options)); ?>
				</label><br/>
                
				<label>
                	&nbsp; &nbsp; &nbsp; <input class="A2A_SHARE_SAVE_child_of_display_in_posts" name="A2A_SHARE_SAVE_display_in_feed" type="checkbox"<?php 
						if($options['display_in_feed']!='-1') echo ' checked="checked"'; 
						if($options['display_in_posts']=='-1') echo ' disabled="disabled"';
						?> value="1"/>
					<?php printf(__('Display at the %s of posts in the feed', 'add-to-any'), position_in_content($options)); ?>
				</label><br/>
                <label>
                	<input name="A2A_SHARE_SAVE_display_in_pages" type="checkbox"<?php if($options['display_in_pages']!='-1') echo ' checked="checked"'; ?> value="1"/>
                    <?php printf(__('Display at the %s of pages', 'add-to-any'), position_in_content($options, TRUE)); ?>
				</label>
                <br/><br/>
                <div class="setting-description">
                	<strong>*</strong> <?php _e("If unchecked, be sure to place the following code in <a href=\"theme-editor.php\">your template pages</a> (within <code>index.php</code>, <code>single.php</code>, and/or <code>page.php</code>)", "add-to-any"); ?>: <span id="addtoany_show_template_button_code" class="button-secondary">&#187;</span>
                    <div id="addtoany_template_button_code">
                      <code>&lt;?php if( function_exists('ADDTOANY_SHARE_SAVE_KIT') ) { ADDTOANY_SHARE_SAVE_KIT(); } ?&gt;</code>
                    </div>
                    <noscript><code>&lt;?php if( function_exists('ADDTOANY_SHARE_SAVE_KIT') ) { ADDTOANY_SHARE_SAVE_KIT(); } ?&gt;</code></noscript>
                </div>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Menu Style', 'add-to-any'); ?></th>
            <td><fieldset>
					<p><?php _e("Using AddToAny's Menu Styler, you can customize the colors of your Share/Save menu! When you're done, be sure to paste the generated code in the <a href=\"#\" onclick=\"document.getElementById('A2A_SHARE_SAVE_additional_js_variables').focus();return false\">Additional Options</a> box below.", "add-to-any"); ?></p>
                    <p>
                		<a href="http://www.addtoany.com/buttons/share_save/menu_style/wordpress" class="button-secondary" title="<?php _e("Open the AddToAny Menu Styler in a new window", "add-to-any"); ?>" target="_blank"
                        	onclick="document.getElementById('A2A_SHARE_SAVE_additional_js_variables').focus();
                            	document.getElementById('A2A_SHARE_SAVE_menu_styler_note').style.display='';"><?php _e("Open Menu Styler", "add-to-any"); ?></a>
					</p>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Menu Options', 'add-to-any'); ?></th>
            <td><fieldset>
                <label>
                	<input name="A2A_SHARE_SAVE_onclick" 
                        type="checkbox"<?php if($options['onclick']=='1') echo ' checked="checked"'; ?> value="1"/>
                	<?php _e('Only show the menu when the user clicks the Share/Save button', 'add-to-any'); ?>
                </label><br />
				<label>
                	<input name="A2A_SHARE_SAVE_show_title" 
                        type="checkbox"<?php if($options['show_title']=='1') echo ' checked="checked"'; ?> value="1"/>
                	<?php _e('Show the title of the post (or page) within the menu', 'add-to-any'); ?>
                </label>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Additional Options', 'add-to-any'); ?></th>
            <td><fieldset>
            		<p id="A2A_SHARE_SAVE_menu_styler_note" style="display:none">
                        <label for="A2A_SHARE_SAVE_additional_js_variables" class="updated">
                            <strong><?php _e("Paste the code from AddToAny's Menu Styler in the box below!", 'add-to-any'); ?></strong>
                        </label>
                    </p>
                    <label for="A2A_SHARE_SAVE_additional_js_variables">
                    	<p><?php _e('Below you can set special JavaScript variables to apply to each Share/Save menu.', 'add-to-any'); ?>
                    	<?php _e("Advanced users might want to explore AddToAny's <a href=\"http://www.addtoany.com/buttons/customize/\" target=\"_blank\">additional options</a>.", "add-to-any"); ?></p>
					</label>
                    <p>
                		<textarea name="A2A_SHARE_SAVE_additional_js_variables" id="A2A_SHARE_SAVE_additional_js_variables" class="code" style="width: 98%; font-size: 12px;" rows="6" cols="50"><?php echo stripslashes($options['additional_js_variables']); ?></textarea>
					</p>
                    <?php if( $options['additional_js_variables']!='' ) { ?>
                    <label for="A2A_SHARE_SAVE_additional_js_variables" class="setting-description"><?php _e("<strong>Note</strong>: If you're adding new code, be careful not to accidentally overwrite any previous code.</label>", 'add-to-any'); ?>
					<?php } ?>	
			</fieldset></td>
            </tr>
			<tr valign="top">
            <th scope="row"><?php _e('Advanced Options', 'add-to-any'); ?></th>
            <td><fieldset>
            	<label for="A2A_SHARE_SAVE_inline_css">
					<input name="A2A_SHARE_SAVE_inline_css" id="A2A_SHARE_SAVE_inline_css"
                    	type="checkbox"<?php if($options['inline_css']!='-1') echo ' checked="checked"'; ?> value="1"/>
            	<?php _e('Use CSS stylesheet', 'add-to-any'); ?>
				</label><br/>
				<label for="A2A_SHARE_SAVE_cache">
					<input name="A2A_SHARE_SAVE_cache" id="A2A_SHARE_SAVE_cache" 
                    	type="checkbox"<?php if($options['cache']=='1') echo ' checked="checked"'; ?> value="1"/>
            	<?php _e('Cache AddToAny locally with daily cache updates', 'add-to-any'); ?> <strong>**</strong>
				</label>
				<br/><br/>
                <div class="setting-description">
					<strong>**</strong> <?php _e("Only consider for sites with frequently returning visitors. Since many visitors will have AddToAny cached in their browser already, serving AddToAny locally from your site will be slower for those visitors.  Be sure to set far future cache/expires headers for image files in your <code>uploads/addtoany</code> directory.", "add-to-any"); ?>
				</div>
            </fieldset></td>
            </tr>
        </table>
        
        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'add-to-any' ) ?>" />
            <input id="A2A_SHARE_SAVE_reset_options" type="submit" name="Reset" onclick="return confirm('<?php _e('Are you sure you want to delete all AddToAny options?', 'add-to-any' ) ?>')" value="<?php _e('Reset', 'add-to-any' ) ?>" />
        </p>
    
    </form>
    
    <h2><?php _e('Like this plugin?','add-to-any'); ?></h2>
    <p><?php _e('<a href="http://wordpress.org/extend/plugins/add-to-any/">Give it a good rating</a> on WordPress.org.','add-to-any'); ?> <a href="http://www.facebook.com/AddToAny">Facebook</a> / <a href="http://twitter.com/AddToAny">Twitter</a></p>
    <p><?php _e('<a href="http://www.addtoany.com/share_save?linkname=WordPress%20Share%20%2F%20Bookmark%20Plugin%20by%20AddToAny.com&amp;linkurl=http%3A%2F%2Fwordpress.org%2Fextend%2Fplugins%2Fadd-to-any%2F">Share it</a> with your friends.','add-to-any'); ?></p>
    
    <h2><?php _e('Need support?','add-to-any'); ?></h2>
    <p><?php _e('See the <a href="http://wordpress.org/extend/plugins/add-to-any/faq/">FAQs</a>.','add-to-any'); ?></p>
    <p><?php _e('Search the <a href="http://wordpress.org/tags/add-to-any">support forums</a>.','add-to-any'); ?></p>
    </div>

<?php
 
}

// Admin page header
function A2A_SHARE_SAVE_admin_head() {
	if (isset($_GET['page']) && $_GET['page'] == 'add-to-any.php') {
      
		$options = get_option('addtoany_options');
  
	?>
	<script type="text/javascript"><!--
	jQuery(document).ready(function(){
		
		// Toggle child options of 'Display in posts'
		jQuery('#A2A_SHARE_SAVE_display_in_posts').bind('change click', function(e){
			if (jQuery(this).is(':checked'))
				jQuery('.A2A_SHARE_SAVE_child_of_display_in_posts').attr('checked', true).attr('disabled', false);
			else 
				jQuery('.A2A_SHARE_SAVE_child_of_display_in_posts').attr('checked', false).attr('disabled', true);
		});
		
		// Update button position labels/values universally in Placement section 
		jQuery('select[name="A2A_SHARE_SAVE_position"]').bind('change click', function(e){
			var $this = jQuery(this);
			jQuery('select[name="A2A_SHARE_SAVE_position"]').not($this).val($this.val());
			
			jQuery('.A2A_SHARE_SAVE_position').html($this.find('option:selected').html());
		});
	
		var to_input = function(this_sortable){
			// Clear any previous services stored as hidden inputs
			jQuery('input[name="A2A_SHARE_SAVE_active_services[]"]').remove();
			
			var services_array = jQuery(this_sortable).sortable('toArray'),
				services_size = services_array.length;
			if(services_size<1) return;
			
			for(var i=0, service_name; i < services_size; i++){
				if(services_array[i]!='') { // Exclude dummy icon
					jQuery('form:first').append('<input name="A2A_SHARE_SAVE_active_services[]" type="hidden" value="'+services_array[i]+'"/>');
					
					// Special service options?
					service_name = services_array[i].substr(7);
					if (service_name == 'facebook_like' || service_name == 'twitter_tweet' || service_name == 'google_plusone') {
						if ((service_name == 'twitter_tweet' || service_name == 'google_plusone') && jQuery('#' + services_array[i] + '_show_count').is(':checked'))
							jQuery('form:first').append('<input name="addtoany_' + service_name + '_show_count" type="hidden" value="1"/>');
						if ((service_name == 'facebook_like') && jQuery('#' + services_array[i] + '_verb').val() == 'recommend')
							jQuery('form:first').append('<input name="addtoany_' + service_name + '_verb" type="hidden" value="recommend"/>');
					}
				}
			}
		};
	
		jQuery('#addtoany_services_sortable').sortable({
			forcePlaceholderSize: true,
			items: 'li:not(#addtoany_show_services, .dummy)',
			placeholder: 'ui-sortable-placeholder',
			opacity: .6,
			tolerance: 'pointer',
			update: function(){to_input(this)}
		});
		
		// Service click = move to sortable list
		var moveToSortableList = function(){
			var configurable_html = '',
				this_service = jQuery(this),
				this_service_name = this_service.attr('id').substr(7),
				checked = '',
				special_options = '';
			
			if (jQuery('#addtoany_services_sortable li').not('.dummy').length == 0)
				jQuery('#addtoany_services_sortable').find('.dummy').hide();
				
			if (this_service.hasClass('addtoany_special_service')) {
				if (this_service_name == 'facebook_like') {
					if (service_options[this_service_name] && service_options[this_service_name].verb)
						checked = ' selected="selected"';
					special_options_html = '<select id="' + this_service.attr('id') + '_verb" name="' + this_service.attr('id') + '_verb">'
						+ '<option value="like">Like</option>'
						+ '<option' + checked + ' value="recommend">Recommend</option>'
						+ '</select>';
				} else {
					// twitter_tweet & google_plusone
					if (service_options[this_service_name] && service_options[this_service_name].show_count)
						checked = ' checked="checked"';
					special_options_html = '<label><input' + checked + ' id="' + this_service.attr('id') + '_show_count" name="' + this_service.attr('id') + '_show_count" type="checkbox" value="1"> Show count</label>';
				}
				
				configurable_html = '<span class="down_arrow"></span><br style="clear:both"/><div class="special_options">' + special_options_html + '</div>';
			}
			
			this_service.toggleClass('addtoany_selected')
			.unbind('click', moveToSortableList)
			.bind('click', moveToSelectableList)
			.clone()
			.html( this_service.find('img').clone().attr('alt', this_service.attr('title')) ).append(configurable_html)
			.click(function(){
				jQuery(this).not('.addtoany_special_service_options_selected').find('.special_options').slideDown('fast').parent().addClass('addtoany_special_service_options_selected');
			})
			.hide()
			.insertBefore('#addtoany_services_sortable .dummy')
			.fadeIn('fast');
			
			this_service.attr( 'id', 'old_'+this_service.attr('id') );
		};
		
		// Service click again = move back to selectable list
		var moveToSelectableList = function(){
			jQuery(this).toggleClass('addtoany_selected')
			.unbind('click', moveToSelectableList)
			.bind('click', moveToSortableList);
	
			jQuery( '#'+jQuery(this).attr('id').substr(4).replace(/\./, '\\.') )
			.hide('fast', function(){
				jQuery(this).remove();
			});
			
			
			if( jQuery('#addtoany_services_sortable li').not('.dummy').length==1 )
				jQuery('#addtoany_services_sortable').find('.dummy').show();
			
			jQuery(this).attr('id', jQuery(this).attr('id').substr(4));
		};
		
		// Service click = move to sortable list
		jQuery('#addtoany_services_selectable li').bind('click', moveToSortableList);
        
        // Form submit = get sortable list
        jQuery('form').submit(function(){to_input('#addtoany_services_sortable')});
        
        // Auto-select active services
        <?php
		$admin_services_saved = is_array($_POST['A2A_SHARE_SAVE_active_services']) || isset($_POST['Submit']);
		$active_services = ( $admin_services_saved )
			? $_POST['A2A_SHARE_SAVE_active_services'] : $options['active_services'];
		if( ! $active_services )
			$active_services = Array();
		$active_services_last = end($active_services);
		if($admin_services_saved)
			$active_services_last = substr($active_services_last, 7); // Remove a2a_wp_
		$active_services_quoted = '';
		foreach ($active_services as $service) {
			if($admin_services_saved)
				$service = substr($service, 7); // Remove a2a_wp_
			$active_services_quoted .= '"'.$service.'"';
			if ( $service != $active_services_last )
				$active_services_quoted .= ',';
		}
		?>
        var services = [<?php echo $active_services_quoted; ?>],
        	service_options = {};
        
        <?php		
		// Special service options
		if ( $_POST['addtoany_facebook_like_verb'] == 'recommend' || $options['special_facebook_like_options']['verb'] == 'recommend') {
			?>service_options.facebook_like = {verb: 'recommend'};<?php
		}
		if ( $_POST['addtoany_twitter_tweet_show_count'] == '1' || $options['special_twitter_tweet_options']['show_count'] == '1') {
			?>service_options.twitter_tweet = {show_count: 1};<?php
		}
		if ( $_POST['addtoany_google_plusone_show_count'] == '1' || $options['special_google_plusone_options']['show_count'] == '1') {
			?>service_options.google_plusone = {show_count: 1};<?php
		}
		?>
        
        jQuery.each(services, function(i, val){
        	jQuery('#a2a_wp_'+val).click();
		});
		
		// Add/Remove Services
		jQuery('#addtoany_services_sortable .dummy:first').after('<li id="addtoany_show_services"><?php _e('Add/Remove Services', 'add-to-any'); ?> &#187;</li>');
		jQuery('#addtoany_show_services').click(function(e){
			jQuery('#addtoany_services_selectable, #addtoany_services_info').slideDown('fast');
			jQuery(this).fadeOut('fast');
		});
		jQuery('#addtoany_show_template_button_code').click(function(e){
			jQuery('#addtoany_template_button_code').slideDown('fast');
			jQuery(this).fadeOut('fast');
		});
		jQuery('#addtoany_show_css_code').click(function(e){
			jQuery('#addtoany_css_code').slideDown('fast');
			jQuery(this).fadeOut('fast');
		});
	});
	--></script>

	<style type="text/css">
	.ui-sortable-placeholder{background-color:transparent;border:1px dashed #AAA !important;}
	.addtoany_admin_list{list-style:none;padding:0;margin:0;}
	.addtoany_admin_list li{-webkit-border-radius:9px;-moz-border-radius:9px;border-radius:9px;}
	
	#addtoany_services_selectable{clear:left;display:none;}
	#addtoany_services_selectable li{cursor:crosshair;float:left;width:150px;font-size:11px;margin:0;padding:6px;border:1px solid transparent;_border-color:#FAFAFA/*IE6*/;overflow:hidden;}
	<?php // white-space:nowrap could go above, but then webkit does not wrap floats if parent has no width set; wrapping in <span> instead (below) ?>
	#addtoany_services_selectable li span{white-space:nowrap;}
	#addtoany_services_selectable li:hover, #addtoany_services_selectable li.addtoany_selected{border:1px solid #AAA;background-color:#FFF;}
	#addtoany_services_selectable li.addtoany_selected:hover{border-color:#F00;}
	#addtoany_services_selectable li:active{border:1px solid #000;}
	#addtoany_services_selectable img{margin:0 4px;width:16px;height:16px;border:0;vertical-align:middle;}
	#addtoany_services_selectable .addtoany_special_service{padding:3px 6px;}
	#addtoany_services_selectable .addtoany_special_service img{width:auto;height:20px;}
	
	#addtoany_services_sortable li, #addtoany_services_sortable li.dummy:hover{cursor:move;float:left;padding:9px;border:1px solid transparent;_border-color:#FAFAFA/*IE6*/;}
	#addtoany_services_sortable li:hover{border:1px solid #AAA;background-color:#FFF;}
	#addtoany_services_sortable li.dummy, #addtoany_services_sortable li.dummy:hover{cursor:auto;background-color:transparent;}
	#addtoany_services_sortable img{width:16px;height:16px;border:0;vertical-align:middle;}
	#addtoany_services_sortable .addtoany_special_service img{width:auto;height:20px;float:left;}
	#addtoany_services_sortable .addtoany_special_service span.down_arrow{background:url(<?php echo admin_url( '/images/menu-bits.gif' ); ?>) no-repeat -2px -110px;float:right;height:30px;;margin:-5px 0 -6px 5px;width:20px;}
	#addtoany_services_sortable .addtoany_special_service div.special_options{display:none;font-size:11px;margin-top:9px;}
	#addtoany_services_sortable .addtoany_special_service_options_selected{border:1px solid #AAA;background-color:#FFF;}
	#addtoany_services_sortable .addtoany_special_service_options_selected span.down_arrow{display:none;}
	
	li#addtoany_show_services{border:1px solid #DFDFDF;background-color:#FFF;cursor:pointer;}
	li#addtoany_show_services:hover{border:1px solid #AAA;}
	#addtoany_services_info{clear:left;display:none;}
	
	#addtoany_template_button_code, #addtoany_css_code{display:none;}
	
	#A2A_SHARE_SAVE_reset_options{color:red;margin-left: 15px;}
  </style>
<?php

	}
}

add_filter('admin_head', 'A2A_SHARE_SAVE_admin_head');

function A2A_SHARE_SAVE_add_menu_link() {
		
	if( current_user_can('manage_options') ) {
		$page = add_options_page(
			'AddToAny: '. __("Share/Save", "add-to-any"). " " . __("Settings")
			, __("AddToAny", "add-to-any")
			, 'activate_plugins' 
			, basename(__FILE__)
			, 'A2A_SHARE_SAVE_options_page'
		);
		
		/* Using registered $page handle to hook script load, to only load in AddToAny admin */
        add_filter('admin_print_scripts-' . $page, 'A2A_SHARE_SAVE_scripts');
	}
}

function A2A_SHARE_SAVE_scripts() {
	wp_enqueue_script('jquery-ui-sortable');
}


function A2A_SHARE_SAVE_widget_init() {
	global $A2A_SHARE_SAVE_plugin_dir;
	
    include_once($A2A_SHARE_SAVE_plugin_dir . '/add-to-any-wp-widget.php');
    register_widget('A2A_SHARE_SAVE_Widget');
}

add_action('widgets_init', 'A2A_SHARE_SAVE_widget_init');


add_filter('admin_menu', 'A2A_SHARE_SAVE_add_menu_link');

// Place in Option List on Settings > Plugins page 
function A2A_SHARE_SAVE_actlinks( $links, $file ){
	// Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	
	if ( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=add-to-any.php">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}

add_filter("plugin_action_links", 'A2A_SHARE_SAVE_actlinks', 10, 2);


?>