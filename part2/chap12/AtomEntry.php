<?php // Atomエントリ文書定義用クラス
class AtomEntry {
  static public function content($entry) {
    if (!isset($entry['title'])) {
      return false;
    }
    $xml = <<<EOS
<?xml version="1.0" encoding="utf-8"?>
<entry xmlns="http://www.w3.org/2005/Atom"></entry>
EOS;
    $sxe = new SimpleXMLElement($xml);
    $sxe->addChild('title', $entry['title']);
    if (!empty($entry['content'])) {
      $content = $sxe->addChild('content', $entry['content']);
      $content->addAttribute('type','text');
    }
    if (!empty($entry['summary'])) {
      $summary = $sxe->addChild('summary', $entry['summary']);
      $summary->addAttribute('type','text');
    }
    return $sxe->asXML();
  }

  static public function commonEntry($entry) {
    $link = array();
    foreach ($entry->link as $elink) {
      if (preg_match('(alt|self|edit)', $elink['rel'], $matched)) {
	$link[$matched[0]] = (string)$elink['href'];
      }
    }
    $feed = array('title'=>(string)$entry->title, 
		  'author'=>(string)$entry->author->name,
		  'link'=>$link);
    return $feed;
  }

  static public function parseFeed($xml, $url_c = null) {
    $feed = new SimpleXMLElement($xml);
    foreach ($feed->entry as $entry) {
      $f = self::commonEntry($entry);
      $list[] = $f;
    }
    return $list;
  }
}
?>
