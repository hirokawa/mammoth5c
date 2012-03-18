<?php // DB接続用設定
define('DSN', 'mysql:dbname=user;host=localhost');
define('DB_USER', 'dbuser');// <-- 使用時にユーザ名を変更
define('DB_PWD', 'secret'); // <-- 使用時にパスワードを変更
$dbopts = array('dsn'=>DSN,'db_user'=>DB_USER,'db_pwd'=>DB_PWD);
?>
