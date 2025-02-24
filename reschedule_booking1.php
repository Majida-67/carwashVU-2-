<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];

    $query = "UPDATE customer_bookings SET service_date='$new_date', service_time='$new_time', status='Rescheduled' WHERE id=$id";
    mysqli_query($conn, $query);
    
    header("Location: view_booking.php");
}

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Booking</title>
</head>
<body>
    <h2>Reschedule Booking</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>New Date:</label>
        <input type="date" name="new_date" required>
        <label>New Time:</label>
        <input type="time" name="new_time" required>
        <button type="submit">Reschedule</button>
    </form>
</body>
</html>
