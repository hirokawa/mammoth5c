<?php
require_once('uBlog.php');
define('TTL',60);

function cachedCall($m, $key, $func, $arg = null) {
  if (!($data = $m->get($key)) &&
      ($data = call_user_func($func, $arg))) {
    $m->set($key, $data, TTL);
  }
  return $data;
}

$m = new Memcached();
$m->addServer('mc1.example.com',11211);

$entries = cachedCall($m,'entries', 'uBlog::getEntry');
$users = uBlog::getNickname($m, $entries);
uBlog::showEntry($entries, $users);
?>
