<?php
require '../../database/db.php'; // Ensure you include your database connection
header('Content-Type: application/json');

$database = new Database();
$conn = $database->connect();

session_start();
$user_id = $_SESSION['user_id'] ?? 1;

try {
    $stmt = $conn->prepare("SELECT id, message, is_read FROM notifications WHERE user_id = :user_id ORDER BY id DESC");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Count unread notifications
    $unread_count = array_reduce($notifications, function($count, $notif) {
        return $count + ($notif['is_read'] == 0 ? 1 : 0);
    }, 0);

    // Return notifications as JSON
    echo json_encode([
        "unread_count" => $unread_count,
        "notifications" => $notifications
    ]);
    exit;
    print_r($notifications);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
