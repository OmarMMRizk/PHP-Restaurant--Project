<?php
session_start();
include_once '../backend/database/db.php';
include_once '../backend/modules/user.php';

if (!isset($_SESSION['user_email'])) {
    header("Location:../forms/php/login.php");
    exit;
}

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
    <title>Profile</title>
    <link rel="stylesheet" href="../Styles/userProfile/profile.css">
</head>
<body>
    <div class="container">
        <h2>Profile</h2>

        <?php if (!empty($success)): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <p class="error"><?= implode("<br>", $errors) ?></p>
        <?php endif; ?>

        <div class="profile-section">
            <div class="profile-image">
                <?php if (!empty($_SESSION['user']['profile_image'])): ?>
                    <img src="<?= htmlspecialchars($_SESSION['user']['profile_image']) ?>" alt="Profile Image">
                <?php else: ?>
                    <p>No profile image uploaded.</p>
                <?php endif; ?>
            </div>

            <div class="form-section">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['user']['first_name']) ?>" required>

                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['user']['last_name']) ?>" required>

                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($_SESSION['user']['phone']) ?>" required>

                    <label>Profile Image</label>
                    <input type="file" name="profile_image">

                    <label>New Password</label>
                    <input type="password" name="new_password">

                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">

                    <button type="submit">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- <a href="logout.php">Logout</a> -->
    </div>
</body>
</html>