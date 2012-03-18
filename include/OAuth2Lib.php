<?php
require_once('LightOAuth2.php');

class OAuth2Lib {
  public $entry = array(), $auth = null;
  
  public function __construct($client_id, $client_secret, $entry, 
            $copts = array()) {
    session_start();
    $this->entry = $entry;
    $this->auth = new LightOAuth2($client_id, $client_secret, $copts);
    $this->auth->setCredentials('OAuth'); // OAuthドラフト10用
  }

  public function logout() { // ログアウト処理
    $_SESSION = array();
    session_destroy();
  }

  public function check($opts = array(), $type = 'json') { // 認可フロー
    if (isset($_SESSION['login'])) {
      $this->updateToken(time());
      return true;
    }
    if (!isset($_GET['code'])) { // 認可コード取得
      $_SESSION['state'] = md5(uniqid(rand(), true)); // CSRF対策
      $opts['state'] = $_SESSION['state'];
      $url = $this->auth->getAuthUrl($this->entry['authorize'], 
                     $this->entry['callback'], $opts);
      header("Location: " . $url); // 認証用URLにリダイレクト
      exit();
    }
    if (isset($_GET['error']) && $_GET['error']) { // エラー処理
      throw new RuntimeException('Server Error: '.$_GET['error']);
    } else if (isset($_SESSION['state']) && (!isset($_GET['state']) 
                   || $_SESSION['state'] != $_GET['state'])) { // CSRF対策
      throw new RuntimeException('Error: the state does not match.');    
  } 

    $obj = $this->auth->getToken($this->entry['access_token'], 
                   $this->entry['callback'], $_GET['code'], $type);
    if (isset($obj->error)) { // エラーの場合
      unset($_SESSION['access_token']);
      throw new RuntimeException('Error: '.$obj->error);  
    }
    $_SESSION['login'] = true;
    $_SESSION['access_token'] = $obj->access_token;
    $_SESSION['expires_in'] = @$obj->expires_in;
    if (isset($obj->refresh_token)) { // リフレシュトークン保存
      $_SESSION['refresh_token'] = $obj->refresh_token;
      $_SESSION['login_time'] = time();
    }
  }

  public function request($url, $params = null, $method = 'GET', 
        $headers = array(), $code = 200) {
    $this->auth->setToken($_SESSION['access_token']);
    return $this->auth->fetch($url, $params, $method, $headers, $code);
  }

  public function updateToken($time, $type = 'json') { // トークン更新
    if (!isset($_SESSION['refresh_token']) || 
        !isset($_SESSION['expires_in']) ||
       ($time < $_SESSION['login_time'] + $_SESSION['expires_in'])) {
      return false;
    }
    $obj = $this->auth->getToken($this->entry['access_token'], 
         null, $_SESSION['refresh_token'], $type);
    if (isset($obj->error)) {
      $this->logout();
      throw new RuntimeException('Error: '.$obj->error);  
    }
    $_SESSION['access_token'] = $obj->access_token;
    $_SESSION['refresh_token'] = $obj->refresh_token;
    $_SESSION['login_time'] = $time;
    return true;
  }
}
?>
