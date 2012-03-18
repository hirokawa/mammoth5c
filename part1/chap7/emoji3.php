<?php
$map = array(
        0xe63e, 0xe6a5, 0x0000, 0xffff,  // 0xf89f-0xf949 U+E63E-U+E6A5
        0xe6ce, 0xe757, 0x0000, 0xffff); // 0xf972-0xf9fc U+E6CE-U+E757
$s = "明日は\xF8\x9F"; // 置換対象文字列
echo mb_encode_numericentity($s, $map, "SJIS-win");// 出力：明日は&#58942;
?>