<?php
session_start();
include_once './userbackend/dbomar.php';
include_once './userbackend/user.php';

// if (!isset($_SESSION['user_email'])) {
//     header("Location: login.php");
//     exit;
// }

$user = $_SESSION['user'];
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $phone = trim($_POST["phone"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (!empty($_FILES["profile_image"]["name"])) {
        $target_dir = "profile_pic/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    } else {
        $target_file = $user['profile_image'];
    }

    if (empty($first_name) || empty($last_name) || empty($phone)) {
        $errors[] = "All fields are required.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors[] = "Invalid phone number.";
    }

    if (!empty($new_password) || !empty($confirm_password)) {
        if (strlen($new_password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        } elseif ($new_password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
    }

    if (empty($errors)) {
        $database = new Database();
        $conn = $database->connect();

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, profile_image = ?, password = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $phone, $target_file, $hashed_password, $user['id']]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, profile_image = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $phone, $target_file, $user['id']]);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user['id']]);
        $updated_user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $updated_user;

        $success = "Profile updated successfully!";
        header("Location: profile.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userprofilestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<div class="container my-5">
    <div class="row">
        <div class="text-center">
            <h1>Profile Settings</h1>
        </div>
           <div>
           <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>
           <?php if (!empty($errors)) echo "<p  class='alert alert-danger'>" . implode("<br>", $errors) . "</p>"; ?>
           </div>
        <div class="col-md-4 d-flex justify-content-center ">
        <?php if (!empty($_SESSION['user']['profile_image'])): ?>
        <img src="<?= htmlspecialchars($_SESSION['user']['profile_image']) ?>" class="profile-image">
        <?php endif; ?>
        <!-- <img src="https://yt3.googleusercontent.com/ytc/AIdro_m4QoZl7BsRmri3tn3Lu71WmjIo96yRYqVkn9VfOzjdz8Q=s900-c-k-c0x00ffffff-no-rj" class="profile-image" alt="..."> -->
        </div>
        <div class="col-md-8">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"  value="<?= htmlspecialchars($_SESSION['user']['first_name']) ?>" required>
                </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="last_name" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($_SESSION['user']['last_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phome">Phome:</label>
                        <input type="tel" class="form-control" id="phome" name="phome" pattern="[0-9]{11,14}" value="<?= htmlspecialchars($_SESSION['user']['phone']) ?>" required>
                    </div>
                    <div class="form-group">
                         <label for="new_password">New Password:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                         <label for="confirm_password">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                        
                    </div>
                    <div class="my-4">
                        <button type="submit" class="btn btn-primary">Save Update</button>
                    </div>
                 
                        
                    <div class="my-4">
                        <a href="logout.php" class="btn btn-secondary">Logout</a>
                    </div>
            
                </div>
            </form>
        </div>
          
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>