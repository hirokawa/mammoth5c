<?php
include_once('Form_Auth.php');

class Form_Digest_Auth extends Form_Auth {
  function check() { // 認証情報を検証
    if ($_SESSION['login']) {
      return true;
    }
    $password = $this->getCredential($_SESSION['username']);
    if ($_SESSION['hash'] && $password) {
      $expected = hash_hmac('sha256', 
	     $_SESSION['username'].':'.$password, $_SESSION['key']);

      return ($_SESSION['password'] == $expected);
    }      
    return false;
  }

  function login($status) { // 認証情報入力を要求
    $key = md5(uniqid());
    echo <<<EOS
<script language="JavaScript" src="sha256-min.js"></script>
<script language="JavaScript"><!--
function login(p) {
  p['password'].value = hex_hmac_sha256( p['key'].value, 
	      p['username'].value + ':' + p['password'].value);
  p['hash'].value = 1;
  return true;
}
//--></script>
      {$this->message[$status]}
<form method="POST" action="" onSubmit="return login(this);">
      ユーザ名:<input type="text" name="username" /><br/>
      パスワード:<input type="password" name="password" /><br/>
      <input type="hidden" name="key" value="$key" />
      <input type="hidden" name="hash" value="0" />
      <input type="submit" />
</form>
EOS;
    exit();
  }

  function loadData() {
    parent::loadData();
    $_SESSION['key'] = isset($_POST['key']) ? $_POST['key'] : null;
    $_SESSION['hash'] = isset($_POST['hash']) ? $_POST['hash'] : null;
  }
}
?>