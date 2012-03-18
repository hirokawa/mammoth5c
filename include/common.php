<?php
function hs($v, $enc = 'UTF-8') { // HTMLエスケープ処理
  return is_array($v) ? array_map('hs',$v) : htmlspecialchars(
      $v,ENT_QUOTES, $enc);
}

function chk_link($link) { // リンク指定の妥当性を確認
	return filter_var($link, FILTER_VALIDATE_URL) ? $link : null;
}

function rfc3986_build_query($params) { // RFC3986形式のクエリ生成
  $s = '';
  foreach ($params as $key => $val) {
    $s .= '&' . rawurlencode($key) .'='. rawurlencode($val);
  }
  return substr($s, 1); // remove leading '&' and return
}

function show_query_form() {  // HTMLフォーム表示
  echo <<<EOS
    <form method="post" action="">
    キーワード:<input type="text" name="query"/>
    <input type="submit" value="送信" /></form>
EOS;
}
?>
