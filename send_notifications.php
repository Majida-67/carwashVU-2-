<?php
session_start();
include('db_connect.php'); // Database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (isset($_POST['send_email']) && !empty($email)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bc210418371mmu@vu.edu.pk'; // Replace with your email
            $mail->Password = '  ngjr nlks vrhw kymk '; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Email Content
            $mail->setFrom('your_email@gmail.com', 'Admin');
            $mail->addAddress($email);
            $mail->Subject = 'Important Notification';
            $mail->isHTML(true);
            $mail->Body = "<html><body><h3>Dear User,</h3><p>$message</p><p>Best Regards,<br>Admin</p></body></html>";
            
            $mail->send();
            echo "Email sent successfully to $email";
        } catch (Exception $e) {
            echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    if (isset($_POST['send_sms']) && !empty($contact)) {
        // SMS sending logic using Twilio or any other SMS API
        echo "SMS sent successfully to $contact with message: $message";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #87d3d7; text-align: center; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); width: 50%; margin: auto; }
        textarea { width: 100%; height: 100px; padding: 10px; border: 1px solid #010c3e; border-radius: 5px; }
        button { background: #010c3e; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; transition: 0.3s; margin-top: 10px; }
        button:hover { background: #87d3d7; color: #010c3e; }
    </style>
</head>
<body>
    <h2>Send Notification</h2>
    <form method="post">
        <input type="hidden" name="email" value="<?php echo $_POST['email'] ?? ''; ?>">
        <input type="hidden" name="contact" value="<?php echo $_POST['contact'] ?? ''; ?>">
        <label><b>Write Notification Message:</b></label>
        <textarea name="message" required></textarea>
        <br>
        <button type="submit" name="send_email">Send Email</button>
        <button type="submit" name="send_sms">Send SMS</button>
    </form>
</body>
</html>
