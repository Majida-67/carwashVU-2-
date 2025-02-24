<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch employee data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    if ($stmt->execute([$name, $email, $user_id])) {
        $_SESSION['user_name'] = $name;
        echo "<script>alert('Profile updated successfully!'); window.location.href='employee_Profile.php';</script>";
    } else {
        echo "<script>alert('Profile update failed. Try again.');</script>";
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_Role.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        .profile-container { 
            width: 40%; 
            margin: 50px auto; 
            padding: 30px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 { margin-bottom: 20px; }
        .input-group { 
            margin: 15px 0; 
            text-align: left;
        }
        label { font-weight: bold; display: block; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .button-group {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        button {
            padding: 10px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .update-btn { background-color: #010c3e; color: white; }
        .update-btn:hover { background-color: #2980b9; }
        .logout-btn { background: red; color: white; }
        .logout-btn:hover { background: darkred; }
        .back-btn { background: #555; color: white; }
        .back-btn:hover { background: #333; }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Employee Profile</h2>
    <form method="POST">
        <div class="input-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="button-group">
            <button type="submit" name="update_profile" class="update-btn">Update</button>
            <a href="employee_Profile.php?logout=true"><button type="button" class="logout-btn">Logout</button></a>
            <a href="employee_dashboard.php"><button type="button" class="back-btn">Employee Dashboard</button></a>
        </div>
    </form>
</div>

</body>
</html>
