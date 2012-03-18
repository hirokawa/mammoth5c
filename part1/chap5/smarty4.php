<?php
require_once 'MobileSmarty.php';

$tlist = array(MobileSmarty::T_PC=>'ex1.tpl',
	       MobileSmarty::T_DOCOMO=>'ex1_m.tpl',
	       MobileSmarty::T_EZWEB=>'ex1_m.tpl',
	       MobileSmarty::T_SB=>'ex1_m.tpl');

try {
  $ms = new MobileSmarty();
  $ms->assign('title','テンプレートの例: 1');
  $ms->assign('name','太郎');
  $ms->display($tlist[$ms->agent]); // 表示
} catch (Exception $e) {  echo $e->getMessage(); }
?>