<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Reward {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM rewards");
        return $stmt->fetchAll();
    }
}