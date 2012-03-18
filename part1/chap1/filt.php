<?php
$_GET = array('id'=>'123<script><script/>',
		'password'=>'0 --',
		'email'=>'taro@example.com\r\n'); // サンプル入力
$filt = array('id'=>FILTER_VALIDATE_INT,
		'password'=>array('filter'=>FILTER_VALIDATE_REGEXP,
			   'options'=>array('regexp'=>'/^[.a-z0-9@_-]+$/iD')),
		'email'=>FILTER_VALIDATE_EMAIL); // フィルタ定義

$param = filter_var_array($_GET, $filt);
var_dump($param); // 出力： id,email,password => false
