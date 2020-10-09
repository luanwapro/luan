<?php

namespace  app\core;
require dirname(__FILE__)."/../controllers/baseControllers/layoutController.php";
require dirname(__FILE__)."/../controllers/baseControllers/baseController.php";
require dirname(__FILE__)."/../controllers/baseControllers/dbController.php";
use app\controllers\baseControllers\layout;
class controller{
    function __construct()
    {
    }

    function requireToVar($file){
        ob_start();
        require($file);
        return ob_get_clean();
    }
    public static  function  render($view,$data=null){
       $layout = new layout();
      if( count( explode("/",$view))>1){

          if(file_exists(dirname(__FILE__)."/../views/".$view.".php")){
              if(is_array($data)){
                extract($data, EXTR_PREFIX_SAME, "wddx");
              }
            ob_start();
           require dirname(__FILE__)."/../views/".$view.".php";
            $contenttmp=  ob_get_clean();




       self::createFile ($contenttmp,$data);


          }else{
              echo $view." not found";
          }
      }else{

          if(file_exists(dirname(__FILE__)."/../views/".$view)){

            if(file_exists( dirname(__FILE__)."/../views/".$view."/index.php")){
                extract($data, EXTR_PREFIX_SAME, "wddx");
                ob_start();
                  require  dirname(__FILE__)."/../views/".$view."/index.php";
                $contenttmp=  ob_get_clean();
                self::createFile ($contenttmp,$data);
            }else{

                foreach (glob(dirname(__FILE__)."/../views/"."*.php") as $filename)
                {
                    ob_start();
                    require  $filename;
                    $contenttmp=  ob_get_clean();
                    self::createFile ($contenttmp,$data);
                    if(is_array($data)){
                        extract($data, EXTR_PREFIX_SAME, "wddx");
                      }
                      
                    break;
        
                }
            }
          }else{
            echo $view." not found";
        }
      }






        return new static();
    }
    function createFile($content,$data){
        $tmp =rand(0,100).rand(0,100).rand(0,100).rand(0,100).rand(0,100);
        $fp=fopen(dirname(__FILE__)."/../../Setting/Access/". $tmp.'.php','w');
        fwrite($fp, $content);
        fclose($fp);
        extract($data, EXTR_PREFIX_SAME, "wddx");
        $layout = new layout();
        ob_start();
        require dirname(__FILE__)."/../../Setting/Access/". $tmp.'.php';
        $contenttmp=  ob_get_clean();

        unlink(dirname(__FILE__)."/../../Setting/Access/". $tmp.'.php');
        echo  $contenttmp;
    }
    public static    function view($view,$data=null){



    }

    public static  function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);


    }
    static function  getConfig(){

        $string = file_get_contents(dirname(__FILE__)."/../../config/config.json");
        return  (array)(json_decode($string)->DB[0]);
    }


}





?>