<?php
include "../config.php";
session_start();
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
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- LOGO -->
                <div class="flex-shrink-0">
                    <?php
                    include "../config.php";
                    $sql = "SELECT * FROM settings";
                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['logo'] == "") {
                                echo '<a href="http://localhost:8000/index.php" target="_blank" class="text-2xl font-bold">Logo</a>';
                            } else {
                                echo '<a href="http://localhost:8000/index.php" target="_blank" id="logo"><img src="./imgs/logo.png" alt="Logo" class="h-10"></a>';
                            }
                        }
                    }
                    ?>
                </div>

                <!-- User Icon or Get Started Button -->
                <div class="flex items-center relative">
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo '<div class="relative inline-block">';
                        // Profile Icon
                        echo '<a href="#" id="profile-menu-toggle" class="text-gray-800">';
                        echo '<i class="fas fa-user-circle text-2xl"></i>';
                        echo '</a>';

                        // Dropdown Menu
                        echo '<div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">';
                        echo '<a href="http://localhost:8000/index.php" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">See Blog</a>';
                        echo '<a href="logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<a href="./login.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Get Started</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Admin Menu Bar -->
    <div id="admin-menubar" class="bg-gray-800">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <ul class="admin-menu flex space-x-6 text-white py-3 list-none">
                    <li><a href="post.php" class="px-4 hover:text-blue-400">Post</a></li>
                    <li><a href="bookmark.php" class="px-4 hover:text-blue-400">Bookmarks</a></li>
                    <?php if ($_SESSION["user_role"] == '1') { ?>
                        <li><a href="category.php" class="px-4 hover:text-blue-400">Category</a></li>
                        <li><a href="users.php" class="px-4 hover:text-blue-400">Users</a></li>
                        <li><a href="newsletterlist.php" class="px-4 hover:text-blue-400">Subscribers</a></li>
                        <li><a href="views.php" class="px-4 hover:text-blue-400">Stats</a></li>
                        <li><a href="settings.php" class="px-4 hover:text-blue-400">Settings</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Admin Menu Bar -->

    <script>
        // Toggle the profile menu dropdown
        const profileMenuToggle = document.getElementById('profile-menu-toggle');
        const profileMenu = document.getElementById('profile-menu');

        profileMenuToggle.addEventListener('click', (event) => {
            event.preventDefault();
            profileMenu.classList.toggle('hidden');
        });

        // Close the menu if clicked outside
        document.addEventListener('click', (event) => {
            if (!profileMenuToggle.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>