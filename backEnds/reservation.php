<?php
require './dbomar.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO reservations (customer_name, customer_email, phone, reservation_date, reservation_time, guests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['customer_name'], 
        $_POST['customer_email'], 
        $_POST['phone'], 
        $_POST['reservation_date'], 
        $_POST['reservation_time'], 
        $_POST['guests']
    ]);

    mail($_POST['customer_email'], "Reservation Confirmation", "Your table has been reserved for " . $_POST['reservation_date'] . " at " . $_POST['reservation_time']);

    header("Location: ../reservationForm.php?success=1");
    exit();
}
?>