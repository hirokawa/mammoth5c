<?php
require_once('MyFruitCart.php');

$obj = new MyFruitCart("くだもの屋","駅前店");
$obj->addItem("みかん",1);
$obj->addItem("りんご",3);
$obj->show();
?>
