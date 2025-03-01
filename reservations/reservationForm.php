<?php include './backend/database/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Table Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Reserve a Table</h2>
            <form action="../backend/modules/reservation.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="reservation_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time</label>
                    <input type="time" name="reservation_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Guests</label>
                    <input type="number" name="guests" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reserve Now</button>
            </form>
        </div>
    </div>
</body>
</html>