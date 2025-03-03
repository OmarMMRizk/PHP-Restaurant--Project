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


<script>
    document.addEventListener('DOMContentLoaded', function() {
    displayCartItems();

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        showSuccessAlert("تمت إضافة الطلب بنجاح");
        history.replaceState({}, document.title, window.location.pathname); // Remove success param
    }
});

function showSuccessAlert(message) {
    const alertContainer = document.createElement("div");
    alertContainer.innerHTML = `
        <div class="alert alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 shadow-lg text-center" 
                role="alert" 
                style="z-index: 1050; width: 350px; background-color: #d4edda; color:  #28a745;">
            <i class="fas fa-check-circle me-2"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    document.body.appendChild(alertContainer);

    setTimeout(() => {
        alertContainer.remove();
    }, 5000);
}

function displayCartItems() {
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const orders = JSON.parse(localStorage.getItem('cart')) || [];
    const removeAll = document.getElementsByClassName('remove-all-btn');

    cartItemsContainer.innerHTML = '';

    if (orders.length === 0) {
        cartItemsContainer.innerHTML = '<h3 class="text-center py-3">Your cart is empty.</h3>';
        if (removeAll.length > 0) {
            removeAll[0].style.display = 'none';
        }
        document.getElementById('cartTotal').textContent = 'Total: 0 $';
        document.getElementById('totalPriceInput').value = '0'; 
        return;
    }

    let totalPrice = 0;

    orders.forEach((order, index) => {
        const quantity = order.quantity ? parseInt(order.quantity) : 1;

        let extrasTotal = 0;
        let extrasText = '';
        if (order.extras && order.extras.length > 0) {
            order.extras.forEach(extra => {
                extrasTotal += parseFloat(extra.price);
            });
            extrasText = 'Extras: ' + order.extras.map(e => e.name + ' (' + e.price + ' $)').join(', ');
        }

        const basePrice = parseFloat(order.price);
        const itemPrice = basePrice + extrasTotal;
        const itemTotal = (itemPrice * quantity).toFixed(2);
        totalPrice += parseFloat(itemTotal);

        const itemRow = document.createElement('div');
        itemRow.className = 'cart-item-row';

        const img = document.createElement('img');
        img.src = order.image || '../images/pizza.jfif';
        img.alt = order.name;
        img.className = 'cart-item-image';

        const detailsDiv = document.createElement('div');
        detailsDiv.className = 'cart-item-details';

        const title = document.createElement('p');
        title.className = 'cart-item-title';
        title.textContent = order.name;

        const price = document.createElement('h5');
        price.className = 'cart-item-price';
        price.textContent = `${order.price} $`;

        detailsDiv.appendChild(title);
        detailsDiv.appendChild(price);

        if (extrasText) {
            const extrasEl = document.createElement('small');
            extrasEl.textContent = extrasText;
            detailsDiv.appendChild(extrasEl);
        }

        const qtyContainer = document.createElement('div');
        qtyContainer.className = 'quantity-controls';

        const btnMinus = document.createElement('button');
        btnMinus.className = 'btn-qty';
        btnMinus.textContent = '-';
        btnMinus.onclick = function() {
            updateCounter(index, -1);
        };

        const spanQty = document.createElement('span');
        spanQty.id = `qty-${index}`;
        spanQty.textContent = order.quantity || 1;

        const btnPlus = document.createElement('button');
        btnPlus.className = 'btn-qty';
        btnPlus.textContent = '+';
        btnPlus.onclick = function() {
            updateCounter(index, 1);
        };

        qtyContainer.appendChild(btnMinus);
        qtyContainer.appendChild(spanQty);
        qtyContainer.appendChild(btnPlus);

        const removeBtn = document.createElement('button');
        removeBtn.className = 'remove-item-btn ms-2 me-3';
        removeBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
        removeBtn.onclick = function() {
            removeItem(index);
        };

        const itemTotalDiv = document.createElement('div');
        itemTotalDiv.className = 'ms-auto';
        itemTotalDiv.innerHTML = `<strong>${itemTotal} $</strong>`;

        itemRow.appendChild(img);
        itemRow.appendChild(detailsDiv);
        itemRow.appendChild(qtyContainer);
        itemRow.appendChild(removeBtn);
        itemRow.appendChild(itemTotalDiv);

        cartItemsContainer.appendChild(itemRow);
    });

    document.getElementById('cartTotal').textContent = `Total: ${totalPrice.toFixed(2)} $`;
    document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);
}

function updateCounter(index, change) {
    const orders = JSON.parse(localStorage.getItem('cart')) || [];
    if (!orders[index]) return;

    let newQty = (orders[index].quantity || 1) + change;
    if (newQty < 1) newQty = 1;

    orders[index].quantity = newQty;
    localStorage.setItem('cart', JSON.stringify(orders));

    displayCartItems();
}

function removeItem(index) {
    const orders = JSON.parse(localStorage.getItem('cart')) || [];
    orders.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(orders));
    displayCartItems();
}

function removeAllItems() {
    localStorage.setItem('cart', JSON.stringify([]));
    displayCartItems();
}

function checkout() {
    const cartData = JSON.parse(localStorage.getItem('cart')) || [];
    if (cartData.length === 0) {
        alert('Your cart is empty.');
        return;
    }
    let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    let totalPrice = parseFloat(document.getElementById('totalPriceInput').value);

      // Ensure cart data is sent with the form
    let cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(cartData);
    document.querySelector("form").appendChild(cartInput);

    let requestData = {
        payment_method: paymentMethod,
        cart: cartData,
        total_price: totalPrice
    };

    console.log("🚀 Sending requestData:", requestData);

    if (paymentMethod === 'cod') {
        localStorage.removeItem('cart');
        document.querySelector("form").submit();
        return;
    }
    fetch('http://localhost/ICC/PHP-Restaurant--Project/backend/modules/orders/payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Error: " + data.error);
        } else if(data.redirectUrl) {
            window.location.href = data.redirectUrl; // Redirect for Stripe payment
        }
    })
    .catch(error => console.error("Error:", error));}


</script>



    <!-- <script src="../js/cart.js"></script> -->

</body>
</html>
