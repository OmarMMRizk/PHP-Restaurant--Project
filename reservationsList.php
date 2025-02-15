<?php
require './backEnds/dbomar.php';

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM reservations ORDER BY reservation_date, reservation_time");
$stmt->execute();
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Reservations</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><?= $res['customer_name'] ?></td>
                        <td><?= $res['customer_email'] ?></td>
                        <td><?= $res['phone'] ?></td>
                        <td><?= $res['reservation_date'] ?></td>
                        <td><?= $res['reservation_time'] ?></td>
                        <td><?= $res['guests'] ?></td>
                        <td><?= $res['status'] ?></td>
                        <td>
                            <form action="modify_list.php" method="POST" class="d-inline">
                                <input type="hidden" name="reservation_id" value="<?= $res['id'] ?>">
                                <button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>