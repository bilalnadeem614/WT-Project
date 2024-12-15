<!-- Incomplete :( -->

<?php
session_start();
include "./config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['subscriber_email']);

    
    $check_query = "SELECT email FROM newsletter_subscribers WHERE email = '{$email}'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['msg'] = "You are already subscribed!";
    } else {
        // Insert new subscriber
        $insert_query = "INSERT INTO newsletter_subscribers (email) VALUES ('{$email}')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['msg'] = "Thank you for subscribing!";
        } else {
            $_SESSION['msg'] = "Subscription failed. Try again!";
        }
    }

    // Redirect back to the page
    header("Location: {$hostname}/index.php");
    exit();
}
?>