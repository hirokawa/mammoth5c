<?php
include_once('db_config.php');
include_once('HTTP_Digest_Auth.php');

$auth = new HTTP_Digest_Auth($dbopts);
$auth->start();

if ($auth->getAuth()) { // 以下、認証が必要なコンテンツを表示
  echo "認証成功！";
}
?>
