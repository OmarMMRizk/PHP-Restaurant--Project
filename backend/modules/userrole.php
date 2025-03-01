<?php
class UserManager {
    private $conn;

    public function __construct($database) {
        $this->conn = $database->connect();
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateUserRole($id, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);
    }
}
?>