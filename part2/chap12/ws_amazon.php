<?php // Amazon Webサービスサンプル
require_once('common.php');
define('USERID','<アクセスキーID>');
define('SECRET','<シークレットアクセスキー>');
define('ASSOC_TAG','<アソシエイトタグ>');

function get_sign($uri, $params, $key, $method = 'GET') {
  ksort($params); // キーでソート
  $query = rfc3986_build_query($params);
  $v = parse_url($uri); // URLをパースし、配列に代入
  $str = "$method\n{$v['host']}\n{$v['path']}\n$query"; // 署名対象文字列
  $sign = rawurlencode(base64_encode(
      hash_hmac('sha256',$str, $key, true)));
  return array($query, $sign);
}

show_query_form(); // フォームを表示
if (!isset($_POST['query'])) {
  exit;
}

$uri = 'http://ecs.amazonaws.jp/onca/xml';
$keyword = strip_tags($_POST['query']);
$params = array('Service'=>'AWSECommerceService',
    'Operation'=>'ItemSearch', 'AWSAccessKeyId'=>USERID, 
    'AssociateTag'=>ASSOC_TAG, 'SearchIndex'=>'Books', 
    'Version'=>'2011-08-01', 'Keywords'=>$keyword, 
    'Timestamp'=>gmdate(DATE_ISO8601));
list($query, $sign) = get_sign($uri, $params, SECRET); // 署名生成
$uri .= "?$query&Signature=$sign";

try {
  $xml = new SimpleXMLElement($uri, null, true); 
  if ($xml->Items->TotalResults > 0) {
    echo '<ul>';
    foreach ($xml->Items->Item as $item) {
      echo "<li><a href=\"{$item->DetailPageURL}\">
          {$item->ItemAttributes->Title}</a></li>";
    }
    echo '</ul>';
  }
} catch (Exception $e) {  echo $e->getMessage(); }
?>
