<?php
require '../backend/database/db.php';
$database = new Database();
$conn = $database->connect();
session_start();

$user_id = 1;
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITI Resturant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../Styles/index/bootstrap.css">
    <link rel="stylesheet" href="../Styles/index/style.css">
    <link rel="stylesheet" href="../Styles/index/all.min.css">
    <link rel="stylesheet" href="../Styles/index/nav.css">
    <link rel="stylesheet" href="../Styles/index/order.css">
    <link rel="stylesheet" href="../Styles/index/all-orders.css">


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">ITI Restaurant</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    
                    <li class="nav-item"><a class="nav-link act" href="#contact">Login</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- all orders -->

    <div class="order-history-container">
        <h1 class="text-center mb-4 text-light">Order History</h1>
        <div class="row">
            <?php if (count($orders) > 0): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="order-card">
                            <div class="card-body">
                                <h5>Order #<?= $order['id']; ?></h5>
                                <p class="text-light"><strong>Date:</strong> <?= date("Y-m-d", strtotime($order['created_at'])); ?></p>
                                <p><strong>Items:</strong> 1x Burger, 1x Fries, 1x Coke</p>
                                <p><strong>Total:</strong> $<?= number_format($order['total_price'], 2); ?></p>
                                <p><strong>Status:</strong> <?= $order['status']; ?></p>
                                <div class="mt-auto">
                                    <a href="order.php?order_id=<?= $order['id']; ?>" class="reorder-btn">Reorder</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-light text-center">No orders found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>