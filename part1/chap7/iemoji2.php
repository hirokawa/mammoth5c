<?php
 $s = "\xEE\x98\xBEのち\xEE\x98\xBF"; // docomo絵文字を含む文字列（UTF-8）
 $regex = "[\x{E63E}-\x{E757}]";  // docomo絵文字を含む正規表現

 echo preg_replace_callback("/$regex/u", function ($match) {
		$v = unpack('C*',$match[0]);
		$uni = (($v[1] & 0x0f)<<12) | (($v[2] & 0x3f)<<6) | ($v[3] & 0x3f);
		return sprintf("&#x%04X;", $uni); // 数値実体参照として出力	
	}, $s);  // 出力：&#xE63E;のち&#xE63F;
?>
