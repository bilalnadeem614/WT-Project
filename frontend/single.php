<!DOCTYPE html>
<html lang="en">

<?php
include "./config.php";
$title = '';
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT post.title FROM post WHERE post.post_id = {$post_id}";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
    } else {
        $title = 'Post Not Found';
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
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
    <title><?php echo $title; ?></title>
</head>

<body>
    <?php include './nav.php'; ?>
    <div id="main-content" class="min-h-screen py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-2/3 px-4">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                        // Fetch full post details
                        $sql = "SELECT post.post_id, post.title, post.description, post.post_date, post.author,
                                category.category_name, user.username, post.category, post.post_img,
                                (SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id) AS save_count,
                                (SELECT COUNT(*) FROM saved_posts WHERE saved_posts.post_id = post.post_id AND saved_posts.user_id = {$_SESSION['user_id']}) AS is_saved
                                FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                WHERE post.post_id = {$post_id}";

                        $result = mysqli_query($conn, $sql) or die("Query Failed.");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="post-content single-post bg-white shadow-md rounded-lg overflow-hidden mb-8 relative">
                                    <h3 class="ml-4 text-2xl sm:text-3xl font-bold mt-4 mb-4"><?php echo $row['title']; ?></h3>
                                    <div class="ml-4 post-information text-sm text-gray-600 mb-4">
                                        <span class="mr-4">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category']; ?>' class="text-blue-500 hover:underline">
                                                <?php echo $row['category_name']; ?>
                                            </a>
                                        </span>
                                        <span class="mr-4">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author']; ?>' class="text-blue-500 hover:underline">
                                                <?php echo $row['username']; ?>
                                            </a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
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
                                            </form>
                                        <?php } ?>
                                        <p><?php echo $row['save_count']; ?></p>
                                    </div>

                                    <div class="image-container mb-4">
                                        <img class="w-full h-auto object-cover rounded-lg" style="height: 250px;" src="users/uploads/<?php echo $row['post_img']; ?>" alt="Post Image" />
                                    </div>
                                    <p class="ml-4 description text-base sm:text-lg text-gray-700">
                                        <?php echo $row['description']; ?>
                                    </p>
                                </div>

                        <?php
                            }
                        } else {
                            echo "<h2 class='text-center text-xl font-semibold'>No Record Found.</h2>";
                        }
                        ?>
                    </div>
                    <!-- /post-container -->
                </div>
                <!-- Sidebar with responsive behavior -->

                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
    <?php include './footer.php'; ?>

</body>

</html>