<?php
class MyShop {
  private static $items = 0; // 商品数の合計
  public static $price = 150; // 商品価格
  
  public static function add($num) { // 商品数を追加
    self::$items += $num;
  }

  public static function show() {
    return self::$items * self::$price; // 購入価格を出力
  }
}

echo MyShop::$price; // 商品価格（150）を出力
MyShop::add(2); // 商品を２つ追加
echo MyShop::show(); // 商品価格の合計（300）を出力
?>