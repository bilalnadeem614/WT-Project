<?php include "./header.php";
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/users/post.php");
}
if (isset($_POST['submit'])) {
    include "../config.php";

    $userid = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['l_name']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$user}', role = '{$role}' WHERE user_id = {$userid}";

    if (mysqli_query($conn, $sql)) {
        header("Location: {$hostname}/users/users.php");
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
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Modify User Details</h1>
                </div>
                <div class="w-full md:w-4/12 mx-auto">
                    <?php
                    include "../config.php";
                    $user_id = $_GET['id'];
                    $sql = "SELECT * FROM user WHERE user_id = {$user_id}";
                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <!-- Form Start -->
                            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="bg-white p-8 shadow-md rounded-lg">
                                <input type="hidden" name="user_id" class="block w-full p-2 border border-gray-300 rounded" value="<?php echo $row['user_id']; ?>">

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">First Name</label>
                                    <input type="text" name="f_name" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo $row['first_name']; ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Last Name</label>
                                    <input type="text" name="l_name" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo $row['last_name']; ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">User Name</label>
                                    <input type="text" name="username" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo $row['username']; ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">User Role</label>
                                    <select name="role" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <?php
                                        if ($row['role'] == 1) {
                                            echo "<option value='0'>Normal User</option>
                                      <option value='1' selected>Admin</option>";
                                        } else {
                                            echo "<option value='0' selected>Normal User</option>
                                      <option value='1'>Admin</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Update">
                            </form>
                            <!-- /Form -->
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->

</body>

</html>