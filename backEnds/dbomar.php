<?php
class Database {
    private $host = "localhost";
    private $db_name = "resturant";
    private $username = "root";
    private $password = "Password@123";
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", 
                                  $this->username, $this->password, [
                                      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                                  ]);
        } catch (PDOException $e) {
            die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>