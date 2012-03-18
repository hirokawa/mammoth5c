<?php
require_once('chkfile.php');
$dstdir = '/var/www/upload';
$tmpfile = $_FILES['userfile']['tmp_name'];
$file = "$dstdir/".basename($_FILES['userfile']['name']);
if (chk_file($tmpfile, $file) && move_uploaded_file($tmpfile, $file)) {
	echo htmlspecialchars($file,ENT_QUOTES,'UTF-8'),
        'にアップロードしました';
}
