<?php
include 'db/db.config.php';

$result = $conn->query("SELECT * FROM employees_admins");
$totalUsers = $result->num_rows;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Check if the ID exists
    $check = $conn->query("SELECT * FROM employees_admins WHERE id = $id");
    if ($check->num_rows == 0) {
        die("User ID does not exist!");
    }

    $stmt = $conn->prepare("DELETE FROM employees_admins WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: user_list.php?success=deleted");
        exit();
    } else {
        die("Error deleting record: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 20px; }
        .container { width: 80%; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        .btn { padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .edit-btn { background: #28a745; color: white; }
        .edit-btn:hover { background: #218838; }
        .delete-btn { background: #dc3545; color: white; }
        .delete-btn:hover { background: #c82333; }
        .add-btn { background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block; margin-bottom: 15px; }
        .add-btn:hover { background: #0056b3; }
        .edit-form { display: none; padding: 20px; background: #f2f2f2; margin-top: 20px; border-radius: 8px; }
        h2 { color: #343a40; }
        .cancel-btn { background: #6c757d; color: white; }
        .cancel-btn:hover { background: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Total Users: <?php echo $totalUsers; ?></h2>

        <!-- Add User Button -->
        <a href="user_form.php" class="btn add-btn">+ Add User</a>

        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php $counter = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <button class="btn edit-btn" onclick="editUser(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['role']; ?>')">Edit</button>
                    <a href="user_list.php?delete=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <!-- Edit Form -->
        <div class="edit-form" id="editForm">
            <h3>Edit User</h3>
            <form method="POST" action="user_management.php">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="name" id="edit_name" placeholder="Name" required>
                <input type="email" name="email" id="edit_email" placeholder="Email" required>
                <select name="role" id="edit_role" required>
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                </select>
                <button type="submit" class="btn edit-btn">Update</button>
                <button type="button" class="btn cancel-btn" onclick="document.getElementById('editForm').style.display='none'">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function editUser(id, name, email, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
