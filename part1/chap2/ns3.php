<?php
require_once('MyClassLoader.php');

MyClassLoader::register('Zend','/usr/local/php/include/Zend');
MyClassLoader::register('My','/usr/local/php/include/MyLib');

use My\Shop\Fruit;  // My\Shop\FruitにエイリアスFruitを定義 
$b = new Fruit;
$b->show();   // 出力: [My\Shop\Fruit]
?>
