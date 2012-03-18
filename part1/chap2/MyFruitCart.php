<?php
require_once('MyCart.php');
class MyFruitCart extends MyCart {
  private $place;
  // コンストラクタ
  public function __construct($name, $place) {
    $this->place = $place;
    parent::__construct($name); // 親クラスのコンストラクタをコール
  }
  // カートの中の品物を表示
  public function show() {
    print $this->name.$this->place."\n";
    foreach($this->item as $name=>$value) {
      print "$name $value 個\n";
    }
  }
}
?>
