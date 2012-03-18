<?php
require_once 'common.php';
$xml = new SimpleXMLElement('phpnews.xml',null,true); 
$xml->registerXPathNamespace('rss', 'http://purl.org/rss/1.0/');
foreach($xml->xpath('//rss:title') as $title) {
  echo hs($title),"<br />";
}
?>