<?php
include "./config.php";
$page = basename($_SERVER['PHP_SELF']);
switch ($page) {
    case "./single.php":
        if (isset($_GET['id'])) {
            $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Tile Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['title'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "./category.php":
        if (isset($_GET['cid'])) {
            $sql_title = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Tile Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['category_name'] . " News";
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "./author.php":
        if (isset($_GET['aid'])) {
            $sql_title = "SELECT * FROM user WHERE user_id = {$_GET['aid']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Tile Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = "News By " . $row_title['first_name'] . " " . $row_title['last_name'];
        } else {
            $page_title = "No Post Found";
        }
        break;
    case "./search.php":
        if (isset($_GET['search'])) {

            $page_title = $_GET['search'];
        } else {
            $page_title = "No Search Result Found";
        }
        break;
    default:
        $sql_title = "SELECT websitename FROM settings";
        $result_title = mysqli_query($conn, $sql_title) or die("Tile Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = $row_title['websitename'];
        break;
}
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <!-- <link rel="stylesheet" href="./dist/font-awesome.css">
    <link rel="stylesheet" href="./dist/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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
                    include "./config.php";

                    $sql = "SELECT * FROM settings";
                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['logo'] == "") {
                                echo '<a href="../index.php" class="text-2xl font-bold">Logo</a>';
                            } else {
                                echo '<a href="./index.php" id="logo"><img src="users/imgs/logo.png" class="h-10" alt="Logo" ></a>'; //class="h-10"
                            }
                        }
                    }
                    ?>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex space-x-8">
                    <?php
                    include "./config.php";

                    if (isset($_GET['cid'])) {
                        $cat_id = $_GET['cid'];
                    }

                    $sql = "SELECT * FROM category"; //WHERE post > 0 To get only items that have any post
                    $result = mysqli_query($conn, $sql) or die("Query Failed. : Category");
                    if (mysqli_num_rows($result) > 0) {
                        $active = "";
                    ?>
                        <ul class="flex space-x-4">
                            <?php if ($page>1 || (isset($_GET['cid']))) {
                                echo "<li><a class='text-gray-800 mx-2 hover:text-blue-600 {$active}' href='../index.php'>Home</a></li>";
                            } ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($_GET['cid'])) {
                                    if ($row['category_id'] == $cat_id) {
                                        $active = "text-blue-600 font-semibold";
                                    } else {
                                        $active = "";
                                    }
                                }
                                echo "<li><a class='text-gray-800 mx-2 hover:text-blue-600 {$active}' href='./category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                            } ?>
                        </ul>
                    <?php } ?>
                </div>

                <!-- Authentication Button -->
                <!-- <div class="flex items-center">
                    <?php

                    if (isset($_SESSION["username"])) {
                        echo '<a href="profile.php" class="text-gray-800"><i class="fas fa-user-circle text-2xl"></i></a>';
                    } else {
                        echo '<a href="../login.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Get Started</a>';
                    }
                    ?>
                </div> -->
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
                        echo '<a href="../users/post.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Add New Post</a>';
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

        <!-- Mobile Menu -->
        <div class="md:hidden">
            <button id="mobile-menu-toggle" class="text-gray-800 ml-2 hover:text-blue-600 focus:outline-none focus:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <ul id="mobile-menu" class="hidden flex-col space-y-4 mt-2">
                <?php
                if ($page > 1 || (isset($_GET['cid']))) {
                    echo "<li><a class='text-gray-800 mx-2 hover:text-blue-600 {$active}' href='../index.php'>Home</a></li>";
                }
                $result = mysqli_query($conn, $sql) or die("Query Failed. : Category");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if (isset($_GET['cid'])) {
                            $active = ($row['category_id'] == $cat_id) ? "text-blue-600 font-semibold" : "";
                        }
                        echo "<li><a class='text-gray-800 ml-4 hover:text-blue-600 {$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </nav>

    <script>
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script>
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