<?php 
require_once("Image/QRCode.php"); 

$s = 'QRコードサンプル http://www.example.com/';
$s = mb_convert_encoding($s,'SJIS-win');
$opts = array('error_correct'=>'L');
try {
	$qr = new Image_QRCode(); 
	$qr->makeCode($s, $opts); // QRコード画像生成
} catch (Exception $e) { echo $e;}
?>