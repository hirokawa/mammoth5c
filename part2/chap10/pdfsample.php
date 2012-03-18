<?php
require_once('tcpdf/tcpdf.php'); 

class MyPDF extends TCPDF {
	protected function chapterTitle($num, $title) { // 章タイトル出力
		$this->SetFont('kozgopromedium','B',12); // ゴシック体で出力
		$this->SetFillColor(200,220,255); // 背景色を指定
		$this->Cell(0,6, "第 $num 章 $title",0,1,'L',true); // 文字列を出力  
		$this->Ln(5); // 改行
	}

	protected function chapterBody($file) { // 章ボディ部出力
		$content = file_get_contents($file); // ファイル読み込み
		$this->SetFont('kozminproregular','',11); // 明朝体で出力
		$this->MultiCell(0,5, $content); // 複数セルに文字列を出力
		$this->Ln(); // 改行
	}
	
	public function printChapter($num, $title, $file) {
		$this->chapterTitle($num, $title);
		$this->chapterBody($file);
	}
}

$pdf= new MyPDF();
$pdf->SetTitle('PHP新機能の解説'); // タイトルを指定
$pdf->setPrintHeader(false);      // ヘッダを表示しない
$pdf->AddPage();                  // ページを追加
$pdf->printChapter(1,'PHP5.4の新機能','ch1.txt');
$pdf->printChapter(2,'PHPの今後','ch2.txt');
$pdf->Output("pdfsample.pdf","I"); // インライン形式でPDFファイルを出力
?>