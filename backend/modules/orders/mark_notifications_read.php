<?php
require '../../database/db.php'; 
$database = new Database();
$conn = $database->connect();

session_start();
$user_id = $_SESSION['user_id'] ?? 1;

// Mark notifications as read
$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();

echo json_encode(["success" => true]);
?>
