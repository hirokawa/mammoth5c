<?php
require 'Slim/Slim.php';
$app = new Slim();

$app->get('/disp/:name', function ($name) use ($app) {
	$app->render('tp1.php', array('name_tpl'=>$name));
});
$app->run();
?>