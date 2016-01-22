<?php
/*
Plugin Name: Lightbox 2
Plugin URI: http://www.stimuli.ca/lightbox/
Description: Used to overlay images on the current page. Lightbox JS v2.2 by <a href="http://www.huddletogether.com/projects/lightbox2/" title="Lightbox JS v2.2 ">Lokesh Dhakar</a>. Now with better regular expressions, courtesy of <a href="http://atastypixel.com/" title="visit his site">Michael Tyson</a>!
Version: 2.9.2
Author: Rupert Morris
Author URI: http://www.stimuli.ca/
*/

/* Where our theme reside: */
$lightbox_2_theme_path = (dirname(__FILE__)."/Themes");
update_option('lightbox_2_theme_path', $lightbox_2_theme_path);
/* Set the default theme to Black */
add_option('lightbox_2_theme', 'Black');
add_option('lightbox_2_automate', 1);
add_option('lightbox_2_resize_on_demand', 0);

/* use WP_PLUGIN_URL if version of WP >= 2.6.0. If earlier, use wp_url */
//if($wp_version >= '2.6.0') {
	$stimuli_lightbox_plugin_prefix = WP_PLUGIN_URL."/lightbox-2/"; /* plugins dir can be anywhere after WP2.6 */
//} else {
//	$stimuli_lightbox_plugin_prefix = get_bloginfo('wpurl')."/wp-content/plugins/lightbox-2/";
//}

/* options page (required for saving prefs)*/
$options_page = get_option('siteurl') . '/wp-admin/admin.php?page=lightbox-2/options.php';
/* Adds our admin options under "Options" */
function lightbox_2_options_page() {
	add_options_page('Lightbox Options', 'Lightbox 2', 'level_10', 'lightbox-2/options.php');
}

function lightbox_styles() {
	/* What version of WP is running? */
	global $wp_version;
	global $stimuli_lightbox_plugin_prefix;
    /* The next line figures out where the javascripts and images and CSS are installed,
    relative to your wordpress server's root: */
    $lightbox_2_theme = urldecode(get_option('lightbox_2_theme'));
    $lightbox_style = ($stimuli_lightbox_plugin_prefix."Themes/".$lightbox_2_theme."/");

    /* The xhtml header code needed for lightbox to work: */
	$lightboxscript = "
	<!-- begin lightbox scripts -->
	<script type=\"text/javascript\">
    //<![CDATA[
    document.write('<link rel=\"stylesheet\" href=\"".$lightbox_style."lightbox.css\" type=\"text/css\" media=\"screen\" />');
    //]]>
    </script>
	<!-- end lightbox scripts -->\n";
	/* Output $lightboxscript as text for our web pages: */
	echo($lightboxscript);
}

/* Added a code to automatically insert rel="lightbox[nameofpost]" to every image with no manual work. 
If there are already rel="lightbox[something]" attributes, they are not clobbered. 
Michael Tyson, you are a regular expressions god! ;) 
http://atastypixel.com
*/
function autoexpand_rel_wlightbox ($content) {
	global $post;
	$pattern        = "/(<a(?![^>]*?rel=['\"]lightbox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
	$replacement    = '$1 rel="lightbox['.$post->ID.']">';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

if (get_option('lightbox_2_automate') == 1){
	add_filter('the_content', 'autoexpand_rel_wlightbox', 99);
	add_filter('the_excerpt', 'autoexpand_rel_wlightbox', 99);
}

/* To resize images, or not to resize; that is the question */
$resize_images_or_not = get_option('lightbox_2_resize_on_demand');
if ($resize_images_or_not == 1) {
	$stimuli_lightbox_js = "lightbox-resize.js"; 
} else {
	$stimuli_lightbox_js = "lightbox.js"; 
}

if (!is_admin()) { // if we are *not* viewing an admin page, like writing a post or making a page:
	wp_enqueue_script('lightbox', ($stimuli_lightbox_plugin_prefix.$stimuli_lightbox_js), array('scriptaculous-effects'), '1.8');
}

/* we want to add the above xhtml to the header of our pages: */
add_action('wp_head', 'lightbox_styles');
add_action('admin_menu', 'lightbox_2_options_page');
?>
