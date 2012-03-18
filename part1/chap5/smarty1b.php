<?php
require_once 'Smarty.class.php';

try {
  $smarty = new Smarty();
  $smarty->assign('name','太郎'); // Smartyオブジェクト変数を代入
  $tpl = $smarty->createTemplate('ex1.tpl', $smarty);
  $tpl->assign('title','テンプレートの例: 1'); // テンプレート変数を代入
  $tpl->display(); // 表示
} catch (Exception $e) {  echo $e->getMessage(); }
?>
