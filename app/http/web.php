<?php

Router::get("/haha","homeController@luandeptrai")->redirect("hihi/luan");
Router::get("/thinghiem","hahaController@luan");

Router::get("/hihi/luan",function(){
   echo "Xin Chào Luân";
    });
  Router::prefix("phim")->group(function(){

             Router::get("/caiho",function(){
                echo "caiho";
               
                 })->redirect("hi");
                 Router::get("/luan",function(){
                    echo "Xin Chào Luân";
                  
                     });
    });
    Router::post("/caigi/luan",function(){
        echo "Xin Chào Luân";
         });
?>