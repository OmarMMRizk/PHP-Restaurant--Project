<?php
include_once '../../backend/user.php';

$first_name = $last_name = $email = $password = $confirm_password = $phone = "";
$errors = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'phone' => '',
    'profile_image' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $phone = trim($_POST["phone"]);
    $profile_image = $_FILES["profile_image"]["name"] ?? null;

    if (empty($first_name)) {
        $errors['first_name'] = "First name is required.";
    }

    if (empty($last_name)) {
        $errors['last_name'] = "Last name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($phone)) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors['phone'] = "Invalid phone number.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Confirm password is required.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    if ($profile_image) {
        $target_dir = "../../profile_pic/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    if (!array_filter($errors)) {
        $user = new User();
        $result = $user->register($first_name, $last_name, $email, $password, $confirm_password, $phone, $profile_image);
        header("Location: ../login/login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>

<body>

    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="row g-0">
                        
                        <div class="col-md-6 d-none d-md-block">
                            <img src="sign.jpg" alt="Login Image" class="img-fluid">
                        </div>

                       
                        <div class="col-md-6">
                            <div class="card-body">
                                <h1 class="card-title">Create Account</h1>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="mb-2">
                                        <input type="text" name="first_name" class="form-control form-control-sm <?= $errors['first_name'] ? 'is-invalid' : '' ?>" placeholder="First Name" value="<?= htmlspecialchars($first_name) ?>">
                                        <div class="invalid-feedback"><?= $errors['first_name']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="text" name="last_name" class="form-control form-control-sm <?= $errors['last_name'] ? 'is-invalid' : '' ?>" placeholder="Last Name" value="<?= htmlspecialchars($last_name) ?>">
                                        <div class="invalid-feedback"><?= $errors['last_name']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="email" name="email" class="form-control form-control-sm <?= $errors['email'] ? 'is-invalid' : '' ?>" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
                                        <div class="invalid-feedback"><?= $errors['email']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="text" name="phone" class="form-control form-control-sm <?= $errors['phone'] ? 'is-invalid' : '' ?>" placeholder="Phone Number" value="<?= htmlspecialchars($phone) ?>">
                                        <div class="invalid-feedback"><?= $errors['phone']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="password" name="password" class="form-control form-control-sm <?= $errors['password'] ? 'is-invalid' : '' ?>" placeholder="Password">
                                        <div class="invalid-feedback"><?= $errors['password']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="password" name="confirm_password" class="form-control form-control-sm <?= $errors['confirm_password'] ? 'is-invalid' : '' ?>" placeholder="Confirm Password">
                                        <div class="invalid-feedback"><?= $errors['confirm_password']; ?></div>
                                    </div>

                                    <div class="mb-2">
                                        <input type="file" name="profile_image" class="form-control form-control-sm <?= $errors['profile_image'] ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback"><?= $errors['profile_image']; ?></div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-sm">Register</button>
                                    </div>
                                </form>

                                <p class="text-center mt-3 small">Already have an account? <a href="../login/login.php">Login</a></p>
                            </div>
                        </div> <!-- نهاية الفورم -->
                    </div> <!-- نهاية row -->
                </div> <!-- نهاية البطاقة -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>