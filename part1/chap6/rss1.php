<?php
require_once 'common.php';
$xml = new XMLReader();
$xml->open('phpnews.xml');

while($xml->read()) {
  if ($xml->name == 'title' && $xml->nodeType == XMLReader::ELEMENT) {
    $xml->read();
    echo hs($xml->value),"<br />";
  }
}
$xml->close();
?>
