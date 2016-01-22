<?php
class Duoshuo_Abstract {
	const DOMAIN = 'duoshuo.com';
	const STATIC_DOMAIN = 'static.duoshuo.com';
	const VERSION = '0.9';
	
	/**
	 * 
	 * @var string
	 */
	public $shortName;
	
	/**
	 * 
	 * @var string
	 */
	public $secret;
	
	public function oauthConnect(){
			if (!isset($_GET['code']))
			return false;
		
		$oauth = $this->getClient();
		
		$keys = array(
			'code'	=> $_GET['code'],
			'redirect_uri' => 'http://duoshuo.com/login-callback/',
		);
		
		$token = $oauth->getAccessToken('code', $keys);
		
		if ($token['code'] != 0)
			return false;
		
		$this->userLogin($token);
	}
	
	/**
	 * 默认的获取Client的函数，可以被派生
	 * @param string|int $userId
	 * @return Duoshuo_Client
	 */
	public function getClient($userId = 0){
		return new Duoshuo_Client($this->shortName, $this->secret);
	}
	
	public function syncLog(){
		$this->updateOption('sync_lock',  time());
		
		$last_log_id = $this->getOption('last_log_id');
		if (!$last_log_id)
			$last_log_id = 0;
		
		$limit = 20;
			
		$params = array(
				'limit' => $limit,
				'order' => 'asc',
		);
			
		$client = $this->getClient();
		
		$posts = array();
		$affectedThreads = array();
		
		//do{
			
			$params['since_id'] = $last_log_id;
			$response = $client->request('GET', 'log/list', $params);
			
			if (is_string($response))
				throw new Duoshuo_Exception($response, Duoshuo_Exception::INTERNAL_SERVER_ERROR);
			
			if (!isset($response['response']))
				throw new Duoshuo_Exception($response['message'], $response['code']);
			
			foreach($response['response'] as $log){
				switch($log['action']){
					case 'create':
						$affected = $this->createPost($log['meta']);
						break;
					case 'approve':
						$affected = $this->approvePost($log['meta']);
						break;
					case 'spam':
						$affected = $this->spamPost($log['meta']);
						break;
					case 'delete':
						$affected = $this->deletePost($log['meta']);
						break;
					case 'delete-forever':
						$affected = $this->deleteForeverPost($log['meta']);
						break;
					case 'update'://现在并没有update操作的逻辑
					default:
						$affected = array();
				}
				
				//合并
				if (is_array($affected))
					$affectedThreads = array_merge($affectedThreads, $affected);
		
				if (strlen($log['log_id']) > strlen($last_log_id) || strcmp($log['log_id'], $last_log_id) > 0)
					$last_log_id = $log['log_id'];
			}
			
			$this->updateOption('last_log_id', $last_log_id);
		
		//} while (count($response['response']) == $limit);//如果返回和最大请求条数一致，则再取一次
			
		$this->updateOption('sync_lock',  0);
		
		//更新静态文件
		if ($this->getOption('sync_to_local') && $this->plugin->getOption('seo_enabled'))
			$this->refreshThreads(array_unique($affectedThreads));
		
		return count($response['response']);
	}
	
	public function remoteAuth($user_data){
		$message = base64_encode(json_encode($user_data));
	    $time = time();
	    return $message . ' ' . self::hmacsha1($message . ' ' . $time, $this->secret) . ' ' . $time;
	}
	
	function rfc3339_to_mysql($string){
		if (method_exists('DateTime', 'createFromFormat')){	//	php 5.3.0
			return DateTime::createFromFormat(DateTime::RFC3339, $string)->format('Y-m-d H:i:s');
		}
		else{
			$timestamp = strtotime($string);
			return gmdate('Y-m-d H:i:s', $timestamp  + $this->timezone() * 3600);
		}
	}
	
	function rfc3339_to_mysql_gmt($string){
		if (method_exists('DateTime', 'createFromFormat')){	//	php 5.3.0
			return DateTime::createFromFormat(DateTime::RFC3339, $string)->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
		}
		else{
			$timestamp = strtotime($string);
			return gmdate('Y-m-d H:i:s', $timestamp);
		}
	}
	
	// from: http://www.php.net/manual/en/function.sha1.php#39492
	// Calculate HMAC-SHA1 according to RFC2104
	// http://www.ietf.org/rfc/rfc2104.txt
	static function hmacsha1($data, $key) {
		if (function_exists('hash_hmac'))
			return hash_hmac('sha1', $data, $key);
		
	    $blocksize=64;
	    $hashfunc='sha1';
	    if (strlen($key)>$blocksize)
	        $key=pack('H*', $hashfunc($key));
	    $key=str_pad($key,$blocksize,chr(0x00));
	    $ipad=str_repeat(chr(0x36),$blocksize);
	    $opad=str_repeat(chr(0x5c),$blocksize);
	    $hmac = pack(
	                'H*',$hashfunc(
	                    ($key^$opad).pack(
	                        'H*',$hashfunc(
	                            ($key^$ipad).$data
	                        )
	                    )
	                )
	            );
	    return bin2hex($hmac);
	}
	
	function exportUsers($users){
		if (count($users) === 0)
			return 0;
	
		$params = array('users'=>array());
		foreach($users as $user)
			$params['users'][] = $this->packageUser($user);
		 
		$remoteResponse = $this->getClient()->request('POST', 'users/import', $params);
		
		if (isset($remoteResponse['response'])){
			foreach($remoteResponse['response'] as $userId => $duoshuoUserId)
				$this->updateUserMeta($userId, 'duoshuo_user_id', $duoshuoUserId);
		}
		
		return count($users);
	}
	
	function exportPosts($threads){
		if (count($threads) === 0)
			return 0;
	
		$params = array(
			'threads'	=>	array(),
		);
		foreach($threads as $index => $thread){
			$params['threads'][] = $this->packageThread($thread);
		}
	
		$remoteResponse = $this->getClient()->request('POST','threads/import', $params);
		
		if (isset($remoteResponse['response'])){
			foreach($remoteResponse['response'] as $threadId => $duoshuoThreadId)
				$this->updateThreadMeta($threadId, 'duoshuo_thread_id', $duoshuoThreadId);
		}
		
		return count($threads);
	}
	
	function exportComments($comments){
		if (count($comments) === 0)
			return 0;
	
		$params = array(
			'posts'	=>	array()
		);
	
		foreach($comments as $comment)
			$params['posts'][] = $this->packageComment($comment);
	
		$remoteResponse = $this->getClient()->request('POST', 'posts/import', $params);
	
		return count($comments);
	}
}
