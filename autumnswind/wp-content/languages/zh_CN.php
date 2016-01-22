<?php
/**
 * WordPress China Localization Patches Collection
 */

/**
 * Legacy database options cleanup
 *
 * Cleanup of all options that were introduced pre-3.4.
 * To save time, this function is only to be called on admin pages.
 *
 * @since 3.4.0
 */
function zh_cn_l10n_legacy_option_cleanup() {
  // 3.3 series
  delete_site_option( 'zh_cn_l10n_preference_patches' );
  
  // 3.0.5, 3.1 series, 3.2 series
  delete_site_option( 'zh_cn_language_pack_enable_chinese_fake_oembed' );
  
  // 3.0.1, 3.0.2, 3.0.3, 3.0.4
  delete_site_option( 'zh_cn_language_pack_options_version' );
  delete_site_option( 'zh_cn_language_pack_enable_backend_style_modifications' );
  
  // awkward ones...
  delete_site_option( 'zh_cn_language_pack_enable_icpip_num_show' );
  delete_site_option( 'zh_cn_language_pack_icpip_num' );
  delete_site_option( 'zh_cn_language_pack_is_configured' );
  
}
add_action( 'admin_init', 'zh_cn_l10n_legacy_option_cleanup' );


/**
 * Tudou wp_embed handler
 *
 * Embed code last updated:
 *  Tue, 05 Jun 2012 22:23:03 -0400 
 *
 * Feel free to submit or correct URL formats here:
 *  http://cn.wordpress.org/contact/
 *
 * @since 3.4.0
 */
function wp_embed_handler_tudou( $matches, $attr, $url, $rawattr ) {
  $embed = sprintf(
    '<embed src="http://www.tudou.com/v/%1$s/&resourceId=0_05_05_99&bid=05/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400"></embed>',
    esc_attr( $matches['video_id'] ) );

  return apply_filters( 'embed_tudou', $embed, $matches, $attr, $url, $rawattr );
}
wp_embed_register_handler( 'tudou', 
  '#https?://(?:www\.)?tudou\.com/(?:programs/view|listplay/(?<list_id>[a-z0-9_=\-]+))/(?<video_id>[a-z0-9_=\-]+)#i', 
  'wp_embed_handler_tudou' );


/**
 * 56.com wp_embed handler
 *
 * Embed code last updated:
 *  Tue, 05 Jun 2012 23:03:29 -0400 
 *
 * Feel free to submit or correct URL formats here:
 *  http://cn.wordpress.org/contact/
 *
 * @since 3.4.0
 */
function wp_embed_handler_56com( $matches, $attr, $url, $rawattr ) {
  $matches['video_id'] = $matches['video_id1'] == '' ? 
    $matches['video_id2'] : $matches['video_id1'];
  
  $embed = sprintf(
    "<embed src='http://player.56.com/v_%1\$s.swf'  type='application/x-shockwave-flash' width='480' height='405' allowFullScreen='true' allowNetworking='all' allowScriptAccess='always'></embed>",
    esc_attr( $matches['video_id'] ) );

  return apply_filters( 'embed_56com', $embed, $matches, $attr, $url, $rawattr );
}
wp_embed_register_handler( '56com', 
  '#https?://(?:www\.)?56\.com/[a-z0-9]+/(?:play_album\-aid\-[0-9]+_vid\-(?<video_id1>[a-z0-9_=\-]+)|v_(?<video_id2>[a-z0-9_=\-]+))#i', 
  'wp_embed_handler_56com' );


/**
 * Youku wp_embed handler
 *
 * Embed code last updated:
 *  Wed, 06 Jun 2012 00:36:11 -0400 
 *
 * Feel free to submit or correct URL formats here:
 *  http://cn.wordpress.org/contact/
 *
 * @since 3.4.0
 */
function wp_embed_handler_youku( $matches, $attr, $url, $rawattr ) {
  $embed = sprintf(
    '<embed src="http://player.youku.com/player.php/sid/%1$s/v.swf" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>',
    esc_attr( $matches['video_id'] ) );

  return apply_filters( 'embed_youku', $embed, $matches, $attr, $url, $rawattr );
}
wp_embed_register_handler( 'youku', 
  '#https?://v\.youku\.com/v_show/id_(?<video_id>[a-z0-9_=\-]+)#i', 
  'wp_embed_handler_youku' );


/**
 * Chinese administration screens style - enqueue stylesheet
 *
 * This patch serves as a work-around to fix the font-size and font-style.
 *
 * Submit better CSS rules here:
 *  http://cn.wordpress.org/contact/
 *
 * @since 3.3.0
 */
function zh_cn_l10n_patch_admin_screens_style_enqueue_stylesheet() {
  wp_register_style( 'zh-cn-l10n-administration-screens', 
    content_url( ( WP_DEBUG ? '/languages/zh_CN-administration-screens.dev.css' : '/languages/zh_CN-administration-screens.css' ) ), 
    array( 'wp-admin' ), 
    '20111120');
  wp_enqueue_style( 'zh-cn-l10n-administration-screens' );
}
add_action( 'admin_init', 
  'zh_cn_l10n_patch_admin_screens_style_enqueue_stylesheet' );


/**
 * Chinese character count - register script
 *
 * This patch serves as a work-around to fix the built-in word-count.js.
 * 
 * The sum of Chinese characters and English words will show up in "word count"
 * field once enabled.
 *
 * @since 3.3.0
 */
function zh_cn_l10n_patch_character_count_register_script() {
  wp_deregister_script( 'word-count' );
  wp_register_script( 'word-count', 
    content_url( ( WP_DEBUG ? '/languages/zh_CN-word-count.dev.js' : '/languages/zh_CN-word-count.js' ) ), 
    array( 'jquery' ), 
    '20120605' );
}
add_action( 'admin_footer', 
  'zh_cn_l10n_patch_character_count_register_script' );


?>
