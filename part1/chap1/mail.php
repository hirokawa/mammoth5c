<?php
echo <<<EOS
<form action="">
	送信元:<input type="text" name="from"/><br/>
	本文:<textarea name="body"></textarea><input type="submit"/>
</form>
EOS;
if (isset($_GET['from']) && isset($_GET['body'])) {
	mb_send_mail('admin@example.com','質問',$_GET['body'],
               "From: ".$_GET['from']);	
}