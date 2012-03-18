<?php
class MyCart {
  public $items = array();
  public function add(MyItem $obj) { // 商品を追加
    $this->items[] = $obj;
  }
}

class MyItem {
  public $item;
  public function __construct($item) {
    $this->item = $item;
  }
}

$shop = new MyCart();
$shop->add(new MyItem('バナナ'));
$shop->add(new MyItem('オレンジ'));
$shop2 = clone $shop; // オブジェクトをディープコピー
echo ($shop->items[0] === $shop2->items[0]) ? '一致' : '不一致';
?>
