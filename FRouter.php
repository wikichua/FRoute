<?php

class FRouter extends FRouterFactory
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
                $this->$head($name.'/'.$lastname,[
                    'as'=> $name.'.'.$lastname,
                    'uses'=>$controller.'@'.$method->name,
                    ]);
            }
        }
    }

    public function get($name,$controller)
    {
        if(!is_array($controller))
            $this->assignRoute($name,$controller,'Get');
        else
        {
            $this->assignRoute($name,$controller['uses'],'Get');
            $this->assignAs($name, $controller);
        }            
    }

    public function post($name,$controller)
    {
        if(!is_array($controller))
            $this->assignRoute($name,$controller,'Post');
        else
        {
            $this->assignRoute($name,$controller['uses'],'Post');
            $this->assignAs($name, $controller);
        } 
    }

    // public function put($name,$controller)
    // {
    //     if(!is_array($controller))
    //      $this->assignRoute($name,$controller,'Put');
    //     else
    //     {
    //      $this->assignRoute($name,$controller['uses'],'Put');
    //      $this->assignAs($name, $controller);
    //     }
    // }

    // public function delete($name,$controller)
    // {
    //     if(!is_array($controller))
    //      $this->assignRoute($name,$controller,'Delete');
    //     else
    //     {
    //      $this->assignRoute($name,$controller['uses'],'Delete');
    //      $this->assignAs($name, $controller);
    //     }
    // }
     
    public function route($name)
    {
        return $this->RoutesAs[$name];
    }
     
    public function run() {
        $this->parseUri();
        if(empty($this->controller))
            call_user_func_array($this->callback, $this->params);
            
        if(!is_null($this->controller) 
            && !empty($this->controller))
            call_user_func_array(array(new $this->controller, $this->callback), $this->params);
    }
}