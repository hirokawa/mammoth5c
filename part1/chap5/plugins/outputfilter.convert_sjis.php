<?php // Shift_JIS (CP932) 変換用出力フィルタ
function Smarty_outputfilter_convert_sjis($src, $smarty) {
	if (!headers_sent()) {
		header('Content-Type: text/html; charset=Shift_JIS');
	}
	return mb_convert_encoding($src,"SJIS-win");
}
?>