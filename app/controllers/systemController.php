<?php 
namespace app\controllers;
class systemController{

    function __construct()
    {
        
    }

    function notFound(){
      echo  file_get_contents((dirname(__FILE__)."/../../resources/html/404.html") );

    }

    function forBidden(){
        echo  file_get_contents((dirname(__FILE__)."/../../resources/html/403.html") );
  
      }
      function indexluandeptrai(){
        echo  file_get_contents((dirname(__FILE__)."/../../resources/html/index.html") );
  
      }

}


?>