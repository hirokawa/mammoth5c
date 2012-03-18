<?php
abstract class MyCart {
  abstract public function show($name, $num); // 抽象メソッド
  protected function getPrice($num) {         // 通常のメソッド
    return $num*$this->price;
  }
}

class MyFruitCart extends MyCart {
  protected $price = 120;
  public function show($name, $num) {
    echo "$name: ",$this->getPrice($num),"円";
  }
}

$fruit = new MyFruitCart();
$fruit->show("みかん", 3);
?>
