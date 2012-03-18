<?php // Smartyキャッシュ機能のサンプル
require_once 'Smarty.class.php';

try {
  $smarty = new Smarty;
  $smarty->caching = Smarty::CACHING_LIFETIME_SAVED; 
      // 保存時の有効期限を使用
  $smarty->cache_lifetime = 300; // キャッシュの有効時間(秒)
  $cid = md5($_SERVER['PHP_SELF'] . serialize($_GET)); // キャッシュID
  if (!$smarty->isCached('ex1.tpl', $cid)) { // 有効なキャッシュがない場合
    $smarty->assign('name',"太郎(".time().")"); 
        // 変数を代入（テスト用に時刻を表示）
  }
  $smarty->display('ex1.tpl', $cid); // テンプレートの内容を出力
} catch (Exception $e) {  echo $e->getMessage(); }
?>