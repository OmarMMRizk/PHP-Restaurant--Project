<?php
require '../backend/database/db.php'; 
$db = new Database();
$conn = $db->connect();

if (!isset($_GET['supplier_id']) || empty($_GET['supplier_id'])) {
    header("Location: suppliers.php");
    exit;
}

$supplier_id = $_GET['supplier_id'];

$supplier_stmt = $conn->prepare("SELECT * FROM suppliers WHERE id=?");
$supplier_stmt->execute([$supplier_id]);
$supplier = $supplier_stmt->fetch();

if (!$supplier) {
    header("Location: suppliers.php");
    exit;
}

$orders_stmt = $conn->prepare("SELECT * FROM supplier_orders WHERE supplier_id=?");
$orders_stmt->execute([$supplier_id]);
$orders = $orders_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Orders for <?= htmlspecialchars($supplier['name']) ?></h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders): ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['item_name']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No orders found for this supplier.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="suppliers.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
