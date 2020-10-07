<?php
namespace app\controllers\baseControllers;

class baseController{

    function __construct()
    {
    }
   public function Url($str){

       $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       print   $actual_link."/".$str;
    }
    public function Access($str){
        $actual_link = "http://$_SERVER[HTTP_HOST]";

        echo $actual_link."/".$str;
    }

    public function hah($str){
echo $str;
    }

}