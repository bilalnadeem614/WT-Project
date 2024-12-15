<?php
include "../config.php";
session_start();

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM saved_posts WHERE post_id = {$post_id} AND user_id = {$user_id}";
    if (mysqli_query($conn, $sql)) {
        header("Location: bookmark.php");
    } else {
        echo "Error: Unable to remove bookmark.";
    }
} else {
    header("Location: bookmark.php");
}
?>