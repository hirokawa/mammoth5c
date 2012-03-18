<?php
$dir = new DirectoryIterator('.'); // ディレクトリイテレータ
foreach($dir as $file) {
  if ($file->isFile() && $file->isReadable()){ 
    echo $file, PHP_EOL; // 読込み可能なファイルを出力
  }
}

$regex = new RegexIterator($dir, '/^part/'); // 正規表現イテレータ
foreach ($regex as $file) {
  echo $file, PHP_EOL; // partで始まるファイル名を出力
}

$glob = new GlobIterator('*.tex'); // globイテレータ
foreach ($glob as $file) {
  echo $file, PHP_EOL; // 拡張子*.texのファイル名を出力
}
?>
