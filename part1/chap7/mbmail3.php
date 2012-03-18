<?php
$to = array("name"=>"鈴木たろう", "email"=>"taro@ezweb.ne.jp"); // 宛先
$from = array("name"=>"管理者", "email"=>"admin@example.com"); // 送信者
$to_head = mb_encode_mimeheader($to['name']) . " <{$to['email']}>";
$extra = "From: ".mb_encode_mimeheader($from['name']) . 
         " <{$from['email']}>\r\n";
$extra .= "Content-Type: text/plain; charset=ISO-2022-JP\r\n"; 
$extra .= "Content-Transfer-Encoding: 7bit\r\n"; 
$extra .= "MIME-Version: 1.0\r\n"; 

$subject = "お知らせ\xF0\x9F\x8C\xBB"; // お知らせ[ひまわり] (UTF-8)
$body = "明日は\xE2\x98\x80です。";     // 明日は[はれ]です (UTF-8)
$subject = mb_encode_mimeheader($subject, "ISO-2022-JP-Mobile#KDDI");
$body = mb_convert_encoding($body,"ISO-2022-JP-Mobile#KDDI");
mail($to_head, $subject, $body, $extra); // メール送信
?>
