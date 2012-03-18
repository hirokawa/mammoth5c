<?php
$map = igbinary_unserialize(file_get_contents('docomo_fb.bin'));
mb_substitute_character("entity"); // 代替文字に数値文字参照を指定
$s = mb_convert_encoding(
    "文字に\xF7\xD9","SJIS-Mobile#docomo","SJIS-Mobile#KDDI");
echo $s,PHP_EOL; // 数値文字参照（&#x2611;）
echo str_replace($map[0], $map[1], $s),PHP_EOL; // 代替文字列に置換
?>
