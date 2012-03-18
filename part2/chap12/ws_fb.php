<?php // Facebook Graph API
require_once 'config.php';
require_once 'common.php';
require_once 'OAuth2Lib.php';

try {
  $auth = new OAuth2Lib(CLIENT_ID, CLIENT_SECRET, $entry, $copts);
  if (isset($_GET['logout']) && $_GET['logout']) {
    $auth->logout();
  }
  $auth->check($opts, 'urlencode');
  show_update_form('ID:<input type="text" name="id"/>');
  if (!$_SESSION['login'] || !isset($_POST['f'])) {
    exit;
  }
  $id = $_POST['id'] ?: 'me';
  $url = "https://graph.facebook.com/$id/feed";
  if ($_POST['f']=='timeline') { // タイムライン表示
    $res = $auth->request($url);
    $obj = json_decode($res);
    echo "<ul>";
    foreach($obj->data as $entry) {
      if (isset($entry->message)) {
        echo '<li>',hs($entry->message."({$entry->from->name})"),'</li>';
      } else {
        $url = chk_link($entry->picture);
        echo '<li>',hs($entry->name),"<img src=\"{$url}\"/></li>";
      }
    }
    echo "</ul>";
  } else if ($_POST['f']=='submit') { // 投稿
    $img = $_FILES['img'] ?: null;
    $params = array('message'=>$_POST['data']);
    if (isset($_FILES['img']) && !empty($_FILES['img']['tmp_name'])) {
      $url = "https://graph.facebook.com/$id/photos";
      $params['source'] = '@' . $_FILES['img']['tmp_name'];
    }
    $res = $auth->request($url,$params,'POST'); // データ投稿
    $obj = json_decode($res);
    $res = $auth->request('https://graph.facebook.com/'.$obj->id); 
         // リソース情報取得
    $obj = json_decode($res);
    $msg = !empty($_FILES['img']['tmp_name']) ? $obj->name : $obj->message;
    echo hs("$msg ({$obj->from->name})[$obj->updated_time]");
  }
} catch (Exception $e) {
  print_r($e);
}
?>
