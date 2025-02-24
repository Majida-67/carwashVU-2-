<?php
include('db_connection2.php');

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="add_service_form.php">Add New Service</a>
    <table border="1">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Availability</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['duration']} minutes</td>
                        <td>" . ($row['availability'] ? 'Active' : 'Inactive') . "</td>
                        <td><img src='uploads/{$row['image']}' alt='Service Image' width='100'></td>
                        <td>
                            <a href='edit_service.php?id={$row['id']}'>Edit</a> | 
                            <a href='delete_service.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this service?');\">Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No services found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
