function chk_virus($file) { // ウイルスチェック
	$conn = fsockopen('unix:///var/run/clamav/clamd.ctl');	
	fwrite($conn, 'SCAN '.$file); // ウイルスチェック実行
	$r = fread($conn, 256);
	if (preg_match('/OK$/', $r) != 1) {
		echo '画像が不正です.'; return false;
	}
	return true;
}