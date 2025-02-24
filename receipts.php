<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if booking_id is provided
if (!isset($_GET['booking_id'])) {
    die("Invalid request.");
}

$booking_id = intval($_GET['booking_id']);

// Fetch booking details with user email
$query = "SELECT cb.id, u.name, u.email, cb.service, cb.service_date, cb.service_time, cb.status 
          FROM customer_bookings cb
          JOIN add_users u ON cb.user_id = u.id
          WHERE cb.id = ? AND cb.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}

// Check if the booking is confirmed
if ($booking['status'] !== 'Confirmed') {
    die("Receipt not available for unconfirmed bookings.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #010c3e;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .details {
            text-align: left;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .details p {
            margin: 10px 0;
        }
        .print-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #010c3e;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #023b7a;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
        .back-link a {
            color: #010c3e;
            font-weight: bold;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Booking Receipt</h2>
        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>

        <div class="details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
            <p><strong>Service:</strong> <?php echo htmlspecialchars($booking['service']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($booking['service_date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($booking['service_time']); ?></p>
            <p><strong>Status:</strong> <span style="color: green; font-weight: bold;">Confirmed</span></p>
        </div>

        <button class="print-btn" onclick="window.print()">Print Receipt</button>

        <div class="back-link">
            <a href="booking_history.php">Back to Booking History</a>
        </div>
    </div>
</body>
</html>
