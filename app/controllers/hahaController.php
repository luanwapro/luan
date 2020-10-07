<?php
namespace  app\controllers;


use app\core\controller;
 use app\controllers\baseControllers\DB;
         class hahaController extends controller {

            function __construct(){

           }

           function luan(){


               $baiviet=DB::table("baiviet")->get(6);

            return   self::render("luan",["luan"=>$baiviet]);



           }


         }