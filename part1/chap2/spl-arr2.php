<?php
require_once('Shop.php');
$fruit = new Shop(array('banana','orange'));

for ($i=0; $i<count($fruit); $i++){
  echo $fruit[$i], PHP_EOL; // 出力： banana, orange
}
?>
