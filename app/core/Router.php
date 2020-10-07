<?php
require_once   dirname((__FILE__)."")."/AutoLoad.php";
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

         
           foreach(self::$urlListGet as $key=>$value){

          
            if($url==$value[0]){
             $kt=true;
             $vt=$key;
            
             
            }
           }
           


           if($kt!==false){

           

           
            self::action((self::$urlListGet[$vt]),$url);

            return $this;
        
           }else{
            
            foreach(self::$urlListGet as $key=>$value){

                $urla=explode("/",$value[0]);
                $urlb=explode("/",$url);
                if(count( $urla)==count($urlb)&&$urlb[1]==$urla[1]){

                   
                 
                    self::action((self::$urlListGet[$key]),$url);
                    return $this;
                    
                }else{
                   
                }
               

            }
           
            self::$bonlebonget+=1;

          
           }

        }else if($method=="POST"){



            foreach(self::$urlListPost as $key=>$value){

            
                if($url==$value[0]){
                 $kt=true;
                 $vt=$key;
                 
                break;
                }
               }
               if($kt!==false){
                
                self::action((self::$urlListPost[$vt]),$url);
                return $this;
               }else{
            
                foreach(self::$urlListPost as $key=>$value){
    
                    $urla=explode("/",$value[0]);
                    $urlb=explode("/",$url);
                    if(count($urla)==count($urlb)&&$urlb[1]==$urla[1]){
                       
                        self::action((self::$urlListPost[$key]),$url);
                        return $this;
                      
                    }
                   
    
                }

                self::$bonlebonpost+=1;
               }
 
    
        }
       
     
     if(self::$bonlebonget==count(self::$urlListGet)&&count(self::$urlListGet)!=0){

      
        
           
            self::notfound();
            return $this;
      

     }
     if(self::$bonlebonpost==count(self::$urlListPost)&&count(self::$urlListPost)!=0){
        
            self::notfound();
            return $this;
        
     }
     
      
      

    }

    function perForMance(){
       
        if ( isset($_SERVER['PATH_INFO']))
        {
           
        self::start($_SERVER['REQUEST_METHOD'],$_SERVER['PATH_INFO']);
      
        }else{
           self::index();
        }
  
       
      
    }

    function notfound(){

        self::get("/404","systemController@notFound");
        self::start($_SERVER['REQUEST_METHOD'],"/404");
    }

    function index(){
       
        self::get("/indexluandeptrai","systemController@indexluandeptrai");
        self::start($_SERVER['REQUEST_METHOD'],"/indexluandeptrai");
    }



    function forBidden(){

        self::get("/403","systemController@forBidden");
        self::start($_SERVER['REQUEST_METHOD'],"/403");
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
        
   
       if(self::$newAcction==1){
       self::$redirectTmp=self::$urlListGet[count(self::$urlListGet)-1][0];
      
       }elseif(self::$newAcction==2){
        self::$redirectTmp=self::$urlListPost[count(self::$urlListPost)-1][0];
       }

       $strp ="/".self::$tenprefix. self::$redirectTmp;
       if(isset($_SERVER['PATH_INFO'])){

         if(  self::$redirectTmp==$_SERVER['PATH_INFO']){
            
            
        }elseif( $strp==$_SERVER['PATH_INFO']){
            header( "Location:". $url );
        }
    }
        return $this;
        

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

              
                $arrayvalue=  self::removeArrayString( $arrayvalue,$url);

              
                 
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
              $ref = new ReflectionMethod("{$class}", explode("@",$array[1])[1]);
              $reflectionParams = $ref->getParameters();
            if(count($ref->getParameters())>0){


                foreach(  $reflectionParams  as $key=>$param) {
                    if($param->getType()!=null){

                        $classparam =(string)$param->getType();
                        $bien = new $classparam;


                        if(isset(  $arrayvalue [$key])){

                           array_splice( $arrayvalue, $key, 0,[$bien] );



                        }else {
                            $arrayvalue [$key] = $bien;



                        }
                    }


                }
                if(count($arrayvalue)>count($ref->getParameters()))
                {
                      for($i=count($arrayvalue)-1;$i>0;$i--){
                          if(count($arrayvalue)>count($ref->getParameters())){

                              if(is_string($arrayvalue[$i])) {
                                  unset($arrayvalue[$i]);
                              }
                          }
                          else if(count($arrayvalue)>count($ref->getParameters())) {
                              break;

                          }

                      }
                }



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
        
        if( self::$tenprefix!=null){

        
            for($i=0;$i<self::$countGroupGet;$i++){
               
       self::$urlListGet[count(self::$urlListGet)-($i+1)][0]="/".$namefunc.(string)(self::$urlListGet[count(self::$urlListGet)-($i+1)])[0];
            }

            for($i=0;$i<self::$countGroupPost;$i++){
               
                self::$urlListPost[count(self::$urlListPost)-($i+1)][0]="/".$namefunc.(string)(self::$urlListPost[count(self::$urlListPost)-($i+1)])[0];
                     }
        }
        
        return $this;
    }
    function group($func){
       if(is_callable($func)){
        //  self::$isFuncGroup=1;
        call_user_func(($func));

        self::includeGroup($func,self::$tenprefix);
       }
       self::$tenprefix=null;
       return $this;

    }
    function prefix($str){
       
        self::$tenprefix=$str;
       
        
        return $this;
    }

   function end(){

   }
    function get($url,$action)
    {   
     
     
        $kt =true;
        foreach(self::$urlListGet as $key=>$value){
            
            if($value[0]==$url){
                $kt =  false;
            }
               
     
        }
    
        if($kt==true){
            if([$url,$action]!==null)
            array_push( self::$urlListGet, [$url,$action]);
            self::$newAcction=1;

        }
          
        // print_r($_SERVER);
        
        if(self::$tenprefix!=null){
      self::$countGroupGet+=1;
        }

//        return $this;
       
 
    }


    function post($url,$action)
    {
        $kt =true;
        foreach(self::$urlListPost as $key=>$value){
               
            if($value[0]==$url){
                $kt =  false;
            }
                
     
        }
           
        if($kt==true){
            if([$url,$action]!==null)
             self::$urlListPost[] =[$url,$action];
             self::$newAcction=2;
          

        }
        if(self::$tenprefix!=null){
            self::$countGroupPost+=1;
         }
//         return $this;
    }
    
}


?>