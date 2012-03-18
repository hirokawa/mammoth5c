<?php
$dstdir = '/var/www/upload';
$tmpfile = $_FILES['userfile']['tmp_name'];
$file = "$dstdir/".basename($_FILES['userfile']['name']);
if (is_uploaded_file($tmpfile) && move_uploaded_file($tmpfile, $file) {
	echo htmlspecialchars($file,ENT_QUOTES,'UTF-8'),
		'にアップロードしました';
}
