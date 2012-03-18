<html>
<head><title>Form Test</title></head><body>
<?php
require_once('Numeric.php');

echo <<<EOS
<form name="form1" method="post" action="">
  x:<input type="text" size="3" name ="x_val">
  y:<input type="text" size="3" name ="y_val">
   <input type="submit" id="submit" value="計算">
</form>
EOS;

$obj = new Numeric;

if (isset($_POST['x_val']) && (isset($_POST['y_val']))) {
  $result = $obj->add((int)$_POST['x_val'],(int)$_POST['y_val']);
  echo "<div id=\"result1\">$result</div>";
} else {
  echo '値を指定してください.';
}
?>
</body>