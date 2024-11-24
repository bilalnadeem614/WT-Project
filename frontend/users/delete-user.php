<?php
include "../config.php";
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/users/post.php");
}
$userid = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = {$userid}";

if (mysqli_query($conn, $sql)) {
    header("Location: {$hostname}/users/users.php");
} else {
    echo "<p class='text-red-500 my-2'>Can't Delete the User Record.</p>";
}

mysqli_close($conn);
?>