<?php
interface Write {};
class Shop implements Write {};
class MyShop extends Shop {}

$obj = new MyShop();
if ($obj instanceof Shop) {
  echo '一致', PHP_EOL;
}
print_r(class_parents($obj)); // 出力： Array ([Shop] => Shop )
print_r(class_implements($obj)); // 出力： Array ([Write] => Write)
?>
