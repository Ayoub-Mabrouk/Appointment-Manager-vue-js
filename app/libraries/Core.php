<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL format /controller/method/params
*/
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod= 'index';
    protected $params = [];
    
    public function __construct()
    {
        $url=$this->getURL();
        // Look in controllers for first value
        if($url!=null && file_exists('../app/controllers/'.ucwords($url[0].'.php'))){
            //if exists, set as controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        // require the controller
        require_once '../app/controllers/'.$this->currentController.'.php';

        // instantiate controller class
        $this->currentController = new $this->currentController;

        // check for second part of url
        if(isset($url[1])){
            // check if method exists in controller
            if(method_exists($this->currentController,$url[1])){
                $this->currentMethod=$url[1];
                // unset 1 index
                unset($url[1]);
            }  
        }
        $this->currentController->data = file_get_contents("php://input") ? json_decode(file_get_contents("php://input")) : [];
        // get params
        $this->params=$url ? array_values($url):[];
        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
    }
    public function getURL(){
       return isset($_GET['url'])?explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL)):null;    
    }
    
}