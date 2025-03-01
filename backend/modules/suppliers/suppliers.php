<?php
require '../../database/db.php'; 
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_supplier'])) {
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $conn->prepare("INSERT INTO suppliers (name, contact) VALUES (?, ?)")->execute([$name, $contact]);
    } elseif (isset($_POST['edit_supplier'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $conn->prepare("UPDATE suppliers SET name=?, contact=? WHERE id=?")->execute([$name, $contact, $id]);
    } elseif (isset($_POST['delete_supplier'])) {
        $id = $_POST['id'];
        $conn->prepare("DELETE FROM suppliers WHERE id=?")->execute([$id]);
    }
}

$suppliers = $conn->query("SELECT * FROM suppliers")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function editSupplier(id, name, contact) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_contact').value = contact;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Supplier Management</h2>

        <form method="post" class="mt-3">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-3">
                <label class="form-label">Supplier Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact</label>
                <input type="text" name="contact" id="edit_contact" class="form-control" required>
            </div>
            <button type="submit" name="add_supplier" class="btn btn-success">Add Supplier</button>
            <button type="submit" name="edit_supplier" class="btn btn-warning">Edit Supplier</button>
        </form>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?= $supplier['id'] ?></td>
                    <td><?= $supplier['name'] ?></td>
                    <td><?= $supplier['contact'] ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="editSupplier('<?= $supplier['id'] ?>', '<?= $supplier['name'] ?>', '<?= $supplier['contact'] ?>')">Edit</button>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
                            <button type="submit" name="delete_supplier" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a href="../../../suppliers/supplier_orders.php?supplier_id=<?= $supplier['id'] ?>" class="btn btn-primary btn-sm">View Orders</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
