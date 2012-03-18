<?php
define('CONSUMER_KEY',<コンシューマID>);
define('CONSUMER_SECRET',<コンシューマシークレット>);

$entry = array('callback'=>'http://www.example.com/twitter.php',
			   'req_token'=>'https://twitter.com/oauth/request_token',
			   'authorize'=>'https://twitter.com/oauth/authorize',
			   'access_token'=>'https://twitter.com/oauth/access_token');
$opts = array();

$optForm = <<<EOS
  <br />場所：<input type="text" name="where" size="20" />
  <br />日付(YYYY/mm/dd)：<input type="text" name="date" size="10" />
  <br />時間(hh:mm)<input type="text" name="start" size="5" />〜
  <input type="text" name="end" size="5" />
EOS;

$copts = array();

function show_update_form($opts = null) {
  echo <<<EOS
    <form method="post" action="" enctype="multipart/form-data">
    <input type="radio" name="f" value="submit"/>つぶやく
    <input type="radio" name="f" value="timeline" checked="checked"/>TL
    <br />つぶやき/スクリーン名：<input type="text" name="data" size="20" />
    画像：<input type="file" name="img" size="26" /><br/>
    $opts <input type="submit" /></form>
EOS;
}  
?>
