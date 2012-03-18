<?php
require_once 'Fruit.php';
use My\Shop\Fruit, My\Shop as MyShop;

$shop = new Fruit;
$shop->show(); // 出力： [My\Shop\Fruit]
echo MyShop\show(); // 出力： My\Shop
?>
