<?php
class OAuthLib {
protected $auth = null, $entry = array();
protected $opts = array('cainfo'=>null, 'redirect'=>true, 'debug'=>false);

public function __construct($key, $secret, $entry, $opts = array()) {
    session_start();
    $this->entry = $entry;
    $this->auth = new OAuth($key, $secret);
    $this->opts = array_merge($this->opts, $opts);
    if (!empty($this->opts['cainfo'])) {
      $this->auth->setCAPath('', $this->opts['cainfo']);
    }
    if ($this->opts['debug']) { $this->auth->enableDebug();}
  }
  
  public function setRedirect($v) {
    $old = $this->opts['redirect'];
    $this->opts['redirect'] = $v;
    return $old;
  }
  
  public function getAuth() { return $this->auth;}
  
  public function logout() {
    $_SESSION = array();
    session_destroy();
  }
  
  public function check($opts = array()) {
    if (isset($_SESSION['login']) && $_SESSION['login']) {
      $this->updateToken(time());
      return true;
    }
    if (!isset($_GET['oauth_verifier'])) {
      $url = $this->entry['req_token'];
      if (!empty($opts)) {
        $url .= '?' . rfc3986_build_query($opts);
      }
      $r = $this->auth->getRequestToken($url,$this->entry['callback']);
      $_SESSION['token_secret'] = $r['oauth_token_secret'];
      $auth_url = 
          $this->entry['authorize'].'?oauth_token='.$r["oauth_token"];
      header("Location: $auth_url");
    } else {
      $this->auth->setToken($_GET['oauth_token'], 
          $_SESSION['token_secret']);
      $r = $this->auth->getAccessToken($this->entry['access_token']);
      $_SESSION['token'] = $r['oauth_token']; 
      $_SESSION['token_secret'] = $r['oauth_token_secret'];
      $_SESSION['login'] = true;
      $this->saveOpts($r);
      return true;
    }
  }
  
  public function request($url, $params = array(), $method = 'GET',
              $header = array(), $return_info = false) {
    $this->auth->setToken($_SESSION['token'],$_SESSION['token_secret']);
    if ($this->opts['redirect']) {
      $this->auth->enableRedirects();
    } else {
      $this->auth->disableRedirects();
    }
    $this->auth->fetch($url, $params, $method, $header);
    if ($return_info) {
      return $this->auth->getLastResponseInfo();
    } else {
      return $this->auth->getLastResponse();      
    }
  }
  
  public function updateToken($time) { }
  public function saveOpts($r) {
    if (isset($r['url_name'])) { // hatena
      $_SESSION['url_name'] = $r['url_name'];  
    }
  }
}
?>
