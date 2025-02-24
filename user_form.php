<?php
include 'db/db.config.php';

// Handle User Submission (Create/Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE employees_admins SET name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO employees_admins (name, email, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $role);
    }
    
    if ($stmt->execute()) {
        header("Location: user_list.php");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Handle Deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM employees_admins WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: user_list.php");
    exit();
}
?>

<!-- User Form Page -->
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-3">User Management</h2>
    <form method="POST" class="p-4 border rounded shadow">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="user_list.php" class="btn btn-secondary">View Users</a>
    </form>
</body>
</html>
