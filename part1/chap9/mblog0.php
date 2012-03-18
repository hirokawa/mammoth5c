<?php
require_once('uBlog.php');

$entries = uBlog::getEntry();
$users = uBlog::getNickname(null, $entries);
uBlog::showEntry($entries, $users);
?>
