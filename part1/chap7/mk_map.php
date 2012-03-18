<?php
$xml = new SimpleXMLElement('emoji4unicode.xml',NULL, TRUE);
$carrier = 'docomo'; // kddi,softbank
foreach($xml->xpath('//e') as $e) {
 if (isset($e['unicode']) && isset($e['text_fallback']) && 
     !isset($e[$carrier])) { 
  $map[] = '&#x'.str_replace('+','',strtolower($e['unicode'])).';';
  $map_fb[] = (string)$e['text_fallback'];
 }
}
$ig = igbinary_serialize(array($map, $map_fb));
file_put_contents($carrier.'_fb.bin',$ig);
?>