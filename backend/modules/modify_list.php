<?php
include '../database/db.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == "cancel") {
        $stmt = $conn->prepare("UPDATE reservations SET status = 'canceled' WHERE id = ?");
        $stmt->execute([$_POST['reservation_id']]);
        header("Location: ../../reservations/reservationsList.php");
        exit();
    }
}
?>
