<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="Cache-Control" content="no-siteapp">
<title><?php $t = trim(wp_title('', false)); if($t) echo $t._hui('connector'); else ''; bloginfo('name'); if (is_home ()) echo _hui('connector').get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php wp_head(); ?>
<!--<link rel="shortcut icon" href="<?php echo HOME_URI.'/favicon.ico' ?>">-->
<link id="favicon" href="https://assets-cdn.github.com/favicon.ico" rel="icon" type="image/x-icon" />
<!--[if lt IE 9]><script src="<?php echo THEME_URI ?>/js/html5.js"></script><![endif]-->
</head>
<body <?php body_class( _hui('layout') ); ?>>
<?php if( _hui('layout') == 'ui-navtop' ){ ?>
<header class="header">
<div class="container">
<?php }else{ ?>
<section class="container">
<header class="header">
<?php } ?>
	<?php hui_logo(); ?>
	<?php hui_nav_menu(); ?>
	<div class="feeds">
		<?php if( _hui('weibo') ){ ?>
			<a class="feed feed-weibo" rel="external nofollow" href="<?php echo _hui('weibo') ?>" target="_blank"><i></i><?php echo __('微博', 'haoui') ?></a>
		<?php }if( _hui('tqq') ){ ?>
			<a class="feed feed-tqq" rel="external nofollow" href="<?php echo _hui('tqq') ?>" target="_blank"><i></i><?php echo __('腾讯微博', 'haoui') ?></a>
		<?php }if( _hui('facebook') ){ ?>
			<a class="feed feed-facebook" rel="external nofollow" href="<?php echo _hui('facebook') ?>" target="_blank"><i></i><?php echo __('Facebook', 'haoui') ?></a>
		<?php }if( _hui('twitter') ){ ?>
			<a class="feed feed-twitter" rel="external nofollow" href="<?php echo _hui('twitter') ?>" target="_blank"><i></i><?php echo __('Twitter', 'haoui') ?></a>
		<?php }if( _hui('feed') ){ ?>
			<a class="feed feed-rss" rel="external nofollow" href="<?php echo _hui('feed') ?>" target="_blank"><i></i><?php echo __('RSS订阅', 'haoui') ?></a>
		<?php }if( _hui('wechat') ){ ?>
			<a class="feed feed-weixin" rel="external nofollow" href="javascript:;" title="<?php echo __('关注', 'haoui') ?>”<?php echo _hui('wechat') ?>“" data-content="<img src='<?php echo _hui("wechat_qr") ?>'>"><i></i><?php echo __('微信', 'haoui') ?></a>
		<?php } ?>
	</div>
	<div class="slinks">
		<?php echo _hui('menu_links') ?>
	</div>
	<?php if( is_user_logged_in() ){
		global $current_user;
		get_currentuserinfo();
	?>
		<div class="user-welcome">
			<?php echo hui_get_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, $src=true); ?>
			<strong><?php echo $current_user->display_name ?></strong><span class="text-muted"><?php echo __('欢迎登录！', 'haoui') ?></span>
		</div>
		<p class="user-logout"><a href="<?php echo wp_logout_url() ?>"><?php echo __('退出', 'haoui') ?></a></p>
	<?php }else{ ?>
		<div class="user-signin">
			<a target="_blank" href="<?php echo site_url('/wp-login.php'); ?>"><?php echo __('登陆', 'haoui') ?></a><br>
			<a target="_blank" href="<?php echo site_url('/wp-login.php?action=register'); ?>"><?php echo __('注册', 'haoui') ?></a>
		</div>
	<?php } ?>
<?php if( _hui('layout') == 'ui-navtop' ){ ?>
</div>
</header>
<section class="container">
<?php }else{ ?>
</header>
<?php } ?>