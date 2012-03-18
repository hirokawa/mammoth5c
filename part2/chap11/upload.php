<?php
require_once('chkfile.php');
session_start(); // セッション開始
if($_SERVER['REQUEST_METHOD']=='POST') { // ファイルアップロード完了時
	$tmpfile = $_FILES['userfile']['tmp_name'];
	$file = "/var/www/upload/".basename($_FILES['userfile']['name']);
	if (chk_file($tmpfile, $file) && move_uploaded_file($tmpfile, $file)) {
		echo "<p>画像ファイルをアップロードしました!</p>";
	}
	exit();
}
$id = uniqid(mt_rand(),true); // アップロード用にユニークなIDを生成
$pname = ini_get("session.upload_progress.name");
?>
<html><head>
<script type="text/javascript" 
    src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function() { 
 $("#form1").submit(function () {
	$("#uframe").show();
	setTimeout(function () {
		$("#uframe").attr('src','progress.php?id=<?php echo $id;?>');
	}, 500);
 });
});
</script></head><body>
<form action="" method="post" enctype="multipart/form-data" id="form1">
  <input type="hidden" name="<?php echo $pname;?>" 
      value="<?php echo $id; ?>"/>
  <input type="file" name="userfile" size="30"/>
  <input type="submit" value="アップロード" /><br />
 </form>
 <iframe id="uframe" src="" frameborder="0" scrolling="no"></iframe>
</body></html>