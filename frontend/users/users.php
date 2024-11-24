<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <?php include "./header.php";
    if ($_SESSION["user_role"] == '0') {
        header("Location: {$hostname}/admin/post.php");
    }
    ?>
    <div id="admin-content" class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center mb-6">
                <div class="w-full md:w-10/12">
                    <h1 class="admin-heading text-2xl md:text-3xl font-bold text-gray-800">All Users</h1>
                </div>
                <div class="w-full md:w-2/12 text-right">
                    <a class="add-new bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 block md:inline-block text-center" href="add-user.php">Add User</a>
                </div>
            </div>
            <div class="w-full overflow-x-auto lg:overflow-visible">
                <?php
                include "../config.php"; // database configuration
                /* Calculate Offset Code */
                $limit = 3;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $limit;

                /* Select query of user table with offset and limit */
                $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
                $result = mysqli_query($conn, $sql) or die("Query Failed.");

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">S.No.</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Full Name</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">User Name</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Role</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Edit</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr class="border-b text-center">
                                    <td class="py-3 px-2 md:px-6"><?php echo $serial; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['username']; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo ($row['role'] == 1) ? "Admin" : "Normal"; ?></td>
                                    <td class="py-3 px-2 md:px-6 text-center">
                                        <a href='update-user.php?id=<?php echo $row["user_id"]; ?>' class='text-blue-500 hover:underline'>
                                            <i class='fa fa-edit'></i>
                                        </a>
                                    </td>
                                    <td class="py-3 px-2 md:px-6 text-center">
                                        <a href='delete-user.php?id=<?php echo $row["user_id"]; ?>' class='text-red-500 hover:underline'>
                                            <i class='fa fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $serial++;
                            } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "<h3 class='text-center text-red-500 font-bold mt-6'>No Results Found.</h3>";
                }

                // Pagination
                $sql1 = "SELECT * FROM user";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);
                    $total_page = ceil($total_records / $limit);

                    echo '<ul class="pagination flex justify-center mt-6 space-x-2">';
                    if ($page > 1) {
                        echo '<li><a href="users.php?page=' . ($page - 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        $cls = ($i == $page) ? 'bg-blue-500 text-white' : 'bg-gray-200';
                        echo '<li><a href="users.php?page=' . $i . '" class="py-2 px-4 rounded ' . $cls . ' hover:bg-blue-500 hover:text-white">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        echo '<li><a href="users.php?page=' . ($page + 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Next</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>