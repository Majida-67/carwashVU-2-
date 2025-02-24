<?php
session_start();
require 'vendor/autoload.php'; // Twilio SDK Install Karne Ke Baad

use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact = $_POST['contact'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($contact) && !empty($message)) {
        $sid = 'YOUR_TWILIO_SID'; // Twilio Account SID
        $token = 'YOUR_TWILIO_AUTH_TOKEN'; // Twilio Auth Token
        $twilio_number = "+1234567890"; // Twilio Ke Issued Number

        try {
            $client = new Client($sid, $token);
            $client->messages->create(
                $contact, // Receiver's Number (e.g., +923001234567 for Pakistan)
                [
                    'from' => $twilio_number,
                    'body' => $message
                ]
            );

            echo "SMS Sent Successfully to $contact!";
        } catch (Exception $e) {
            echo "Failed to send SMS. Error: " . $e->getMessage();
        }
    } else {
        echo "Please provide a valid phone number and message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS Notification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #87d3d7; text-align: center; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); width: 50%; margin: auto; }
        textarea { width: 100%; height: 100px; padding: 10px; border: 1px solid #010c3e; border-radius: 5px; }
        button { background: #010c3e; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; transition: 0.3s; margin-top: 10px; }
        button:hover { background: #87d3d7; color: #010c3e; }
    </style>
</head>
<body>
    <h2>Send SMS Notification</h2>
    <form method="post">
        <input type="text" name="contact" placeholder="Enter phone number (e.g., +923001234567)" required>
        <label><b>Write SMS Message:</b></label>
        <textarea name="message" required></textarea>
        <br>
        <button type="submit">Send SMS</button>
    </form>
</body>
</html>
