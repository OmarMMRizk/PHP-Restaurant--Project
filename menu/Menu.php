<?php
session_start();
$isLoggedIn = isset($_SESSION['emai']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<?php

include_once'../backend/database/db.php';
include_once'../backend/modules/menu.php';



$product = new Product();

$products = $product->getAll();

$productsPizza = $product->getPizza();
$productsSushi = $product->getSushi();
$productsBurger = $product->getBurger();
$productsDesserts = $product->getDesserts();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../Styles/menu/MenuStyle.css">
    <link rel="stylesheet" href="../Styles/menu/navbar.css">
    <link rel="stylesheet" href="../Styles/menu/footerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Document</title>
</head>

<body class="body">
  
  
 
<div class="header-navbar">

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

                    <li class="nav-item dropdown" >
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notification-icon" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell ms-3"></i>
                            <span id="notification-count" class="position-absolute top-3 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                        <ul id="notification-list" class="dropdown-menu dropdown-menu-end p-2 shadow-sm" style="width: 300px; max-height: 300px; overflow-y: auto; z-index:999;">
                            <li class="text-center text-muted m-2">No notifications</li>
                        </ul>
                    </li>
                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link act" href="Forms/login/login.php">Login</a></li>
                    <?php else: ?>
                        <li class="nav-item "><a class="nav-link act" href="../backend/modules/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>


    
    

    <div class="container ">
        <div class="row">

            <nav class="navbar navbar-expand-xl navbar-expand-md  top-pos">
                <div class="container-fluid">
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse"  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse nav-ul navbar-collapse justify-content-center " id="navbarSupportedContent" >
                    <ul class="nav  nav-fill d-flex  flex-column flex-sm-column flex-md-row  flex-xl-row flex-xxl-row bg-pr  " >
                        <li class="nav-item me-5 nav-items">
                            <a class="btn btn-outline-dark  " href="#Pizza">Pizza</a>
                        </li>
                        <li class="nav-item me-5 nav-items">
                            <a class="btn btn-outline-dark "href="#Burger">Burger</a>
                        </li>
                        <li class="nav-item me-5 nav-items">
                            <a class="btn btn-outline-dark"  href="#Sushi">Sushi</a>
                        </li>
                        <li class="nav-item me-5 nav-items">
                            <a class="btn btn-outline-dark "  href="#Desserts">Desserts</a>
                        </li>
                      </ul>
           

            </div>
        </div>
    </nav>
    
    <!-- menu -->

    
    <p class="main-menu " id="Pizza">
         Pizza
    </p>

    <div id="main-menu">
        <div class="row ">
      

<?php foreach ($productsPizza as $product): ?>
<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">

  <div class="card " id="Pizza">
    <img src="<?=$product['image'] ?>"
        alt="<?= htmlspecialchars($product['name']) ?>" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
        <a class="btn btn-outline-primary btn-sm" href="#">Info</a>
            <button class="btn btn-outline-danger btn-sm" type="button">Add To Cart</button>
        </div>                        
    </div>
</div>
</div>


<?php endforeach; ?>
<!--  -->

<hr><br>
<!--  -->
<p class="main-menu "id="Burger">
        Burger
    </p>
<?php foreach ($productsBurger as $product): ?>

<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
  <div class="card" >
  <img src="<?= htmlspecialchars($product['image']) ?>"
  alt="<?= htmlspecialchars($product['name']) ?>" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="#">Info</a>
            <button class="btn btn-outline-danger btn-sm" type="button">Add To Cart</button>
        </div>                        
    </div>
</div>
</div>

<?php endforeach; ?>
<!--  -->
<br><hr>
<!--  -->
<p class="main-menu "id="Sushi">
        Sushi
    </p>
<?php foreach ($productsSushi as $product): ?>

<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
  <div class="card" >
  <img src="<?= htmlspecialchars($product['image']) ?>"
  alt="<?= htmlspecialchars($product['name']) ?>" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="#" >Info</a>
            <button class="btn btn-outline-danger btn-sm" type="button">Add To Cart</button>
        </div>                        
    </div>
</div>
</div>

<?php endforeach; ?>
<!--  -->
<br> <hr>
<!--  -->
<p class="main-menu "id="Desserts">
       Desserts
    </p>
<?php foreach ($productsDesserts as $product): ?>

<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
  <div class="card" >
  <img src="<?= htmlspecialchars($product['image']) ?>"
  alt="<?= htmlspecialchars($product['name']) ?>" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="#">Info</a>
            <button class="btn btn-outline-danger btn-sm" type="button">Add To Cart</button>
        </div>                        
    </div>
</div>
</div>

<?php endforeach; ?>














            
            </div>
        </div>





































    
        <footer id="footer" class="footer dark-background">


            <div class="container">
              <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                  <i class="bi bi-geo-alt icon"></i>
                  <div class="address">
                    <h4>Address</h4>
                    <p>A108 Adam Street</p>
                    <p>New York, NY 535022</p>
                    <p></p>
                  </div>
        
                </div>
        
                <div class="col-lg-3 col-md-6 d-flex">
                  <i class="bi bi-telephone icon"></i>
                  <div>
                    <h4>Contact</h4>
                    <p>
                      <strong>Phone:</strong> <span>+1 5589 55488 55</span><br>
                      <strong>Email:</strong> <span>info@example.com</span><br>
                    </p>
                  </div>
                </div>
        
                <div class="col-lg-3 col-md-6 d-flex">
                  <i class="bi bi-clock icon"></i>
                  <div>
                    <h4>Opening Hours</h4>
                    <p>
                      <strong>Mon-Sat:</strong> <span>11AM - 23PM</span><br>
                      <strong>Sunday</strong>: <span>Closed</span>
                    </p>
                  </div>
                </div>
        
                <div class="col-lg-3 col-md-6">
                  <h4>Follow Us</h4>
                  <div class="social-links d-flex">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
        
              </div>
            </div>
        
            <div class="container copyright text-center mt-4">
              <p>© <span>Copyright</span> <strong class="px-1 sitename">P H P</strong> <span>All Rights Reserved</span></p>
           </div>
        
          </footer>















        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>

</html>