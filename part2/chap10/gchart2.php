<?php
$s = 'QRコードサンプル http://www.example.com/';

$params = array('chs'=>'300x150','cht'=>'qr','chl'=>$s,
				'choe'=>'Shift_JIS','chld'=>'L');
$query = http_build_query($params,null,'&');
echo "<img src=\"http://chart.apis.google.com/chart?$query\"/>";
?>