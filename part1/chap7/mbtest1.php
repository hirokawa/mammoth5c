<?php
mb_http_output("SJIS");
ob_start("mb_output_handler");

echo <<<EOS
 <form method="POST" action="">
	 <input type="text" name="str"/>
<input type="hidden" name="dummy" value="日本語文字" />
	 <input type="submit"/></form>
EOS;

if (isset($_POST['str'])) {
	$s = $_POST['str'];
	echo mb_http_input(),"($s)<br/>";
}
?>
