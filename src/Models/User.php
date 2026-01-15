<?php

Class User{
  private PDO $db;

    public function __construct(){
    $this->$db = Database::getConnection();
    }

    public function create($email , $password , $name){
        $passwordhash = password_hash($password , PASSWORD_BCRYPT);
        $sql = "INSERT INTO user (email , password_hash , name) Values (?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email , $passwordhash , $name]);

    }

    public function login($email , $password):array{
    $sql = "select * from user where email =?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password , $user['password_hash'])){
        return $user;
    }
        return null;
    }

    public function findUserById($id){
    $sql = "select * from user where id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
    }
}