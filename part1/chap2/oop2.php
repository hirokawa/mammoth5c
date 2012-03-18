<?php
class MyShop {
  private $obj;
  public function __construct($obj) { // コンストラクタ
    $this->obj = $obj;
  }

  public function __call($method, $args) { // メソッドのオーバーロード
    echo "[__call:".$method.":".implode($args,","),"]",PHP_EOL;
    if (is_callable(array($this->obj, $method))) {
      return call_user_func_array(array($this->obj, $method), $args);
    } else {
      throw new BadMethodCallException('undefined method : '.$method);
    }
  }

  public static function __callStatic($method, $args) {
    echo "[__callStatic:".$method.":".implode($args,","),"]",PHP_EOL;  
  
    if (is_callable(array('Calculate', $method))) {
      return forward_static_call_array(array('Calculate', $method), $args);
    } else {
      throw new BadMethodCallException('undefined method : '.$method);
    }        
  }
}

class Calculate {
  public function add($a, $b){
    return $a+$b;
  }
  public static function sub($a, $b) {
    return $a-$b;
  }
}

try {
  $shop = new MyShop(new Calculate());
  echo $shop->add(2,3); // 未定義のメソッドaddをコール
  echo MyShop::sub(3,1); // 未定義のstaticメソッドsubをコール
} catch (Exception $e) {
  echo $e;
}
?>
