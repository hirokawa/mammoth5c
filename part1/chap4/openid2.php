<?php
require_once('OpenID_Auth.php');
$opts=array('realm'=>'www.example.com',
			'required'=>array('namePerson/friendly'),
			'optional'=>array('person/gender','namePerson/first'));
$auth = new OpenID_Auth($opts);
$auth->start();

if ($auth->getAuth()) { // 認証が必要なコンテンツを表示
  $nickname = htmlspecialchars(
      $auth->attr['namePerson/friendly'],ENT_QUOTES,'UTF-8');
  echo "こんにちは、 $nickname さん！";
}
?>
