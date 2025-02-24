<?php
session_start(); // Start the session

// Check if the user is logged in and has a valid role
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

include 'db/connection.php';

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT * FROM user_accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user is found in the database
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch the user data as an associative array
} else {
    die("User not found!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>

    <h2>Edit User</h2>
    <form action="edit_user.php" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?php echo isset($user) ? $user['name'] : ''; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($user) ? $user['email'] : ''; ?>" required><br>

        <label for="role">Role:</label>
        <select name="role">
            <option value="employee" <?php echo (isset($user) && $user['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
            <option value="admin" <?php echo (isset($user) && $user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select><br>

        <button type="submit">Save Changes</button>
    </form>

</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user data is available
    if (isset($user)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Update user data in the database
        $update_sql = "UPDATE user_accounts SET name = ?, email = ?, role = ?, password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $name, $email, $role, $password, $user_id);

        if ($update_stmt->execute()) {
            echo "User updated successfully!";
        } else {
            echo "Error: " . $update_stmt->error;
        }
    } else {
        echo "User data is not available!";
    }
}
?>