<?php // Google Calendar エントリ文書定義用クラス
require_once 'AtomEntry.php';

class GCalEntry extends AtomEntry {
  static public function content($entry) {
    $start = date('Y-m-d\TH:i:s.000P', 
          strtotime($entry['date'].' '.$entry['start']));
    $end = date('Y-m-d\TH:i:s.000P', 
          strtotime($entry['date'].' '.$entry['end']));
    $data = array('summary'=>$entry['title'],'location'=>$entry['where'],
          'start'=>array('dateTime'=>$start), 
          'end'=>array('dateTime'=>$end));
    if (!empty($entry['content'])) {
      $data['description'] = $entry['content'];
    }  
    return json_encode($data);    
  }

  static public function parseFeed($data, $uri_c = NULL) {
    $feed = json_decode($data);
    $list = array();
    foreach ($feed->items as $entry) {
    $list[] = array('title'=>$entry->summary,
            'start'=>$entry->start->dateTime,
            'end'=>$entry->end->dateTime,
            'link'=>array('alt'=>$entry->htmlLink,
                    'edit'=>$uri_c.'/'.$entry->id),
            'where'=>$entry->location);
    }
    return $list;
  }
}
?>