<?php
class MyCart {
  protected $item = array();
  public $name;
  // コンストラクタ
  public function __construct($name) {
    $this->name = $name;
    echo "いらっしゃいませ! {$name}へようこそ\n";
  }
  // カートに品物を追加
  public function addItem($name, $num) {
    if(isset($this->item[$name])) {
      $this->item[$name] += $num;
    } else {
      $this->item[$name] = $num;
    }
  }
  // カートの中の品物を表示
  public function show() {
    foreach($this->item as $name=>$value) {
      echo "$name:$value\n";
    }
  }
  // デストラクタ
  public function __destruct() {
    echo "ありがとうございました!\n";
  }
}
?>
