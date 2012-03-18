<?php
require_once('db_config.php');
require_once('Form_Auth.php');

$auth = new Form_Auth($dbopts);
$auth->start();

if ($auth->getAuth()) { // 認証が必要なコンテンツを表示
  echo "認証成功！";
}
?>
