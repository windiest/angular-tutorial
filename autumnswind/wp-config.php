<?php
/** 
 * WordPress 基础配置文件。
 *
 * 本文件包含以下配置选项: MySQL 设置、数据库表名前缀、
 * 密匙、WordPress 语言设定以及 ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/Editing_wp-config.php 编辑
 * wp-config.php} Codex 页面。MySQL 设置具体信息请咨询您的空间提供商。
 *
 * 这个文件用在于安装程序自动生成 wp-config.php 配置文件，
 * 您可以手动复制这个文件，并重命名为 wp-config.php，然后输入相关信息。
 *
 * @Author Elmer Zhang <freeboy6716@gmail.com>
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress 数据库的名称 */
define('DB_NAME', SAE_MYSQL_DB);

/** MySQL 数据库用户名 */
define('DB_USER', SAE_MYSQL_USER);

/** MySQL 数据库密码 */
define('DB_PASSWORD', SAE_MYSQL_PASS);

/** MySQL 主机 */
define('DB_HOST', SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT);

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

define('WP_USE_MULTIPLE_DB', true);

$db_list = array(
		'write'=> array(
			array(
				'db_host' => SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,
				'db_user'=> SAE_MYSQL_USER,
				'db_password'=> SAE_MYSQL_PASS,
				'db_name'=> SAE_MYSQL_DB,
				'db_charset'=> 'utf8'
				)
			),
		'read'=> array(
			array(
				'db_host' => SAE_MYSQL_HOST_S.':'.SAE_MYSQL_PORT,
				'db_user'=> SAE_MYSQL_USER,
				'db_password'=> SAE_MYSQL_PASS,
				'db_name'=> SAE_MYSQL_DB,
				'db_charset'=> 'utf8'
				)
			),
		);
$global_db_list = $db_list['write'];

/**#@+
 * 身份密匙设定。
 *
 * 您可以随意写一些字符
 * 或者直接访问 {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org 私钥生成服务}，
 * 任何修改都会导致 cookie 失效，所有用户必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         hash_hmac('sha1', SAE_ACCESSKEY . 'AUTH_KEY', SAE_SECRETKEY ));
define('SECURE_AUTH_KEY',  hash_hmac('sha1', SAE_ACCESSKEY . 'SECURE_AUTH_KEY', SAE_SECRETKEY ));
define('LOGGED_IN_KEY',    hash_hmac('sha1', SAE_ACCESSKEY . 'LOGGED_IN_KEY', SAE_SECRETKEY ));
define('NONCE_KEY',        hash_hmac('sha1', SAE_ACCESSKEY . 'NONCE_KEY', SAE_SECRETKEY ));
define('AUTH_SALT',        hash_hmac('sha1', SAE_ACCESSKEY . 'AUTH_SALT', SAE_SECRETKEY ));
define('SECURE_AUTH_SALT', hash_hmac('sha1', SAE_ACCESSKEY . 'SECURE_AUTH_SALT', SAE_SECRETKEY ));
define('LOGGED_IN_SALT',   hash_hmac('sha1', SAE_ACCESSKEY . 'LOGGED_IN_SALT', SAE_SECRETKEY ));
define('NONCE_SALT',       hash_hmac('sha1', SAE_ACCESSKEY . 'NONCE_SALT', SAE_SECRETKEY ));

/**#@-*/

/**
 * WordPress 数据表前缀。
 *
 * 如果您有在同一数据库内安装多个 WordPress 的需求，请为每个 WordPress 设置不同的数据表前缀。
 * 前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * WordPress 语言设置，默认为英语。
 *
 * 本项设定能够让 WordPress 显示您需要的语言。
 * wp-content/languages 内应放置同名的 .mo 语言文件。
 * 要使用 WordPress 简体中文界面，只需填入 zh_CN。
 */
define ('WPLANG', 'zh_CN');

/**
 * 开发者专用：WordPress 调试模式。
 *
 * 将这个值改为“true”，WordPress 将显示所有开发过程中的提示。
 * 强烈建议插件开发者在开发环境中启用本功能。
 */
define('WP_DEBUG', false);

/* 好了！请不要再继续编辑。请保存该文件。 */

/** WordPress 目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置 WordPress 变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');