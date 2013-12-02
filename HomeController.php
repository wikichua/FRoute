<?php

class HomeController
{
	function __construct() {

	}

	public function tryme()
	{
		echo 'try me? - normal';
	}

	public function get_tryme()
	{
		echo 'try me? - restful';
	}

	public function trypost()
	{
		echo 'try post? - normal';
	}

	public function post_try()
	{
		echo 'try post? - restful';
	}
}