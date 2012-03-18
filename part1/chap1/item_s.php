<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
	$token = hash('sha256',mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	echo <<<EOS
	<form action="shop_s.php" method="POST">
		 購入数：<input type="text" name="num" />
		 <input type="submit" />
		 <input type="hidden" name="token" value="$token" />
	</form>
EOS;
	$_SESSION['token'] = $token;
}
?>