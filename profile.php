<?php
session_start();
include('config.php'); // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user_email'];

// Fetch user profile information
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #010c3e;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .profile-details {
            margin-bottom: 30px;
        }

        .profile-details p {
            margin: 5px 0;
            font-size: 18px;
        }

        .button {
            display: inline-block;
            background-color: #010c3e;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            margin: 10px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #5796cb;
        }

        .button-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .section-title {
            color: #010c3e;
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $user['name']; ?></h2>
        
        <div class="profile-details">
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Contact Details:</strong> <?php echo $user['contact_details']; ?></p>
        </div>

        <div class="button-row">
            <a href="edit_profile.php" class="button">Edit Profile</a>
            <!-- <a href="booking_history.php" class="button">View Booking History</a> -->
            <!-- <a href="create_booking.php" class="button">Create Booking</a> -->
            <a href="login.php" class="button">View Booking History</a>
        <a href="login.php" class="button">Create Booking</a>

        </div>
    </div>
</body>
</html>
