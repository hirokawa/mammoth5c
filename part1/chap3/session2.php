<?php
session_start(); // セッションを開始
$_SESSION = array(); // 全てのセッション変数の登録を解除
if (isset($_COOKIE[session_name()])) { // クライアント側のセッションIDを破棄
  setcookie(session_name(), '', time()-42000, '/');
}
session_destroy(); // サーバ側でのセッション破棄
echo "セッションを破棄し、ログアウトしました。"
?>