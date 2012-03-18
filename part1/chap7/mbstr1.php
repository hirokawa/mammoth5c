<?php
$str = "日本語abc文字列";
echo mb_substr($str, 1, 3),PHP_EOL; // 出力: 本語a
echo mb_strcut($str, 1, 3),PHP_EOL; // 出力: 日
?>
