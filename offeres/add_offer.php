<?php
require '../backend/database/db.php';

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $discount = $_POST['discount'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO offers (name, discount, expiry_date) VALUES (:name, :discount, :expiry_date)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':discount' => $discount,
        ':expiry_date' => $expiry_date
    ]);

    header("Location: offers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Offer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Add Special Offer</h2>
    <form method="post" class="border p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Offer Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Discount (%)</label>
            <input type="number" name="discount" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Offer</button>
    </form>
</body>
</html>
