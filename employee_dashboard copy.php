<?php
session_start();
include 'db2.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_Role.php");
    exit();
}

// Fetch employee details from session
$employee_id = $_SESSION['user_id'];

// Fetch employee name from database
$query = "SELECT name FROM users WHERE id = '$employee_id'";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $employee_name = $row['name'];
} else {
    $employee_name = "Employee"; // Default value if not found
}

// Fetch total bookings count
$total_bookings_query = "SELECT COUNT(*) AS total FROM customer_bookings WHERE user_id = '$employee_id'";
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, $total_bookings_query))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 70px; /* Space for fixed navbar */
        }
        .navbar {
            background-color: #0F766E;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .dashboard-container {
            text-align: center;
            padding: 40px 20px;
        }
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            margin: 50px auto;
        }
        .stat-box h3 {
            color: #0F766E;
        }
    </style>
</head>
<body>

<!-- Employee Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="employee_dashboard.php">CarWash Employee</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="login_Role.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="employee_bookings.php">View Bookings</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="dashboard-container">
    <h2 class="dashboard-header">Welcome, <?php echo $employee_name; ?>!</h2>
    
    <div class="stat-box">
        <h3>Total Bookings</h3>
        <p><?php echo $total_bookings; ?></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
