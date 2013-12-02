<?php

abstract class FRouterFactory
{
    protected $RoutesAs        = [];
	protected $GetRoutes    	= [];
	protected $PostRoutes    	= [];
	// protected $PutRoutes    	= [];
	// protected $DeleteRoutes    	= [];

    protected function assignRoute($name,$controller,$method = 'Get')
    {
        $method = "{$method}Routes";
        $this->{$method}[$name] = $controller;
    } 

    protected function assignAs($name,$controller)
    {
        if(isset($controller['as']))
        {
            $name = '/'.$name;
            if($name == '//')
            {
                $name = '';
            }
            $this->RoutesAs[$controller['as']] = "http://$_SERVER[HTTP_HOST]$name";
        }
    }

	protected function parseUri()
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),"/");
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

        $s = preg_grep("/(\/{.+})+/i",array_keys($this->{$method}));
        $break_path = explode('/', $path);
        foreach ($s as $possible_path) {
            $break_possible_path = explode('/', trim($possible_path,'/'));
            if(count($break_possible_path) == count($break_path))
            {
                $count_path = count($break_path);
                $check = 0;
                foreach (explode('/', trim($possible_path,'/')) 
                    as $key => $value) {
                    if($value == $break_path[$key] ||
                        preg_match('/{.+}/i', $value))
                    {
                        if(preg_match('/{.+}/i', $value))
                        {
                            $params[] = $break_path[$key];
                        }
                        $check++;
                    }
                }

                if($check == $count_path)
                {
                    $this->params = $params;
                    $path = $possible_path;
                }
            }
        }

        if(is_callable($this->{$method}[$path]))
        {
            $this->controller = '';
            $this->callback = $this->{$method}[$path];
            return;
        }

        if(in_array($path, array_keys($this->{$method})))
        {
            list($controller,$callback) = explode('@', $this->{$method}[$path]);
            $this->controller = $controller;
            $this->callback = $callback;
            return;
        }

    }
}