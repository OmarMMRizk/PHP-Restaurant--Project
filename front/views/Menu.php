
<?php

include_once'backend/dbomar.php';
include_once'backend/product.php';



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
    <link rel="stylesheet" href="MenuStyle.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footerStyle.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Document</title>
</head>

<body class="body">
<div class="header-navbar">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">ITI Restaurant</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-shopping-cart ms-3 " ></i>
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
                    <li class="nav-item"><a class="nav-link act" href="#contact">Login</a></li>
    
                </ul>
            </div>
        </div>
    </nav></div>


    
    
<div id="categories-nav"></div>
    <div class="container">
        <div class="row gap-">

            <nav class="navbar navbar-expand-xl navbar-expand-md sticky-top">
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
      
      <?php foreach ($products as $product): ?>
<!-- 
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
          <div class="card" >
            <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60"
                alt="" class="card-img-top">
            <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
                    <a class="btn btn-outline-primary btn-sm" href="https://github.com/OmarMMRizk/PHP-Restaurant--Project" target="_blank">Info</a>
                    <button class="btn btn-outline-danger btn-sm" type="button">Add To Cart</button>
                </div>                        
            </div>
        </div>
        </div> -->

        <?php endforeach; ?>
        <!--  -->


<?php foreach ($productsPizza as $product): ?>
<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 ">

  <div class="card " id="Pizza">
    <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60"
        alt="" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
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
    <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60"
        alt="" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="https://github.com/OmarMMRizk/PHP-Restaurant--Project" target="_blank">Info</a>
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
    <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60"
        alt="" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="https://github.com/OmarMMRizk/PHP-Restaurant--Project" target="_blank">Info</a>
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
    <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60"
        alt="" class="card-img-top">
    <div class="card-body text-center">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
        <p class="text-center fw-bold">Price : <?= number_format($product['price'], 2) ?></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a class="btn btn-outline-primary btn-sm" href="https://github.com/OmarMMRizk/PHP-Restaurant--Project" target="_blank">Info</a>
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