<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch only confirmed bookings for the logged-in user
$query = "SELECT name, service_date, service_time, service FROM customer_bookings WHERE user_id = ? AND status = 'Confirmed'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmed Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #010c3e;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #010c3e;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
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
        <h2>Confirmed Bookings</h2>

        <?php if ($bookings->num_rows > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Service Date</th>
                        <th>Service Time</th>
                        <th>Service</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $bookings->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_time']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p style="text-align:center;">No confirmed bookings found.</p>
        <?php } ?>

        <div class="back-link">
            <a href="employee_dashboard.php">Back to Profile</a>
        </div>
    </div>
</body>
</html>
