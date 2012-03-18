<?php
require_once 'Smarty.class.php';

try {
  $smarty = new Smarty();
  $smarty->assign('title','テンプレートの例: 1');
  $smarty->assign('name','太郎');
  $smarty->display('ex1.tpl'); // 表示
} catch (Exception $e) {  echo $e->getMessage(); }
?>