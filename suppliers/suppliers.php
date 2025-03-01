<?php
require '../backend/database/db.php'; 
$db = new Database();
$conn = $db->connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Inventory Management</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="../backend/modules/suppliers/inventory.php" class="btn btn-primary w-100">Stock Tracking</a>
            </div>
            <div class="col-md-6">
                <a href="../backend/modules/suppliers/suppliers.php" class="btn btn-secondary w-100">Manage Suppliers</a>
            </div>
        </div>
    </div>
</body>
</html>
