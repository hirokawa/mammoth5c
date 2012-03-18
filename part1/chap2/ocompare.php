<?php // オブジェクトの比較
function obj_compare($a, $b) { // 比較を行う関数
  echo ($a == $b) ? '一致' : '不一致' , '::';
  echo ($a === $b) ? '一致' : '不一致' , PHP_EOL;
}
class MyCart {
  public $items = 1;
}

$a = new MyCart();
$b = $a;       // （シャロー）コピー
obj_compare($a, $b); // 出力:  一致::一致

$b = clone $a; // ディープコピー
obj_compare($a, $b); // 出力:  一致::不一致

$b->items = 2; // プロパティの値を変更
obj_compare($a, $b); // 出力:  不一致::不一致
?>