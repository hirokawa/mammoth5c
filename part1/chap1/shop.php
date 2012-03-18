<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
 if (isset($_POST['num'])) {
  echo htmlspecialchars($_POST['num'],ENT_QUOTES,'UTF-8'),
       '個購入しました。';
 }
}
?>