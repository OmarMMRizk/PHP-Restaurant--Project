document.addEventListener('DOMContentLoaded', function() {
    displayCartItems();
});

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