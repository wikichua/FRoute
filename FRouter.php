<?php

class FRouter extends RouterFactory
{
    protected $params        = [];
    protected $baseFile      = "index.php";
    protected $controllers_prefix = ['get_','post_','put_','delete_'];

    public function controller($name,$controller)
    {
        $class = new ReflectionClass($controller);
        $methods = $class->getMethods();
        foreach ($methods as $method) {
            list($head) = explode('_', $method->name);
            if(in_array($head.'_',$this->controllers_prefix))
            {
                $lastname = str_replace($head.'_', '', $method->name);
                $this->$head($name.'/'.$lastname,$controller.'@'.$method->name);
            }
        }
    }

    public function get($name,$controller)
    {
        $this->GetRoutes[$name] = $controller;
    }

    public function post($name,$controller)
    {
        $this->PostRoutes[$name] = $controller;
    }

    // public function put($name,$controller)
    // {
    //     $this->PutRoutes[$name] = $controller;
    // }

    // public function delete($name,$controller)
    // {
    //     $this->DeleteRoutes[$name] = $controller;
    // }
     
    public function run() {
        $this->parseUri();
        call_user_func_array(array(new $this->controller, $this->callback), $this->params);
    }
}