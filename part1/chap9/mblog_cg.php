<?php
require_once('uBlog.php');
define('TTL',60);

function condGet($key, $ttl = 300) {
  $ctime = time();
  $ETag = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
    stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : '';
  $key_r = substr(strtok($ETag,'-'),1);
  $ctime_r = (int)substr(strtok('-'),0,-1);
  if ($key_r === $key && $ctime - $ctime_r < $ttl) {
    header('HTTP/1.0 304');
    exit;
  }
  header("ETag: \"$key-$ctime\"");
}

$key = md5($_SERVER['PHP_SELF'].serialize($_GET));
condGet($key, TTL);
uBlog::showBlog();
?>
