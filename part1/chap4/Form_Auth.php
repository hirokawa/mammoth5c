<?php
include_once('Auth.php');

class Form_Auth extends Auth {
  protected $message = array('','有効期限切れとなりました.',
	     'ユーザ名とパスワードを入力してください.',
	     'ユーザ名またはパスワードが正しくありません.');

  function check() { // 認証情報を検証
    if ($_SESSION['login']) {
      return true;
    }
    $password = $this->getCredential($_SESSION['username']);
    return ($_SESSION['password'] == $password);
  }

  function login($status) { // 認証情報入力を要求
    echo <<<EOS
      {$this->message[$status]}
<form method="POST" action="">
      ユーザ名:<input type="text" name="username" /><br/>
      パスワード:<input type="password" name="password" /><br/>
      <input type="submit" />
</form>
EOS;
    exit();
  }

  function loadData() { // リクエスト中の認証情報をパース
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $_POST['password'];
      $this->data = true;
    } else if (isset($_SESSION['login']) && $_SESSION['login']) {
      $this->data = true;
    } else {
      $this->data = null;
    }
  }
}
?>