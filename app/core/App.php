<?php

require_once( dirname(__FILE__)."/Router.php");
require_once(dirname((__FILE__)."/Controller.php"));
require_once(dirname((__FILE__)."/AutoLoad.php"));
include dirname(__FILE__)."/../http/web.php";

class App
{
    public $router;
    function __construct()
    {$this->router= new Router;


        
    }
    public function run(){

        $this->router= new Router;
        $this->router->perForMance();

    }
}

?>