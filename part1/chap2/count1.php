<?php
class Counter {
  public $cnt = 1;
}

$a = new Counter();
$b = $a; // オブジェクトを（シャロー）コピー
$c = clone $a; // オブジェクトをディープコピー

$a->cnt++; // カウントアップ

echo $b->cnt; // 出力: 2
echo ($a === $b) ? "同じ" : "別"; // 出力：同じ

echo $c->cnt; // 出力: 1
echo ($a === $c) ? "同じ" : "別"; // 出力：別
?>