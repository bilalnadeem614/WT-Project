<?php
session_start();
include "./config.php";

if (isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];

    $check_sql = "SELECT * FROM saved_posts WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delete_sql = "DELETE FROM saved_posts WHERE user_id = ? AND post_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
    } else {
        $insert_sql = "INSERT INTO saved_posts (user_id, post_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
    }

    header("Location: index.php");
} else {
    header("Location: login.php");
}
?>