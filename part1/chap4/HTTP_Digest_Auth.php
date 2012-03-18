<?php
include_once('Auth.php');

class HTTP_Digest_Auth extends Auth {
  function check() { // 認証情報を検証
    $password = $this->getCredential($this->data['username']);
    $a1 = md5($this->data['username'].':'.$_SESSION['realm'].':'.$password);
    $a2 = md5($_SERVER['REQUEST_METHOD'].':'.$this->data['uri']);
    $expected = md5($a1.':'.$this->data['nonce'].':'.$this->data['nc'].
        ':'.$this->data['cnonce'].':'.$this->data['qop'].':'.$a2);
    return ($this->data['password'] == $expected);
  }

  function login($status) { // 認証情報入力を要求するHTTPレスポンスを返す
    if (!isset($_SESSION['realm'])) {
      $this->setRealm('');
    }
    header('HTTP/1.1 401 Unauthorized');
    $nonce = md5(uniqid(rand(),true));
    header('WWW-Authenticate: Digest realm="'.$_SESSION['realm'].
     '",qop="auth",nonce="'.$nonce.'",algorithm=MD5');
    die('認証はキャンセルされました.');
  }

  function loadData() { // リクエスト中の認証情報をパース
    if (!isset($_SERVER['PHP_AUTH_DIGEST'])) {
      $this->data = null;
      return;
    }
    $parts = array('username'=>1, 'response'=>1,'uri'=>1,'nonce'=>1,
      'nc'=>1, 'cnonce'=>1, 'qop'=>1); // 必須のキーワード
    $keys = implode('|', array_keys($parts));
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', 
      $_SERVER['PHP_AUTH_DIGEST'], $matches, PREG_SET_ORDER);
    foreach ($matches as $m) { // 取得済み要素を配列partsから削除
      $data[$m[1]] = $m[3] ? $m[3] : $m[4];
      unset($parts[$m[1]]);
    }  
    if ($parts) {
      $this->data = null;
    } else {
      $this->data = $data;
      $this->data['password'] = $data['response'];
    }
  }
}
?>