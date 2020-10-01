<?php

 $run=
[
  "run server"=>["php -S 127.0.0.1:8080 -t public/","Server run 127.0.0.1:8080 http://localhost:8080 \nPress Ctrl-C to quit.\n"],
  "run server:"=>[
      "php -S 127.0.0.1:",
  ],
"run server restart"=>[function(){


    if (DIRECTORY_SEPARATOR === '/') {
        // unix, linux, mac
        shell_exec("service php-fpm restart ");
        shell_exec("service php5-fpm restart  ");
        shell_exec("service php7.0-fpm restar");
    }

    if (DIRECTORY_SEPARATOR === '\\') {
        // windows

        echo "\nem bó tay";
    }

     ;},"Server reload"],
];

$make=[
    "make:controller"=>[function($controllerName){

        try {


            $dir = dirname(__FILE__) . "/../../app/controllers/";

            if (file_exists($dir . $controllerName . "Controller.php")) {
                echo "Warring: " . $controllerName . " controller already exist\n";
            } else {

                $controllertmp = fread(fopen(dirname(__FILE__) . "/../Access/controllerheader.txt", "r"), filesize(dirname(__FILE__) . "/../Access/controllerheader.txt")) . " 
                class " . $controllerName . "Controllers " . fread(fopen(dirname(__FILE__) . "/../Access/controllerfoodter.txt", "r"), filesize(dirname(__FILE__) . "/../Access/controllerfoodter.txt"));
                $content = "";
                $fp = fopen($dir . $controllerName . "Controller.php", "wb");
                fwrite($fp, $controllertmp);
                fclose($fp);
                echo "successful file creation\n";

            }
        }catch (Exception $e){
            echo $e;
        }
    },""],
]



?>