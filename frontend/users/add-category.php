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
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Add New Category</h1>
                </div>
                <div class="w-full md:w-6/12 mx-auto">
                    <!-- Form Start -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" class="bg-white p-8 shadow-md rounded-lg">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Category Name</label>
                            <input type="text" name="cat" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Category Name" required>
                        </div>
                        <input type="submit" name="save" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Save" />
                    </form>
                    <!-- /Form End -->
                    <?php
                    if (isset($_POST['save'])) {
                        // Database configuration
                        include '../config.php';
                        $category = mysqli_real_escape_string($conn, $_POST['cat']);
                        /* Query to check if the input value exists in the category table */
                        $sql = "SELECT category_name FROM category WHERE category_name='{$category}'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            // If the input value exists
                            echo "<p class='text-red-500 text-center mt-4'>Category already exists.</p>";
                        } else {
                            // If the input value does not exist
                            /* Query to insert record into category name */
                            $sql = "INSERT INTO category (category_name) VALUES ('{$category}')";

                            if (mysqli_query($conn, $sql)) {
                                header("location: {$hostname}/users/category.php");
                            } else {
                                echo "<p class='text-red-500 text-center mt-4'>Query Failed.</p>";
                            }
                        }
                    }
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->

</body>

</html>