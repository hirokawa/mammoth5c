<?php
class MyShop {
  private $data = array('name'=>'バナナ', 'price'=>100);

  public function __set($name, $value) { // プロパティを設定
    echo "[__set:$name:$value]",PHP_EOL;
    $this->data[$name] = $value;
  }

  public function __get($name) { // プロパティを取得
    echo "[__get:$name]",PHP_EOL;
    if (array_key_exists($name, $this->data)) {
      return $this->data[$name];
    } else {
      throw new RuntimeException('undefined property: '.$name);
    }
  }

  public function __isset($name) { // プロパティの設定確認
    echo "[__isset:$name]",PHP_EOL;
    return isset($this->data[$name]);
  }

  public function __unset($name) { // プロパティの設定確認
    echo "[__unset:$name]",PHP_EOL;
    unset($this->data[$name]);
  }
}

try {
  $shop = new MyShop(); // インスタンスを作成
  $shop->price = 60; // プロパティ変数の値を変更
  echo "{$shop->name}は{$shop->price}円です。\n"; // プロパティ変数を出力
  echo isset($shop->name) ? $shop->name : '未定義'; // 出力：バナナ
  unset($shop->name);   // プロパティ変数を削除
  echo isset($shop->name) ? $shop->name : '未定義'; // 出力：未定義
} catch (Exception $e) {
  echo $e;
}
?>
