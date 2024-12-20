<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body>
    <div id="sidebar" class="w-full md:w-1/3 px-4">
        <!-- search box -->
        <div class="search-box-container mb-6">
            <h4 class="text-xl font-semibold mb-2">Search</h4>
            <form class="search-post" action="search.php" method="GET">
                <div class="flex shadow-md hover:shadow-lg">
                    <input type="text" name="search" class="form-input w-full p-2 border border-gray-300 rounded-l" placeholder="Search .....">
                    <button type="submit" class="bg-red-600 text-white p-2 rounded-r shadow-md ">Search</button>
                </div>
            </form>
        </div>
        <!-- /search box -->

        <!-- recent posts box -->
        <div class="recent-post-container shadow-md hover:shadow-lg">
            <h4 class="text-xl font-semibold mt-1 mb-4 ml-2">Recent Posts</h4>
            <?php
            include "./config.php";
            $limit = 3;

            $sql = "SELECT post.post_id, post.title, post.post_date,
        category.category_name, post.category, post.post_img FROM post
        LEFT JOIN category ON post.category = category.category_id
        ORDER BY post.post_id DESC LIMIT {$limit}";

            $result = mysqli_query($conn, $sql) or die("Query Failed. : Recent Post");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="recent-post ml-2 mb-6">
                        <!-- <a class="block mb-2" href="single.php?id=<?php echo $row['post_id']; ?>">
                            <img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" class="w-full h-auto rounded">
                        </a> -->
                        <div class="post-content">
                            <h5 class="text-lg font-semibold mb-1">
                                <a href="./single.php?id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a>
                            </h5>
                            <span class="block text-sm text-gray-600">
                                <i class="fa fa-tags" aria-hidden="true"></i>
                                <a href="./category.php?cid=<?php echo $row['category']; ?>" class="text-blue-500 hover:underline"><?php echo $row['category_name']; ?></a>
                            </span>
                            <span class="block text-sm text-gray-600">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo $row['post_date']; ?>
                            </span>
                            <a class="text-red-500  hover:underline" href="./single.php?id=<?php echo $row['post_id']; ?>">Read more...</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <!-- /recent posts box -->

        <!-- Newsletter Subscription Box -->
        <div class="newsletter-container shadow-md hover:shadow-lg mt-8">
            <h4 class="text-xl font-semibold mb-4 ml-2">Subscribe to Our Newsletter</h4>
            <form action="newsletter.php" method="POST" class="p-4">
                <input type="email" name="subscriber_email" placeholder="Enter your email" required
                    class="form-input w-full p-2 border border-gray-300 rounded mb-2">
                <button type="submit" class="bg-blue-600 text-white w-full p-2 rounded hover:bg-blue-700 transition">
                    Subscribe
                </button>
            </form>

            <!-- Message -->
            <?php
            if (isset($_SESSION['msg'])) {
                echo "<div id='message-box' class='bg-green-100 text-green-700 p-3 rounded mb-4'>{$_SESSION['msg']}</div>";
                unset($_SESSION['msg']);
            }
            ?>


        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const messageBox = document.getElementById("message-box");
            if (messageBox) {
                
                setTimeout(function() {
                    messageBox.style.transition = "opacity 0.5s ease";
                    messageBox.style.opacity = "0";

                    setTimeout(function() {
                        messageBox.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>


</body>

</html>