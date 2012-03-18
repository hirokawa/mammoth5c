<?php
try {
  $xml = new SimpleXMLElement('simple2.xml', null, true);
  $ns = $xml->getDocNamespaces();
  $xml->registerXPathNamespace('_default', $ns['']);
  $xml->registerXPathNamespace('ad', $ns['ad']);

  $person = $xml->xpath("//_default:person");
  echo $person[0]->name; // 出力: 鈴木太郎

  $name = $xml->xpath("//ad:name");
  echo $name[0][0]; // 出力: 東京
} catch (Exception $e) {
  echo $e->getMessage();
}
?>
