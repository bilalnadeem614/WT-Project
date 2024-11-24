<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
</head>

<body>
    <div id="footer" class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="text-center">
                    <?php
                    include "./config.php";

                    $sql = "SELECT * FROM settings";

                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <span class="text-gray-400"><?php echo $row['footerdesc']; ?></span>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>