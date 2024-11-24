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
                                category.category_name, user.username, post.category, post.post_img 
                                FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                WHERE post.post_id = {$post_id}";

                        $result = mysqli_query($conn, $sql) or die("Query Failed.");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="post-content single-post bg-white shadow-md rounded-lg overflow-hidden mb-8">
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