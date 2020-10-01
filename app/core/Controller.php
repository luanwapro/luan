<?php

namespace  app\core;
class controller{
    function __construct()
    {
    }

    function render($view,$data=null){

        return new static();

    }
    function view($view,$data=null){



    }

    function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        return new static();
    }


}





?>