<?php
require_once 'config.php';
require_once 'common.php';
require_once 'OAuthLib.php';
require_once 'AtomUtil.php';
require_once 'AtomEntry.php';

try {
  $oauth = new OAuthLib(CONSUMER_KEY, CONSUMER_SECRET, $entry, $copts);
  $oauth->check($opts);
  $uri_c = "http://d.hatena.ne.jp/{$_SESSION['url_name']}/atom/blog";
  $xml = $oauth->request($uri_c);
  $feed = AtomEntry::parseFeed($xml);
  AtomUtil::showForm($feed);
  AtomUtil::showFeed($feed);

  if (!isset($_POST['f'])) {
    exit;
  }

  $content = AtomEntry::content($_POST);
  AtomUtil::run($oauth, $_POST['f'], $content, $uri_c, $_POST['entry_id']);
} catch (Exception $e) { 
  echo $e;
  print_r($oauth->auth->getLastResponseInfo());
}
?>
