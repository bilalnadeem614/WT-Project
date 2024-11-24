<?php include "./header.php";

if ($_SESSION["user_role"] == 0) {
    include "../config.php";
    $post_id = $_GET['id'];
    $sql2 = "SELECT author FROM post WHERE post_id = {$post_id}";
    $result2 = mysqli_query($conn, $sql2) or die("Query Failed.");

    $row2 = mysqli_fetch_assoc($result2);

    if ($row2['author'] != $_SESSION["user_id"]) {
        header("location: {$hostname}/users/post.php");
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
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Update Post</h1>
                </div>
                <div class="w-full md:w-6/12 mx-auto">
                    <?php
                    include "../config.php";

                    $post_id = $_GET['id'];
                    $sql = "SELECT post.post_id, post.title, post.description, post.post_img, category.category_name, post.category 
                  FROM post
                  LEFT JOIN category ON post.category = category.category_id
                  LEFT JOIN user ON post.author = user.user_id
                  WHERE post.post_id = {$post_id}";

                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <!-- Form Start -->
                            <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="bg-white p-8 shadow-md rounded-lg">
                                <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>" class="block w-full p-2 border border-gray-300 rounded">

                                <div class="mb-4">
                                    <label for="post_title" class="block text-gray-700 font-bold mb-2">Title</label>
                                    <input type="text" name="post_title" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo $row['title']; ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="postdesc" class="block text-gray-700 font-bold mb-2">Description</label>
                                    <textarea name="postdesc" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" rows="5" required><?php echo $row['description']; ?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                                    <select name="category" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option disabled>Select Category</option>
                                        <?php
                                        include "config.php";
                                        $sql1 = "SELECT * FROM category";
                                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                                        if (mysqli_num_rows($result1) > 0) {
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                $selected = ($row['category'] == $row1['category_id']) ? "selected" : "";
                                                echo "<option {$selected} value='{$row1['category_id']}'>{$row1['category_name']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="old_category" value="<?php echo $row['category']; ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="new-image" class="block text-gray-700 font-bold mb-2">Post Image</label>
                                    <input type="file" name="new-image" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <img src="upload/<?php echo $row['post_img']; ?>" class="mt-4" height="150px">
                                    <input type="hidden" name="old_image" value="<?php echo $row['post_img']; ?>">
                                </div>

                                <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Update">
                            </form>
                            <!-- Form End -->
                    <?php
                        }
                    } else {
                        echo "<p class='text-red-500 text-center mt-4'>Result Not Found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->

</body>

</html>