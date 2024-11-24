<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <?php include "./header.php"; ?>

    <div id="admin-content" class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center mb-6">
                <div class="w-full md:w-8/12 lg:w-10/12 mb-4 md:mb-0">
                    <h1 class="admin-heading text-2xl md:text-3xl font-bold text-gray-800">All Posts</h1>
                </div>
                <div class="w-full md:w-4/12 lg:w-2/12 text-right">
                    <a class="add-new bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 block md:inline-block text-center" href="add-post.php">
                        Add Post
                    </a>
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

                if ($_SESSION["user_role"] == '1') {
                    /* select query of post table for admin user */
                    $sql = "SELECT post.post_id, post.title, post.description, post.post_date,
                    category.category_name, user.username, post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
                } elseif ($_SESSION["user_role"] == '0') {
                    /* select query of post table for normal user */
                    $sql = "SELECT post.post_id, post.title, post.description, post.post_date,
                    category.category_name, user.username, post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE post.author = {$_SESSION['user_id']}
                    ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
                }

                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">S.No.</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Title</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Category</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Date</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Author</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Edit</th>
                                <th class="py-3 px-2 md:px-6 text-center whitespace-nowrap">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="border-b text-center">
                                    <td class="py-3 px-2 md:px-6"><?php echo $serial; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['title']; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['category_name']; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['post_date']; ?></td>
                                    <td class="py-3 px-2 md:px-6"><?php echo $row['username']; ?></td>
                                    <td class="py-3 px-2 md:px-6 text-center">
                                        <a href='update-post.php?id=<?php echo $row['post_id']; ?>' class='text-blue-500 hover:underline'>
                                            <i class='fa fa-edit'></i>
                                        </a>
                                    </td>
                                    <td class="py-3 px-2 md:px-6 text-center">
                                        <a href='delete-post.php?id=<?php echo $row['post_id']; ?>&catid=<?php echo $row['category']; ?>' class='text-red-500 hover:underline'>
                                            <i class="fa fa-trash"></i>
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

                // show pagination
                if ($_SESSION["user_role"] == '1') {
                    /* select query of post table for admin user */
                    $sql1 = "SELECT * FROM post";
                } elseif ($_SESSION["user_role"] == '0') {
                    /* select query of post table for normal user */
                    $sql1 = "SELECT * FROM post WHERE author = {$_SESSION['user_id']}";
                }
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if (mysqli_num_rows($result1) > 0) {

                    $total_records = mysqli_num_rows($result1);

                    $total_page = ceil($total_records / $limit);

                    echo '<ul class="pagination flex flex-wrap justify-center mt-6 space-x-2">';
                    if ($page > 1) {
                        echo '<li><a href="post.php?page=' . ($page - 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $page) {
                            $active = "bg-blue-500 text-white";
                        } else {
                            $active = "bg-gray-200";
                        }
                        echo '<li><a href="post.php?page=' . $i . '" class="py-2 px-4 rounded ' . $active . ' hover:bg-blue-500 hover:text-white">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        echo '<li><a href="post.php?page=' . ($page + 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Next</a></li>';
                    }

                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>