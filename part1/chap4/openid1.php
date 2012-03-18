<?php
require_once('OpenID_Auth.php');

$auth = new OpenID_Auth(array('realm'=>'www.example.com'));
$auth->start();

if ($auth->getAuth()) { // 認証が必要なコンテンツを表示
  echo "認証成功！";
}
?>