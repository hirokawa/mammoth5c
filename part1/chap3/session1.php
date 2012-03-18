<?php
session_start(); // セッション開始

$_SESSION['count'] = isset($_SESSION['count']) ? $_SESSION['count']+1 : 1;
echo "アクセス回数：{$_SESSION['count']}";
?>