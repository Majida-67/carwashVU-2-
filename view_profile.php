<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $update_sql = "UPDATE clients SET name='$name', address='$address', contact='$contact' WHERE email='$email'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='view_profile.php?email=$email';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM clients WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View & Edit Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .container {
                background: white;
                padding: 25px;
                width: 400px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                text-align: center;
            }
            h2 {
                color: #010c3e;
                margin-bottom: 15px;
            }
            .profile-icon {
                font-size: 80px;
                color: #010c3e;
                margin-bottom: 10px;
            }
            .input-group {
                text-align: left;
                margin-bottom: 15px;
            }
            .input-group label {
                display: block;
                font-weight: bold;
                color: #010c3e;
                margin-bottom: 5px;
            }
            .input-group input {
                width: 100%;
                padding: 10px;
                border: 1px solid #010c3e;
                border-radius: 5px;
                font-size: 14px;
            }
            .btn {
                background: #010c3e;
                color: white;
                padding: 12px;
                width: 100%;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 10px;
                transition: background 0.3s;
            }
            .btn:hover {
                background: #0a1b6a;
            }
            .back-btn {
                background:rgba(17, 179, 207, 0.68);
            }
            .back-btn:hover {
                background:rgb(169, 205, 233);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <i class="fa fa-user-circle profile-icon"></i>
            <h2><?php echo $row['name']; ?></h2>
            <form method="post">
                <div class="input-group">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                </div>
                <div class="input-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" disabled>
                </div>
                <div class="input-group">
                    <label>Address:</label>
                    <input type="text" name="address" value="<?php echo $row['address']; ?>">
                </div>
                <div class="input-group">
                    <label>Contact:</label>
                    <input type="text" name="contact" value="<?php echo $row['contact']; ?>">
                </div>
                <input type="submit" class="btn" value="Update Profile">
            </form>
            <a href="create_profile.php"><button class="btn back-btn">Back</button></a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Profile not found!";
}

$conn->close();
?>