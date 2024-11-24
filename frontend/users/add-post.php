<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <?php include "./header.php"; ?>
    <div id="admin-content" class="py-8 bg-gray-100">
        <div class="container mx-auto">
            <div class="flex flex-wrap mb-6">
                <div class="w-full">
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Add New Post</h1>
                </div>
                <div class="w-full md:w-6/12 mx-auto">
                    <!-- Form -->
                    <form action="save-post.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 shadow-md rounded-lg">
                        <div class="mb-4">
                            <label for="post_title" class="block text-gray-700 font-bold mb-2">Title</label>
                            <input type="text" name="post_title" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off" required>
                        </div>
                        <div class="mb-4">
                            <label for="postdesc" class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="postdesc" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" rows="5" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                            <select name="category" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option disabled selected>Select Category</option>
                                <?php
                                include "../config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn, $sql) or die("Query Failed.");

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="fileToUpload" class="block text-gray-700 font-bold mb-2">Post Image</label>
                            <input type="file" name="fileToUpload" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        </div>
                        <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Save">
                    </form>
                    <!--/Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->

</body>

</html>