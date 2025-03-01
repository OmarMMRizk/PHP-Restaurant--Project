<?php
session_start();
include_once '../backend/modules/admin_check.php';
include_once '../backend/modules/category.php';
include_once '../backend/modules/product.php';

$category = new Category();
$product = new Product();

if (isset($_POST['add_product'])) {
    $image = $_FILES['product_image'];
    $product->add($_POST['product_name'], $_POST['product_description'], $_POST['product_price'], $_POST['category_id'], $image);
}

if (isset($_POST['update_product'])) {
    $image = $_FILES['product_image'];
    $product->update($_POST['product_id'], $_POST['product_name'], $_POST['product_description'], $_POST['product_price'], $_POST['category_id'], $image);
}

if (isset($_POST['delete_product'])) {
    $product->delete($_POST['product_id']);
}

$categories = $category->getAll();
$products = [];

if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $products = $product->search($searchKeyword);
} else {
    $products = $product->getAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Manage Products</h2>

    <form method="GET" action="" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for products..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <button type="button" class="btn btn-primary mb-3" id="addNewProductBtn" 
            data-bs-toggle="modal" data-bs-target="#editProductModal">
        Add New Product
    </button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $prod): ?>
                <tr>
                    <td><img src="<?= $prod['image'] ?>" alt="<?= $prod['name'] ?>" width="50"></td>
                    <td><?= $prod['name'] ?></td>
                    <td><?= $prod['description'] ?></td>
                    <td>$<?= $prod['price'] ?></td>
                    <td><?= $prod['category_name'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-btn" 
                                data-id="<?= $prod['id'] ?>"
                                data-name="<?= $prod['name'] ?>"
                                data-description="<?= $prod['description'] ?>"
                                data-price="<?= $prod['price'] ?>"
                                data-category="<?= $prod['category_id'] ?>"
                                data-image="<?= $prod['image'] ?>"
                                data-bs-toggle="modal" data-bs-target="#editProductModal">
                            Edit
                        </button>

                        <form method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="modal_product_id">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="modal_product_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="product_description" id="modal_product_description" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="product_price" id="modal_product_price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="modal_category_id" class="form-select">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="product_image" id="modal_product_image" class="form-control">
                    </div>
                    <button type="submit" name="add_product" id="modal_add_btn" class="btn btn-primary">Add Product</button>
                    <button type="submit" name="update_product" id="modal_update_btn" class="btn btn-success d-none">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".edit-btn");
    const addNewProductBtn = document.getElementById("addNewProductBtn");

    const productIdInput = document.getElementById("modal_product_id");
    const productNameInput = document.getElementById("modal_product_name");
    const productDescriptionInput = document.getElementById("modal_product_description");
    const productPriceInput = document.getElementById("modal_product_price");
    const categoryInput = document.getElementById("modal_category_id");
    const productImageInput = document.getElementById("modal_product_image");

    const addBtn = document.getElementById("modal_add_btn");
    const updateBtn = document.getElementById("modal_update_btn");

    addNewProductBtn.addEventListener("click", function() {
        productIdInput.value = "";
        productNameInput.value = "";
        productDescriptionInput.value = "";
        productPriceInput.value = "";
        categoryInput.value = "";
        productImageInput.value = "";

        addBtn.classList.remove("d-none");
        updateBtn.classList.add("d-none");
    });

    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            productIdInput.value = this.dataset.id;
            productNameInput.value = this.dataset.name;
            productDescriptionInput.value = this.dataset.description;
            productPriceInput.value = this.dataset.price;
            categoryInput.value = this.dataset.category;
            productImageInput.value = ""; 

            addBtn.classList.add("d-none");
            updateBtn.classList.remove("d-none");
        });
    });

    document.getElementById("productForm").addEventListener("submit", function() {
        setTimeout(() => {
            let modal = document.getElementById("editProductModal");
            let bootstrapModal = bootstrap.Modal.getInstance(modal);
            bootstrapModal.hide();
        }, 500);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>