<?php
require_once('uBlog.php');
define('TTL',60);

function cachedOutput($m, $key, $func, $arg = null) {
  if (!($data = $m->get($key))) {
    ob_start();  // 出力バッファリング
    ob_implicit_flush(false);
    call_user_func($func, $arg);
    $data = ob_get_contents();
    ob_end_clean();    
    $m->set($key, $data, TTL);
  }
  echo $data;
}

$m = new Memcached();
$m->addServer('mc1.example.com',11211);
cachedOutput($m, 'ublog', 'uBlog::showBlog');
?>
