<?php
include_once('db_config.php');
include_once('Form_Auth.php');

$auth = new Form_Auth($dbopts);
if ($auth->getAuth()) {
  $auth->logout();
  echo "ログアウトしました.";
}
?>