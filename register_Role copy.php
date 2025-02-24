

<?php
include 'db2.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='register_Role.php';</script>";
    } else {
        // Insert new user
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login_Role.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role-Based Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <label for="role">Select Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>
