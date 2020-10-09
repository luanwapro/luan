<?php
namespace  app\controllers;


use app\core\controller;
 use app\controllers\baseControllers\DB;
         class hahaController extends controller {

            function __construct(){

           }

           function luan(){


               $baiviet=DB::Mongo("mongodb://luan:luan@cluster0-shard-00-00.ndi66.mongodb.net:27017,cluster0-shard-00-01.ndi66.mongodb.net:27017,cluster0-shard-00-02.ndi66.mongodb.net:27017/luan?ssl=true&replicaSet=atlas-rb1qrq-shard-0&authSource=admin&retryWrites=true&w=majority");


               var_dump($baiviet);
//                 return   self::render("luan",["luan"=>$baiviet]);



           }


         }