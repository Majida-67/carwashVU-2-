
<?php
include 'db/db.config.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM employees_admins WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: user_list.php?success=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    echo "Trying to delete ID: " . htmlspecialchars($id); // Debugging Output
    exit(); // Stop further execution to check output
}











// Update User
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $conn->query("UPDATE employees_admins SET name='$name', email='$email', role='$role' WHERE id=$id");
    header("Location: user_list.php");
    exit();
}
?>
