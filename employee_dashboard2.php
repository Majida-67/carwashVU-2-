<?php
session_start();
include 'db/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: login.php"); // Redirect if not logged in or not an employee
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current details of the user
$sql = "SELECT * FROM user_accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role']; // Fetch selected role from form

    // Check if a new password is entered
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $update_sql = "UPDATE user_accounts SET name = ?, email = ?, role = ?, password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $name, $email, $role, $password, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $update_stmt->error . "');</script>";
    }
    $update_stmt->close();

    // Refresh the user data after update
    $sql = "SELECT * FROM user_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>
