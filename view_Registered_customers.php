<?php
session_start();
include('db_connect.php'); // Database connection file

// Fetch all registered users
$query = "SELECT id, name, email, contact_details FROM add_users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #87d3d7;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #010c3e;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #010c3e;
            text-align: center;
        }
        th {
            background: #010c3e;
            color: white;
        }
        td {
            background: #f0f8ff;
        }
        button {
            background: #010c3e;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
            margin:5px 5px ;
        }
        button:hover {
            background: #87d3d7;
            color: #010c3e;
        }
    </style>
</head>
<body>
    <h2>Registered Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact_details']; ?></td>
            <td>
                <form method="post" action="send_notifications.php">
                    <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                    <input type="hidden" name="contact" value="<?php echo $row['contact_details']; ?>">
                    <button type="submit" name="send_email">Send Email</button>
                    <button type="submit" name="send_sms">Send SMS</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
