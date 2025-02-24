<?php
include('db_connection3.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $new_date = $_POST['service_date'];
    $new_time = $_POST['service_time'];

    $query = "UPDATE bookings SET service_date = ?, service_time = ?, status = 'Rescheduled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$new_date, $new_time, $id]);

    header("Location: admin_dashboard.php");
    exit;
} else {
    $id = $_GET['id'];
    $query = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff; /* Blue border on focus */
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3); /* Soft blue shadow */
        }

        .form-actions {
            display: flex;
            justify-content: center;
        }

        .form-actions button {
            background-color: #007bff; /* Blue button */
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .form-actions button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .form-actions button:active {
            background-color: #004085;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-actions button {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Reschedule Booking</h2>
        <form method="POST" action="reschedule_booking.php">
            <input type="hidden" name="id" value="<?= $booking['id'] ?>">
            <div class="form-group">
                <label for="service_date">New Date:</label>
                <input type="date" id="service_date" name="service_date" required>
            </div>
            <div class="form-group">
                <label for="service_time">New Time:</label>
                <input type="time" id="service_time" name="service_time" required>
            </div>
            <div class="form-actions">
                <button type="submit">Reschedule</button>
            </div>
        </form>
    </div>
</body>

</html>
