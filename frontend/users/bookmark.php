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
                    <h1 class="admin-heading text-2xl md:text-3xl font-bold text-gray-800">Saved Bookmarks</h1>
                </div>
            </div>

            <div class="w-full overflow-x-auto lg:overflow-visible">
                <?php
                include "../config.php"; // database configuration

                /* Pagination */
                $limit = 3;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                /* Query to fetch bookmarked posts */
                $sql = "SELECT post.post_id, post.title, post.post_date, category.category_name, user.username 
                        FROM saved_posts 
                        LEFT JOIN post ON saved_posts.post_id = post.post_id
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE saved_posts.user_id = {$_SESSION['user_id']}
                        ORDER BY saved_posts.saved_at DESC 
                        LIMIT {$offset}, {$limit}";

                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-3 px-6 text-center">S.No.</th>
                                <th class="py-3 px-6 text-center">Title</th>
                                <th class="py-3 px-6 text-center">Category</th>
                                <th class="py-3 px-6 text-center">Date</th>
                                <th class="py-3 px-6 text-center">Author</th>
                                <th class="py-3 px-6 text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="border-b text-center">
                                    <td class="py-3 px-6"><?php echo $serial; ?></td>
                                    <td class="py-3 px-6"><?php echo $row['title']; ?></td>
                                    <td class="py-3 px-6"><?php echo $row['category_name']; ?></td>
                                    <td class="py-3 px-6"><?php echo $row['post_date']; ?></td>
                                    <td class="py-3 px-6"><?php echo $row['username']; ?></td>
                                    <td class="py-3 px-6 text-center">
                                        <a href='remove-bookmark.php?post_id=<?php echo $row['post_id']; ?>' class='text-red-500 hover:underline'>
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
                    echo "<h3 class='text-center text-red-500 font-bold mt-6'>No Bookmarked Posts Found.</h3>";
                }

                // Pagination for bookmarks
                $sql1 = "SELECT COUNT(*) AS total FROM saved_posts WHERE user_id = {$_SESSION['user_id']}";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                $row = mysqli_fetch_assoc($result1);
                $total_records = $row['total'];
                $total_page = ceil($total_records / $limit);

                if ($total_page > 1) {
                    echo '<ul class="pagination flex flex-wrap justify-center mt-6 space-x-2">';
                    if ($page > 1) {
                        echo '<li><a href="bookmarks.php?page=' . ($page - 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        $active = ($i == $page) ? "bg-blue-500 text-white" : "bg-gray-200";
                        echo '<li><a href="bookmarks.php?page=' . $i . '" class="py-2 px-4 rounded ' . $active . ' hover:bg-blue-500 hover:text-white">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        echo '<li><a href="bookmarks.php?page=' . ($page + 1) . '" class="bg-gray-200 py-2 px-4 rounded hover:bg-blue-500 hover:text-white">Next</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>