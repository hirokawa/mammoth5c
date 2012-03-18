<?php // Ajax処理用：指定ユーザ名で投稿されたエントリを取得
require_once('db_config.php'); // リスト9.3参照
require_once('common.php');    // リスト1.6参照

header('Content-type: application/json; charset=utf-8');
$db = new PDO(DSN, DBUSER, DBPWD, $dbopts);
$st = $db->prepare("SELECT * FROM user WHERE nickname=?");
$st->execute(array($_POST['key']));
$r = $st->fetch(PDO::FETCH_ASSOC);
if (!$r) { // ユーザIDが存在しない
	echo json_encode(array('error'=>true));
} else { // ユーザIDで投稿したエントリを返す
	$st = $db->query("SELECT * FROM entry WHERE uid={$r['uid']}");
	echo json_encode(hs($st->fetchAll()));
}
?>