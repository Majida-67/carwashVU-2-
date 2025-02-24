<?php
include 'db_connect.php';

// Fetch notification count (Example: low-stock items, pending bookings, etc.)
$notif_query = "SELECT COUNT(*) AS notif_count FROM notifications WHERE status = 'unread'";
$notif_result = mysqli_query($conn, $notif_query);
$notif_row = mysqli_fetch_assoc($notif_result);
$notif_count = $notif_row['notif_count'];
?>

<div class="navbar">
    <!-- Logo -->
    <div class="logo">
        <a href="HomeService.php">CARWASH</a>
    </div>

    <!-- Menu (Links) -->
    <ul class="menu">
        <li><a href="HomeService.php" class="nav-link">Home</a></li>
        <li><a href="login_Role.php" class="nav-link">Profile</a></li>
        <li><a href="admin_Dashboard.php" class="nav-link">Dashboard</a></li>
        <li><a href="admin_add_service.php" class="nav-link">Add Services</a></li>
        <li><a href="admin_add_package.php" class="nav-link">Add Packages</a></li>
        <li><a href="user_form.php" class="nav-link">Add Users</a></li>
    </ul>

    <!-- Notification Bell -->
    <a href="alert_notifications.php" class="notification">
        <i class="fas fa-bell"></i>
        <?php if ($notif_count > 0) { ?>
            <span class="badge"><?php echo $notif_count; ?></span>
        <?php } ?>
    </a>

    <!-- Admin Icon -->
    <div class="admin-icon" onclick="toggleAdminMenu()">
        <i class="fas fa-user-shield"></i>
    </div>

    <!-- Hamburger Icon (for mobile) -->
    <div class="hamburger" onclick="toggleSidebar()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<style>
    .notification {
        position: relative;
        display: inline-block;
        font-size: 24px;
        color: white;
        cursor: pointer;
    }

    .notification .badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 14px;
        font-weight: bold;
    }

    .notification i {
        font-size: 22px;
        margin-right: 10px;
    }
</style>
