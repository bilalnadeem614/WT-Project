<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure you load PHPMailer

function sendEmailsToSubscribers($postTitle, $postLink)
{
    // Database connection
    include "../config.php";

    // Fetch all subscriber emails
    $subscriberQuery = "SELECT email FROM subscribers";
    $result = mysqli_query($conn, $subscriberQuery);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $email = $row['email'];

            // Initialize PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Use Gmail SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com'; // Your email
                $mail->Password = 'your-password'; // App password for Gmail
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('your-email@gmail.com', 'Your Website Name');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'New Post Published!';
                $mail->Body = "
                    <h3>New Post Alert: $postTitle</h3>
                    <p>Check it out here: <a href='$postLink'>$postTitle</a></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email to $email failed: {$mail->ErrorInfo}");
            }
        }
    }
}
?>