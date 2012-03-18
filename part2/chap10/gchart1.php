<?php
$labels = array('4-6月','7-9月','10-12月','1-3月');
$data = array(480,320,150,490); // データ

$params = array('chs'=>'300x150','cht'=>'p3','chds'=>'0,490',
			'chd'=>'t:'.implode(',',$data),'chtt'=>'売上件数',
			'chdl'=>implode('|',$labels));
$query = http_build_query($params,null,'&');
echo "<img src=\"http://chart.apis.google.com/chart?$query\"/>";
?>