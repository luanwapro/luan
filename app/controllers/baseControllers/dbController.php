<?php
namespace app\controllers\baseControllers;
use mysql_xdevapi\Exception;

class DB{
    static $table="";

    static $conn;
    function __construct()
    {
        $conn =self::connection('localhost','root','','dmkiengiang');
    }


    function connection($servername, $username, $password, $dbname){

        self::$conn = \mysqli_connect($servername, $username, $password, $dbname);

        if (! self::$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return  self::$conn;
    }
    function table($nametable){
        self::$table = "select * from ".$nametable;

        return new static();
    }

    function where($where){
        if(self::$table!="") {
            self::$table .= " " . $where;
        }else{
            echo "error: not found table";
        }
        return new static();
    }
    function get($number=null){

        try {


            if (is_int($number)) {

                if (!is_bool( mysqli_query(self::$conn, self::$table))) {

                    $result = (array) mysqli_query(self::$conn, self::$table)->fetch_object();
                    return array_slice($result,0,$number);
                }

            } else if (!is_int($number)) {
                if (!is_bool( mysqli_query(self::$conn, self::$table))) {

                    $result = mysqli_query(self::$conn, self::$table)->fetch_object();
                    return $result;
                }
            }




        }catch (Exception $exception){

            echo $exception;
        }

    }

}