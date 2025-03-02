<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="../Styles/index/cart.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
<form action="../backend/modules/orders/place_order.php" method="post">
    <input type="hidden" name="total_price" id="totalPriceInput">

    <div class="container my-4">
        <div class="cart-container">
            <div class="cart-header">
                <h2 class="mb-0">Shopping Cart</h2>
            </div>

            <div id="cartItemsContainer">
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <button  type="button" class="remove-all-btn" onclick="removeAllItems()">Remove All</button>
                <div class="cart-total" id="cartTotal">Total: 0 $</div>
            </div>
        </div>
        
        <div class="payment-method-container p-3 mt-4 bg-white shadow-sm rounded">
    <h5 class="mb-3">Select Payment Method</h5>
    <div class="d-flex flex-column gap-3">
        <label class="payment-option d-flex align-items-center p-3 border rounded">
            <input type="radio" name="payment_method" value="cod" checked class="me-2">
            <i class="fas fa-truck fa-lg text-success me-2"></i>
            <span>Cash on Delivery</span>
        </label>
        <label class="payment-option d-flex align-items-center p-3 border rounded">
            <input type="radio" name="payment_method" value="stripe" class="me-2">
            <i class="fas fa-credit-card fa-lg text-primary me-2"></i>
            <span>Pay with Card (Stripe)</span>
        </label>
    </div>
    <button type="button"  class="btn btn-success w-100 mt-3" onclick="checkout()">Proceed to Payment</button>
</div>
</form>




    <script src="../js/cart.js"></script>

</body>
</html>
