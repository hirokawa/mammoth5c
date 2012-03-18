<?php
class TwitterAPI {
  static public function showStatuses($json) { // ステータスを表示
    echo '<ul>';
    foreach($json as $status) {
      $user = $status->user;
      $url = chk_link($user->profile_image_url);
      echo "<li><img src=\"$url\" width=\"30\"/>",hs("($user->screen_name)
            {$status->text} ($status->created_at)"),"</li>";
    }
    echo '</ul>';
  }
  // タイムラインを表示
  static public function showTimeline($auth, $uid, $params = array()) {
    $url = 'http://api.twitter.com/1/statuses/friends_timeline.json';
    if (!empty($uid)) {
      $url = 'http://api.twitter.com/1/statuses/user_timeline.json';
      $params['screen_name'] = $uid;
    }
    $json = json_decode($auth->request($url, $params));
    self::showStatuses($json);
  }
  // ステータス（つぶやき）を投稿
  static public function submitUpdate($auth, $status, $img = null, 
     $key = null) {
    $url = 'http://api.twitter.com/1/statuses/update.json';
    if (!empty($img) && !empty($img['tmp_name']) && in_array($img['type'], 
       array('image/jpeg', 'image/png', 'image/gif'))) {
      if (!empty($key)) { // サードパーティ(Twitpic)
        $status = self::submitImage($auth, $status, $img, $key);
        $params = array('status' => $status);
      } else { // Twitterに直接アップロード
        $url = 
           'https://upload.twitter.com/1/statuses/update_with_media.json';
        $params = array('@media[]'=>'@'. $img['tmp_name'], 
           'status' => $status);
      }
    } else {
      $params = array('status' => $status);
    }
    $json = json_decode($auth->request($url, $params, 'POST'));
    $url = chk_link('http://twitter.com/'.$json->user->screen_name.
                   '/status/'.$json->id_str);
    echo "<a href=\"$url\">投稿を確認</a>";
  }
  // OAuth EchoでTwitPicに画像を投稿し、リンクを返す
  static public function submitImage($auth, $update, $img, $api_key) {
    $url_c = 'https://api.twitter.com/1/account/verify_credentials.json';
    $url = 'http://api.twitpic.com/2/upload.json';

    $oauth = $auth->getAuth();
    $oauth->setToken($_SESSION['token'], $_SESSION['token_secret']);
    $oauth_header = $oauth->getRequestHeader(OAUTH_HTTP_METHOD_GET, 
       $url_c);
    $headers = array("X-Verify-Credentials-Authorization: {$oauth_header}",
     "X-Auth-Service-Provider: {$url_c}");
    $params = array ('media' => '@' . $img['tmp_name'], 'key' => $api_key,
    'message' => $update);

    $curl_opts = array(CURLOPT_URL => $url, CURLOPT_POST => true,
       CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => $headers,
       CURLOPT_POSTFIELDS => $params);
    $ch = curl_init();
    curl_setopt_array($ch, $curl_opts); // cURLオプション設定
    $response = curl_exec($ch); // cURLによりPOSTリクエスト実行
    curl_close ($ch);

    $res = json_decode($response);
    return $res->text .' '. $res->url;
  }
}
?>