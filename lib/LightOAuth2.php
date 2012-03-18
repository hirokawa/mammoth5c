<?php
/**
   This class provides a simple interface for OAuth 2.0.

   - OAuth 2.0 draft 10 supported.
   - fallback mode for ealier draft version of OAuth 2.0 supported.
     (for Facebook)
   - MAC, BEARER Authorization header based on OAuth 2.0 draft 12.

   Usage:

<code>
   // for Facebook OAuth 2.0
   $url = "https://graph.facebook.com/me/feed";

   $entry = array('callback'=>'http://www.example.com/ws_fb.php',
   'authorize'=>'https://graph.facebook.com/oauth/authorize',
   'access_token'=>'https://graph.facebook.com/oauth/access_token');

   $opts = array('redirect_uri'=>$entry['callback'],
   'scope'=>'read_stream,offline_access,publish_stream');

   $copts = array('cainfo'=>CAFILE); // can be ignored if cainfo available
   $oauth = new LightOAuth2(CLIENT_ID, CLIENT_SECRET, $copts);
   
   session_start();
   if (!isset($_SESSION['access_token'])) {
    if (!isset($_GET['code'])) {
      $url = $oauth->getAuthUrl($entry['authorize'], $entry['callback'], $opts);
      header("Location: " . $url);
      exit();
    }
    $obj = $oauth->getToken($entry['access_token'], $entry['callback'],
                           $_GET['code'], 'json');
    $_SESSION['access_token'] = $obj->access_token;
   }

   // access to proteced resource
   $oauth->setToken($_SESSION['access_token']);
   $oauth->fetch($url);
</code>

 The library requires PHP >= 5.3.
 @author Rui Hirokawa <rui_hirokawa at yahoo.co.jp>
 @copyright Copyright (c) 2012, Rui Hirokawa
 @license http://www.opensource.org/licenses/mit-license.php MIT
*/
class LightOAuth2 {
  const AUTH_TYPE_HEADER = 1, AUTH_TYPE_FORM = 2, AUTH_TYPE_URI = 3;
  const AUTH_ENGINE_STREAM = 1, AUTH_ENGINE_CURL = 2;
  protected $client_id = null, $client_secret = null, $token = null;
  protected $copts = array('verify_peer'=>true, 
			   'requestEngine'=>self::AUTH_ENGINE_CURL);
  protected $credentials = 'Bearer';
  protected $secret = null;
  protected $algorithm = 'hmac-sha-1'; 
  protected $auth_type = self::AUTH_TYPE_HEADER;

  /**
   * Constructor of the class
   *
   * @param $client_id the client id
   * @param $client_secret the client secret
   * @param $copts the optional array
   * @return an instance of the object
   */
  public function __construct($client_id, $client_secret, $copts = array()) {
    $this->client_id = $client_id;
    $this->client_secret = $client_secret;
    $this->copts = array_merge($this->copts, $copts);
  }

  /**
   * issue a request using PHP stream
   *
   * @param $url the url to access
   * @param $params the optional parameters
   * @param $method the HTTP method (default: 'GET')
   * @param $headers the optional headers
   * @param $code the expected HTTP response code
   * @returns the response string
   */
  protected function requestStream($url, $params = null, $method = 'GET', 
				   $headers = array(), $code = 200) {
	  $opts = array('http'=> array('method' => $method, 
								   'follow_location' => false),
					'ssl' => array('verify_peer' => $this->copts['verify_peer']));
	  if(isset($this->copts['cainfo'])) {
		  $opts['ssl']['cafile'] = $this->copts['cainfo'];
	  }
	  
	  if (!empty($params)) {
		  if ($method == 'POST') {
			  if (is_array($params)) {
				  $files = array();
				  foreach($params as $key => $value) {
					  if ($value[0] == '@') { // file attachment
						  $files[$key] = substr($value, 1);
						  unset($params[$key]);
					  }
				  }
				  if (!empty($files)) {
					  $boundary = "---------------------".substr(md5(rand(0,32000)), 0, 10); 
					  $headers['Content-Type'] = "multipart/form-data; boundary=$boundary";
					  $content = $this->buildFormData($params, $boundary);
				  } else {
					  $headers['Content-type'] = "application/x-www-form-urlencoded";
					  $content = http_build_query($params);
				  }
				  $opts['http']['content'] = $content;		
			  } else {
				  $opts['http']['content'] = $params;	  
			  }
		  } else if ($method == 'GET') {
			  $url .= '?' . http_build_query($params,'','&');
		  }
	  }
	  $header = '';
	  foreach($headers as $key => $value) {
		  $header .= "$key: $value\r\n";
	  }
	  $opts['http']['header'] = $header;
	  
	  $context = stream_context_create($opts);
	  $result = file_get_contents($url, false, $context);
	  if (!$result || !strpos($http_response_header[0], (string)$code)) {
		  throw new RuntimeException($http_response_header[0]);
	  }
	  return $result;
  }
  
  /**
   * issue a request using curl extension
   *
   * @param $url the url to access
   * @param $params the optional parameters
   * @param $method the HTTP method (default: 'GET')
   * @param $headers the optional headers
   * @param $code the expected HTTP response code
   * @returns the response string
   */
  protected function requestCurl($url, $params = null, $method = 'GET', 
								 $headers = array(), $code = 200) {
	  $opts = array(CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYPEER => true);
	  
	  if ($method == 'POST' || $method == 'PUT') {
		  if (!is_null($params)) {
			  $opts[CURLOPT_POSTFIELDS] = $params;
		  }
	  } elseif ($method == 'GET') {
		  if (!is_null($params)) {
			  $url .= '?'. http_build_query($params,'','&');
		  }
	  } elseif ($method == 'DELETE') {
		  $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
	  }	 
	  
	  $opts[CURLOPT_CUSTOMREQUEST] = $method;
	  $opts[CURLOPT_URL] = $url;
	  if(isset($this->copts['cainfo'])) {
		  $opts[CURLOPT_CAINFO] = $this->copts['cainfo'];
	  }
	  
	  if (!empty($headers)) {
		  $header = array();
		  foreach($headers as $key => $value) {
			  $header[] = "$key: $value";
		  }
		  $opts[CURLOPT_HTTPHEADER] = $header;
	  }
	  $ch = curl_init();
	  if (curl_setopt_array($ch, $opts) === false) {
		  die('unable set options for curl.');
	  }
	  $result = curl_exec($ch);
	  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  
	  if (intval($http_code) != $code) {
		  throw new RuntimeException("returned code: $http_code::$result");
	  }
	  curl_close($ch);
	  return $result;
  }

  /**
   * Get token and token secret
   *
   * @param $url the endpoint url to obtain the token
   * @param $callback the callback url (null for 'refresh_token')
   * @param $token the current token for 'refresh_token'
   * @param $type the type of parameter encoding ('json' or 'url')
   * @return an object including the access_token
   */
  public function getToken($url, $callback = null, $token = null, $type = 'json') {
	  $gtype = empty($callback) ? 'refresh_token' : 'authorization_code';
	  $params = array('grant_type'=>$gtype,
					  'client_id'=>$this->client_id, 'client_secret'=>$this->client_secret);
	  if ($gtype == 'authorization_code') {
		  $params['code'] = $token;
		  $params['redirect_uri'] = $callback;
	  } else { // refresh_token
		  $params['refresh_token'] = $token;
	  }
	  
	  if ($this->copts['requestEngine'] == self::AUTH_ENGINE_STREAM) {
		  $result = $this->requestStream($url, $params, 'POST', null, 200);
	  } else {
		  $result = $this->requestCurl($url, $params, 'POST', null, 200);
	  }

	  if ($type == 'json') {
		  $obj = json_decode($result); 
	  } else {
		  parse_str($result, $r);
		  $obj = (object)$r;
	  }

	  return $obj;
  }

  /**
   * Returns the url for authorization 
   *
   * @param $url the endpoint for authorization
   * @param $redirect_uri the uri for redirection
   * @param $opts the optional parameters
   * @return the url for authorization 
   */
  public function getAuthUrl($url, $redirect_uri, $opts = array()) {
    $params = array('client_id'=>$this->client_id, 
		    'redirect_uri'=>$redirect_uri,
		    'response_type'=>'code');
    $params = array_merge($opts, $params);
    $auth_url = $url . '?'. http_build_query($params, null, '&');
    return $auth_url;
  }

  /**
   * Set token
   *
   * @param $token the token
   */
  public function setToken($token) {
    $this->token = $token;
  }

  /**
   * issue a request for the protected resource
   *
   * @param $url the url to access
   * @param $params the optional parameters
   * @param $method the HTTP method (default: HTTP_METH_GET)
   * @param $headers the optional headers
   * @param $code the expected HTTP response code
   * @param $auth_get true if the authorization parameter sends via GET
   * @returns the response string
   */
  public function fetch($url, $params = null, $method = 'GET', 
						$headers = array(), $code = 200){
	  if ($this->auth_type == self::AUTH_TYPE_HEADER) {
		  $sauth = $this->getAuthHeader($url, $this->token, $method);
		  $headers['Authorization'] = $sauth;
	  } else {
		  $params['access_token'] = $this->token;
	  }
	  
	  if ($this->copts['requestEngine'] == self::AUTH_ENGINE_STREAM) {
		  $result = $this->requestStream($url, $params, $method, $headers, $code);
	  } else {
		  $result = $this->requestCurl($url, $params, $method, $headers, $code);
	  }
	  return $result;
  }

  /**
   * set method to send the authorization information in the request
   *
   * @param $auth_type authorization type (default: AUTH_TYPE_HEADER)
   */
  public function setAuthType($auth_type) {
    $this->auth_type = $auth_type;
  }

  /**
   * build multipart/formdata
   *
   * @param $params the optional parameters
   * @param $boundary the boundary
   * @returns the content string
   */
  protected function buildFormData($params = array(), $boundary) {
    $content = '';
    foreach($params as $key => $value) {
      $content .= "--$boundary\r\n";
      $content .= "Content-Disposition: form-data; name=\"$key\"\r\n\r\n";
      $content .=  $value . "\r\n";
    }
    $content .= "--$boundary\r\n";
    foreach($files as $key => $value) {
      $content .= "Content-Disposition: form-data; name=\"$key\"; filename=\"$value\"\r\n\r\n";
      $content .= file_get_contents($value) . "\r\n";
      $content .= "--$boundary--\r\n";
    }
    return $content;
  }

  /**
   * set credentials
   *
   * @param $credentials credentials: 'OAuth'(draft 10),'MAC' or 'Bearer'
   * @param $secret token secret
   * @param $algorithm hash-mac algorithm ('hmac-sha-1' or 'hmac-sha-256')
   */
  public function setCredentials($credentials = 'Bearer', $secret = null, 
			$algorithm = 'hmac-sha-1') {
    $this->credentials = $credentials;
    $this->secret  = $secret;
    $this->algorithm = $algorithm;
  }

  /**
   * generate MAC signature
   *
   * @param $url the target url
   * @param $params parameters
   * @param $secret token secret
   * @param $method the HTTP method
   * @returns signature string
   */
  public function getSignature($url, $params, $secret, $method = 'GET') {
    $v = parse_url($url);
    if (isset($v['query'])) {
      $query = $this->normalized_query($v['query']);
    } else {
      $query = '';
    }
    if (!isset($v['port'])) {
      $v['port'] = ($v['scheme'] == 'https') ? 443 : 80;
    }
    $base = "{$params['token']}\n{$params['timestamp']}\n{$params['nonce']}\n";
    $base .= "$method\n{$v['host']}\n{$v['port']}\n{$v['path']}\n$query";
    $alg = ($this->algorithm == 'hmac-sha-256') ? 'sha256' : 'sha1';
    $sign = base64_encode(hash_hmac($alg,$base, $secret, true));
    return $sign;
  }
  
  /**
   * generate Authorization header
   *
   * @param $url the target url
   * @param $token token
   * @param $method HTTP method
   * @param $timestamp timestamp. automatically generated if it is ignored.
   * @param $nonce nonce. automatically generated if it is ignored.
   * @returns authorization header string.
   */
  public function getAuthHeader($url, $token, $method = HTTP_METH_GET, 
			 $timestamp = null, $nonce = null) {
	  if (strtolower($this->credentials) == 'mac' && !empty($this->secret)) {
		  $timestamp = $timestamp ?: time();
		  $nonce = $nonce ?: md5(microtime(true) . rand(1, 999));
		  $params = array('token'=>$token,
						  'timestamp'=>$timestamp,
						  'nonce'=>$nonce);    
		  $params['signature'] = $this->getSignature($url, $params, $this->secret);
		  $head = '';
		  foreach($params as $key => $value) {
			  $head .= ",$key=\"$value\"";
		  }
		  $token = substr($head, 1);
	  }
	  return $this->credentials .' '. $token;
  }
  
  /**
   * build query string for MAC signature
   *
   * @param $params the optional parameters
   * @returns string based on RFC-3986
   */
  protected function normalized_query($query) {
	  $v = explode('&',$query);
	  $q = array();
	  foreach($v as $key) {
		  if (strpos($key,'=')) {
			  list($key, $value) = explode('=',$key);
			  $value = rawurlencode(urldecode($value));
		  } else {
			  $value = '';
		  }
		  $key = rawurlencode(urldecode($key));
		  $q[] = "$key=$value";
	  }
	  sort($q);
	  return implode("\n",$q)."\n";
  }
}
?>
