<?php
require_once('HTMLPurifier.auto.php');

$html = "<a href=\"javascript:alert('Danger!');\">リンク</a>";
    // 確認するHTMLの例
$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.Allowed', 'p,b,a[href],i'); // 許可するタグを指定
$pf = new HTMLPurifier($config);
echo $pf->purify($html); // 出力： <a>リンク</a>
?>
