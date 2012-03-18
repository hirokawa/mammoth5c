<?php
require_once 'Fruit.php';

$shop = new My\Shop\Fruit;
$shop->show();            // 出力： [My\Shop\Fruit]
My\Shop\Fruit::stShow(); // 出力： [My\Shop\Fruit]
echo \My\Shop\show();    // 出力： My\Shop
echo \My\Shop\NS;        // 出力： My\Shop
?>
