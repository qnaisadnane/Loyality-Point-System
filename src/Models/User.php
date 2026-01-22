<?php
namespace App\Models;
use App\Core\Database;
use PDO;

Class User{
  private PDO $db;

    public function __construct(){
    $this->db = Database::getConnection();
    }

    public function create(string $email , string $password , string $name):bool{

        $passwordhash = password_hash($password , PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email , password_hash , name) Values (?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email , $passwordhash , $name]);

    }

    public function login($email , $password){
    $stmt = $this->db->prepare("select * from users where email = :email");
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password , $user['password_hash'])){
        return $user;
    }
        return false;
    }

    public function findById($id){
    $stmt = $this->db->prepare("select * from users where id = :id");
    $stmt->execute(['id'=>$id]);
    return $stmt->fetch();
    }

    public function getTransactions($user_id){
        $stmt = $this->db->prepare("SELECT * FROM points_transactions WHERE user_id = :user_id ORDER BY createdat DESC");
        $stmt->execute(['user_id'=>$user_id]);
        return $stmt->fetchAll();
    }

    public function updatePoints($user_id, $points){
        $stmt = $this->db->prepare("UPDATE users SET total_points = total_points + ? WHERE id = ?");
        $stmt->execute([$points, $user_id]);
    }

    public function addTransaction($user_id, $type, $amount, $description){
        $user = $this->findById($user_id);
        $balance_after = $user['total_points'] + $amount;
        $stmt = $this->db->prepare("INSERT INTO points_transactions (user_id, type, amount, description, balance_after) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $type, $amount, $description, $balance_after]);
        $this->updatePoints($user_id, $amount);
    }
}