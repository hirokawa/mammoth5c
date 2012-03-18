<?php // 3次元円グラフの例
require_once("jpgraph/jpgraph.php");
require_once("jpgraph/jpgraph_pie.php");
require_once("jpgraph/jpgraph_pie3d.php");

$labels = array('4-6月','7-9月','10-12月','1-3月');
$data = array(480,320,150,490); // データ

mb_http_output('pass');
$graph = new PieGraph(400,300,'auto',600); // 400*250ピクセルで描画

$graph->SetShadow(); // 枠に影を付ける

$graph->title->Set('売上件数'); // タイトル（ゴシック/14pt）
$graph->title->SetFont(FF_GOTHIC,FS_NORMAL,14);
$graph->title->SetColor('darkblue');

$pie = new PiePlot3d($data); // 3次元円グラフ
$pie->SetCenter(0.5, 0.4); // 円グラフの中心を設定
$pie->SetAngle(30); // 円グラフの傾斜を30度に

$pie->value->SetFont(FF_ARIAL,FS_NORMAL,12); // 値（Arial,12pt)
$pie->ExplodeSlice(2,50); // 2つ目のスライスを飛び出させる
$pie->value->SetFormat('%d'); // 数値のみ表示
$pie->SetLabelType(PIE_VALUE_ABS); // ％ではなく値を表示

$graph->legend->SetFont(FF_GOTHIC,FS_NORMAL,10); // 凡例（ゴシック/10pt）
$pie->SetLegends($labels); // 凡例を追加
$graph->Add($pie); // 円グラフを追加
$graph->Stroke(); // グラフを出力
?>