<?php
include 'db_connection2.php';

$sql = "SELECT * FROM admin_services";
$result = mysqli_query($conn, $sql);

echo "<table>";
echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Duration</th><th>Availability</th><th>Actions</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['price']}</td>
            <td>{$row['duration']} mins</td>
            <td>" . ($row['availability'] ? "Active" : "Inactive") . "</td>
            <td>
                <a href='edit_service.php?id={$row['id']}'>Edit</a> | 
                <a href='delete_service.php?id={$row['id']}'>Delete</a>
            </td>
          </tr>";
}
echo "</table>";
?>
