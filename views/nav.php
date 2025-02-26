<!--Main  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">ITI Restaurant</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">

                    <?php if ($isAdmin): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="reservation.php">Reserve a Table</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-shopping-cart ms-3"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end cart-dropdown" aria-labelledby="cartDropdown">
                            <li class="dropdown-cart-header d-flex justify-content-between">
                                <span class="fw-bold">2 Items</span>
                                <a href="cart.html" class="text-decoration-none text-primary">View Cart</a>
                            </li>
                            <hr>
                            <li class="cart-item">
                                <a href="javascript:void(0)" class="remove me-3" title="Remove">
                                    <i class="fas fa-times"></i>
                                </a>
                                <div>
                                    <img src="images/pizza.jpg" alt="#" class="cart-img">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0"><a href="product-details.html" class="text-dark text-decoration-none">Apple Watch</a></h6>
                                    <p class="mb-0 text-muted">1x - <span class="fw-bold">$99.00</span></p>
                                </div>
                            </li>
                            <li class="cart-item">
                                <a href="javascript:void(0)" class="remove me-3" title="Remove">
                                    <i class="fas fa-times"></i>
                                </a>
                                <div>
                                    <img src="images/pizza.jpg" alt="#" class="cart-img">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0"><a href="product-details.html" class="text-dark text-decoration-none">Wi-Fi Camera</a></h6>
                                    <p class="mb-0 text-muted">1x - <span class="fw-bold">$35.00</span></p>
                                </div>
                            </li>
                            <hr>
                            <li class="d-flex justify-content-between align-items-center">
                                <span class="cart-total">Total:</span>
                                <span class="cart-total">$134.00</span>
                            </li>
                            <li class="text-center mt-3">
                                <a href="checkout.html" class="btn btn-checkout w-100">Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link act" href="Forms/login/login.php">Login</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link act" href="backend/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>