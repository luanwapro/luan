<?php
require_once(dirname((__FILE__)."/Controller.php"));
require_once dirname(__FILE__)."/AutoLoad.php";
AutoLoad::load();

use app\controllers\homeController;
use app\controllers\systemController;


class Router
{
    function __construct()
    {


        
    }

    static  $urlListGet =array();
    static  $urlListPost =array();
    static $bonlebonget =1;
    static $bonlebonpost =1;
    static $tenprefix ="";
    static $countGroupGet=0;
    static $countGroupPost=0;
    static $newAcction =0;
    static $redirectTmp ="";
    static $isFuncGroup=0;


    public function start($method,$url){

        $kt =false;
        $vt =0;
       
       
        if($method==="GET"){


           foreach(Router::$urlListGet as $key=>$value){

            if($url==$value[0]){
             $kt=true;
             $vt=$key;
            
             
            }
           }
           


           if($kt!==false){

           

           
            Router::action((Router::$urlListGet[$vt]),$url);

            return new static();
        
           }else{
            
            foreach(Router::$urlListGet as $key=>$value){

                $urla=explode("/",$value[0]);
                $urlb=explode("/",$url);
                if(count( $urla)==count($urlb)&&$urlb[1]==$urla[1]){

                   
                 
                    Router::action((Router::$urlListGet[$key]),$url);
                    return new static();
                    
                }else{
                   
                }
               

            }
           
            Router::$bonlebonget+=1;

          
           }

        }else if($method=="POST"){



            foreach(Router::$urlListPost as $key=>$value){

            
                if($url==$value[0]){
                 $kt=true;
                 $vt=$key;
                 
                break;
                }
               }
               if($kt!==false){
                
                Router::action((Router::$urlListPost[$vt]),$url);
                return new static();
               }else{
            
                foreach(Router::$urlListPost as $key=>$value){
    
                    $urla=explode("/",$value[0]);
                    $urlb=explode("/",$url);
                    if(count($urla)==count($urlb)&&$urlb[1]==$urla[1]){
                       
                        Router::action((Router::$urlListPost[$key]),$url);
                        return new static();
                      
                    }
                   
    
                }

                Router::$bonlebonpost+=1;
               }
 
    
        }
       
     
     if(Router::$bonlebonget==count(Router::$urlListGet)||Router::$bonlebonpost==count(Router::$urlListPost)){
        Router::notfound();
        return new static();
     }
     
      
      

    }

    function perForMance(){
        if ( isset($_SERVER['PATH_INFO']))
        {
        Router::start($_SERVER['REQUEST_METHOD'],$_SERVER['PATH_INFO']);
        }else{
           Router::index();
        }
    }

    function notfound(){

        Router::get("/404","systemController@notFound");
        Router::start($_SERVER['REQUEST_METHOD'],"/404");
    }

    function index(){
        echo "<script>console.log('Debug Objects: " . "hahaha" . "' );</script>";
        Router::get("/indexluandeptrai","systemController@indexluandeptrai");
        Router::start($_SERVER['REQUEST_METHOD'],"/indexluandeptrai");
    }



    function forBidden(){

        Router::get("/403","systemController@forBidden");
        Router::start($_SERVER['REQUEST_METHOD'],"/403");
    }
    function removeArrayString($a,$b)
    
    {
       
      
        $arraytmp =[];
        $str="";
        $arrayurlb=explode("/",$b);

       
       foreach(  $a  as $key=>$value)
        {
            if(strpos($value,"{")!==false){
              
                $str.=$arrayurlb[$key].";";
               
            }
       
        }
        
        
        $str = str_replace("{","", $str);
        $str = str_replace("}","",$str );
       
        foreach(  explode(";",$str)  as $key=>$value ){

            $arraytmp [] =$value;
           
        }
        
        
            unset($arraytmp[count($arraytmp)-1]);
        


        return $arraytmp;
    }
    function redirect($url){
        
   
       if(Router::$newAcction==1){
       Router::$redirectTmp=Router::$urlListGet[count(Router::$urlListGet)-1][0];
      
       }elseif(Router::$newAcction==2){
        Router::$redirectTmp=Router::$urlListPost[count(Router::$urlListPost)-1][0];
       }

       $strp ="/".Router::$tenprefix. Router::$redirectTmp;
       if(isset($_SERVER['PATH_INFO'])){

         if(  Router::$redirectTmp==$_SERVER['PATH_INFO']){
            
            
        }elseif( $strp==$_SERVER['PATH_INFO']){
            header( "Location:". $url );
        }
    }
        return new static();
        

    }
    function action($array,$url){


     
      
        $arrayvalue =[];
       
        $doiso =(substr_count($array[0],"}")+substr_count($array[0],"{"));
        if(strpos($array[0],"{")!==false&&strpos($array[0],"}")!==false){

            
            if((substr_count($array[0],"}")+substr_count($array[0],"{"))%2==0){

            
               
                foreach(  explode('/',$array[0])  as $key=>$value)
                {
               
                        $arrayvalue[] =$value;
                         
                }

              
                $arrayvalue=  Router::removeArrayString( $arrayvalue,$url);

              
                 
            }

        }

       
        if(is_callable($array[1])){

            if($arrayvalue!=null){
                call_user_func_array($array[1],$arrayvalue);
                die();
            }else{
                $array[1]();
                die();
            }

        }else if(is_string($array[1])){
            $class = "app\\controllers\\".explode("@",$array[1])[0];
          if(class_exists( $class)){

            
            $a =new $class;
            if($arrayvalue!=null){
                call_user_func_array(array( "{$class}",explode("@",$array[1])[1]),$arrayvalue);
             die();
            }else{
                call_user_func(array( "{$class}",explode("@",$array[1])[1]));
           
                die();
            }
           

          }else{
            echo $class." Not Found";
            die();
          }
         
        }

        
    }

    function includeGroup($func,$namefunc){
        
        if( Router::$tenprefix!=null){

        
            for($i=0;$i<Router::$countGroupGet;$i++){
               
       Router::$urlListGet[count(Router::$urlListGet)-($i+1)][0]="/".$namefunc.(string)(Router::$urlListGet[count(Router::$urlListGet)-($i+1)])[0];
            }

            for($i=0;$i<Router::$countGroupPost;$i++){
               
                Router::$urlListPost[count(Router::$urlListPost)-($i+1)][0]="/".$namefunc.(string)(Router::$urlListPost[count(Router::$urlListPost)-($i+1)])[0];
                     }
        }
        
        return new static();
    }
    function group($func){
       if(is_callable($func)){
        //  Router::$isFuncGroup=1;
        call_user_func(($func));

        Router::includeGroup($func,Router::$tenprefix);
       }
       Router::$tenprefix=null;
       return new static();

    }
    function prefix($str){
       
        Router::$tenprefix=$str;
       
        
        return new static();
    }

   
    function get($url,$action)
    {   
     
     
        $kt =true;
        foreach(Router::$urlListGet as $key=>$value){
            
            if($value[0]==$url){
                $kt =  false;
            }
               
     
        }
    
        if($kt==true){
            if([$url,$action]!==null)
            array_push( Router::$urlListGet, [$url,$action]);
            Router::$newAcction=1;

        }
          
        // print_r($_SERVER);
        
        if(Router::$tenprefix!=null){
      Router::$countGroupGet+=1;
        }

        return new static();
       
 
    }


    function post($url,$action)
    {
        $kt =true;
        foreach(Router::$urlListPost as $key=>$value){
               
            if($value[0]==$url){
                $kt =  false;
            }
                
     
        }
           
        if($kt==true){
            if([$url,$action]!==null)
             Router::$urlListPost[] =[$url,$action];
             Router::$newAcction=2;
          
            if ( isset($_SERVER['PATH_INFO']))
            {
            Router::start($_SERVER['REQUEST_METHOD'],$_SERVER['PATH_INFO']);
            }
        }
        if(Router::$tenprefix!=null){
            Router::$countGroupPost+=1;
         }
         return new static();
    }
    
}


?>