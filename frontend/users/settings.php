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
    <div id="admin-content" class="py-8">
        <div class="container mx-auto">
            <div class="flex flex-wrap mb-10 pb-5">
                <div class="w-full mb-8">
                    <h1 class="admin-heading text-3xl  font-bold text-gray-800">Website Settings</h1>
                </div>
                <!-- <br /> -->
                <div class="w-full md:w-8/12 mx-auto">
                    <?php
                    include "../config.php";

                    $sql = "SELECT * FROM settings";

                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <!-- Form -->
                            <form action="save-settings.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 shadow-lg rounded-lg">
                                <div class="mb-4">
                                    <label for="website_name" class="block text-gray-700 font-bold mb-2">Website Name</label>
                                    <input type="text" name="website_name" value="<?php echo $row['websitename']; ?>" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off" required>
                                </div>
                                <div class="mb-4">
                                    <label for="logo" class="block text-gray-700 font-bold mb-2">Website Logo</label>
                                    <input type="file" name="logo" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <img src="./imgs/logo.png" class="mt-4 h-20">
                                    <input type="hidden" name="old_logo" value="<?php echo $row['logo']; ?>">
                                </div>
                                <div class="mb-4">
                                    <label for="footer_desc" class="block text-gray-700 font-bold mb-2">Footer Description</label>
                                    <textarea name="footer_desc" class="block w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" rows="5" required><?php echo $row['footerdesc']; ?></textarea>
                                </div>
                                <input type="submit" name="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 cursor-pointer" value="Save" />
                            </form>
                            <!--/Form -->
                    <?php
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