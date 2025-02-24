<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking details
$query = "SELECT id, name, user_email, service, service_date, service_time, total_price, discount, status FROM customer_bookings WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "<p style='color:red; text-align:center;'>Invalid or Unauthorized Access.</p>";
    exit();
}

$final_price = $booking['total_price'] - ($booking['total_price'] * ($booking['discount'] / 100));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            width: 60%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #010c3e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #010c3e;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #010c3e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h2>Booking Receipt</h2>
        <table>
            <tr>
                <th>Service</th>
                <td><?php echo htmlspecialchars($booking['service']); ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($booking['name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($booking['user_email']); ?></td>
            </tr>
            <tr>
                <th>Service Date</th>
                <td><?php echo htmlspecialchars($booking['service_date']); ?></td>
            </tr>
            <tr>
                <th>Service Time</th>
                <td><?php echo htmlspecialchars($booking['service_time']); ?></td>
            </tr>
            <tr>
                <th>Original Price</th>
                <td>$<?php echo number_format($booking['total_price'], 2); ?></td>
            </tr>
            <tr>
                <th>Discount</th>
                <td><?php echo $booking['discount'] > 0 ? $booking['discount'] . '% Off' : 'No Discount'; ?></td>
            </tr>
            <tr>
                <th>Final Price</th>
                <td>$<?php echo number_format($final_price, 2); ?></td>
            </tr>
        </table>
        <button class="btn" onclick="window.print()">Print Receipt</button>
        <a href="booking_history.php" class="btn" style="text-decoration:none; display:inline-block;">Back</a>
    </div>
</body>
</html>
