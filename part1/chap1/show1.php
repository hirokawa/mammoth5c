<?php
$users = array('taro','jiro','hanako'); // 有効なユーザのリスト
$basedir = '/var/data/'; // Webサーバの非公開ディレクトリ
ini_set('open_basedir',$basedir);
if (isset($_GET['user']) && in_array($_GET['user'],$users)) {
	include $basedir.basename($_GET['user']).'.html';
}