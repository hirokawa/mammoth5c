<?php
require_once 'Smarty.class.php';

try {
  $smarty = new Smarty();
  //$smarty->debugging = true;
  $smarty->debugging_ctrl = 'URL';
  $smarty->addPluginsDir('./plugins');
  //
  //$smarty->setAutoloadFilters(array('convert_sjis'),'output');

  $tpl = $smarty->createTemplate('ex1a.tpl', $smarty);
  $tpl->loadFilter('output','convert_sjis');

  // pre,post,output,variable
  //$tpl->registerFilter('output','smarty_outputfilter_convert');
  //$tpl->escape_html = true;
  //$tpl->loadFilter('variable','htmlspecialchars');
  //$tpl->loadFilter('output','trimwhitespace');
  $tpl->assign('title','テンプレートの例: 1');
  //$tpl->assign('name','太郎<script>alert("danger")</script> ');
  $tpl->assign('name',"太郎<!-- test -->\r\n\n");
  $tpl->display(); // 表示
} catch (Exception $e) {  echo $e->getMessage(); }

?>
