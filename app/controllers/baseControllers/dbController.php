<?php
namespace app\controllers\baseControllers;
use app\core\controller;
use mysql_xdevapi\Exception;
use MongoDB;

class DB{
    static $table="";

    static $conn;
    static $db;
    static $config;
    function __construct()
    {
        $config=controller::getConfig();
       $db= $config["DB_CONNECTION"];
        if($db=="mysql"){
            $conn =self::connection($config["DB_HOST"],$config["DB_USERNAME"],$config["DB_PASSWORD"],$config["DB_DATABASE"]);
        }elseif($db=="mongo"&&$config["DB_HOST"]=="localhost"){

            $conn = new  MongoDB\Driver\Manager("mongodb://localhost:".$config["DB_PORT"]);

        }
    }


    function Mongo($urlcn){
       self::$conn = new   MongoDB\Driver\Manager($urlcn);


       return   self::$conn;
    }
    function connection($servername, $username, $password, $dbname){

        self::$conn = \mysqli_connect($servername, $username, $password, $dbname);

        if (! self::$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return  self::$conn;
    }
    function table($nametable){
        if(self::$db=="mysql"){
            self::$table = "select * from ".$nametable;
        }


        return new static();
    }

    function where($where){
        if(self::$db=="mysql") {
            if (self::$table != "") {
                if (substr_count(self::$table, "where") > 0) {
                    self::$table .= " and " . $where;
                } else {
                    self::$table .= " where " . $where;
                }

            } else {
                echo "error: not found table";
            }
        }
        return new static();
    }
    function orwhere($where){
        if(self::$db=="mysql") {
            if (self::$table != "") {
                self::$table .= " or " . $where;
            } else {
                echo "error: not found table";
            }
        }
        return new static();
    }
    function join($table,$frist,$operator,$second,$where=null){

        if(self::$db=="mysql") {
            if (!is_bool(mysqli_query(self::$conn, self::$table))) {
                self::$table .= " INNER JOIN " . $table . " on " . $frist . "  " . $operator . " " . $second . " " . $where . " ";
            } else {
                echo "error: not found table";
            }
        }
        return new static();
    }
    function groupBy($groupBy,$having){
        if(self::$db=="mysql") {
            self::$table .= " " . $groupBy . " HAVING " . $having . " ";
        }
        return new static();
    }
    function oderBy($column,$type,$where=null){
        if(self::$db=="mysql") {
            self::$table .= " order by " . $where . " " . $column . " " . $type . " ";
            return new  static();
        }
        return new static();
    }
    function get($number=null)
    {
        if (self::$db == "mysql") {
            try {


                if (is_int($number)) {

                    if (!is_bool(mysqli_query(self::$conn, self::$table))) {

                        $result = (array)mysqli_query(self::$conn, self::$table)->fetch_object();
                        return array_slice($result, 0, $number);
                    }

                } else if (!is_int($number)) {
                    if (!is_bool(mysqli_query(self::$conn, self::$table))) {

                        $result = mysqli_query(self::$conn, self::$table)->fetch_object();
//                    return $result;
                    }
                }


            } catch (Exception $exception) {

                echo $exception;
            }

        }
    }

}