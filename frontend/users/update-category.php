<?php include "./header.php";
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/users/post.php");
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
                    <h1 class="admin-heading text-3xl font-bold text-gray-800">Update Category</h1>
                </div>
                <div class="w-full md:w-6/12 mx-auto">
                    <?php
                    include '../config.php';
                    $cat_id = $_GET['id'];
                    /* Query to get the record for modification */
                    $sql = "SELECT * FROM category WHERE category_id = '{$cat_id}'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <!-- Form Start -->
                            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="bg-white p-8 shadow-md rounded-lg">
                                <input type="hidden" name="cat_id" value="<?php echo $row['category_id']; ?>" class="block w-full p-2 border border-gray-300 rounded">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Category Name</label>
                                    <input type="text" name="cat_name" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="<?php echo $row['category_name']; ?>" required>
                                </div>
                                <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer w-full" value="Update">
                            </form>
                            <!-- Form End -->
                    <?php
                        }
                    }
                    ?>
                    <?php
                    if (isset($_POST['submit'])) {
                        $category = mysqli_real_escape_string($conn, $_POST['cat_name']);
                        $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
                        /* Query to check if the input value exists in the category table */
                        $sql = "SELECT category_name FROM category WHERE category_name = '{$category}' AND NOT category_id = '{$cat_id}'";
                        $result1 = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result1) > 0) {
                            // If the input value already exists
                            echo "<p class='text-red-500 text-center mt-4'>Category Name '" . $category . "' already exists.</p>";
                        } else {
                            // If the input value does not exist
                            /* Query to update the category table */
                            $sql1 = "UPDATE category SET category_id = '{$_POST['cat_id']}', category_name = '{$_POST['cat_name']}' WHERE category_id = {$_POST['cat_id']}";

                            if (mysqli_query($conn, $sql1)) {
                                // Redirect to the all categories page
                                header("location: {$hostname}/users/category.php");
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php"; ?> -->
</body>

</html>