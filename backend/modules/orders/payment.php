<?php
error_reporting(0); // Disable error reporting
ini_set('display_errors', 0); // Hide errors
require __DIR__. "/../../../vendor/autoload.php";

// require __DIR__ . '/../vendor/autoload.php'; // Adjust path if needed
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');  // Ensure data is JSON

$stripe_secret_key = "sk_test_51PD6cqDAFbKV4bTRnbmGlG0fDWG7zjCZv3vT06wQyXSAGz6U8bDdDtdchkVcNKTmvqU5W1igwQzmhoQS33urgSxQ00I6yoR34s";
\Stripe\Stripe::setApiKey($stripe_secret_key);

$requestData = json_decode(file_get_contents('php://input'), true);
$cart = $requestData['cart'];

$totalPrice = 0; // Initialize total price
$line_items = [];

foreach ($cart as $item) {
    $quantity = $item['quantity'] ?? 1;
    $extrasTotal = 0;

    if (!empty($item['extras'])) {
        foreach ($item['extras'] as $extra) {
            $extrasTotal += floatval($extra['price']);
        }
    }

    $product_data = [
        'name' => $item['name'],
    ];
    
    // Only add description if there are extras
    if (!empty($item['extras'])) {
        $product_data['description'] = 'Extras: ' . implode(', ', array_column($item['extras'], 'name'));
    }

    $unitPrice = (floatval($item['price']) + $extrasTotal);
    $totalPrice += $unitPrice * $quantity;

    $line_items[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => $product_data,
            'unit_amount' => intval($unitPrice * 100),
        ],
        'quantity' => $quantity,
    ];
}

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/ICC/PHP-Restaurant--Project/backend/modules/orders/place_order.php?session_id={CHECKOUT_SESSION_ID}&total_price=' . $totalPrice . '&cart=' . urlencode(json_encode($cart)),
        'cancel_url' => 'http://localhost/ICC/restApp2/payment_cancel.php',
    ]);

    echo json_encode(['redirectUrl' => $checkout_session->url]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}