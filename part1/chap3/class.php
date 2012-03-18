<?php
class MyClass {
  private $price, $item;
  function __construct($name, $price) {
    $this->item = $name;
    $this->price = $price;
  }
  function show() {
    return "{$this->item}は{$this->price}円です";
  }
} 

session_start();

if (!isset($_SESSION['c'])) { // セッション変数が未定義の場合に作成
  $_SESSION['c']  = new MyClass('オレンジ', 200);
} else {
  $c = $_SESSION['c']; // 定義済みの場合は使用
}
print $c->show(); // 出力: オレンジは200円です。
?>
