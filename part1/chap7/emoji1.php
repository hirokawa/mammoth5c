<?php
$s = "\xF8\x9F\x82\xCC\x82\xBF\xF8\xA0"; // 対象文字列（[晴れ]のち[くもり]）
$emoji = '[\x{F89F}-\x{F8FC}|\x{F940}-\x{F9FC}]'; // docomo絵文字用正規表現
mb_regex_encoding("SJIS"); // 正規表現の文字コードをシフトJISに設定
echo mb_ereg_replace($emoji,'',$s); // 出力：のち
?>
