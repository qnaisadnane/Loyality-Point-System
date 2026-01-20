<?php

namespace App\Core;
use PDO;
use PDOException;
class Database{
    private static ?Database $instance = null;
    private $host = "localhost";
    private $dbname = "loyality_point_system";
    private $user = "root";
    private $pass = '';
    private PDO $db;

    public function __construct(){
    try{
            $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
            $this->user,
            $this->pass);

            $this->db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

    }catch(PDOExeption $e){
        echo"erreur" .$e->getMessage();
    }

    }
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->db;
    }

}
