<?php // 折れ線グラフの例
require_once("jpgraph/jpgraph.php");
require_once("jpgraph/jpgraph_line.php");

$labels = array('2000','2001','2002','2003','2004','2005');
$data = array(1.2,5.1,7.5,10, 15, 18); 

$graph = new Graph(300,250,"auto"); // 300*250ピクセルで描画
$graph->SetScale("textlin"); // X軸:テキスト, Y軸:線形

$graph->img->SetMargin(60,40,40,60); // マージン設定
$graph->img->SetAntiAliasing(); // アンチエイリアス処理有効
$graph->SetShadow(); // 枠の影を付ける

$graph->title->Set("PHPユーザ数の推移"); // タイトル
$graph->title->SetFont(FF_GOTHIC,FS_NORMAL,14); // ゴシック/14ポイント
$graph->xaxis->SetTickLabels($labels); // X軸ラベルを指定
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,11); // X軸：Arial/11ポイント
$graph->xaxis->SetLabelAngle(45); // 45度傾ける

$line = new LinePlot($data); // 線を描画
$line->mark->SetType(MARK_FILLEDCIRCLE); // マーカ:●
$line->mark->SetFillColor("green"); // 緑で塗りつぶしす
$line->mark->SetWidth(3); // マーカの大きさを指定
$line->SetColor("blue"); // 線の色は青
$line->SetLegend("ドメイン"); // 凡例を設定

$graph->legend->SetLayout(LEGEND_VERT);  // 凡例を垂直に描画
$graph->legend->SetFont(FF_GOTHIC);  // 凡例：ゴシック
$graph->legend->Pos(0.8,0.5,"center"); // 凡例の位置を指定
$graph->Add($line); // グラフに線を追加
$graph->Stroke();  // グラフを出力
?>
