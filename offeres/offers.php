<?php
require '../backend/database/db.php';

$db = new Database();
$conn = $db->connect();

$sql = "SELECT * FROM offers WHERE expiry_date >= CURDATE() ORDER BY expiry_date ASC";
$stmt = $conn->query($sql);
$offers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Available Offers</h2>
    <table class="table table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Offer Name</th>
                <th>Discount</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $offer): ?>
                <tr>
                    <td><?= htmlspecialchars($offer['name']) ?></td>
                    <td><?= htmlspecialchars($offer['discount']) ?>%</td>
                    <td><?= htmlspecialchars($offer['expiry_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
