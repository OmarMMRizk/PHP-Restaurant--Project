document.addEventListener("DOMContentLoaded", function() {
    updateCartCount();
});

document.querySelectorAll(".addToCartBtn").forEach(button => {
    button.addEventListener("click", function() {
        addToCart(this);
    });
});

function addToCart(button) {
    const extras = [];
    document.querySelectorAll("input[name='extras[]']:checked").forEach(extra => {
        extras.push({
            name: extra.nextElementSibling.innerText,
            price: parseFloat(extra.value)
        });
    });
    const order = {
        name: button.dataset.name,
        price: parseFloat(button.dataset.price),
        image: button.dataset.image,
        extras: extras
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.push(order);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    button.disabled = true;
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    document.getElementById('cart-count').innerText = cart.length;
}



document.addEventListener("DOMContentLoaded", function() {
    fetchNotifications();

    document.getElementById("notification-icon").addEventListener("click", function() {
        markNotificationsAsRead();
    });
});