<?php
session_start();
$isLoggedIn = isset($_SESSION['email']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITI Resturant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="Styles/index/style.css">
    <link rel="stylesheet" href="Styles/index/all.min.css">
    <link rel="stylesheet" href="Styles/index/nav.css">
    <link rel="stylesheet" href="styles.css">
</head>


<body>


    <?php include_once 'views/nav.php'; ?>

    <!-- <div style="position: relative; width: 100%; height: 100vh; overflow: hidden;">
    <img src="images/pexels-igor-starkov-233202-1307698.jpg" style="width: 100%; height: 100vh; object-fit: cover;" alt="Restaurant Image">
    
    <div class="landing-section">
        <h3>Welcome To ITI Restaurant</h3>
        <h2><a href="reservation.php">Reserve a Table Now</a></h2>
    </div>
    </div> -->



    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/P1.jpg" class="limg d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/p2.jpg" class="limg d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/pasta.jpg" class="limg d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <section id="categories" class="container text-center mt-5">
        <h2 class="fw-bold title ">categories</h2>
        <div class="row mt-4">
            <div class="col-6 col-md-3 col-sm-12 ">
                <img src="images/pizza.jpg" alt="Pizza" class="cat-img">
                <a href="">
                    <p class="fw-bold mt-4 cat-text">Pizza</p>
                </a>
            </div>
            <div class="col-6 col-md-3 col-sm-12 ">
                <img src="images/beef-burger.avif" alt="Burger" class="cat-img">
                <a href="">
                    <p class="fw-bold mt-4 cat-text">Burger</p>
                </a>
            </div>
            <div class="col-6 col-md-3 col-sm-12 ">
                <img src="images/pizza.jpg" alt="Pasta" class="cat-img">
                <a href="">
                    <p class="fw-bold mt-4 cat-text">Pasta</p>
                </a>
            </div>
            <div class="col-6 col-md-3 col-sm-12 ">
                <img src="images/pasta.jpg" alt="Dessert" class="cat-img">
                <a href="">
                    <p class="fw-bold mt-4 cat-text">Deserts</p>
                </a>
            </div>
        </div>
    </section>



    <!-- Top orders Section -->
    <section class="container text-center my-5">
        <h2 class="fw-bold title">Top Orders</h2>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="card custom-card">
                        <div class="image-container">
                            <img src="images/pizza.jpg" class="card-img-top top-img" alt="Food Image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title.</p>
                            <a href="orders/order.php" class="btn btn-primary">Add To Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card custom-card">
                        <div class="image-container">
                            <img src="images/pasta.jpg" class="card-img-top top-img" alt="Food Image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title.</p>
                            <a href="orders/order.php" class="btn btn-primary">Add To Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card custom-card">
                        <div class="image-container">
                            <img src="images/beef-burger.avif" class="card-img-top top-img" alt="Food Image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title.</p>
                            <a href="orders/order.php" class="btn btn-primary">Add To Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card custom-card">
                        <div class="image-container">
                            <img src="images/pasta.jpg" class="card-img-top top-img" alt="Food Image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title.</p>
                            <a href="orders/order.php" class="btn btn-primary">Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once 'views/footer.php'; ?>

 

</body>

</html>