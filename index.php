<?php

require_once __DIR__.'/FRouterFactory.php';
require_once __DIR__.'/FRouter.php';
require_once __DIR__.'/HomeController.php';

$Router = new FRouter();

// $Router->get('/','HomeController@tryme');
$Router->post('home/post',['as'=>'posting','uses'=>'HomeController@trypost']);
$Router->controller('home','HomeController');

$Router->get('/',['as'=>'home.index','uses'=>'HomeController@tryme']);
$Router->get('/{name}/work/{work}',['as'=>'home.closure','uses'=>function($name, $work){
	echo $name . 'my work is ' .$work;
}]);

$Router->get('/{name}/age/{age}',['as'=>'home.closure','uses'=>function($name,$age){
	echo $name . 'i have an age ' . $age;
}]);

$Router->get('/{name}',['as'=>'home.closure','uses'=>function($name){
	echo $name;
}]);

$Router->get('hello/{name}',['as'=>'home.closure','uses'=>function($name){
	echo 'hello '.$name;
}]);

$Router->get('hey/{name}/age/{age}',['as'=>'home.closure','uses'=>function($name,$age){
	echo 'hello '.$age;
}]);
$Router->get('hello/{name}/age/{age}',['as'=>'home.closure','uses'=>function($name,$age){
	echo 'hello '.$name . ' and im age ' . $age;
}]);


// echo $Router->route('home.index');
// echo $Router->route('home.tryme');
// echo $Router->route('posting');

$Router->run();