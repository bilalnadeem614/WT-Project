<?php
include "../config.php";
session_start();

if (isset($_SESSION["username"])) {
    header("Location: {$hostname}/users/post.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div id="wrapper-admin" class="body-content h-screen flex justify-center items-center">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="text-center mb-6">
                        <img class="mx-auto w-20 h-20" src="images/news.jpg" alt="Logo">
                        <h3 class="heading text-3xl font-bold text-gray-800 mt-4">Admin</h3>
                    </div>
                    <!-- Form Start -->
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="bg-white p-8 shadow-md rounded-lg">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input type="text" name="username" class="form-control block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" class="form-control block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="" required>
                        </div>
                        <input type="submit" name="login" class="btn bg-blue-500 text-white font-bold py-2 px-4 rounded w-full hover:bg-blue-600" value="Login" />
                    </form>
                    <!-- /Form  End -->
                    <?php
                    if (isset($_POST['login'])) {
                        include "config.php";
                        if (empty($_POST['username']) || empty($_POST['password'])) {
                            echo '<div class="bg-red-500 text-white text-center p-4 mt-4 rounded">All Fields must be entered.</div>';
                            die();
                        } else {
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $password = md5($_POST['password']);

                            $sql = "SELECT user_id, username, role FROM user WHERE username = '{$username}' AND password= '{$password}'";

                            $result = mysqli_query($conn, $sql) or die("Query Failed.");

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    session_start();
                                    $_SESSION["username"] = $row['username'];
                                    $_SESSION["user_id"] = $row['user_id'];
                                    $_SESSION["user_role"] = $row['role'];

                                    header("Location: {$hostname}/users/post.php");
                                }
                            } else {
                                echo '<div class="bg-red-500 text-white text-center p-4 mt-4 rounded">Username and Password are not matched.</div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>