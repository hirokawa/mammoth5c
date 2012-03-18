<?php // Yahoo! Japan GeoCoder API
require_once('common.php');

$appId = '<アプリケーションID>'; // <-- 開発者のアプリケーションIDに置換

$url = 'http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder';
$url_map = 'http://map.olp.yahooapis.jp/OpenLocalPlatform/V1/static';
$url_map .= "?appid=$appId&width=300&z=15";

show_query_form(); // フォームを表示

if (isset($_POST['query'])) {
  try {
    $params = array('appid'=>$appId, 'query'=>$_POST['query'], 'results'=>3);
    $url .= '?' . rfc3986_build_query($params);
    $xml = new SimpleXMLElement($url, null, true); // XMLデータ取得
    if (isset($xml) && $xml->ResultInfo->Count > 0) {
      echo '<ul>';
      foreach ($xml->Feature as $feature) { 
        $geo = $feature->Property;
      list($lon,$lat) = explode(',',$feature->Geometry->Coordinates);
      $url = "$url_map&lat=$lat&lon=$lon"; // スタティック地図のURL
        echo "<li><a href=\"$url\" target=\"ilink\">",
         hs($geo->Address),"</a></li>"; // スタティックマップへのリンクを表示
      }
      echo '</ul>';
    }
  } catch (Exception $e) { echo $e->getMessage(); }
}
?>
<iframe name="ilink" width="200" height="300"></iframe>
<hr/>
<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<span style="margin:15px 15px 15px 15px">
<a href="http://developer.yahoo.co.jp/about">
Webサービス by Yahoo! JAPAN</a></span>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->