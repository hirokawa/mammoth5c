<?php // 簡易RSSリーダの例
function showItem ($title, $link, $date = null) {
  $date = date('Y-m-d', strtotime($date));
  echo "<li><a href=\"{$link}\">{$title} ({$date})</a></li>";
}

$xml = 'phpnews.xml';

try {
  $rss = new SimpleXMLElement($xml, null, true); 
  echo '<ul>';
  switch (strtolower($rss->getName())) {
  case 'rdf': // RSS 1.0
    foreach ($rss->item as $item) {
      showItem($item->title, $item->link, 
         $item->children('http://purl.org/dc/elements/1.1/')->date);
    }
    break;
  case 'rss': // RSS 2.0
    foreach ($rss->channel->item as $item) {
      showItem($item->title, $item->link, $item->pubDate);
    }
    break;
  case 'feed': // Atom
    foreach ($rss->entry as $entry) {
      showItem($entry->title, $entry->link['href'], $entry->updated);
    }
    break;
  }
  echo '</ul>';    
} catch (Exception $e) {
  echo $e->getMessage();
}
?>
