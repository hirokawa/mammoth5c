<?php
require_once("jpgraph/jpgraph.php");
require_once("jpgraph/jpgraph_gantt.php");

$data = array(
  array(0,ACTYPE_NORMAL,'執筆','2012-1-21','2012-02-10',' [70%]'),
  array(1,ACTYPE_NORMAL,'編集','2012-2-12','2012-02-28',''),
  array(2,ACTYPE_MILESTONE,'マイルストーン','2012-2-11','脱稿'));  // データ
$constrains = array(array(0,1,CONSTRAIN_ENDSTART)); // 拘束条件
$progress = array(array(0,0.7),array(1,0.0)); // 進捗度

$graph = new GanttGraph(0,0,'auto'); // ガント図生成
$graph->SetBox(); // 外枠表示
$graph->SetShadow(); // 影を表示
$graph->title->Set("執筆進捗"); // タイトル設定
$graph->title->SetFont(FF_GOTHIC,FS_NORMAL,11); // ゴシック, 11pt

$graph->SetDateRange('2012-1-30','2012-2-15'); // 日付表示を固定
$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH); 
    // 月,週,曜日を表示
$graph->scale->SetDateLocale('ja_JP.UTF-8');
$graph->scale->month->SetBackgroundColor("lightblue"); 
    // ヘッダの背景色を指定
$graph->scale->month->SetFont(FF_GOTHIC);
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY3);
$graph->scale->day->SetFont(FF_GOTHIC);
$graph->scale->day->SetStyle(DAYSTYLE_SHORT);

$graph->SetSimpleFont(FF_GOTHIC, 10); // ゴシック,10pt
$graph->CreateSimple($data,$constrains,$progress); // ガント図を描画
$graph->Stroke(); // 出力
?>