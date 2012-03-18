<?php
try {
  $xml = new SimpleXMLElement('simple1.xml', null, true); 
  $xml->person[1]->name = '佐藤三郎'; // 既存の要素の値を更新
  $person = $xml->addChild('person'); // 新規要素を追加
  $person->addAttribute('id','a3');
  $person->addChild('name','鈴木三郎');
  $person->addChild('age',45);
  echo $xml->asXML(); // XMLデータを出力
} catch (Exception $e) {
  echo $e->getMessage();
}
?>
