<?php
include_once('Auth.php');

class HTTP_Auth extends Auth {
  function check() { // 認証情報を検証
    $password = $this->getCredential($_SESSION['username']);
    return ($_SESSION['password'] == $password);
  }

  function login($status) { // 認証情報入力を要求するHTTPレスポンスを返す
    if (!isset($_SESSION['realm'])) {
      $this->setRealm('');
    }
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="'.$_SESSION['realm']);
    die('認証はキャンセルされました.');
  }

  function loadData() { // リクエスト中の認証情報をパース
    if (isset($_SERVER['PHP_AUTH_USER']) && 
        isset($_SERVER['PHP_AUTH_PW'])) {
      $_SESSION['username'] = $_SERVER['PHP_AUTH_USER'];
      $_SESSION['password'] = $_SERVER['PHP_AUTH_PW'];
      $this->data = true;
    } else {
      $this->data = null;
    }
  }
}
?>