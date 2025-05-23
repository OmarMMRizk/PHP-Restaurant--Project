<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITI Resturant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="cart.php" id="cartDropdown" role="button">
                            <i class="fas fa-shopping-cart ms-3"></i>
                            <span id="cart-count" class="position-absolute top-3 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notification-icon" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell ms-3"></i>
                            <span id="notification-count" class="position-absolute top-3 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                        <ul id="notification-list" class="dropdown-menu dropdown-menu-end p-2 shadow-sm" style="width: 300px; max-height: 300px; overflow-y: auto;">
                            <li class="text-center text-muted m-2">No notifications</li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link act ms-5" href="#contact">Login</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-2">
        <div class="card mx-auto" style="max-width: 300px;">
            <img src="../images/pizza.jfif" class="card-img-top" alt="Pizza" style="height: 200px; object-fit: cover;" />
            <div class="card-body">
                <h5 class="card-title">Pizza</h5>
                <p class="card-text">
                    Enjoy our delicious pizza made with fresh ingredients and baked to perfection.
                </p>
                <p class="card-text fw-bold">Price: $20</p>
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="extras[]" value="5" id="mushroom">
                            <label for="mushroom" class="ms-2">Mushroom</label>
                        </div>
                        <span id="price-mushroom" class="fw-bold">5$</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="extras[]" value="5" id="mayonnaise">
                            <label for="mayonnaise" class="ms-2">Mayonnaise</label>
                        </div>
                        <span id="price-mayonnaise" class="fw-bold">5$</span>
                    </div>
                    <!-- <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="extras[]" value="5" id="Cheese">
                            <label for="Cheese" class="ms-2">Cheese</label>
                        </div>
                        <span id="price-Cheese" class="fw-bold">5$</span>
                    </div> -->
                </div>
                <button
                    type="button"
                    class="btn btn-primary w-100 addToCartBtn mt-3"
                    data-name="Pizza"
                    data-price="20"
                    data-quantity="1"
                    data-image="../images/pizza.jfif">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            fetchNotifications();

            document.getElementById("notification-icon").addEventListener("click", function() {
                markNotificationsAsRead();
            });
        });

        function fetchNotifications() {
            fetch("php/get_notifications.php") // Fetch all notifications from the backend
                .then(response => response.json())
                .then(data => {
                    let countSpan = document.getElementById("notification-count");
                    let notificationList = document.getElementById("notification-list");

                    // Update unread notification count
                    if (data.unread_count > 0) {
                        countSpan.innerText = data.unread_count;
                        countSpan.style.display = "inline-block";
                    } else {
                        countSpan.style.display = "none";
                    }

                    // Populate notifications dropdown
                    let listContent = "";
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(notification => {
                            let isUnread = notification.status === 'unread';
                            listContent += `
                        <li class="dropdown-item d-flex justify-content-between align-items-center notification-item 
                            ${isUnread ? 'fw-bold bg-light' : 'text-muted'} p-2 rounded-2"
                            data-id="${notification.id}" data-status="${notification.status}" style="cursor: pointer;">
                            <span>${notification.message}</span>
                            ${isUnread ? '<span class="badge bg-success">New</span>' : ''}
                        </li>
                    `;
                        });
                    } else {
                        listContent = `<li class="text-center text-muted m-2">No notifications</li>`;
                    }

                    notificationList.innerHTML = listContent;
                })
                .catch(error => console.log("Error fetching notifications:", error));
        }



        // Mark notifications as read
        function markNotificationsAsRead() {
            fetch("php/mark_notifications_read.php") // API to mark all notifications as read
                .then(response => response.json())
                .then(() => {
                    document.getElementById("notification-count").style.display = "none";

                    // Update styling of unread notifications
                    document.querySelectorAll(".notification-item").forEach(item => {
                        item.classList.remove("fw-bold", "text-dark");
                        item.classList.add("text-muted");

                        let badge = item.querySelector(".badge");
                        if (badge) badge.remove(); // Remove the "New" badge
                    });
                })
                .catch(error => console.log("Error marking notifications as read:", error));
        }


        // Mark notifications as read when clicking the bell icon
        document.getElementById("notification-icon").addEventListener("click", function(event) {
            event.preventDefault();

            fetch("mark_notifications_read.php")
                .then(response => response.json())
                .then(() => {
                    document.getElementById("notification-count").style.display = "none";
                    fetchNotifications(); // Refresh notifications
                })
                .catch(error => console.log("Error marking notifications as read:", error));
        });
    </script>



    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.7.1.js"></script>
    <script src="../js/order.js"></script>

</body>

</html>