<?php
interface Calc {
  public function add($a);
}

interface Display {
  public function show();
}

class MyCart implements Calc, Display {
  protected $items = 0;
  public function show() {
    echo $this->items,'個',PHP_EOL;
  }
  public function add($a) {
    $this->items += $a;
  }
}

$shop = new MyCart();
$shop->add(3);
$shop->show(); // 出力: 3個
?>
