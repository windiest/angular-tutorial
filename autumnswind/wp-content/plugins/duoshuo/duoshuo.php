<?php
/*
Plugin Name: 多说
Plugin URI: http://wordpress.org/extend/plugins/duoshuo/
Description: 追求最佳用户体验的社会化评论框，为中小网站提供“新浪微博、QQ、人人、豆瓣等多帐号登录并评论”功能。“多说”帮你搭建更活跃，互动性更强的评论平台，功能强大且永久免费。
Author: 多说网
Version: 0.9
Author URI: http://duoshuo.com/
*/

define('DUOSHUO_PLUGIN_PATH', dirname(__FILE__));

if (version_compare(PHP_VERSION, '5.0.0', '<')){
	if(is_admin()){
		function duoshuo_php_version_warning(){
			echo '<div class="updated"><p><strong>您的php版本低于5.0，请升级php到最新版，多说就能为您服务了。</strong></p></div>';
		}
		add_action('admin_notices', 'duoshuo_php_version_warning');
	}
	return;
}

if (version_compare( $wp_version, '2.8', '<' )){
	if(is_admin()){
		function duoshuo_wp_version_warning(){
			echo '<div class="updated"><p><strong>您的WordPress版本低于2.8，请升级WordPress到最新版，多说就能为您服务了。</strong></p></div>';
		}
		add_action('admin_notices', 'duoshuo_wp_version_warning');
	}
	return;
}

function duoshuo_get_available_transport(){
	if (extension_loaded('curl') && function_exists('curl_init') && function_exists('curl_exec'))
		return 'curl';
	
	if (function_exists('fopen') && function_exists('ini_get') && ini_get('allow_url_fopen'))
		return 'streams';
	
	if (function_exists('fsockopen') && (false === ($option = get_option( 'disable_fsockopen' )) || time() - $option >= 43200))
		return 'fsockopen';
	
	return false;
}

$transport = duoshuo_get_available_transport();
if ($transport === false){
	if(is_admin()){
		function duoshuo_transport_warning(){
			echo '<div class="updated"><p><strong>没有可用的 HTTP 传输器</strong>，请联系你的主机商，安装或开启curl</p></div>';
		}
		add_action('admin_notices', 'duoshuo_transport_warning');
	}
	return;
}

if (!extension_loaded('json'))
	include DUOSHUO_PLUGIN_PATH . '/compat-json.php';
	
require DUOSHUO_PLUGIN_PATH . '/Exception.php';
require DUOSHUO_PLUGIN_PATH . '/Client.php';
require DUOSHUO_PLUGIN_PATH . '/Abstract.php';
require DUOSHUO_PLUGIN_PATH . '/WordPress.php';

function duoshuo_admin_initialize(){
	global $wp_version, $duoshuoPlugin, $plugin_page;
	
	//在admin界面内执行的action
	// wordpress2.8 以后都支持这个过滤器
	add_filter('plugin_action_links_duoshuo/duoshuo.php', array($duoshuoPlugin, 'pluginActionLinks'), 10, 2);
	
	if (empty($duoshuoPlugin->shortName) || empty($duoshuoPlugin->secret)){//你尚未安装这个插件。
		function duoshuo_config_warning(){
			echo '<div class="updated"><p><strong>只要再<a href="' . admin_url('admin.php?page=duoshuo') . '">配置一下</a>多说帐号，多说就能开始为您服务了。</strong></p></div>';
		}
		
		if ($plugin_page !== 'duoshuo')
			add_action('admin_notices', 'duoshuo_config_warning');
		return ;
	}
	
	add_action('admin_notices', array($duoshuoPlugin, 'notices'));
	
	add_action('switch_theme', array($duoshuoPlugin, 'updateSite'));
	//	support from WP 2.9
	//add_action('updated_option', array($duoshuoPlugin, 'updatedOption'));
	
	add_filter('post_row_actions', array($duoshuoPlugin, 'actionsFilter'));
	
	if (function_exists('get_post_types')){//	support from WP 2.9
		$post_types = get_post_types( array('public' => true, 'show_in_nav_menus' => true), 'objects');
		
		foreach($post_types as $type => $object)
			add_meta_box('duoshuo-sidebox', '同时发布到', array($duoshuoPlugin,'syncOptions'), $type, 'side', 'high');
	}
	else{
		add_meta_box('duoshuo-sidebox', '同时发布到', array($duoshuoPlugin,'syncOptions'), 'post', 'side', 'high');
		add_meta_box('duoshuo-sidebox', '同时发布到', array($duoshuoPlugin,'syncOptions'), 'page', 'side', 'high');
	}
	//wp 3.0以下不支持此项功能
	/**
	 * TODO 
	if ($post !== null && 'publish' == $post->post_status || 'private' == $post->post_status)
		add_meta_box('duoshuo-comments', '来自社交网站的评论(多说)', array($duoshuoPlugin,'managePostComments'), 'post', 'normal', 'low');
	 */
	
	add_action('profile_update', array($duoshuoPlugin, 'syncUserToRemote'));
	add_action('user_register', array($duoshuoPlugin, 'syncUserToRemote'));
	
	add_action('wp_dashboard_setup', 'duoshuo_add_dashboard_widget');
	
	//// backwards compatible (before WP 3.0)
	if (version_compare( $wp_version, '3.0', '<' ) && current_user_can('administrator')){
		function duoshuo_wp_version_notice(){
			echo '<div class="updated"><p>您的WordPress版本低于3.0，如果您能升级WordPress，多说就能更好地为您服务。</p></div>';
		}
		add_action(get_plugin_page_hook('duoshuo', 'duoshuo'), 'duoshuo_wp_version_notice');
		add_action(get_plugin_page_hook('duoshuo-preferences', 'duoshuo'), 'duoshuo_wp_version_notice');
		add_action(get_plugin_page_hook('duoshuo-settings', 'duoshuo'), 'duoshuo_wp_version_notice');
	}
	
	if (!is_numeric($duoshuoPlugin->getOption('synchronized')) && current_user_can('administrator')){
		function duoshuo_unsynchronized_notice(){
			echo '<div class="updated"><p>上一次同步没有完成，<a href="' . admin_url('admin.php?page=duoshuo-settings') . '">点此继续同步</a></p></div>';
		}
		
		add_action(get_plugin_page_hook('duoshuo', 'duoshuo'), 'duoshuo_unsynchronized_notice');
		add_action(get_plugin_page_hook('duoshuo-preferences', 'duoshuo'), 'duoshuo_unsynchronized_notice');
		add_action(get_plugin_page_hook('duoshuo-settings', 'duoshuo'), 'duoshuo_unsynchronized_notice');
	}
	
	add_action('admin_head-edit-comments.php', array($duoshuoPlugin, 'originalCommentsNotice'));
	
	if (defined('DOING_AJAX')){
		add_action('wp_ajax_duoshuo_export', array($duoshuoPlugin, 'export'));
		add_action('wp_ajax_duoshuo_sync_log', array($duoshuoPlugin, 'syncLogAction'));
	}
	
	duoshuo_common_initialize();
}
	
function duoshuo_initialize(){
	global $duoshuoPlugin;
	
	if (empty($duoshuoPlugin->shortName) || empty($duoshuoPlugin->secret)){
		return;
	}
	
	if ($duoshuoPlugin->getOption('social_login_enabled'))
		add_action('login_form', array($duoshuoPlugin, 'loginForm'));
	//add_action('wp_login', array($duoshuoPlugin, 'login'));
	
	// wp2.8 以后支持这个事件
	add_action('wp_print_scripts', array($duoshuoPlugin, 'appendScripts'));
	//add_action('wp_head', array($duoshuoPlugin, 'appendStyles'));
	
	//以下应该根据是否设置，选择是否启用
	add_filter('comments_template', array($duoshuoPlugin,'commentsTemplate'));
	
	//add_filter('comments_number')
	if (is_active_widget(false, false, 'recent-comments'))
		add_action('wp_footer', array($duoshuoPlugin, 'outputFooterCommentJs'));
	
	if (get_option('duoshuo_cc_fix')) //直接输出HTML评论
		add_filter('comments_number', array($duoshuoPlugin, 'commentsText'));
		
	add_action('trackback_post', array($duoshuoPlugin, 'exportOneComment'));
	add_action('pingback_post', array($duoshuoPlugin, 'exportOneComment'));
	
	duoshuo_common_initialize();
}

function duoshuo_common_initialize(){
	global $duoshuoPlugin;
	// 没有用cookie方式保持身份，所以不需要重定向
	//add_action('wp_logout', array($duoshuoPlugin, 'logout'));
	add_filter('comments_open', array($duoshuoPlugin, 'commentsOpen'));
	
	if ($duoshuoPlugin->getOption('cron_sync_enabled')){
		add_action('duoshuo_sync_log_cron', array($duoshuoPlugin, 'syncLog'));
		if (!wp_next_scheduled('duoshuo_sync_log_cron')){
			wp_schedule_event(time(), 'hourly', 'duoshuo_sync_log_cron');
		}
	}
}

// Register widgets.
function duoshuo_register_widgets(){
	require_once dirname(__FILE__) . '/widgets.php';
	
	register_widget('Duoshuo_Widget_Recent_Visitors');
	//register_widget('Duoshuo_Widget_Top_Commenters');
	
	register_widget('Duoshuo_Widget_Recent_Comments');
	register_widget('Duoshuo_Widget_Top_Threads');
	
	register_widget('Duoshuo_Widget_Qqt_Follow');
}

function duoshuo_add_pages() {
	global $duoshuoPlugin;
	
	if (empty($duoshuoPlugin->shortName) || empty($duoshuoPlugin->secret)){	//	尚未安装
		add_object_page(
			'安装',
			'多说评论',
			'moderate_comments',	//	权限
			'duoshuo',
			array($duoshuoPlugin, 'config'),
			$duoshuoPlugin->pluginDirUrl . 'images/menu-icon.png' 
		);
	}
	else{	// 已经安装成功
		if (current_user_can('moderate_comments')){
			if(get_option('duoshuo_synchronized') === false){
				add_object_page(
					'数据同步',
					'多说评论',
					'moderate_comments',
					'duoshuo',
					array($duoshuoPlugin, 'sync'),
					$duoshuoPlugin->pluginDirUrl . 'images/menu-icon.png'
				);
				add_submenu_page(
					'duoshuo',
					'多说评论管理',
					'多说评论',
					'moderate_comments',
					'duoshuo-manage',
					array($duoshuoPlugin,'manage')
				);
			}
			else{
				add_object_page(
					'多说评论管理',
					'多说评论',
					'moderate_comments',
					'duoshuo',
					array($duoshuoPlugin,'manage'),
					$duoshuoPlugin->pluginDirUrl . 'images/menu-icon.png' 
				);
			}
			add_submenu_page(
		         'duoshuo',//$parent_slug
		         '个性化设置',//page_title
		         '个性化设置',//menu_title
		         'manage_options',//权限
		         'duoshuo-preferences',//menu_slug
		         array($duoshuoPlugin, 'preferences')//function
		    );
			add_submenu_page(
		         'duoshuo',//$parent_slug
		         '高级选项',//page_title
		         '高级选项',//menu_title
		         'manage_options',//权限
		         'duoshuo-settings',//menu_slug
		         array($duoshuoPlugin, 'settings')//function
		    );
		    add_submenu_page(
		         'duoshuo',//$parent_slug
		         '我的多说帐号',//page_title
		         '我的多说帐号',//menu_title
		         'level_0',//权限
		         'duoshuo-profile',//menu_slug
		         array($duoshuoPlugin, 'profile')//function
		    );
		}
		elseif(current_user_can('level_0')){
			add_submenu_page(
			'profile.php',//$parent_slug
			'我的多说帐号',//page_title
			'我的多说帐号',//menu_title
			'level_0',//权限
			'duoshuo-profile',//menu_slug
			array($duoshuoPlugin, 'profile')//function
			);
		}
	}
}

function duoshuo_add_dashboard_widget(){
	global $duoshuoPlugin;
	
	wp_add_dashboard_widget('dashboard_duoshuo', '多说最新评论', array($duoshuoPlugin, 'dashboardWidget'), array($duoshuoPlugin, 'dashboardWidgetControl'));
}

function duoshuo_register_settings(){
	register_setting('duoshuo', 'duoshuo_short_name');
	register_setting('duoshuo', 'duoshuo_secret');
	
	register_setting('duoshuo', 'duoshuo_api_hostname');
	register_setting('duoshuo', 'duoshuo_cron_sync_enabled');
	register_setting('duoshuo', 'duoshuo_seo_enabled');
	register_setting('duoshuo', 'duoshuo_cc_fix');
	register_setting('duoshuo', 'duoshuo_social_login_enabled');
	register_setting('duoshuo', 'duoshuo_comments_wrapper_intro');
	register_setting('duoshuo', 'duoshuo_comments_wrapper_outro');
}

function duoshuo_request_handler(){
	global $duoshuoPlugin, $parent_file;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		switch ($parent_file){
			case 'duoshuo':
				if (isset($_POST['duoshuo_uninstall']))
					$duoshuoPlugin->uninstall();
				if (isset($_POST['duoshuo_local_options']))
					$duoshuoPlugin->updateLocalOptions();
				break;
			default:
		}
	}
	elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
		switch ($parent_file){
			case 'options-general.php':
				if (isset($_GET['settings-updated']))
					$duoshuoPlugin->updateSite();
				break;
			case 'duoshuo':
				if (isset($_GET['duoshuo_connect_site']))
					$duoshuoPlugin->connectSite();
				break;
			default:
		}
	}
}

function duoshuo_deactivate($network_wide = false){
	//	升级插件的时候也会停用插件
	//delete_option('duoshuo_synchronized');
}


$duoshuoPlugin = Duoshuo_WordPress::getInstance();

if(is_admin()){//在admin界面内执行的action
	register_deactivation_hook(__FILE__, 'duoshuo_deactivate');
	add_action('admin_menu', 'duoshuo_add_pages', 10);
	add_action('admin_init', 'duoshuo_request_handler');
	add_action('admin_init', 'duoshuo_register_settings');
	add_action('admin_init', 'duoshuo_admin_initialize');
}
else{
	add_action('init', 'duoshuo_initialize');
	add_action('login_form_duoshuo_login', array($duoshuoPlugin, 'oauthConnect'));
	//add_action('login_form_duoshuo_logout', array($duoshuoPlugin,'oauthDisconnect'));
}

add_action('widgets_init', 'duoshuo_register_widgets');

add_action('save_post', array($duoshuoPlugin, 'syncPostToRemote'));

/*
if (function_exists('get_post_types')){	//	cron jobs runs in common mode, sometimes
	foreach(get_post_types() as $type)
		if ($type !== 'nav_menu_item' && $type !== 'revision')
			add_action('publish_' . $type, array($duoshuoPlugin,'syncPostToRemote'));
}
else{
	add_action('publish_post', array($duoshuoPlugin,'syncPostToRemote'));
	add_action('publish_page', array($duoshuoPlugin,'syncPostToRemote'));
}
*/
