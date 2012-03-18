<?php
require 'openid.php';

try {
  if (isset($_POST['openid_identifier'])) { // 識別子が入力された場合
    $auth = new LightOpenID('www.example.com');
    $auth->identity = $_POST['openid_identifier'];
    $url = htmlspecialchars($auth->authUrl(), ENT_QUOTES, 'UTF-8');
    echo "OPエンドポイントURL: ".substr($url, 0, strpos($url, '?'));
  } else { // ID入力フォーム表示
    echo <<<EOS
<form action="" method="post">
 OpenID: 
<input type="text" name="openid_identifier" /><input type="submit" />
</form>
EOS;
  }
} catch(ErrorException $e) {
  echo $e->getMessage();
}
?>