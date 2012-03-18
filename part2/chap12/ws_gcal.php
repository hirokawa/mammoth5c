<?php // Google Calendar APIの例
require_once 'common.php';
require_once 'config.php';
require_once 'OAuth2Lib.php';
require_once 'AtomUtil.php';
require_once 'GCalEntry.php';

try {
  $oauth = new OAuth2Lib(CLIENT_ID, CLIENT_SECRET, $entry, $copts);
  if (isset($_GET['logout']) && $_GET['logout']) { // ログアウト処理
    $oauth->logout();
  }
  $oauth->check($opts);

  $data = $oauth->request($uri_c);
  $feed = GCalEntry::parseFeed($data, $uri_c);

  AtomUtil::showForm($feed, $optForm);
  AtomUtil::showFeed($feed);

  if (!isset($_POST['f'])) {
	  exit;
  }

  $content = GCalEntry::content($_POST);
  AtomUtil::run($oauth, $_POST['f'], $content, $uri_c,
				chk_link($_POST['entry_id']), false);
} catch (Exception $e) { 
  echo $e; 
}
?>
