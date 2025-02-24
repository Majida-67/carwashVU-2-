<?php
session_start();
include('config.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $contact_details = $_POST['contact_details'];

    // Check for duplicate email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Use valid Email Address .";
    } else {
        // Insert user data into the users table
        $sql = "INSERT INTO users (email, password, name, contact_details, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $email, $password, $name, $contact_details);
        $stmt->execute();

        // Redirect to login page or profile page
        $_SESSION['user_email'] = $email; // Store email in session
        header('Location: profile.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #87d3d7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #010c3e;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #fff;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            color: #fff;
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            background-color: #87d3d7;
            color: #010c3e;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #76c3c4;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <label>Name:</label>
            <input type="text" name="name" required><br>

            <label>Contact Details:</label>
            <input type="text" name="contact_details" required><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
