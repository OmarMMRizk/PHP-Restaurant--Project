<?php
require '../backend/database/db.php';
$database = new Database();
$conn = $database->connect();

// $user_id = $_SESSION['user_id'] ?? null;
$user_id = 1;

if (!$user_id) {
    die("Unauthorized access. Please login.");
}

$stmt = $conn->prepare("SELECT id FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$latest_order = $stmt->fetch(PDO::FETCH_ASSOC);
$order_id = $latest_order['id'] ?? null;

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id");
$stmt->bindParam(":order_id", $order_id);
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$status = $order['status'];
$order_date = date("Y-m-d", strtotime($order['created_at']));
$total_price = $order['total_price'];

$stmt = $conn->prepare("
    SELECT item, extras 
    FROM order_items 
    WHERE order_id = :order_id
");
$stmt->bindParam(":order_id", $order_id);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$order_items = [];
$extras_list = [];

foreach ($items as $item) {
    $item_name = $item['item'];
    // Ensure unique item names
    if (!in_array($item_name, $order_items)) {
        $order_items[] = $item_name;
    }
    if (!empty($item['extras'])) {
        $extras_list[] = $item['extras'];
    }
}

$order_items_string = implode(", ", $order_items);
$extras_string = !empty($extras_list) ?  implode(", ", $extras_list)  : "";

$progressWidth = 0;
$pendingClass = "";
$preparingClass = "";
$readyClass = "";
$deliveredClass = "";

switch ($status) {
    case 'Pending':
        $progressWidth = 25;
        $pendingClass = "active";
        break;
    case 'Preparing':
        $progressWidth = 50;
        $pendingClass = "active";
        $preparingClass = "active";
        break;
    case 'Ready':
        $progressWidth = 75;
        $pendingClass = "active";
        $preparingClass = "active";
        $readyClass = "active";
        break;
    case 'Delivered':
        $progressWidth = 100;
        $pendingClass = "active";
        $preparingClass = "active";
        $readyClass = "active";
        $deliveredClass = "active";
        break;
}

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

    <!-- order tracking -->
    <div class="order-tracking-card">
        <h2 class="text-center mb-4 text-light">Order Tracking</h2>

        <div class="progress-bar">
            <div class="progress" style="width: <?= $progressWidth; ?>%;"></div>
        </div>

        <div class="status-step">
            <span class="<?= $pendingClass; ?>">Pending</span>
            <span class="<?= $preparingClass; ?>">Preparing</span>
            <span class="<?= $readyClass; ?>">Ready</span>
            <span class="<?= $deliveredClass; ?>">Delivered</span>
        </div>

        <div class="order-details">
            <h4 class="mt-5 text-light">Order Details</h4>
            <p class="text-light"><strong>Order ID: </strong><?= '#'.$order_id; ?></p>
            <p class="text-light"><strong>Order Date: </strong><?= $order_date; ?></p>
            <p class="text-light"><strong>Items: </strong><?= $order_items_string; ?></p>
            <p class="text-light"><strong>Extras: </strong><?= $extras_string; ?></p>
            <p class="text-light"><strong>Total: </strong><?= $total_price; ?> $</p>
        </div>
    </div>

</body>

</html>