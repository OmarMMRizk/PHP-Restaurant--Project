<!--Main  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.php">ITI Restaurant</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">

                    <?php if ($isAdmin): ?>
                        <li class="nav-item"><a class="nav-link" href="../dashboard/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link" href="../userProfile/profile.php">Profile</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="../reservations/reservationForm.php">Reserve a Table</a></li>
                    <li class="nav-item"><a class="nav-link" href="../menu/Menu.php">Menu</a></li>
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
                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link act" href="../forms/php/login.php">Login</a></li>
                    <?php else: ?>
                        <li class="nav-item "><a class="nav-link act" href="../backend/modules/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>