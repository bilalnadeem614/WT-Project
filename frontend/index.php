<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
    <title>Home - Welcome</title>
    <style>
        .bookmark-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .bookmark-button:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <?php include './nav.php'; ?>
    <div id="main-content" class="py-8 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Main Content Area -->
                <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                        include "./config.php";

                        /* Calculate Offset Code */
                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $offset = ($page - 1) * $limit;

                        // $sql = "SELECT post.post_id, post.title, post.description, post.post_date, post.author,
                        //     category.category_name, user.username, post.category, post.post_img,
                        //     (SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id) AS save_count,
                        //     (SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id AND saved_posts.user_id = {$_SESSION['user_id']}) AS is_saved
                        //     FROM post
                        //     LEFT JOIN category ON post.category = category.category_id
                        //     LEFT JOIN user ON post.author = user.user_id
                        //     ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                        // $result = mysqli_query($conn, $sql) or die("Query Failed.");

                        $sql = "SELECT post.post_id, post.title, post.description, post.post_date, post.author,
                                category.category_name, user.username, post.category, post.post_img,
                                (SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id) AS save_count, ";
                        if (isset($_SESSION['user_id'])) {
                            $sql .= "(SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id AND saved_posts.user_id = {$_SESSION['user_id']}) AS is_saved ";
                        } else {
                            $sql .= "0 AS is_saved ";
                        }

                        $sql .= "FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                        $result = mysqli_query($conn, $sql) or die("Query Failed.");

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="post-content mb-8 bg-white shadow-md rounded-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                                    <div class="flex flex-wrap">
                                        <div class="w-full sm:w-1/2 md:w-1/3">
                                            <a class="block" href="single.php?id=<?php echo $row['post_id']; ?>">
                                                <img src="users/uploads/<?php echo $row['post_img']; ?>" alt="" class="w-full h-48 object-cover">
                                            </a>
                                        </div>
                                        <div class="w-full sm:w-1/2 md:w-2/3 px-4 py-4 relative">
                                            <div class="inner-content">
                                                <h3 class="text-lg md:text-2xl font-semibold">
                                                    <a href="./single.php?id=<?php echo $row['post_id']; ?>" class="hover:text-blue-500 transition-colors duration-300"><?php echo $row['title']; ?></a>
                                                </h3>
                                                <div class="post-information text-xs md:text-sm text-gray-600 mt-2">
                                                    <span class="mr-4">
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <a href='./category.php?cid=<?php echo $row['category']; ?>' class="text-blue-500 hover:underline">
                                                            <?php echo $row['category_name']; ?>
                                                        </a>
                                                    </span>
                                                    <span class="mr-4">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <a href='./author.php?aid=<?php echo $row['author']; ?>' class="text-blue-500 hover:underline">
                                                            <?php echo $row['username']; ?>
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo $row['post_date']; ?>
                                                    </span>
                                                </div>
                                                <p class="description mt-4 text-gray-700 text-sm md:text-base">
                                                    <?php echo substr($row['description'], 0, 130) . "..."; ?>
                                                </p>
                                                <a class='read-more text-red-500 hover:underline inline-block mt-4' href='./single.php?id=<?php echo $row['post_id']; ?>'>read more...</a>
                                            </div>
                                            <div class="absolute top-4 right-4 text-center">
                                                <?php if (isset($_SESSION['user_id'])) { ?>
                                                    <form action="toggle_save_post.php" method="POST">
                                                        <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                                                        <button type="submit" class="bookmark-button">
                                                            <?php if ($row['is_saved']) { ?>
                                                                <!-- Bookmarked Icon -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18l7-5 7 5V3z" />
                                                                </svg>
                                                            <?php } else { ?>
                                                                <!-- Bookmark Icon -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18l7-5 7 5V3z" />
                                                                </svg>
                                                            <?php } ?>
                                                        </button>
                                                        <p><?php echo $row['save_count']; ?></p>
                                                    </form>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<h2 class='text-center text-xl font-semibold'>No Record Found.</h2>";
                        }

                        // Pagination logic
                        $sql1 = "SELECT * FROM post";
                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                        if (mysqli_num_rows($result1) > 0) {
                            $total_records = mysqli_num_rows($result1);
                            $total_page = ceil($total_records / $limit);

                            echo '<ul class="pagination flex justify-center mt-8">';
                            if ($page > 1) {
                                echo '<li class="mx-2"><a href="index.php?page=' . ($page - 1) . '" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"><-- Prev</a></li>';
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                $active = ($i == $page) ? 'bg-blue-500 text-white' : 'bg-gray-200';
                                echo '<li class="mx-2"><a href="index.php?page=' . $i . '" class="px-4 py-2 rounded ' . $active . ' hover:bg-blue-500 hover:text-white">' . $i . '</a></li>';
                            }
                            if ($total_page > $page) {
                                echo '<li class="mx-2"><a href="index.php?page=' . ($page + 1) . '" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Next --></a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div><!-- /post-container -->
                </div>
                <!-- Sidebar -->

                <?php include './sidebar.php'; ?>

            </div>
        </div>
    </div>
    <?php include './footer.php'; ?>
</body>

</html>