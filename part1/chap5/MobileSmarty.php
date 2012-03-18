<?php
require_once 'Smarty.class.php';

class MobileSmarty extends Smarty {
  const T_PC = 1, T_DOCOMO = 2, T_EZWEB = 3, T_SB = 4; 
  public $agent = MobileSmarty::T_PC;

  public function __construct() {
    parent::__construct();
    $this->agent = $this->detectAgent($_SERVER['HTTP_USER_AGENT']);
	$this->addPluginsDir('./plugins');
	if ($this->agent !== MobileSmarty::T_PC) {
		$this->loadFilter('output','convert_sjis');
	}
  }

  public function detectAgent($ua) { // クライアント種別を検出
    if (preg_match('/^DoCoMo/',$ua)) {
      return MobileSmarty::T_DOCOMO;
    } elseif (preg_match('/^KDDI\-/' ,$ua)) {
      return MobileSmarty::T_EZWEB;
    } elseif (preg_match('/^(SoftBank|Vodafone)/' ,$ua)) {
      return MobileSmarty::T_SB;
    } else { // 判別できない場合はPC端末とする
      return MobileSmarty::T_PC;
    }  
  }
}
?>