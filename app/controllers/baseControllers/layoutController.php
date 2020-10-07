<?php
namespace app\controllers\baseControllers;
use app\controllers\baseControllers\baseController;


class layout{

    function __construct()
    {
        $controller= new \app\controllers\baseControllers\baseController();
    }


    static $controller;
    static $func=["foreach"=>"","for"=>"","if"=>"","else"=>"","elseif"=>"","endfor"=>"<?php } ?>","endif"=>"<?php } ?>","endforeach"=>"<?php } ?>"];
    static $listRegister =array();


    function registerLayout($content,$path,$data=null){



       for($i=0;$i<100;$i++) {
            if (substr_count($content, "@registerl") > 0 && substr_count($content, "@endl") > 0) {

                $start = (int)strpos($content, "@registerl(");
                $end = (int)strpos($content, "@endl") + 5;
                $ten = substr(substr($content, (int)strpos($content, "@registerl(" . '"') + 10, 1000), $start, (int)strpos(substr($content, (int)strpos($content, "@registerl(" . '"') + 11, 1000), '")'));


                $content = substr($content, $start + strlen("@registerl") + strlen($ten) + 4, ($end - 5) - ($start + strlen("@registerl") + strlen($ten) + 4));



            }
        }

        if(substr_count($content,"{{")>0&&substr_count($content,"}}")>0){
            return  self::getEditLayout($content,$data);
        }else{

            echo   self::createFile(  $content,$data);;
        }
        $listRegister [] =["ten"=> $ten ,
            "path"=>$path,"start"=>$start,"end"=>$end];

    }
    function replaceFunc($content){


        $start1 ="";
        $end1 ="";
        foreach (self::$func as $keys=>$value){

            if(substr_count($content,"@".$keys."(")>0){


                if($value!=""){





                }else{




                    $start =(int)strpos($content,"@".$keys."(");
                    $contenttmp =substr($content,$start,100);
                    $end = (int)strpos($contenttmp,")");








                    $contentPra=  substr($content,($start+strlen($keys)+1),($end+1)-($start-1));





                 $content= str_replace("@".$keys.$contentPra,"<?php ".$keys.$contentPra." { ?> ",$content)    ;




                }

            }elseif (substr_count($content,"@".$keys."@")>0){


              $content= str_replace("@".$keys."@",$value,$content)    ;

            }


        }

    return ($content);
    }

    function replaceDataFunc($content){


        $start1 ="";
        $end1 ="";
        foreach (self::$func as $keys=>$value){

            if(substr_count($content,"@".$keys."(")>0){


                if($value!=""){





                }else{




                    $start =(int)strpos($content,"@".$keys."(");
                    $contenttmp =substr($content,$start,100);
                    $end = (int)strpos($contenttmp,")");








                    $contentPra=  substr($content,($start+strlen($keys)+1),($end+1)-($start-1));




                   $start1=($start+strlen($contentPra));








                }

            }elseif (substr_count($content,"@".$keys."@")>0){

                $end1=(int)strpos($content,"@".$keys."@");





            }
            if($start1!=""&&$end1!=""){




              echo htmlentities(substr($content,$start1,$end1));
            }

        }

//      return ($content);
    }

    function getEditLayout($content,$data=null){

        $class = new \ReflectionClass('\app\controllers\baseControllers\baseController');
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $keys=>$value){
           if(substr_count($content,"{{".$methods[$keys]->name)>0){


                   $start =(int)strpos($content,"{{".$methods[$keys]->name."(")+strlen($methods[$keys]->name)+2;

                   $end =(int)strpos($content,")}}")+1;

                   $contenttmp =substr($content,$start,$end-$start);





               $content= self::str_replace_first("{{".$methods[$keys]->name.$contenttmp."}}","<?php \app\controllers\baseControllers\baseController::".$methods[$keys]->name.$contenttmp."?>",$content);



               }








           }


        while (1){
            foreach ($methods as $keys=>$value){
                if(substr_count($content,"{{".$methods[$keys]->name)>0){


                    $start =(int)strpos($content,"{{".$methods[$keys]->name."(")+strlen($methods[$keys]->name)+2;

                    $end =(int)strpos($content,")}}")+1;

                    $contenttmp =substr($content,$start,$end-$start);





                    $content= self::str_replace_first("{{".$methods[$keys]->name.$contenttmp."}}","<?php \app\controllers\baseControllers\baseController::".$methods[$keys]->name.$contenttmp."?>",$content);



                }elseif (substr_count($content,"{{".$methods[$keys]->name)==0){

                    unset($methods[$keys]);

                }
            }

            if(count($methods)==0){
                break;
            }
        }



      echo self::createFile(  $content,$data);

    }
    function  str_Replace_Data($data,$str){
        if(!is_array($data)){
          return  str_replace($data,"<?php echo $data ?>",$str);
        }else{

        }

    }
    function str_replace_first($from, $to, $str)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $str, 1);

    }

    function getEditLayouts($content,$name){



            if(substr_count($content,"{{".$name)>0){

                $start =(int)strpos($content,"{{".$name."(")+strlen($name)+2;

                $end =(int)strpos($content,")}}")+1;

                $contenttmp =substr($content,$start,$end-$start);


                $content= self::str_replace_first("{{".$name.$contenttmp."}}","<?php \app\controllers\baseControllers\baseController::".$name.$contenttmp."?>",$content);


                return $content;



            }else{
                return $content;
            }


    }
    function createFile($content,$data=null){


        $tmp =rand(0,100).rand(0,100).rand(0,100).rand(0,100).rand(0,100);

        $fp=fopen(dirname(__FILE__)."/../../../Setting/Access/". $tmp.'.php','w');
        fwrite($fp, $content);
        fclose($fp);
        unlink(dirname(__FILE__)."/../../../Setting/Access/". $tmp.'.php');
        return $content;
    }

    function getLayout($key,$data=null){
        $content = requireToVar( self::$listRegister[$key]["path"]);
        echo str_replace( "@endl","",substr($content, self::$listRegister[$key]["start"]+strlen("@registerl")+strlen(self::$listRegister[$key]["ten"])+4, self::$listRegister[$key]["end"]-strlen("@endl")));
    }
    function requireToVar($file){
        ob_start();
        require($file);
        return ob_get_clean();
    }
    function includeLayout($name,$data=null){

        extract($data, EXTR_PREFIX_SAME, "wddx");
        foreach(self::$listRegister as $key=>$value){

            if(trim($value["ten"])==trim($name)){

                getLayout($key);

//                return new static();

            }
        }



        foreach (glob(dirname(__FILE__)."/../../views/layout/"."*.tmp.php") as $filename)
        {
//            $content=   self::requireToVar($filename);
            $myfile = fopen($filename, "r") or die("Unable to open file!");
            $content =fread($myfile,filesize($filename));
            fclose($myfile);

            if(substr_count($content,$name)){

             return   self::registerLayout($content,$filename,$data);
//                return new static();

            }

        }
    }
}