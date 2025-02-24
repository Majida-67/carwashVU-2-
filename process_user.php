<?php
include 'db/db_connection.php';

// Add User
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, role) VALUES ('$name', '$email', '$role')";
    if ($conn->query($sql) === TRUE) {
        header("Location: user_management.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id='$id'";
    $conn->query($sql);
    header("Location: user_management.php");
    exit();
}

// Edit User
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id='$id'");
    $row = $result->fetch_assoc();
    ?>
    <form action="process_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <select name="role">
            <option value="Admin" <?php if ($row['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="Employee" <?php if ($row['role'] == 'Employee') echo 'selected'; ?>>Employee</option>
        </select>
        <button type="submit" name="update_user">Update</button>
    </form>
    <?php
}

// Update User
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'";
    $conn->query($sql);
    header("Location: user_management.php");
    exit();
}

$conn->close();
?>
