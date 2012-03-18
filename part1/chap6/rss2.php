<?php
$xml = new SimpleXMLElement('phpnews.xml',null,true); 

$xml->registerXPathNamespace('rss', 'http://purl.org/rss/1.0/');
foreach($xml->xpath('//rss:title') as $title) {
  echo htmlspecialchars($title,ENT_QUOTES,"UTF-8"),"<br />";
}
?>