<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <?php include "./header.php"; ?>
    <div class="container mx-auto my-8 px-8">
        <h2 class="text-3xl font-bold mb-4">Newsletter Subscribers</h2>
        <?php
        $sql = "SELECT * FROM newsletter_subscribers"; // ORDER BY subscribed_at DESC
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Subscribed At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['subscribed_at']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p class='text-red-500 font-bold'>No subscribers found!</p>";
        }
        ?>
    </div>
</body>

</html>