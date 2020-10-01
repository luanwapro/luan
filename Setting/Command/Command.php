<?php




class Command{
    
    static $argv;
function __construct($argvs)
{
    self::$argv=$argvs;
    
}
function gioithieu(){
    $myfile = fopen(dirname(__FILE__)."/../Access/file.txt", "r") or die("Unable to open file!");
    echo fread($myfile,filesize(dirname(__FILE__)."/../Access/file.txt"));
    fclose($myfile);
    echo "\n";
    echo "\n";
}
function run(){


    if(count(self::$argv)>1){
        // self::gioithieu();
        include dirname(__FILE__)."/Server.php";
        switch (self::$argv[1]) {
            case "run":

               self::runCommand($run);
              break;
            case "make:controller":
                self::makeCommand($make);

                break;
         
            default:
            echo "Please check the command";
              
          }

    }
}
function stringArgv(){
   $str ="";
   foreach(self::$argv as $key=> $value){
       if($key!=0){
        $str .=$value." "; 
       }
   }
   return $str;

}

function getKeyArray($str,$array){
  try{
    foreach($array as $key=> $value) {

            if (trim($key) == trim($str)) {
                if (is_array($value)) {
                    if (count($value) > 1) {
                        self::gioithieu();

                        if(is_callable($value[0])){
                            call_user_func($value[0]);
                        }elseif (is_string($value[0])) {
                            echo $value[1];
                            $output = shell_exec($value[0]);

                        }
                    } else {
                        echo "ERROR: {$key} The value must be an array";
                    }
                }
            } else if (strpos($str, ":") && strpos($key, ":")) {

                if (is_int((int)explode($str, ":")[0])) {
                    self::gioithieu();
                    if(trim(explode(':',$str)[1])=="80") {
                        echo "Server run 127.0.0.1:" . trim(explode(':', $str)[1]) . " http://localhost:" . trim(explode(':', $str)[1]) . " \nPress Ctrl-C to quit\n";
                        $output = shell_exec($value[0] . trim(explode(":", $str)[1]) . "");
                    }else{
                        echo "Server run 127.0.0.1:" . trim(explode(':', $str)[1]) . " http://localhost:" . trim(explode(':', $str)[1]) . " \nPress Ctrl-C to quit\n";
                        $output = shell_exec($value[0] . trim(explode(":", $str)[1]) . " -t public/");
                    }

                }


            }
        }
  }catch(Exception $e){
      echo "Please check the command";
  }
}

function  makeCommand($run){
    self::getKeyArrayMake(self::stringArgv(),$run);
}
function runCommand($run){
    
    // echo dirname(__FILE__);
    // print_r($run);
     self::getKeyArray(self::stringArgv(),$run);


}

function  getKeyArrayMake($str,$array){

    try{
        foreach($array as $key=> $value) {


            if(trim($key)==trim(explode(" ",$str)[0])){
                $valueArray=[];
                foreach (explode(" ",$str) as $keys=>$values){
                    if($keys!=0) {
                        array_push($valueArray, $values);

                    }

                }

                if(count(explode(" ",$str))>2) {
                    unset($valueArray[count($valueArray) - 1]);

                    call_user_func_array($value[0], $valueArray);
                }else{
                    echo "Please check the command\n";
                }

            }


        }
    }
    catch (Exception $exception){

    }

}



}


?>