<?php
// PHPMailer files ko include karein
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $service_date = htmlspecialchars($_POST['service_date']);
    $service_time = htmlspecialchars($_POST['service_time']);

    // PHPMailer ka object banaiye
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bc210418371mmu@vu.edu.pk'; // Gmail address
        $mail->Password = ' ngjr nlks vrhw kymk ';   // App password (not regular Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('your-email@gmail.com', 'Car Wash Service');
        $mail->addAddress($email, $name); // Client ka email aur naam
        $mail->Subject = 'Car Wash Booking Confirmation';
        $mail->Body = "
            Dear $name,

            Thank you for booking your car wash service with us.

            Booking Details:
            - Service Date: $service_date
            - Service Time: $service_time

            We look forward to serving you.

            Regards,
            Car Wash Team
        ";

        // Email bhejiye
        $mail->send();

        // Success page par redirect karein
        header("Location: receive_mail_success.php");
        exit();
    } catch (Exception $e) {
        echo "Booking successful, but email couldn't be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
