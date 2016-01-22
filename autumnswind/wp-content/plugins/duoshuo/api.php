<?php
/*
if ( ! isset( $_REQUEST['action'] ) )
	die('-1');*/

if (!extension_loaded('json'))
	include dirname(__FILE__) . '/compat-json.php';

require '../../../wp-load.php';

require '../../../wp-admin/includes/admin.php';

do_action('admin_init');

if (!headers_sent()) {
	nocache_headers();
	header('Content-Type: text/javascript; charset=utf-8');
}

if (!class_exists('Duoshuo_WordPress')){
	$response = array(
		'code'			=>	30,
		'errorMessage'	=>	'Duoshuo plugin hasn\'t been activated.'
	);
	echo json_encode($response);
	exit;
}

require DUOSHUO_PLUGIN_PATH . '/LocalServer.php';

$plugin = Duoshuo_WordPress::getInstance();

try{
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$input = $_POST;
		if (isset($input['spam_confirmed']))	//D-Z Theme 会给POST设置这个参数
			unset($input['spam_confirmed']);
		
		$server = new Duoshuo_LocalServer($plugin);
		$server->dispatch($input);
	}
}
catch (Exception $e){
	$plugin->sendException($e);
}
