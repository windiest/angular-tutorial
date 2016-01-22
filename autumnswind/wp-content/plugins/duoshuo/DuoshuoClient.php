<?php
/**
 * 
 * @link http://duoshuo.com/
 * @author shen2
 *
 */
class DuoshuoClient{
	var $end_point = 'http://duoshuo.com/api/';
	var $format = 'json';
	var $userAgent;
	var $shortName;
	var $secret;
	var $accessToken;
	var $http;
	
	function __construct($shortName = null, $secret = null, $remoteAuth = null, $accessToken = null){
		global $wp_version;
		
		$this->shortName = $shortName;
		$this->secret = $secret;
		$this->remoteAuth = $remoteAuth;
		$this->accessToken = $accessToken;
		$this->http = new WP_Http();
		$this->userAgent = 'WordPress/' . $wp_version . '|Duoshuo/'. Duoshuo::VERSION;
	}
	
	/**
	 * 
	 * @param $method
	 * @param $path
	 * @param $params
	 * @throws Duoshuo_Exception
	 * @return array
	 */
	function request($method, $path, $params = array()){
        $params['short_name'] = $this->shortName;
		$params['remote_auth'] = $this->remoteAuth;
        
        if ($this->accessToken)
        	$params['access_token'] = $this->accessToken;
		
		$url = $this->end_point . $path. '.' . $this->format;
		
		return $this->httpRequest($url, $method, $params);
	}
	
	function httpRequest($url, $method, $params){
		$args = array(
			'method' => $method,
			'timeout' => 60,
			'redirection' => 5,
			'httpversion' => '1.0',
			'user-agent' => $this->userAgent,
			//'blocking' => true,
			'headers' => array('Expect'=>''),
			//'cookies' => array(),
			//'compress' => false,
			//'decompress' => true,
			'sslverify' => false,
			//'stream' => false,
			//'filename' => null
		);
		
		switch($method){
			case 'GET':
				$url .= '?' . http_build_query($params, null, '&');	// overwrite arg_separator.output
				break;
			case 'POST':
				$args['body'] = $params;	// http类自己会做 http_build_query($params, null, '&') 并指定Content-Type
				break;
			default:
		}
		
		$response = $this->http->request($url, $args);
			
		if (isset($response->errors)){
			if (isset($response->errors['http_request_failed'])){
				$message = $response->errors['http_request_failed'][0];
				if ($message == 'name lookup timed out')
					$message = 'DNS解析超时，请重试或检查你的主机的域名解析(DNS)设置。';
				elseif (stripos($message, 'Could not open handle for fopen') === 0)
					$message = '无法打开fopen句柄，请重试或联系多说管理员。http://duoshuo.com/';
				elseif (stripos($message, 'Couldn\'t resolve host') === 0)
					$message = '无法解析duoshuo.com域名，请重试或检查你的主机的域名解析(DNS)设置。';
				elseif (stripos($message, 'Operation timed out after ') === 0)
					$message = '操作超时，请重试或联系多说管理员。http://duoshuo.com/';
				throw new Duoshuo_Exception($message, Duoshuo_Exception::REQUEST_TIMED_OUT);
			}
            else
            	throw new Duoshuo_Exception('连接服务器失败, 详细信息：' . json_encode($response->errors), Duoshuo_Exception::REQUEST_TIMED_OUT);
		}

		$json = json_decode($response['body'], true);
		return $json === null ? $response['body'] : $json;
	}
	
	/**
	 * 
	 * @param string $type
	 * @param array $keys
	 */
	function getAccessToken( $type, $keys ) {
		$params = array(
			'client_id'	=>	$this->shortName,
			'client_secret' => $this->secret,
		);
		
		switch($type){
		case 'token':
			$params['grant_type'] = 'refresh_token';
			$params['refresh_token'] = $keys['refresh_token'];
			break;
		case 'code':
			$params['grant_type'] = 'authorization_code';
			$params['code'] = $keys['code'];
			$params['redirect_uri'] = $keys['redirect_uri'];
			break;
		case 'password':
			$params['grant_type'] = 'password';
			$params['username'] = $keys['username'];
			$params['password'] = $keys['password'];
			break;
		default:
			throw new Duoshuo_Exception("wrong auth type");
		}

		$accessTokenUrl = 'http://api.duoshuo.com/oauth2/access_token';
		$response = $this->httpRequest($accessTokenUrl, 'POST', $params);
		
		$token = $response;
		if ( is_array($token) && !isset($token['error']) ) {
			$this->access_token = $token['access_token'];
			if (isset($token['refresh_token'])) //	可能没有refresh_token
				$this->refresh_token = $token['refresh_token'];
		} else {
			var_dump($response);var_dump($params);var_dump($token);	// 用来调试
			throw new Duoshuo_Exception("get access token failed." . $token['error']);
		}
		
		return $token;
	}
}
