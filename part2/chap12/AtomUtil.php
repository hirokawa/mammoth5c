<?php
class AtomUtil {
  static public function showForm($feed, $optForm = null) {
    echo <<<EOS
    <form method="post" action="">
    <input type="radio" name="f" value="submit"/>投稿
    <input type="radio" name="f" value="disp" checked="checked"/>表示
    <input type="radio" name="f" value="edit"/>編集
    <input type="radio" name="f" value="delete"/>削除
    <br />タイトル：<input type="text" name="title" size="50" />
    <br />本文：<br/><textarea name="content" cols="60" rows="5"></textarea>
    <br />$optForm
    <br /><select name="entry_id">
EOS;
    foreach($feed as $f) {
      printf('<option value="%s">%s</option>',
               chk_link($f['link']['edit']),hs($f['title']));
    }
    echo '</select><br /><input type="submit" /></form><hr />';
  }

  static public function showFeed($feed) {
    echo '<ul>';
    foreach($feed as $f) {
      printf('<li><a href="%s">%s</a></li>',
         chk_link($f['link']['alt']), hs($f['title']));
    }
    echo '</ul>';
  }

  static public function showContent($dat, $is_xml = true) {
    if ($is_xml) {
      $obj = new SimpleXMLElement($dat);
      echo "タイトル:",hs($obj->title),"<br />本文: ",hs($obj->content);
    } else {
      $obj = json_decode($dat);
      echo "タイトル:",hs($obj->summary),"<br />";
      echo "場所:",hs($obj->location),"<br/>";
      echo "日時:",hs($obj->start->dateTime),
              "〜",hs($obj->end->dateTime);
    }
  }

  static public function run($oauth, $f, $data, $uri_c, $uri_e, 
      $is_xml = true) {
    $url = ($f == 'submit') ? $uri_c : $uri_e;
  if (empty($url)) {   return false;}
  if ($is_xml) {
    $header = array('Content-Type'=>'application/atom+xml');
  } else { // JSON
    $header = array('Content-Type'=>'application/json; charset=UTF-8');
  }
    switch ($f) {
    case 'submit':
      $dat = $oauth->request($url, $data, 'POST', $header);
      AtomUtil::showContent($dat, $is_xml);
      break;
    case 'disp':
      $dat = $oauth->request($url);
      AtomUtil::showContent($dat, $is_xml);
      break;
    case 'edit':
      $dat = $oauth->request($url, $data, 'PUT', $header);
      AtomUtil::showContent($dat, $is_xml);
      break;
    case 'delete':
      $oauth->request($url, null, 'DELETE', array(), 204);
      break;
    }
  }
}
?>