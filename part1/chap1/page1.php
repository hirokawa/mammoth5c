<html><body>
  <form action="">
   名前:<input type="text" name="name">
   パスワード:<input type="password" name="password">
   <input type="submit"></form><hr />
<?php
 if (isset($_GET['name']) && isset($_GET['password'])) {
   $db = new PDO("mysql:host=localhost;dbname=testdb;charset=utf8", 
                 "dbuser", "secret");
   $sSQL = sprintf("SELECT * FROM users WHERE name='%s' AND password='%s'",
				   $_GET['name'], $_GET['password']);
   $st = $db->query($sSQL);
   if ($st && $st->rowCount() > 0){
	   echo "認証されました。";
   }
 }
?></body></html>