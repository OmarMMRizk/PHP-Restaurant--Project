<?php 
session_start();
// include_once '../backend/database/db.php';
include_once '../backend/modules/product.php';
include_once '../backend/modules/user.php';
$user = new User();
$Product = new Product();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="views/dashboard/dashboard.css">

</head>

<body>
<?php include_once 'views/sidebar.php' ; ?>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-brand">Welcome to the Dashboard</span>
            </div>
        </nav>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?= $user->getUserCount(); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text">230</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text"><?= $Product->getproductCount();?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total reservation</h5>
                        <p class="card-text">150</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Stock</h5>
                        <p class="card-text">230</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Suppliers Orders</h5>
                        <p class="card-text">500</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="card mt-4">
            <div class="card-header">Users Table</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ahmed</td>
                            <td>ahmed@example.com</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mohamed</td>
                            <td>mohamed@example.com</td>
                            <td>User</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>