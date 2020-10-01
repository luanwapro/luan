<?php


class AutoLoad{
    function __construct()
    {
         spl_autoload_register(['this','load']);

    }
    function load(){

        foreach (glob(dirname(__FILE__)."/../controllers/"."*.php") as $filename)
        {
             include  $filename;

        }
    }

}


?>