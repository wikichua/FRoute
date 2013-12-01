<?php

require_once __DIR__.'/RouterFactory.php';
require_once __DIR__.'/Router.php';
require_once __DIR__.'/HomeController.php';

$Router = new Router();

$Router->get('/','HomeController@tryme');
// $Router->post('home/post','HomeController@trypost');
$Router->controller('home','HomeController');

$Router->run();