<?php
session_start();
include_once '../../backend/user.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();

    $userData = $user->login($_POST['email'], $_POST['password']);

    if (is_array($userData) && isset($userData['email'], $userData['role'])) {
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_role'] = $userData['role'];

        header("Location: ../../index.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Styles/Forms/login.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block">
                            <img src="../../images/6310507.jpg" alt="Login Image" class="card-img-left">
                        </div>

                        <div class="col-md-6">
                            <div class="card-body">
                                <h1 class="card-title">Welcome Back</h1>
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-danger text-center"><?= $message ?></div>
                                <?php endif; ?>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Enter your email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Login</button>
                                </form>

                                <div class="text-center mt-4">
                                    <a href="../reset/reset.html">Forgot Password?</a>
                                    <span class="mx-2">|</span>
                                    <a href="../signup/register.php">Create Account</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>