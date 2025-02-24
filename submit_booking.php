<?php
// Database connection
include('db_connection3.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming form fields are sent via POST method
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $service_date = $_POST['service_date'];
    $service_time = $_POST['service_time'];

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, service, service_date, service_time, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $email, $phone, $service, $service_date, $service_time]);

    // Redirect to confirmation page with success message
    header("Location: confirmation.php");

    exit;
}
?>
