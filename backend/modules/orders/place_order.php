<?php
require __DIR__. "/../../../vendor/autoload.php";
require '../../database/db.php';
$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['payment_method']) && $_POST['payment_method'] === "cod") {
    $user_id = $_SESSION['user_id'] ?? 1;
    $totalPrice = $_POST['total_price'] ?? 0;
    $cart = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : [];

    if (!is_array($cart) || empty($cart)) {
        die("<script>alert('Error: Cart is empty or invalid!'); window.history.back();</script>");
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (:user_id, :total_price)");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":total_price", $totalPrice);

    if ($stmt->execute()) {

        $order_id = $conn->lastInsertId();

        $orderItemStmt = $conn->prepare("INSERT INTO order_items (order_id, item,extras) VALUES (:order_id, :item,:extras)");

        foreach ($cart as $item) {
            // Convert extras array to string
            $extrasText = !empty($item['extras']) ? implode(', ', array_column($item['extras'], 'name')) : null;

            $orderItemStmt->execute([
                ":order_id" => $order_id,
                ":item" => $item['name'],
                ":extras" => $extrasText
            ]);
        }

        $message = "Your order #$order_id has been placed successfully!";
        $notifyStmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (:user_id, :message, 0)");
        $notifyStmt->bindParam(":user_id", $user_id);
        $notifyStmt->bindParam(":message", $message);
        $notifyStmt->execute();

        echo "<script>
                    setTimeout(function() {
                        window.location.href = '../../../orders/cart.php?success=1';
                    }, 500); 
            </script>"; 
        exit;

        exit;
    } else {
        print_r($stmt->errorInfo());
    }
}

if (isset($_GET['session_id'])) {
    $stripe_secret_key = "sk_test_51PD6cqDAFbKV4bTRnbmGlG0fDWG7zjCZv3vT06wQyXSAGz6U8bDdDtdchkVcNKTmvqU5W1igwQzmhoQS33urgSxQ00I6yoR34s";
    \Stripe\Stripe::setApiKey($stripe_secret_key);


    try {
        $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
        $totalPrice = floatval($_GET['total_price']);
        $cart = json_decode(urldecode($_GET['cart']), true);
        $user_id = $_SESSION['user_id'] ?? 1;

        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (:user_id, :total_price)");
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("total_price", $totalPrice);

        if ($stmt->execute()) {

            $order_id = $conn->lastInsertId();

            // $orderItemStmt = $conn->prepare("INSERT INTO order_items (order_id, category_id, item, quantity, price) VALUES (:order_id, :category_id, :item, :quantity, :price)");

            // foreach ($cart as $item) {
            //     $orderItemStmt->bindParam(":order_id", $order_id);
            //     $orderItemStmt->bindParam(":category_id", $item['category_id']);
            //     $orderItemStmt->bindParam(":item", $item['name']);
            //     $orderItemStmt->bindParam(":quantity", $item['quantity']);
            //     $orderItemStmt->bindParam(":price", $item['price']);
            //     $orderItemStmt->execute();
            // }




            $message = "Your order #$order_id has been placed successfully!";
            $notifyStmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (:user_id, :message, 0)");
            $notifyStmt->bindParam(":user_id", $user_id);
            $notifyStmt->bindParam(":message", $message);
            $notifyStmt->execute();

            echo "<script>
                    localStorage.removeItem('cart');
                    setTimeout(function() {
                        window.location.href = '../../../orders/cart.php?success=1';
                    }, 500); 
            </script>"; 
        exit;

        exit;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "  <script>
                                alert('خطأ أثناء إضافة الطلب:');
                            </script>";
        }
    } catch (\Exception $e) {
        echo "<script>alert('خطأ: " . $e->getMessage() . "');</script>";
    }
    exit;
}

