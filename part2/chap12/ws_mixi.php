<?php
require_once 'config.php';
require_once 'common.php';
require_once 'OAuth2Lib.php';
require_once 'MixiConnect.php';

try {
  $auth = new OAuth2Lib(CLIENT_ID, CLIENT_SECRET, $entry, $copts);
  if (isset($_GET['logout']) && $_GET['logout']) {
    $auth->logout();
  }
  $auth->check($opts);
  show_update_form();
  if (!$_SESSION['login'] || !isset($_POST['f'])) {
    exit;
  }
  switch ($_POST['f']) {
  case 'submit':
    $img = $_FILES['img'] ?: null;
    MixiConnect::submitUpdate($auth, $_POST['data'], $img);
    break;
  case 'timeline':
    MixiConnect::showTimeline($auth, $_POST['data'], array('count'=>8));
    break;
  }
} catch (Exception $e) {
  print_r($e);
}
?>
