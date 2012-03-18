<?php
define('DSN','mysql:host=localhost;dbname=mblog;charset=utf8');
define('DBUSER','dbuser'); // <-- 使用するユーザ名に変更
define('DBPWD','secret');  // <-- 使用するパスワードに変更
$dbopts = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES=>false);
?>
