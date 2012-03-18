<?php
function conv($u) { // IBM拡張領域用変換関数
	$v = unpack('C*',$u);
	if ($v[2] < 0x8e) {
		$uni = (($v[1]-0x17)<<8) | ($v[2] < 0x7F ? $v[2]-0x40 : $v[2]-0x41);
	} else {
		$uni = (($v[1]-0x16)<<8) | $v[2]-0xa0;
	}
	return sprintf("&#x%04X;", $uni);
}

// SoftBank Unicode 数値文字参照(IBM拡張文字領域を除く)
$map_sb_uni = array(
        0xe69d, 0xe6f6, 0xf964, 0xffff, // 0xf941-0xf99b U+E001-U+E05A
        0xe525, 0xe57e, 0xfbdc, 0xffff, // 0xf741-0xf79b U+E101-U+E15A
        0xe584, 0xe5d6, 0xfc7d, 0xffff, // 0xf7a1-0xf7f3 U+E201-U+E253
        0xe6fc, 0xe748, 0xfc05, 0xffff);// 0xf9a1-0xf9ed U+E301-U+E34D

$s = "\xF9\x8B\xFB\x41"; // 絵文字を含む文字列の例
$s = mb_encode_numericentity($s, $map_sb_uni, "SJIS-win");
mb_regex_encoding('SJIS');
echo mb_ereg_replace("([\x{FB41}-\x{FBD7}])", 'conv("\\1")', $s, 'e');
?>
