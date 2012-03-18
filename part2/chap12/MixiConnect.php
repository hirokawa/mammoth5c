<?php
require_once('TwitterAPI.php');

class MixiConnect {
  static public function showTimeline($auth, $uid, $params = array()) {
    $url = MIXIVOICE . '/statuses/friends_timeline/';
    if (!empty($uid)) { 
      $url = MIXIVOICE . "/statuses/$uid/user_timeline";
    }
    $json = json_decode($auth->request($url, $params));
    TwitterAPI::showStatuses($json);
  }

  static public function submitUpdate($auth, $status, $img = null) {
    $url = MIXIVOICE . '/statuses/update';
    if (!empty($img['name']) && 
	(($img['type'] == 'image/jpeg') || ($img['type'] == 'image/png'))) {
      $url .= '?status='.rawurlencode($status);
      $headers = array('Content-Type'=>$img['type']);
      $params = file_get_contents($img['tmp_name']);
    } else {
      $headers = array();
      $params = array('status'=>$status);
    }
    $res = $auth->request($url, $params, 'POST', $headers, 200);
    $json = json_decode($res);
    echo hs(
      "完了:{$json->text}({$json->user->screen_name}:{$json->created_at})");
  }
}
?>
