<?php
session_start();
include_once '../backend/modules/admin_check.php';
include_once '../backend/modules/category.php';

$category = new Category();

if (isset($_POST['add_category'])) {
    $category->add($_POST['category_name']);
}

if (isset($_POST['update_category'])) {
    $category->update($_POST['category_id'], $_POST['category_name']);
}

if (isset($_POST['delete_category'])) {
    $category->delete($_POST['category_id']);
}

$categories = $category->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Manage Categories</h2>
    <form method="POST" class="mb-3">
        <input type="text" name="category_name" class="form-control mb-2" placeholder="Enter Category Name" required>
        <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
    </form>

    <ul class="list-group">
        <?php foreach ($categories as $cat): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= $cat['name'] ?>
                <form method="POST" class="d-flex">
                    <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                    <input type="text" name="category_name" value="<?= $cat['name'] ?>" class="form-control me-2" required>
                    <button type="submit" name="update_category" class="btn btn-warning me-2">Update</button>
                    <button type="submit" name="delete_category" class="btn btn-danger">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
