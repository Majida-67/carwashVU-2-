<?php
// Database connection
include('db_connection3.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch client bookings from the database
$query = "SELECT * FROM   bookings WHERE user_email = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$user_email]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <h2 class="text-center text-primary mb-4">My Booking History</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Service Date</th>
                        <th>Service Time</th>
                        <th>Status</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?= $booking['id'] ?></td>
                            <td><?= htmlspecialchars($booking['service']) ?></td>
                            <td><?= htmlspecialchars($booking['service_date']) ?></td>
                            <td><?= htmlspecialchars($booking['service_time']) ?></td>
                            <td class="text-center">
                                <span class="badge <?= strtolower($booking['status']) === 'confirmed' ? 'bg-success' : (strtolower($booking['status']) === 'cancelled' ? 'bg-danger' : 'bg-warning') ?>">
                                    <?= htmlspecialchars($booking['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($booking['receipt'])) : ?>
                                    <a href="receipts/<?= $booking['receipt'] ?>" target="_blank" class="btn btn-sm btn-primary">View Receipt</a>
                                <?php else : ?>
                                    <span class="text-muted">Not Available</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="profile.php" class="btn btn-secondary">Back to Profile</a>
</body>
</html>
