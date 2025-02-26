<?php
include_once '../database/db.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($first_name, $last_name, $email, $password, $confirm_password, $phone, $profile_image, $role = "user") {
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone)) {
            return "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
            return "Invalid phone number.";
        }

        if ($password !== $confirm_password) {
            return "Passwords do not match.";
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->execute([$email, $phone]);
        if ($stmt->fetch()) {
            return "Email or phone is already registered.";
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, profile_image, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password, $profile_image, $role]);

            return "Registration successful!";
        } catch (PDOException $e) {
            return "Registration failed: " . $e->getMessage();
        }
    }



    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return "Email and password are required.";
        }
    
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
    
            $_SESSION['user'] = $user;
    
            return $_SESSION['user']; 
        } else {
            return "Invalid email or password.";
        }
    }

    public function getUserCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    
}


?>
