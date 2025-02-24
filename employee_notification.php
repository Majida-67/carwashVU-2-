<?php
session_start();
include 'db.php';

// Check if employee is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['user_id'];

// Fetch notifications for this employee
$query = "SELECT id, message, created_at, status FROM employee_notifications WHERE employee_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .notification { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .unread { background-color: #ffeeba; }
        .read { background-color: #d4edda; }
        .mark-read { background-color: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>My Notifications</h2>

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="notification <?php echo ($row['status'] == 'unread') ? 'unread' : 'read'; ?>">
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <small>Received on: <?php echo $row['created_at']; ?></small><br>
                <?php if ($row['status'] == 'unread') { ?>
                    <a href="mark_read.php?id=<?php echo $row['id']; ?>" class="mark-read">Mark as Read</a>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No notifications found.</p>
    <?php } ?>
</body>
</html>
