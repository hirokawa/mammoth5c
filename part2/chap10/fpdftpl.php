<?php // PDFテンプレートファイル使用例
error_reporting(E_ALL ^ E_STRICT);
require_once('tcpdf/tcpdf.php'); 
require_once('tcpdf/fpdi.php'); 

$tplfile = "quotation.pdf"; // テンプレートファイル
$product = array('みかん','オレンジ','りんご');
$price = array(100,200,150); // 価格リスト

if (isset($_POST['name']) && isset($_POST['num'])) {
	$pdf = new FPDI();// 'P','mm','A4'
	$pdf->setSourceFile($tplfile);
	$tplIdx = $pdf->importPage(1);
	
	$pdf->SetLeftMargin(24); // 左マージンを24mmに設定
	$pdf->AddPage(); // ページ追加
	$pdf->useTemplate($tplIdx); // テンプレートを使用
	
	$pdf->SetFont('kozminproregular', '', 12);
	$pdf->SetXY(160, 40);
	$pdf->Write(12,date("Y年m月d日")); // 日付を出力
	$pdf->SetXY(40, 48);
	$pdf->Write(12,$_POST['name'].' 様'); // 宛先を出力
	
	$pdf->SetFont('kozgopromedium','',11); // ゴシック11ポイントを指定
	$sum = 0;
	$pdf->SetXY(24,77);
	for ($i=0; $i<count($product); $i++) {
		$num[$i] = intval($_POST['num'][$i]);         // 個数取得
		$subtotal = $price[$i]*$num[$i];              // 小計計算
		$sum += $subtotal;                            // 合計計算
		$pdf->Cell(120,7.3, $product[$i]);            // 商品名出力
		$pdf->Cell(30,7.3,sprintf("%4d", $num[$i]));  // 個数出力
		$pdf->Cell(30,7.3,'￥'.$subtotal); $pdf->Ln(); // 小計出力
	}
	$pdf->SetXY(174,109); $pdf->Write(12,'￥'.$sum); // 合計を出力
	$pdf->Output("ex1.pdf","I"); // インライン形式でPDFファイルを出力
} else { // 入力フォームを出力
	echo <<<EOS
<form action="" method="POST">
<table border=1>
お名前：<input type="text" name="name" size="20"><br>
EOS;
	for ($i=0;$i<count($product);$i++){
		echo <<<EOS
  <tr><td>{$product[$i]}</td>
  <td><input type="text" size="5" name="num[]"></td></tr>
EOS;
	}
	echo '</table><input type="submit" value="作成">';
}
?>