<?php
class App
{ 
    protected $controller = 'home';

    protected $method = 'index';

    protected $param = [];

    public function __construct() 
    {
        $url = $this->parseUrl();
        if (!isset($url[0])){
            $url[0] = 'home';
        }
        if (file_exists('../app/controllers/' . $url[0] . '.php')){
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        if (!isset($url[1])){
            $url[1] = 'index';
        }
        if (isset($url[1])){
            if (method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        if (!empty($url)){
            $this->param = array_values($url);
        }
        call_user_func_array([$this->controller, $this->method], $this->param);
    }

    public function parseUrl() 
    {
            if( isset($_GET["url"]) ){
                return explode("/", filter_var(trim($_GET["url"], "/")));
            }

    }
}


