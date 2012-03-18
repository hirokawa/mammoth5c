<?php
abstract class Auth {
  protected $opts = array('dsn'=>'','db_user'=>'','db_pwd'=>'','idle'=>0);
  protected $data;
  const TIMEOUT = 1, NO_DATA = 2, INVALID = 3;

  function __construct($opts = null) {
    foreach ($this->opts as $key => $value) { // オプション設定
      $this->opts[$key] = isset($opts[$key]) ? $opts[$key] : $value;
    }
    session_start();
  }

  function setRealm($realm) {
    if (!isset($_SESSION['realm'])) {
      $_SESSION['realm'] = empty($realm) ? md5(uniqid()) : $realm;
    } else if (!empty($realm)) {
      $_SESSION['realm'] = $realm;
    }
  }

  function getCredential($username) { // 認証情報を取得
    try {
      $db = new PDO($this->opts['dsn'],
          $this->opts['db_user'], $this->opts['db_pwd'],
          array(PDO::ATTR_EMULATE_PREPARES => false));
      $stmt = $db->prepare('SELECT * FROM auth WHERE username=?');
      $stmt->execute(array($username)); // クエリー実行
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "DBエラー:".$e->getMessage();
    }
    return $row ? $row['password'] : false;
  }

  function getAuth() { // ログイン状態時にtrueを返す
    return isset($_SESSION['login']) ? $_SESSION['login'] :  false;
  }

  function logout() { // ログアウト処理
    $_SESSION = array();
    session_destroy();
  }

  function start() { // 認証処理を開始
    if (!isset($_SESSION['realm'])) {
      $this->setRealm('');
    }
    $this->loadData();
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      if ($this->opts['idle'] > 0 &&
        time()-$_SESSION['idle'] > $this->opts['idle']) {
        $this->logout(); // 有効期限切れの場合はログアウト
        $this->login(self::TIMEOUT);
      } else {
        $_SESSION['idle'] = time(); // アイドル時間を更新
      }
    }
    if (!$this->data) {
      $this->login(self::NO_DATA); // 認証画面表示
    } else if (!$this->check()) { // 認証情報の有効・無効を判定
      $this->login(self::INVALID); // 認証情報が無効な場合は認証画面表示
    } else {
      if (!$_SESSION['login']) {
        session_regenerate_id(true);
      }
      $_SESSION['login'] = true;
      $_SESSION['idle'] = time();      
    }
  }

  abstract function check(); // 認証情報を検証
  abstract function login($status); // 認証情報入力を要求
  abstract function loadData(); // 認証情報を読み込み
}
?>
