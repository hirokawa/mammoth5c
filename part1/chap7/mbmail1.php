<?php
$to = array("name"=>"鈴木たろう", "email"=>"taro@example.com"); // 宛先
$from = array("name"=>"管理者", "email"=>"admin@example.com"); // 送信者

$to_head = mb_encode_mimeheader($to['name']) . " <{$to['email']}>";
$from_head = mb_encode_mimeheader($from['name']) . " <{$from['email']}>";
$extra = "From: $from_head\r\n" . 
         "Reply-To: webmaster@example.com\r\n";
$subject = "お知らせ";
$body = "こんにちは、{$to['name']}さん。"; // 本文
mb_send_mail($to_head, $subject, $body, $extra); // メール送信
?>
