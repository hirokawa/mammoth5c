<?php
$m = new Memcached();
$m->addServer('127.0.0.1',11211);

$m->set('key1','tokyo'); // データを設定
$data = $m->get('key1',null,$token); // データを取得
$m->set('key1','kyoto'); // データを変更
if ($m->cas($token,'key1','chiba') === FALSE) { 
    // アトミック処理によるデータ取得
  echo $m->getResultMessage(),PHP_EOL; 
      // エラー出力: CONNECTION DATA EXISTS
}
echo $m->get('key1'),PHP_EOL; // 出力: kyoro
?>
