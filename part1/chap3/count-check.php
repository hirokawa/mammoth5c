<?php
function generate_finger_print($type, $salt) { // 指紋を生成
  $base = $salt;
  $base .= $_SERVER['REMOTE_ADDR']; // クライアントのIPアドレス

  if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    $base .= $_SERVER['HTTP_USER_AGENT'];
  }

  if ($type == 'client') { // クライアント側の情報で指紋を生成
    if (!empty($_SERVER['HTTP_REFERER'])) {
      $src = preg_replace("/(.+)\?.*/",'$1',$_SERVER['HTTP_REFERER']);
    }
  } else { // サーバー側の情報で指紋を生成
    $src = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  }
  return sha1($base . $src);
}

function check_session($salt) { // 指紋の一致を確認
  $fp_cli = generate_finger_print('client', $salt); // クライアントの指紋

  if (!isset($_SERVER['HTTP_REFERER']) || !isset($_SESSION['fp']) || 
      $_SESSION['fp'] != $fp_cli) { // 指紋一致を確認

    session_regenerate_id(true); // 一致しない場合はセッションID変更
    $_SESSION = array(); // セッション変数を初期化
    $_SESSION['fp'] = generate_finger_print('server', $salt); 
        // 指紋を更新
    echo "セッションが開始されました<br>";
    return false;
  } else {
    return true;
  }
}

$salt = "secret"; // 秘密の文字列
session_start();
check_session($salt); // 指紋の一致を確認

$_SESSION['cnt'] = isset($_SESSION['cnt']) ? $_SESSION['cnt']+1 : 1;
echo "アクセス回数: {$_SESSION['cnt']}<br>";
echo  "<a href=\"{$_SERVER['PHP_SELF']}\">クリック</a>";
?>