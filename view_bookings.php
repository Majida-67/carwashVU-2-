<?php
// Include the database connection file
include('db_connection3.php');

// Query to fetch all bookings
$query = "SELECT * FROM bookings";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch all the records from the database
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML to display the bookings -->
<h1>Manage Bookings</h1>

<?php if (count($bookings) > 0): ?>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Service</th>
            <th>Service Date</th>
            <th>Service Time</th>
            <th>Status</th>
        </tr>

        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?php echo htmlspecialchars($booking['name']); ?></td>
                <td><?php echo htmlspecialchars($booking['email']); ?></td>
                <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                <td><?php echo htmlspecialchars($booking['service']); ?></td>
                <td><?php echo htmlspecialchars($booking['service_date']); ?></td>
                <td><?php echo htmlspecialchars($booking['service_time']); ?></td>
                <td><?php echo htmlspecialchars($booking['status']); ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else: ?>
    <p>No bookings found.</p>
<?php endif; ?>
