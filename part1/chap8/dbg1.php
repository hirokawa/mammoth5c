<?php
require_once('Numeric.php');

$obj = new Numeric;
$args = array(2,0);
$z = $obj->div($args[0],$args[1]);
echo $z;
?>
