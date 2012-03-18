<?php
 $extra = "Content-Type: text/plain; charset=Shift_JIS\r\n"; 
 $extra .= "Content-Transfer-Encoding: base64\r\n"; 
 $extra .= "MIME-Version: 1.0\r\n"; 
 $subject = mb_encode_mimeheader("お知らせ\xF0\x9F\x8C\xBB", 
   "SJIS-Mobile#docomo");
 $body = mb_convert_encoding("明日は\xE2\x98\x80です。",
   "SJIS-Mobile#docomo");
 $body = chunk_split(base64_encode($body));
 mail('taro@docomo.ne.jp', $subject, $body, $extra); // メール送信
?>
