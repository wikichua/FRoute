<?php

require_once __DIR__.'/FRouterFactory.php';
require_once __DIR__.'/FRouter.php';
require_once __DIR__.'/HomeController.php';

$Router = new FRouter();

$Router->get('/','HomeController@tryme');
// $Router->post('home/post','HomeController@trypost');
$Router->controller('home','HomeController');

$Router->run();