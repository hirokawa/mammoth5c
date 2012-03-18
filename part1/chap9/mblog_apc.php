<?php
require_once('uBlog.php');
define('TTL',60);

function cachedCall($m, $key, $func, $arg = null) {
  if (!($data = apc_fetch($key)) &&
      ($data = call_user_func($func, $arg))) {
    apc_store($key, $data, TTL);
  }
  return $data;
}

$m = null;
$entries = cachedCall($m, 'entries', 'uBlog::getEntry');
$users = uBlog::getNickname($m, $entries);
uBlog::showEntry($entries, $users);
?>
