<?php include "header.php";
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/users/post.php");
}
if (isset($_POST['save'])) {
    include "config.php";

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "SELECT username FROM user WHERE username = '{$user}'";

    $result = mysqli_query($conn, $sql) or die("Query Failed.");

    if (mysqli_num_rows($result) > 0) {
        echo "<p class='text-red-500 text-center mt-4'>UserName already exists.</p>";
    } else {
        $sql1 = "INSERT INTO user (first_name, last_name, username, password, role)
              VALUES ('{$fname}', '{$lname}', '{$user}', '{$password}', '{$role}')";
        if (mysqli_query($conn, $sql1)) {
            header("Location: {$hostname}/admin/users.php");
        } else {
            echo "<p class='text-red-500 text-center mt-4'>Can't Insert User.</p>";
        }
    }
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

<body>
    <div id="admin-content" class="py-8 bg-gray-100">
        <div class="container mx-auto">
            <div class="flex flex-wrap mb-6">
                <div class="w-full">
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Add User</h1>
                </div>
                <div class="w-full md:w-6/12 mx-auto">
                    <!-- Form Start -->
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" class="bg-white p-8 shadow-md rounded-lg">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">First Name</label>
                            <input type="text" name="fname" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="First Name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Last Name</label>
                            <input type="text" name="lname" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Last Name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">User Name</label>
                            <input type="text" name="user" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Username" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Password</label>
                            <input type="password" name="password" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Password" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">User Role</label>
                            <select name="role" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="0">Normal User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <input type="submit" name="save" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Save">
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->
</body>

</html>