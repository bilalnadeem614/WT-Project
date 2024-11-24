<?php
include '../config.php';
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/users/post.php");
}
$cat_id = $_GET["id"];

/*sql to delete a record*/
$sql = "DELETE FROM category WHERE category_id ='{$cat_id}'";

if (mysqli_query($conn, $sql)) {
    header("location:{$hostname}/users/category.php");
}

mysqli_close($conn);
?>