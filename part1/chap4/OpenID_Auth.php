<?php
require_once('Auth.php');
require_once('openid.php');

class OpenID_Auth extends Auth {
  protected $opts = array('realm'=>null,'verify_peer'=>true,'cainfo'=>false,
              'required'=>false,'optional'=>false,'idle'=>0);
  protected $auth = null;
  public $attr = array();
  
  function __construct($opts) { // コンストラクタ
    parent::__construct($opts); // 親クラスのコンストラクタ
    $this->auth = new LightOpenID($this->opts['realm']);
    $this->auth->verify_peer = $this->opts['verify_peer'];
    $this->auth->cainfo = $this->opts['cainfo'] ?: null;
    $this->auth->required = $this->opts['required'] ?: array();
    $this->auth->optional = $this->opts['optional'] ?: array();
  }
  
  function check() { // 認証情報を検証
    if ($_SESSION['login']) {
      return true;
    }
    try {
      if ($this->auth->validate()) {
        $this->attr = $this->auth->getAttributes(); // AX,SREG属性取得
        return true;
      }
      return false;
    } catch(ErrorException $e) {
      echo $e->getMessage();
    }
  }
  
  function login($status) { // 認証情報入力を要求
    echo <<<EOS
<form action="" method="post">
    OpenID: 
<input type="text" name="openid_identifier" /><input type="submit" />
</form>
EOS;
    exit();
  }
  
  function loadData() { // 認証リクエストを実行
    if (!$this->auth->mode) {
      if (isset($_POST['openid_identifier'])) {
        try {
          $this->auth->identity = $_POST['openid_identifier'];
          header('Location: ' . $this->auth->authUrl());
        } catch(ErrorException $e) {
          echo $e->getMessage();
        }
        exit();
      } elseif (isset($_SESSION['login']) && $_SESSION['login']) {
        $this->data = true;
      } else {
        $this->data = null;
      }
    } else if ($this->auth->mode == 'id_res'){
      $this->data = true; // 肯定アサーション
    } else { // $this->auth->mode == 'cancel' or 'setup_neeeded'
      $this->data = null; // 認証キャンセル／失敗の場合
    }
  }
}
?>