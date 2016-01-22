<?php

class Duoshuo_LocalServer{
	
	protected $response = array();
	
	protected $plugin;
	
	public function __construct($plugin){
		$this->plugin = $plugin;
	}
	
	/**
	 * 从服务器pull评论到本地
	 * 
	 * @param array $input
	 */
	public function sync_log($input = array()){
		$syncLock = $this->plugin->getOption('sync_lock');//检查是否正在同步评论 同步完成后该值会置0
		if($syncLock && $syncLock > time()- 300){//正在或5分钟内发生过写回但没置0
			$this->response = array(
				'code'	=>	Duoshuo_Exception::SUCCESS,
				'response'=> '同步中，请稍候',
			);
			return;
		}
		
		try{
			$this->response['affected'] = $this->plugin->syncLog();
			$this->response['last_log_id'] = $this->plugin->getOption('last_log_id');
		}
		catch(Exception $ex){
			//$this->plugin->updateOption('sync_lock', $ex->getLine());
		}
		
		$this->response['code'] = Duoshuo_Exception::SUCCESS;
	}
	
	public function update_option($input = array()){
		//duoshuo_short_name
		//duoshuo_secret
		//duoshuo_notice
		foreach($input as $optionName => $optionValue)
			if (substr($optionName, 0, 8) === 'duoshuo_'){
				update_option($_POST['option'], $_POST['value']);
			}
		$this->response['code'] = 0;
	}
	
	public function dispatch($input){
		if (!isset($input['signature']))
			throw new Duoshuo_Exception('Invalid signature.', Duoshuo_Exception::INVALID_SIGNATURE);
	
		$signature = $input['signature'];
		unset($input['signature']);
	
		ksort($input);
		$baseString = http_build_query($input, null, '&');
	
		$expectSignature = base64_encode(hash_hmac('sha1', $baseString, $this->plugin->getOption('secret'), true));
		if ($signature !== $expectSignature)
			throw new Duoshuo_Exception('Invalid signature, expect: ' . $expectSignature . '. (' . $baseString . ')', Duoshuo_Exception::INVALID_SIGNATURE);
	
		$method = $input['action'];
	
		if (!method_exists($this, $method))
			throw new Duoshuo_Exception('Unknown action.', Duoshuo_Exception::OPERATION_NOT_SUPPORTED);
		
		$this->response = array();
		$this->$method($input);
		$this->sendResponse();
	}
	
	public function sendResponse(){
		echo json_encode($this->response);
	}
}
