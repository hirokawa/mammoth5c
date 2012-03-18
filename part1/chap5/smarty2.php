<?php
require_once 'Smarty.class.php';
try {
  $smarty = new Smarty();
  $users = array(array('name'=>'太郎','age'=>30),
           array('name'=>'次郎','age'=>25),
           array('name'=>'三郎','age'=>18));
  $smarty->assign('users',$users);
  $smarty->display('ex4.tpl');
} catch (Exception $e) {  echo $e->getMessage(); }
?>