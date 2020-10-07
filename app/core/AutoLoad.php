<?php


class AutoLoad{
    function __construct()
    {
         spl_autoload_register(['this','load']);

    }
    function load(){

        include dirname(__FILE__)."/Controller.php";


        foreach (glob(dirname(__FILE__)."/../controllers/"."*.php") as $filename)
        {
             include  $filename;

        }
        foreach (glob(dirname(__FILE__)."/../baseControllers/"."*.php") as $filename)
        {
             include  $filename;

        }
    }

}


?>