<?php
include_once('db_config.php');
include_once('Form_Digest_Auth.php');

$auth = new Form_Digest_Auth($dbopts);
$auth->start();

if ($auth->getAuth()) { // 認証が必要なコンテンツを表示
  echo "認証成功！";
}
?>
