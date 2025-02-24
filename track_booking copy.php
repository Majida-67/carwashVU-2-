<?php
include 'db.php';
$user_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM customer_bookings WHERE user_id=$user_id");
?>

<h2>Booking History</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Service</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['service']; ?></td>
            <td><?php echo $row['service_date']; ?></td>
            <td><?php echo $row['service_time']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php } ?>
</table>
