<?php
require 'Slim/Slim.php';
require 'db_config.php';
require 'Views/SmartyView.php';
SmartyView::$smartyDirectory = dirname(__FILE__) . '/libs';

$db = new PDO(DSN, DBUSER, DBPWD, $dbopts);

$app = new Slim(array('view'=> new SmartyView()));
$app->view()->getInstance()->loadFilter('variable','htmlspecialchars');

$app->get('/', function () use ($app) {
	$app->render('menu.tpl');
})->name('menu');

$app->get('/disp(/:year)', function ($year = 2012) use ($app, $db) {
	$st = $db->prepare("SELECT * FROM news WHERE YEAR(wdate)=?");
	$st->execute(array($year));
	$app->render('disp.tpl',array('news' => $st->fetchAll()));		
})->conditions(array('year'=>'(19|20)\d\d'));

$app->get('/submit', function () use ($app) {
    $app->render('form.tpl');
});

$app->post('/submit', function () use ($app, $db) {
	$params = $app->request()->post();
	if (empty($params['title']) || empty($params['content'])) {
		$app->halt(404,'タイトル/内容が指定されていません.');
	} else if (empty($params['link']) ||
		   !filter_var($params['link'], FILTER_VALIDATE_URL)) {
		$app->halt(404,'URLが不正です.');		
	} else if (empty($params['wdate']) ||
	   !preg_match('/(19|20)\d\d\/\d{1,2}\/\d{1,2}/',$params['wdate'])) {
		$app->halt(404,'日付が不正です.');		
	}
	$st = $db->prepare(
        "INSERT INTO news (title,content,link,wdate) VALUES(?,?,?,?)");
	$flag = $st->execute(array($params['title'],$params['content'],
					   $params['link'],$params['wdate']));
	$app->render('result.tpl',array(
        'flag'=>$flag,'url'=>$app->urlFor('menu')));
});

$app->run();
?>