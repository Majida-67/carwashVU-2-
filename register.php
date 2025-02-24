<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim(strtolower($_POST['email'])); // Convert email to lowercase
    $contact_details = trim($_POST['contact_details']);
    $password = trim($_POST['password']);

    // Check if email already exists
    $checkQuery = "SELECT * FROM add_users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color:red;'>Error: Email already registered!</p>";
    } else {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $query = "INSERT INTO add_users (name, email, contact_details, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $contact_details, $hashed_password);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration successful! Redirecting to login...</p>";
            header("refresh:2; url=login.php"); // Redirect to login page
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding: 50px; }
        form { background: white; padding: 20px; display: inline-block; border-radius: 8px; box-shadow: 0px 0px 10px 0px #aaa; }
        input { display: block; margin: 10px auto; padding: 10px; width: 80%; }
        button { background: blue; color: white; padding: 10px; width: 80%; border: none; cursor: pointer; }
        button:hover { background: darkblue; }
    </style>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contact_details" placeholder="Contact Details" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
