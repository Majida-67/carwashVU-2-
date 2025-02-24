<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM customer_bookings");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #010c3e;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status {
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .status-pending {
            color: #ffc107;
        }

        .status-confirmed {
            color: #28a745;
        }

        .status-cancelled {
            color: #dc3545;
        }

        .status-rescheduled {
            color: #007bff;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .approve-btn {
            background-color: #28a745;
        }

        .cancel-btn {
            background-color: #dc3545;
        }

        .reschedule-btn {
            background-color: #ffc107;
            color: black;
        }

        .delete-btn {
            background-color: #6c757d;
        }

        .history-btn {
            background-color: #007bff;
        }
    </style>
    <script>
        function deleteBooking(id) {
            if (confirm('Are you sure you want to delete this booking?')) {
                fetch('delete_booking1.php?id=' + id, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            document.getElementById('row-' + id).remove();
                        } else {
                            alert('Failed to delete booking.');
                        }
                    });
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Customer Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr id="row-<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['user_email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['service']; ?></td>
                        <td><?php echo $row['service_date']; ?></td>
                        <td><?php echo $row['service_time']; ?></td>
                        <td>
                            <?php 
                                // Status display logic
                                $statusText = ($row['status'] == 'Confirmed') ? 'Confirmed' : 'Pending';
                                $statusClass = ($row['status'] == 'Confirmed') ? 'status-confirmed' : 'status-pending';
                            ?>
                            <span class="status <?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="approve_booking1.php?id=<?php echo $row['id']; ?>" class="btn approve-btn">Confirm</a>
                                <a href="reschedule_booking1.php?id=<?php echo $row['id']; ?>" class="btn reschedule-btn">Reschedule</a>
                                <a href="cancel_booking1.php?id=<?php echo $row['id']; ?>" class="btn cancel-btn">Cancel</a>
                                <a href="track_booking.php" class="btn history-btn">History</a>
                                <button onclick="deleteBooking(<?php echo $row['id']; ?>)" class="btn delete-btn">Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
