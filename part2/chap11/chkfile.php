<?php
function chk_file($tmpfile, $file) { // ファイル形式チェック
	if (!is_uploaded_file($tmpfile)) {
		echo 'アップロードされたファイルではありません.';return false;
	}
	$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	if (!in_array($ext, array('png','jpeg','jpg'))) {
		echo '拡張子が無効です.'; return false;
	}
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $tmpfile);	
	if (!in_array($mime_type, array('image/png', 'image/jpeg'))) {
		echo '画像が無効です.'; return false;
	}
	return true;
}
?>