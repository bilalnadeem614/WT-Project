<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body>
    <?php include 'nav.php'; ?>
    <div id="main-content" class="py-8 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-2/3 px-4">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                        include "./config.php";
                        if (isset($_GET['cid'])) {
                            $cat_id = $_GET['cid'];

                            $sql1 = "SELECT * FROM category WHERE category_id = {$cat_id}";
                            $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                            $row1 = mysqli_fetch_assoc($result1);
                        ?>
                            <h2 class="page-heading text-2xl sm:text-3xl font-bold mb-6"><?php echo $row1['category_name']; ?> News</h2>
                            <?php
                            /* Calculate Offset Code */
                            $limit = 3;
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $offset = ($page - 1) * $limit;

                            $sql = "SELECT post.post_id, post.title, post.description, post.post_date, post.author,
                                category.category_name, user.username, post.category, post.post_img 
                                FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                WHERE post.category = {$cat_id}
                                ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                            $result = mysqli_query($conn, $sql) or die("Query Failed.");
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <div class="post-content bg-white shadow-md rounded-lg overflow-hidden mb-8 hover:shadow-2xl transition-shadow duration-300">
                                        <div class="flex flex-col sm:flex-row -mx-4">
                                            <div class="w-full sm:w-1/3 px-4 mb-4 sm:mb-0">
                                                <a class="post-img block" href="single.php?id=<?php echo $row['post_id']; ?>">
                                                    <img class="w-full h-48 object-cover rounded-lg" src="users/uploads/<?php echo $row['post_img']; ?>" alt="" />
                                                </a>
                                            </div>
                                            <div class="w-full sm:w-2/3 px-4">
                                                <div class="inner-content clearfix p-4">
                                                    <h3 class="text-xl sm:text-2xl font-semibold mb-2">
                                                        <a href='single.php?id=<?php echo $row['post_id']; ?>' class="hover:underline">
                                                            <?php echo $row['title']; ?>
                                                        </a>
                                                    </h3>
                                                    <div class="post-information text-sm text-gray-600 mb-4">
                                                        <span class="mr-4">
                                                            <i class="fa fa-tags"></i>
                                                            <a href='category.php?cid=<?php echo $row['category']; ?>' class="text-blue-500 hover:underline">
                                                                <?php echo $row['category_name']; ?>
                                                            </a>
                                                        </span>
                                                        <span class="mr-4">
                                                            <i class="fa fa-user"></i>
                                                            <a href='author.php?aid=<?php echo $row['author']; ?>' class="text-blue-500 hover:underline">
                                                                <?php echo $row['username']; ?>
                                                            </a>
                                                        </span>
                                                        <span>
                                                            <i class="fa fa-calendar"></i>
                                                            <?php echo $row['post_date']; ?>
                                                        </span>
                                                    </div>
                                                    <p class="description text-base sm:text-lg text-gray-700 mb-4">
                                                        <?php echo substr($row['description'], 0, 130) . "..."; ?>
                                                    </p>
                                                    <a class='read-more text-blue-500 hover:underline' href='single.php?id=<?php echo $row['post_id']; ?>'>Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo "<h2 class='text-xl font-semibold text-center'>No Record Found.</h2>";
                            }

                            // show pagination
                            if (mysqli_num_rows($result1) > 0) {

                                $total_records = $row1['post'];

                                $total_page = ceil($total_records / $limit);

                                echo '<ul class="pagination flex justify-center space-x-2 mt-8">';
                                if ($page > 1) {
                                    echo '<li><a href="category.php?cid=' . $cat_id . '&page=' . ($page - 1) . '" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Prev</a></li>';
                                }
                                for ($i = 1; $i <= $total_page; $i++) {
                                    $active = ($i == $page) ? "bg-blue-500 text-white" : "bg-gray-300 text-gray-700 hover:bg-gray-400";
                                    echo '<li><a href="category.php?cid=' . $cat_id . '&page=' . $i . '" class="px-3 py-1 ' . $active . ' rounded">' . $i . '</a></li>';
                                }
                                if ($total_page > $page) {
                                    echo '<li><a href="category.php?cid=' . $cat_id . '&page=' . ($page + 1) . '" class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Next</a></li>';
                                }

                                echo '</ul>';
                            }
                        } else {
                            echo "<h2 class='text-xl font-semibold text-center'>No Record Found.</h2>";
                        }
                        ?>
                    </div><!-- /post-container -->
                </div>
                <!-- Sidebar with responsive behavior -->

                    <?php include 'sidebar.php'; ?>

            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>

</body>

</html>