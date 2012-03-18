<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
	echo <<<EOS
	<form action="shop.php" method="POST">
		 購入数：<input type="text" name="num" />
		 <input type="submit" />
	</form>
EOS;
}
?>