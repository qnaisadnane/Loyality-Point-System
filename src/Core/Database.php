<?php

namespace src\Core\Database;

class Database{
    private static $instance = null;
    private $host = "localhost";
    private $dbname = "loyality_point_system";
    private $user = "root";
    private $pass = '';
    private $db;

    public function __construct(){
    try{
            $this->db = new PDO("mysql:host={$this->$host},dbname={$this->$dbname},",
            $this->user,
            $this->pass);

            $this->db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

    }catch(PDOExeption $e){
        echo"erreur" .getMessage();
    }

    }
    public static function getInstance(){
        if(self::$instance == null){
           self::$instance = new Database(); 
        }
        return self::$instance;
    }

    public function getconnection(){
        return $this->db;
    }

}
