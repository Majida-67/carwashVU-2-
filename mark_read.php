<?php
include 'db.php';

if (isset($_GET['id'])) {
    $notification_id = $_GET['id'];
    $query = "UPDATE employee_notifications SET status = 'read' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notification_id);
    if ($stmt->execute()) {
        header("Location: employee_notification.php");
    } else {
        echo "Error updating notification.";
    }
}
?>
