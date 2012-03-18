<?php
class MyCart {
  protected static $items = 3;
  const PRICE=100;
  public static function add($num) {
    self::$items += $num;
    self::show();
  }
  public static function show() {
    echo __CLASS__,':',self::$items,':',self::PRICE,PHP_EOL; 
  }
}

class MyFruitCart extends MyCart {
  protected static $items = 1;
  const PRICE=150;
  public static function show() {
    echo __CLASS__,':',self::$items,':',self::PRICE,PHP_EOL; 
  }
}

MyFruitCart::add(2); // o—Í  MyCart:5:100
MyCart::add(1);      // o—Í  MyCart:6:100
?>