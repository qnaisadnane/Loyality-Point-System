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

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM rewards WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function redeem($id) {
        $reward = $this->getById($id);
        if (!$reward) return false;
        if ($reward['stock'] != -1 && $reward['stock'] <= 0) return false;
        if ($reward['stock'] != -1) {
            $stmt = $this->db->prepare("UPDATE rewards SET stock = stock - 1 WHERE id = ?");
            $stmt->execute([$id]);
        }
        return $reward;
    }
}