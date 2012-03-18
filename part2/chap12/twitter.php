<?php
require_once('config.php');
require_once('common.php');
require_once('OAuthLib.php');
require_once('TwitterAPI.php');

try {
  $oauth = new OAuthLib(CONSUMER_KEY, CONSUMER_SECRET, $entry, $copts);
  if (isset($_GET['logout']) && $_GET['logout']) { // ログアウト処理
    $oauth->logout();
  }

  $oauth->check($opts);   // 認証確認
  show_update_form(); // フォームを表示  

  if (!isset($_SESSION['login']) || !isset($_POST['f'])) {
    exit(1);
  } else {
    switch ($_POST['f']) {
    case 'submit':
      $img = $_FILES['img'] ?: null;
      TwitterAPI::submitUpdate($oauth, $_POST['data'], $img);
      break;
    case 'timeline':
      TwitterAPI::showTimeline($oauth, $_POST['data']);
      break;
    }
  }
} catch (Exception $e) {
  print_r($e);
}
?>
