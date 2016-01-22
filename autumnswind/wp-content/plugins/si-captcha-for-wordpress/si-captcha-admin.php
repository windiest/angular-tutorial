<?php
/*
SI CAPTCHA Anti-Spam
http://www.642weather.com/weather/scripts-wordpress-captcha.php
Adds CAPTCHA anti-spam methods to WordPress on the comment form, registration form, login, or all. This prevents spam from automated bots. Also is WPMU and BuddyPress compatible. <a href="plugins.php?page=si-captcha-for-wordpress/si-captcha.php">Settings</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KXJWLPPWZG83S">Donate</a>

Author: Mike Challis
http://www.642weather.com/weather/scripts.php
*/

  if (isset($_POST['submit'])) {

      if ( function_exists('current_user_can') && !current_user_can('manage_options') )
            die(__('You do not have permissions for managing this option', 'si-captcha'));

        check_admin_referer( 'si-captcha-options_update'); // nonce
   // post changes to the options array
   $optionarray_update = array(
         'si_captcha_captcha_difficulty' =>   (trim($_POST['si_captcha_captcha_difficulty']) != '' ) ? trim($_POST['si_captcha_captcha_difficulty']) : $si_captcha_option_defaults['si_captcha_captcha_difficulty'], // use default if empty
         'si_captcha_donated' =>            (isset( $_POST['si_captcha_donated'] ) ) ? 'true' : 'false',// true or false
         'si_captcha_perm' =>               (isset( $_POST['si_captcha_perm'] ) ) ? 'true' : 'false',
         'si_captcha_perm_level' =>           (trim($_POST['si_captcha_perm_level']) != '' ) ? trim($_POST['si_captcha_perm_level']) : $si_captcha_option_defaults['si_captcha_perm_level'], // use default if empty
         'si_captcha_comment' =>            (isset( $_POST['si_captcha_comment'] ) ) ? 'true' : 'false',
         'si_captcha_comment_label_position' => (trim($_POST['si_captcha_comment_label_position']) != '' ) ? trim($_POST['si_captcha_comment_label_position'])   : $si_captcha_option_defaults['si_captcha_comment_label_position'], // use default if empty
         'si_captcha_login' =>              (isset( $_POST['si_captcha_login'] ) ) ? 'true' : 'false',
         'si_captcha_register' =>           (isset( $_POST['si_captcha_register'] ) ) ? 'true' : 'false',
         'si_captcha_lostpwd' =>            (isset( $_POST['si_captcha_lostpwd'] ) ) ? 'true' : 'false',
         'si_captcha_rearrange' =>          (isset( $_POST['si_captcha_rearrange'] ) ) ? 'true' : 'false',
         'si_captcha_disable_session' =>    'false',
         'si_captcha_captcha_small' =>      (isset( $_POST['si_captcha_captcha_small'] ) ) ? 'true' : 'false',
         'si_captcha_no_trans' =>           (isset( $_POST['si_captcha_no_trans'] ) ) ? 'true' : 'false',
         'si_captcha_aria_required' =>      (isset( $_POST['si_captcha_aria_required'] ) ) ? 'true' : 'false',
         'si_captcha_external_style' =>      trim( $_POST['si_captcha_external_style'] ),
         'si_captcha_comment_label_style' =>  (trim($_POST['si_captcha_comment_label_style']) != '' ) ? trim($_POST['si_captcha_comment_label_style']) : $si_captcha_option_defaults['si_captcha_comment_label_style'], // use default if empty
         'si_captcha_comment_field_style' =>  (trim($_POST['si_captcha_comment_field_style']) != '' ) ? trim($_POST['si_captcha_comment_field_style']) : $si_captcha_option_defaults['si_captcha_comment_field_style'], // use default if empty
         'si_captcha_captcha_div_style' =>    (trim($_POST['si_captcha_captcha_div_style']) != '' )   ? trim($_POST['si_captcha_captcha_div_style'])   : $si_captcha_option_defaults['si_captcha_captcha_div_style'], // use default if empty
         'si_captcha_captcha_div_style_sm' => (trim($_POST['si_captcha_captcha_div_style_sm']) != '' ) ? trim($_POST['si_captcha_captcha_div_style_sm']) : $si_captcha_option_defaults['si_captcha_captcha_div_style_sm'], // use default if empty
         'si_captcha_captcha_div_style_m' =>    (trim($_POST['si_captcha_captcha_div_style_m']) != '' )   ? trim($_POST['si_captcha_captcha_div_style_m'])   : $si_captcha_option_defaults['si_captcha_captcha_div_style_m'], // use default if empty
         'si_captcha_captcha_input_div_style' => (trim($_POST['si_captcha_captcha_input_div_style']) != '' )   ? trim($_POST['si_captcha_captcha_input_div_style'])   : $si_captcha_option_defaults['si_captcha_captcha_input_div_style'], // use default if empty
         'si_captcha_captcha_image_style' =>  (trim($_POST['si_captcha_captcha_image_style']) != '' ) ? trim($_POST['si_captcha_captcha_image_style']) : $si_captcha_option_defaults['si_captcha_captcha_image_style'],
         'si_captcha_refresh_image_style' =>  (trim($_POST['si_captcha_refresh_image_style']) != '' ) ? trim($_POST['si_captcha_refresh_image_style']) : $si_captcha_option_defaults['si_captcha_refresh_image_style'],
         'si_captcha_required_indicator' =>    $_POST['si_captcha_required_indicator'],
         'si_captcha_label_captcha' =>         trim($_POST['si_captcha_label_captcha']),
         'si_captcha_tooltip_captcha' =>       trim($_POST['si_captcha_tooltip_captcha']),
         'si_captcha_tooltip_refresh' =>       trim($_POST['si_captcha_tooltip_refresh']),
                   );

   // deal with quotes
   foreach($optionarray_update as $key => $val) {
          $optionarray_update[$key] = str_replace('&quot;','"',$val);
   }

    if (isset($_POST['si_captcha_reset_styles'])) {
         // reset styles feature
         $style_resets_arr= array('si_captcha_comment_label_style','si_captcha_comment_field_style','si_captcha_captcha_div_style','si_captcha_captcha_div_style_sm','si_captcha_captcha_div_style_m','si_captcha_captcha_input_div_style','si_captcha_captcha_image_style','si_captcha_refresh_image_style');
         foreach($style_resets_arr as $style_reset) {
           $optionarray_update[$style_reset] = $si_captcha_option_defaults[$style_reset];
         }
    }

    // save updated options to the database
   	if ($wpmu == 1)
      update_site_option('si_captcha', $optionarray_update);
    else
      update_option('si_captcha', $optionarray_update);

    // get the options from the database
    if ($wpmu == 1)
      $si_captcha_opt = get_site_option('si_captcha');
    else
      $si_captcha_opt = get_option('si_captcha');

    // strip slashes on get options array
    foreach($si_captcha_opt as $key => $val) {
           $si_captcha_opt[$key] = $this->si_stripslashes($val);
    }

    if (function_exists('wp_cache_flush')) {
	     wp_cache_flush();
	}

  } // end if (isset($_POST['submit']))
?>
<?php if ( !empty($_POST ) ) : ?>
<div id="message" class="updated"><p><strong><?php _e('Options saved.', 'si-captcha') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php _e('SI Captcha Options', 'si-captcha') ?></h2>

<script type="text/javascript">
    function toggleVisibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>

<?php
if (function_exists('get_transient')) {
  require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

  // Before, try to access the data, check the cache.
  if (false === ($api = get_transient('si_captcha_info'))) {
    // The cache data doesn't exist or it's expired.

    $api = plugins_api('plugin_information', array('slug' => stripslashes( 'si-captcha-for-wordpress' ) ));
    if ( !is_wp_error($api) ) {
      // cache isn't up to date, write this fresh information to it now to avoid the query for xx time.
      $myexpire = 60 * 15; // Cache data for 15 minutes
      set_transient('si_captcha_info', $api, $myexpire);
    }
  }
  if ( !is_wp_error($api) ) {
	$plugins_allowedtags = array('a' => array('href' => array(), 'title' => array(), 'target' => array()),
								'abbr' => array('title' => array()), 'acronym' => array('title' => array()),
								'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
								'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
								'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
								'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
	//Sanitize HTML
	foreach ( (array)$api->sections as $section_name => $content )
		$api->sections[$section_name] = wp_kses($content, $plugins_allowedtags);
	foreach ( array('version', 'author', 'requires', 'tested', 'homepage', 'downloaded', 'slug') as $key )
		$api->$key = wp_kses($api->$key, $plugins_allowedtags);

      if ( ! empty($api->downloaded) ) {
        echo sprintf(__('Downloaded %s times', 'si-captcha'),number_format_i18n($api->downloaded));
        echo '.';
      }
?>
		<?php if ( ! empty($api->rating) ) : ?>
		<div class="star-holder" title="<?php echo esc_attr(sprintf(__('(Average rating based on %s ratings)', 'si-captcha'),number_format_i18n($api->num_ratings))); ?>">
			<div class="star star-rating" style="width: <?php echo esc_attr($api->rating) ?>px"></div>
			<div class="star star5"><img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/star.png" alt="<?php _e('5 stars', 'si-captcha') ?>" /></div>
			<div class="star star4"><img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/star.png" alt="<?php _e('4 stars', 'si-captcha') ?>" /></div>
			<div class="star star3"><img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/star.png" alt="<?php _e('3 stars', 'si-captcha') ?>" /></div>
			<div class="star star2"><img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/star.png" alt="<?php _e('2 stars', 'si-captcha') ?>" /></div>
			<div class="star star1"><img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/star.png" alt="<?php _e('1 star', 'si-captcha') ?>" /></div>
		</div>
		<small><?php echo sprintf(__('(Average rating based on %s ratings)', 'si-captcha'),number_format_i18n($api->num_ratings)); ?> <a target="_blank" href="http://wordpress.org/extend/plugins/<?php echo $api->slug ?>/"> <?php _e('rate', 'si-captcha') ?></a></small>
        <br />
		<?php endif; ?>

<?php
  } // if ( !is_wp_error($api)
 }// end if (function_exists('get_transient'

$si_captcha_update = '';
if (isset($api->version)) {
 if ( version_compare($api->version, $si_captcha_version, '>') ) {
     $si_captcha_update = ', <a href="'.admin_url( 'plugins.php' ).'">'.sprintf(__('a newer version is available: %s', 'si-captcha'),$api->version).'</a>';
     echo '<div id="message" class="updated">';
     echo '<a href="'.admin_url( 'plugins.php' ).'">'.sprintf(__('A newer version of SI Captcha Anti-Spam is available: %s', 'si-captcha'),$api->version).'</a>';
     echo "</div>\n";
  }else{
     $si_captcha_update = ' '. __('(latest version)', 'si-captcha');
  }
}
?>

<p>
<?php echo __('Version:', 'si-captcha'). ' '.$si_captcha_version.$si_captcha_update; ?> |
<a href="http://wordpress.org/extend/plugins/si-captcha-for-wordpress/changelog/" target="_blank"><?php echo __('Changelog', 'si-captcha'); ?></a> |
<a href="http://wordpress.org/extend/plugins/si-captcha-for-wordpress/faq/" target="_blank"><?php echo __('FAQ', 'si-captcha'); ?></a> |
<a href="http://wordpress.org/extend/plugins/si-captcha-for-wordpress/" target="_blank"><?php echo __('Rate This', 'si-captcha'); ?></a> |
<a href="http://wordpress.org/tags/si-captcha-for-wordpress?forum_id=10" target="_blank"><?php echo __('Support', 'si-captcha'); ?></a> |
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KXJWLPPWZG83S" target="_blank"><?php echo __('Donate', 'si-captcha'); ?></a> |
<a href="http://www.642weather.com/weather/scripts.php" target="_blank"><?php echo __('Free PHP Scripts', 'si-captcha'); ?></a> |
<a href="http://www.642weather.com/weather/wxblog/support/" target="_blank"><?php echo __('Contact', 'si-captcha'); ?> Mike Challis</a>
</p>


<?php
if ($si_captcha_opt['si_captcha_donated'] != 'true') {
 ?>

  <table style="border:none; width:850px;">
  <tr>
  <td>
  <div style="width:385px;height:200px; float:left;background-color:white;padding: 10px 10px 10px 10px; border: 1px solid #ddd; background-color:#FFFFE0;">
		<div>
         <h3><?php echo __('Donate', 'si-captcha'); ?></h3>

<?php
_e('Please donate to keep this plugin FREE', 'si-captcha'); echo '<br />';
_e('If you find this plugin useful to you, please consider making a small donation to help contribute to my time invested and to further development. Thanks for your kind support!', 'si-captcha') ?> - <a style="cursor:pointer;" title="<?php _e('More from Mike Challis', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_mike_challis_tip');"><?php _e('More from Mike Challis', 'si-captcha'); ?></a>
<br /><br />
   </div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="KXJWLPPWZG83S" />
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" style="border:none;" name="submit" alt="Paypal Donate" />
<img alt="" style="border:none;" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
  </td><td>

  <div style="width:385px;height:200px; float:left;background-color:white;padding: 10px 10px 10px 20px; border: 1px solid #ddd;">
		<div>
			<h3><?php _e('ThemeFuse Original WP Themes', 'si-captcha'); ?></h3>
            <?php echo sprintf(__('Try <a href="%s" target="_blank">ThemeFuse</a>, they make some amazing original WP themes that have a cool 1 click auto install feature and excellent after care support services. Check out some of their themes!', 'si-captcha'), 'https://www.e-junkie.com/ecom/gb.php?cl=136641&c=ib&aff=148937'); ?>
		</div>
        <a href="https://www.e-junkie.com/ecom/gb.php?cl=136641&c=ib&aff=148937" target="_blank"><img title="<?php echo esc_attr(__('ThemeFuse', 'si-captcha')); ?>" alt="<?php echo esc_attr(__('ThemeFuse', 'si-captcha')); ?>" src="http://themefuse.com/wp-content/themes/themefuse/images/campaigns/themefuse.jpg" width="375" height="85" /></a>
  </div>
  </td>
 </tr>
 </table>

<br />

<div style="text-align:left; display:none" id="si_captcha_mike_challis_tip">
<img src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/si-captcha.jpg" width="250" height="185" alt="Mike Challis" /><br />
<?php _e('Mike Challis says: "Hello, I have spend hundreds of hours coding this plugin just for you. If you are satisfied with my programs and support please consider making a small donation. If you are not able to, that is OK.', 'si-captcha'); ?>
<?php echo ' '; _e('Most people donate $3, $5, $10, $20, or more. Though no amount is too small. Donations can be made with your PayPal account, or securely using any of the major credit cards. Please also rate my plugin."', 'si-captcha'); ?>
 <a href="http://wordpress.org/extend/plugins/si-captcha-for-wordpress/" target="_blank"><?php _e('Rate This', 'si-captcha'); ?></a>.
<br />
<a style="cursor:pointer;" title="Close" onclick="toggleVisibility('si_captcha_mike_challis_tip');"><?php _e('Close this message', 'si-captcha'); ?></a>
</div>
<?php
}
?>

<form name="formoptions" action="<?php
global $wp_version;

// for WP 3.0+ ONLY!
if( $wpmu == 1 && version_compare($wp_version,'3','>=') && is_multisite() && is_super_admin() )  // wp 3.0 +
 echo admin_url( 'ms-admin.php?page=si-captcha.php' );
else if ($wpmu == 1)
 echo admin_url( 'wpmu-admin.php?page=si-captcha.php' );
else
 echo admin_url( 'plugins.php?page=si-captcha-for-wordpress/si-captcha.php' );

?>" method="post">
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="form_type" value="upload_options" />
        <?php wp_nonce_field('si-captcha-options_update'); ?>

      <input name="si_captcha_donated" id="si_captcha_donated" type="checkbox" <?php if( $si_captcha_opt['si_captcha_donated'] == 'true' ) echo 'checked="checked"'; ?> />
      <label name="si_captcha_donated" for="si_captcha_donated"><?php echo __('I have donated to help contribute for the development of this plugin.', 'si-captcha'); ?></label>
      <br />
<?php
    if( version_compare($wp_version,'3','<')  ) { // wp 2 series
?>
<h3><?php _e('Usage', 'si-captcha') ?></h3>

<p>
<?php _e('Your theme must have a', 'si-captcha') ?> &lt;?php do_action('comment_form', $post->ID); ?&gt; <?php _e('tag inside your comments.php form. Most themes do.', 'si-captcha'); echo ' '; ?>
<?php _e('The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button.', 'si-captcha') ?>
</p>
<?php
    }
?>
<h3><?php _e('Options', 'si-captcha') ?></h3>

        <p class="submit">
                <input type="submit" name="submit" value="<?php _e('Update Options', 'si-captcha') ?> &raquo;" />
        </p>

        <fieldset class="options">

        <table width="100%" cellspacing="2" cellpadding="5" class="form-table">

        <tr>
            <th scope="row" style="width: 75px;"><?php _e('CAPTCHA:', 'si-captcha') ?></th>
        <td>
        <a href="<?php echo "$si_captcha_url/test/index.php"; ?>" target="_new"><?php _e('Test if your PHP installation will support the CAPTCHA', 'si-captcha') ?></a>
        <br />

        <label for="si_captcha_captcha_difficulty"><?php echo __('CAPTCHA difficulty level:', 'si-captcha'); ?></label>
      <select id="si_captcha_captcha_difficulty" name="si_captcha_captcha_difficulty">
<?php
$captcha_difficulty_array = array(
'low' => esc_attr(__('Low', 'si-captcha')),
'medium' => esc_attr(__('Medium', 'si-captcha')),
'high' => esc_attr(__('High', 'si-captcha')),
);
$selected = '';
foreach ($captcha_difficulty_array as $k => $v) {
 if ($si_captcha_opt['si_captcha_captcha_difficulty'] == "$k")  $selected = ' selected="selected"';
 echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>'."\n";
 $selected = '';
}
?>
</select>
        <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_captcha_difficulty_tip');"><?php _e('help', 'si-captcha'); ?></a>
        <div style="text-align:left; display:none" id="si_captcha_captcha_difficulty_tip">
        <?php _e('Changes level of distortion of the CAPTCHA image text.', 'si-captcha') ?>
        </div>
        <br />

    <input name="si_captcha_login" id="si_captcha_login" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_login'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_login"><?php _e('Enable CAPTCHA on the login form.', 'si-captcha') ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_login_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_login_tip">
    <?php _e('The Login form captcha is not enabled by default because it might be annoying to users. Only enable it if you are having spam problems related to bots automatically logging in.', 'si-captcha') ?>
    </div>
    <br />

    <input name="si_captcha_register" id="si_captcha_register" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_register'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_register"><?php _e('Enable CAPTCHA on the register form.', 'si-captcha') ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_register_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_register_tip">
    <?php _e('Prevents automated spam bots by requiring that the user pass a CAPTCHA test before registering.', 'si-captcha') ?>
    </div>
    <br />

    <input name="si_captcha_lostpwd" id="si_captcha_lostpwd" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_lostpwd'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_lostpwd"><?php _e('Enable CAPTCHA on the lost password form.', 'si-captcha') ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_lostpwd_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_lostpwd_tip">
    <?php _e('Prevents automated spam bots by requiring that the user pass a CAPTCHA test before lost password request.', 'si-captcha') ?>
    </div>
    <br />

    <input name="si_captcha_comment" id="si_captcha_comment" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_comment'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_comment"><?php _e('Enable CAPTCHA on the comment form.', 'si-captcha') ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_enable_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_enable_tip">
    <?php _e('Prevents automated spam bots by requiring that the user pass a CAPTCHA test before posting comments.', 'si-captcha') ?>
    </div>
    <br />


    <input name="si_captcha_perm" id="si_captcha_perm" type="checkbox" <?php if( $si_captcha_opt['si_captcha_perm'] == 'true' ) echo 'checked="checked"'; ?> />
    <label name="si_captcha_perm" for="si_captcha_perm"><?php _e('Hide CAPTCHA for', 'si-captcha') ?>
    <strong><?php _e('registered', 'si-captcha') ?></strong>
    <?php _e('users who can:', 'si-captcha') ?></label>
    <?php $this->si_captcha_perm_dropdown('si_captcha_perm_level', $si_captcha_opt['si_captcha_perm_level']);  ?>
    <br />

    <label for="si_captcha_comment_label_position"><?php echo __('CAPTCHA input label position on the comment form:', 'si-captcha'); ?></label>
      <select id="si_captcha_comment_label_position" name="si_captcha_comment_label_position">
<?php
$captcha_pos_array = array(
'input-label-required' => esc_attr(__('input-label-required', 'si-captcha')), // wp
'label-required-input' => esc_attr(__('label-required-input', 'si-captcha')), // bp
'label-required-linebreak-input' => esc_attr(__('label-required-linebreak-input', 'si-captcha')), // wp-twenty ten
'label-input-required' => esc_attr(__('label-input-required', 'si-captcha')), // suffusion theme on wp

);
$selected = '';
foreach ($captcha_pos_array as $k => $v) {
 if ($si_captcha_opt['si_captcha_comment_label_position'] == "$k")  $selected = ' selected="selected"';
 echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>'."\n";
 $selected = '';
}
?>
</select>
        <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_comment_label_position_tip');"><?php _e('help', 'si-captcha'); ?></a>
        <div style="text-align:left; display:none" id="si_captcha_comment_label_position_tip">
        <?php _e('Changes position of the CAPTCHA input labels on the comment form. Some themes have different label positions on the comment form. After changing this setting, be sure to view the comments to verify the setting is correct.', 'si-captcha') ?>
        </div>
        <br />

    <input name="si_captcha_rearrange" id="si_captcha_rearrange" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_rearrange'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_rearrange"><?php _e('Change the display order of the CAPTCHA input field on the comment form.', 'si-captcha') ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_rearrange_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_rearrange_tip">
     <?php _e('Sometimes the CAPTCHA image and input field are displayed AFTER the submit button on the comment form.', 'si-captcha'); ?>
     <?php echo ' '; _e('Enable this setting and javascript will relocate the button.', 'si-captcha'); ?>
    </div>
    <br />

    <input name="si_captcha_captcha_small" id="si_captcha_captcha_small" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_captcha_small'] == 'true' ) echo ' checked="checked" '; ?> />
    <label for="si_captcha_captcha_small"><?php echo __('Enable smaller size CAPTCHA image.', 'si-captcha'); ?></label>
    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_captcha_small_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_captcha_small_tip">
    <?php _e('Makes the CAPTCHA image smaller.', 'si-captcha'); ?>
    </div>
    <br />


       <input name="si_captcha_no_trans" id="si_captcha_no_trans" type="checkbox" <?php if ( $si_captcha_opt['si_captcha_no_trans'] == 'true' ) echo ' checked="checked" '; ?> />
       <label for="si_captcha_no_trans"><?php echo __('Disable CAPTCHA transparent text (only if captcha text is missing on the image, try this fix).', 'si-captcha'); ?></label>
       <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_captcha_no_trans_tip');"><?php _e('help', 'si-captcha'); ?></a>
        <div style="text-align:left; display:none" id="si_captcha_captcha_no_trans_tip">
        <?php _e('Sometimes fixes missing text on the CAPTCHA image. If this does not fix missing text, your PHP server is not compatible with the CAPTCHA functions. You should have your web server fixed.', 'si-captcha') ?>
        </div>

       </td>
    </tr>

    <tr>
        <th scope="row" style="width: 75px;"><?php _e('Accessibility:', 'si-captcha') ?></th>
        <td>
       <input name="si_captcha_aria_required" id="si_captcha_aria_required" type="checkbox" <?php if( $si_captcha_opt['si_captcha_aria_required'] == 'true' ) echo 'checked="checked"'; ?> />
       <label name="si_captcha_aria_required" for="si_captcha_aria_required"><?php _e('Enable aria-required tags for screen readers', 'si-captcha') ?>.</label>
       <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_aria_required_tip');"><?php _e('help', 'si-captcha'); ?></a>
       <div style="text-align:left; display:none" id="si_captcha_aria_required_tip">
       <?php _e('aria-required is a form input WAI ARIA tag. Screen readers use it to determine which fields are required. Enabling this is good for accessability, but will cause the HTML to fail the W3C Validation (there is no attribute "aria-required"). WAI ARIA attributes are soon to be accepted by the HTML validator, so you can safely ignore the validation error it will cause.', 'si-captcha') ?>
       </div>
    </td>
    </tr>

     <tr>
       <th scope="row" style="width: 75px;"><?php _e('Akismet:', 'si-captcha'); ?></th>
      <td>
     <strong><?php _e('Akismet spam prevention status:', 'si-captcha'); ?></strong>

    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_akismet_tip');"><?php _e('help', 'si-captcha'); ?></a>
    <div style="text-align:left; display:none" id="si_captcha_akismet_tip">
    <?php _e('Akismet is a WordPress plugin. Akismet will greatly reduce or even completely eliminate the comment and trackback spam you get on your site. If one does happen to get through, simply mark it as "spam" on the moderation screen and Akismet will learn from the mistakes. When Akismet is installed and active, all comment posts will be checked with Akismet to help prevent spam.', 'si-captcha') ?>
    </div>
    <br />

  <?php
   if (function_exists('akismet_verify_key')) {
     if (!isset($_POST['si_captcha_akismet_check'])){
       echo '<span style="background-color:#99CC99; padding:4px;">'.
             __('Akismet is installed.', 'si-captcha'). '</strong></span>';
     }
  ?>
  <input name="si_captcha_akismet_check" id="si_captcha_akismet_check" type="checkbox" value="1" />
  <label for="si_captcha_akismet_check"><?php _e('Check this and click "Update Options" to determine if Akismet key is active.', 'si-captcha'); ?></label>
   <?php
    if (isset($_POST['si_captcha_akismet_check'])){
      echo '<br/>';
      $key_status = 'failed';
	  $key = get_option('wordpress_api_key');
		if ( empty( $key ) ) {
			$key_status = 'empty';
		} else {
			$key_status = akismet_verify_key( $key );
		}
		if ( $key_status == 'valid' ) {
			echo '<span style="background-color:#99CC99; padding:4px;">'.
             __('Akismet is installed and the key is valid. Comment posts will be checked with Akismet to help prevent spam.', 'si-captcha'). '</strong></span>';
		} else if ( $key_status == 'invalid' ) {
			echo '<span style="background-color:#FFE991; padding:4px;">'.
            __('Akismet plugin is installed but key needs to be activated.', 'si-captcha'). '</span>';
		} else if ( !empty($key) && $key_status == 'failed' ) {
			echo '<span style="background-color:#FFE991; padding:4px;">'.
             __('Akismet plugin is installed but key failed to verify.', 'si-captcha'). '</span>';
		}
    }
         echo '<br/><a href="'.admin_url(  "plugins.php?page=akismet-key-config" ).'">'. __('Configure Akismet', 'si-captcha'). '</a>';
   }else{
     echo '<span style="background-color:#FFE991; padding:4px;">'.
            __('Akismet plugin is not installed or is deactivated.', 'si-captcha'). '</span>';
   }
    ?>

      </td>
    </tr>

        </table>

      <br />
  <?php

    // Check for older than PHP5
   if (phpversion() < 5) {
      echo '<br /><span style="color:red;">'. __('Warning: Your web host has not upgraded from PHP4 to PHP5.', 'si-captcha');
      echo '</span> ';
      echo __('PHP4 was officially discontinued August 8, 2008 and is no longer considered safe.', 'si-captcha')."<br />\n";
      echo __('PHP5 is faster, has more features, and is and safer. Using PHP4 might still work, but is highly discouraged. Contact your web host for support.', 'si-captcha')."<br /><br />\n";
    }
  ?>


  <table cellspacing="2" cellpadding="5" class="form-table">

      <tr>
         <th scope="row" style="width: 75px;"><?php echo __('CAPTCHA Form CSS Style:', 'si-captcha'); ?></th>
        <td>
<?php
if( $si_captcha_opt['si_captcha_external_style'] != 'true' ) {
?>
        <input name="si_captcha_reset_styles" id="si_captcha_reset_styles" type="checkbox" />
        <label for="si_captcha_reset_styles"><strong><?php echo __('Reset the CAPTCHA form styles to default.', 'si-captcha') ?></strong></label><br />
        <br />
<?php
}
?>
        <strong><?php _e('Modifiable CAPTCHA Form CSS Style Feature:', 'si-captcha'); ?></strong>
        <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_css_tip');"><?php _e('help', 'si-captcha'); ?></a>
        <div style="text-align:left; display:none" id="si_captcha_css_tip">
        <?php _e('Use to adjust the font colors, image positioning, or other CSS styling of the CAPTCHA form.', 'si-captcha'); ?><br />
        <?php _e('Acceptable Examples:', 'si-captcha'); ?><br />
        color:#000000; background-color:#CCCCCC;<br />
        style="color:#000000; background-color:#CCCCCC;"<br />
        </div>
<br />

    <label for="si_captcha_external_style"><?php echo __('Select the method of delivering the CAPTCHA form style:', 'si-captcha'); ?></label>
      <select id="si_captcha_external_style" name="si_captcha_external_style">
<?php
$style_opt_array = array(
'false' => esc_attr(__('Internal Style Sheet CSS (default, edit below)', 'si-captcha')),
'true' => esc_attr(__('External Style Sheet CSS (requires editing style.css)', 'si-captcha')),
);
$selected = '';
foreach ($style_opt_array as $k => $v) {
 if ($si_captcha_opt['si_captcha_external_style'] == "$k")  $selected = ' selected="selected"';
 echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>'."\n";
 $selected = '';
}
?>
</select>
        <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_external_style_tip');"><?php _e('help', 'si-captcha'); ?></a>
        <div style="text-align:left; display:none" id="si_captcha_external_style_tip">
        <?php _e('By default, the CAPTCHA form styles are editable below when using "Internal Style Sheet CSS". The CAPTCHA CSS will be automatically be included in the page &lt;head&gt; section.', 'si-captcha');  echo ' '; ?>
        <?php _e('Premium themes may have already added support for SI Captcha Anti-Spam style in the theme\'s style.css. If that is the case, then select "External Style Sheet CSS" if instructed by the theme\'s installation instructions.', 'si-captcha'); echo ' '; ?>
        <?php _e('The CAPTCHA CSS will NOT be included in the page &lt;head&gt; section, and it must be included in the style.css of the theme. Be sure to remember this if you switch your theme later on.', 'si-captcha'); ?><br /><br />

<strong><?php _e('External Style Sheet CSS starting point for theme builders:', 'si-captcha'); ?></strong><br />
/*------------------------------------------------*/<br />
/*------------[SI Captcha Anti-Spam]--------------*/<br />
/*------------------------------------------------*/<br />
div#captchaImgDiv { <?php echo $si_captcha_option_defaults['si_captcha_captcha_div_style']; ?> }<br />
.captchaSizeDivSmall { <?php echo $si_captcha_option_defaults['si_captcha_captcha_div_style_sm']; ?> }<br />
.captchaSizeDivLarge { <?php echo $si_captcha_option_defaults['si_captcha_captcha_div_style_m']; ?> }<br />
img#si_image_com,#si_image_reg,#si_image_log,#si_image_side_login { <?php echo $si_captcha_option_defaults['si_captcha_captcha_image_style']; ?> }<br />
.captchaImgRefresh { <?php echo $si_captcha_option_defaults['si_captcha_refresh_image_style']; ?> }<br />
div#captchaInputDiv { <?php echo $si_captcha_option_defaults['si_captcha_captcha_input_div_style']; ?> }<br />
label#captcha_code_label { <?php echo $si_captcha_option_defaults['si_captcha_comment_label_style']; ?> }<br />
input#captcha_code { <?php echo $si_captcha_option_defaults['si_captcha_comment_field_style']; ?> }<br />

        </div>
        <br />

<?php
$readonly = '';
if( $si_captcha_opt['si_captcha_external_style'] == 'true' ) {
  $readonly = 'readonly="readonly"';
  echo '<div class="updated">';
  echo __('Caution: "External Style Sheet CSS" is enabled. This setting requires your theme\'s style.css to include the CAPTCHA CSS. Check the CAPTCHA images and input field on your comment form, make sure they are aligned properly. Be sure your theme includes the CAPTCHA style for this plugin, if it does not, then change the setting back to "Internal Style Sheet CSS".', 'si-captcha');
  echo "</div><br />\n";

  echo '<div class="si-notice">';
  echo __('Note: "Internal Style Sheet CSS" fields below are not editable while "External Style Sheet CSS" is enabled.', 'si-captcha');
  echo "</div><br />\n";
}
?>

      <strong><?php _e('Internal Style Sheet CSS:', 'si-captcha'); ?></strong><br />
      <label for="si_captcha_captcha_div_style"><?php echo __('CSS style for CAPTCHA DIV:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_captcha_div_style" id="si_captcha_captcha_div_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_captcha_div_style']);  ?>" size="50" /> div#captchaImgDiv<br />
      <label for="si_captcha_captcha_div_style_sm"><?php _e('CSS style for Small CAPTCHA Image DIV:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_captcha_div_style_sm" id="si_captcha_captcha_div_style_sm" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_captcha_div_style_sm']);  ?>" size="50" /> .captchaSizeDivSmall<br />
      <label for="si_captcha_captcha_div_style_m"><?php _e('CSS style for Large CAPTCHA Image DIV:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_captcha_div_style_m" id="si_captcha_captcha_div_style_m" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_captcha_div_style_m']);  ?>" size="50" /> .captchaSizeDivLarge<br />
      <label for="si_captcha_captcha_image_style"><?php echo __('CSS style for CAPTCHA image:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_captcha_image_style" id="si_captcha_captcha_image_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_captcha_image_style']);  ?>" size="50" /> img#si_image_com,#si_image_reg,#si_image_log,#si_image_side_login<br />
      <label for="si_captcha_refresh_image_style"><?php echo __('CSS style for Refresh image:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_refresh_image_style" id="si_captcha_refresh_image_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_refresh_image_style']);  ?>" size="50" /> .captchaImgRefresh <br />
      <label for="si_captcha_captcha_input_div_style"><?php echo __('CSS style for CAPTCHA input DIV:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_captcha_input_div_style" id="si_captcha_captcha_input_div_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_captcha_input_div_style']);  ?>" size="50" />div#captchaInputDiv<br />
      <label for="si_captcha_comment_label_style"><?php echo __('CSS style for CAPTCHA input label:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_comment_label_style" id="si_captcha_comment_label_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_comment_label_style']);  ?>" size="50" />label#captcha_code_label<br />
      <label for="si_captcha_comment_field_style"><?php echo __('CSS style for CAPTCHA input field:', 'si-captcha'); ?></label><input <?php echo $readonly ?> name="si_captcha_comment_field_style" id="si_captcha_comment_field_style" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_comment_field_style']);  ?>" size="50" />input#captcha_code
        </td>
    </tr>


        <tr>
          <th scope="row" style="width: 75px;"><?php echo __('Text Labels:', 'si-captcha'); ?></th>
         <td>


        <strong><?php _e('Change text labels:', 'si-captcha'); ?></strong>
        <a style="cursor:pointer;" title="<?php echo __('Click for Help!', 'si-captcha'); ?>" onclick="toggleVisibility('si_captcha_labels_tip');"><?php echo __('help', 'si-captcha'); ?></a>
       <div style="text-align:left; display:none" id="si_captcha_labels_tip">
       <?php echo __('Some people wanted to change the text labels. These fields can be filled in to override the standard text labels.', 'si-captcha'); ?>
       </div>
       <br />
        <label for="si_captcha_required_indicator"><?php echo __('Required', 'si-captcha'); ?></label><input name="si_captcha_required_indicator" id="si_captcha_required_indicator" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_required_indicator']);  ?>" size="50" /><br />
        <label for="si_captcha_label_captcha"><?php echo __('CAPTCHA Code', 'si-captcha'); ?></label><input name="si_captcha_label_captcha" id="si_captcha_label_captcha" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_label_captcha']);  ?>" size="50" /><br />
        <label for="si_captcha_tooltip_captcha"><?php echo __('CAPTCHA Image', 'si-captcha'); ?></label><input name="si_captcha_tooltip_captcha" id="si_captcha_tooltip_captcha" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_tooltip_captcha']);  ?>" size="50" /><br />
        <label for="si_captcha_tooltip_refresh"><?php echo __('Refresh Image', 'si-captcha'); ?></label><input name="si_captcha_tooltip_refresh" id="si_captcha_tooltip_refresh" type="text" value="<?php echo esc_attr($si_captcha_opt['si_captcha_tooltip_refresh']);  ?>" size="50" />

        </td>
    </tr>
      </table>

        </fieldset>

    <p class="submit">
       <input type="submit" name="submit" value="<?php _e('Update Options', 'si-captcha') ?> &raquo;" />
    </p>

</form>

<table style="border:none;" width="775">
  <tr>
  <td width="325">
<p><strong><?php _e('More WordPress plugins by Mike Challis:', 'si-captcha') ?></strong></p>
<ul>
<li><a href="http://www.fastsecurecontactform.com/" target="_blank"><?php echo __('Fast Secure Contact Form', 'si-captcha'); ?></a></li>
<li><a href="http://wordpress.org/extend/plugins/si-captcha-for-wordpress/" target="_blank"><?php echo __('SI CAPTCHA Anti-Spam', 'si-captcha'); ?></a></li>
<li><a href="http://wordpress.org/extend/plugins/visitor-maps/" target="_blank"><?php echo __('Visitor Maps and Who\'s Online', 'si-captcha'); ?></a></li>
</ul>
<?php
  if ($si_captcha_opt['si_captcha_donated'] != 'true') { ?>
   </td><td width="350">
   <?php echo sprintf(__('"I recommend <a href="%s" target="_blank">HostGator Web Hosting</a>. All my sites are hosted there. The prices are great and they offer the most features." - Mike Challis', 'si-captcha'), 'http://secure.hostgator.com/~affiliat/cgi-bin/affiliates/clickthru.cgi?id=mchallis-sicaptchawp&amp;page=http://www.hostgator.com/apps/wordpress-hosting.shtml'); ?>
   </td><td width="100">
     <a href="http://secure.hostgator.com/~affiliat/cgi-bin/affiliates/clickthru.cgi?id=mchallis-sicaptchawp&amp;page=http://www.hostgator.com/apps/wordpress-hosting.shtml" target="_blank"><img title="<?php echo esc_attr(__('Web Site Hosting', 'si-captcha')); ?>" alt="<?php echo esc_attr(__('Web Site Hosting', 'si-captcha')); ?>" src="<?php echo WP_PLUGIN_URL; ?>/si-captcha-for-wordpress/hostgator-blog.gif" width="100" height="100" /></a>
<?php
  }
 ?>
</td>
</tr>
</table>
</div>
