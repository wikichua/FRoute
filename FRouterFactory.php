<?php

abstract class FRouterFactory
{
	protected $GetRoutes    	= [];
	protected $PostRoutes    	= [];
	// protected $PutRoutes    	= [];
	// protected $DeleteRoutes    	= [];

	protected function parseUri() {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),"/");
        $path = preg_replace('/^('.$this->baseFile.'\/*)/i', "", $path);
        if(empty($path))
        	$path = '/';
        
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $this->extractController($path,'Get');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->extractController($path,'Post');
        }

        // if($_SERVER['REQUEST_METHOD'] === 'PUT')
        // {
        //     $this->extractController($path,'Put');
        // }

        // if($_SERVER['REQUEST_METHOD'] === 'DELETE')
        // {
        //     $this->extractController($path,'Delete');
        // }
    }

    protected function extractController($path,$method)
    {
    	$method = "{$method}Routes";
    	if(in_array($path, array_keys($this->{$method})))
        {
            list($controller,$callback) = explode('@', $this->{$method}[$path]);
            $this->controller = $controller;
            $this->callback = $callback;
        }
    }
}