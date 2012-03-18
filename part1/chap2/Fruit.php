<?php
namespace My\Shop;

class Fruit {
  public function show() { echo "[",__CLASS__,"]";}
  public static function stShow() { echo "[",__CLASS__,"]";}
}
function show() { echo __NAMESPACE__; };
const NS = __NAMESPACE__;
?>