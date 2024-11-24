<?php
include "./config.php";
if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $role = 0;  // Normal user role

    // Check if username already exists
    $sql = "SELECT username FROM user WHERE username = '{$username}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $sql1 = "INSERT INTO user (first_name, last_name, username, password, role)
                 VALUES ('{$fname}', '{$lname}', '{$username}', '{$password}', '{$role}')";

        if (mysqli_query($conn, $sql1)) {
            header("Location: login.php");
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 shadow-md rounded-lg w-full max-w-md">
            <a href="./index.php" id="logo"><img class="mx-auto w-20 h-20" src="./users/imgs/logo.png" alt="Logo"></a>
            <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Create Account</h2>

            <?php if (isset($error)) { ?>
                <div class="bg-red-500 text-white text-center p-4 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">First Name</label>
                    <input type="text" name="fname" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="First Name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Last Name</label>
                    <input type="text" name="lname" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Last Name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Username</label>
                    <input type="text" name="username" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Username" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Password" required>
                </div>
                <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded w-full hover:bg-blue-600 cursor-pointer" value="Sign Up">
            </form>

            <p class="text-center text-gray-600 mt-4">
                Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Log in</a>
            </p>
        </div>
    </div>
</body>

</html>