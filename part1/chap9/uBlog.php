<?php
require_once('db_config.php');
require_once('common.php');

class uBlog {
  public static function getEntry() { // データベースからデータを取得
    $db = new PDO(DSN, DBUSER, DBPWD, $GLOBALS['dbopts']);
    $stm = $db->query("SELECT * FROM entry LIMIT 0,30");
    if ($stm === false) { return false;}
    return $stm->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getName($uid) {
    $db = new PDO(DSN, DBUSER, DBPWD, $GLOBALS['dbopts']);
    $st = $db->prepare("SELECT nickname FROM user WHERE uid=?");
    $st->execute(array($uid));
	$data = $st->fetch(PDO::FETCH_ASSOC);
    return $data['nickname'];    
  }

  public static function getNickname($m, $entries) {
    $users = array();
    foreach($entries as $e) {
      $uid = $e['uid'];
      if (!isset($users[$uid])) {
		  $name = self::getName($uid);
		  //$name = cachedCall($m, $uid, 'uBlog::getName', $uid);
        $users[$uid] = $name;
      }
    }
    return $users;
  }

  public static function checkAuth($uinfo) {
    $db = new PDO(DSN, DBUSER, DBPWD, $GLOBALS['dbopts']);
    $params = array(':uname'=>$uinfo['uname'],':pw'=>$uinfo['pwd']);
    $sql = "SELECT uid FROM user WHERE username=:uname AND password=:pw";
    $sth = $db->prepare($sql);
    $sth->execute($params);
    $data = $sth->fetch();
    if ($data === false) { return false;}
    return $data['uid'];
  }

  public static function putEntry($data) {
    $db = new PDO(DSN, DBUSER, DBPWD, $GLOBALS['dbopts']);
    $sql = "INSERT INTO entry VALUES(NULL,:uid,CURRENT_TIMESTAMP,:content)";
    $sth = $db->prepare($sql);
    $params = array(':uid'=>$data['uid'],':content'=>$data['content']);
    return $sth->execute($params);
  }

  public static function showEntry($entries = null, $users = null) {
    echo "<ul>\n";
    foreach ($entries as $e) {
		printf("<li>%s,%s (%s)</li>\n", hs($e['ctime']),
			   hs($e['content']),hs($users[$e['uid']]));
    }
    echo "</ul>\n";
  }

  public static function showForm() {
    echo <<<EOS
<form action="" method="POST">
  username:<input type="text" name="uname">
  password:<input type="password" name="pwd"></br>
  content:<input type="text" size="32" name="content">
 <input type="submit">
</form>
EOS;
  }

  public static function showBlog() {
    $entries = self::getEntry();
    self::showEntry($entries, self::getNickname(null,$entries));
  }
}
?>