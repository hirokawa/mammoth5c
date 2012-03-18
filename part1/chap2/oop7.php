<?php
class MyShop {
  private $dbh;
  const DSN = 'sqlite:/tmp/shop.db'; // PHP定数の定義

  function __construct() {
    $this->dbh = new PDO(self::DSN,'',''); // メソッド内からアクセス
  }
}

$obj = new MyShop();
echo MyShop::DSN."\n"; // 出力: sqlite:/tmp/shop.db
?>
