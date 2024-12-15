<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
</head>

<body class="bg-gray-100">
    <?php include "./header.php"; ?>

    <div id="admin-content" class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center mb-6">
                <div class="w-full md:w-8/12 lg:w-10/12 mb-4 md:mb-0">
                    <h1 class="admin-heading text-2xl md:text-3xl font-bold text-gray-800">All Posts</h1>
                </div>
            </div>

            <!-- Add a section for the chart -->
            <div class="chart-container bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Post Views</h2>
                <canvas id="postViewsChart" width="400" height="200"></canvas>
            </div>

            <div class="w-full overflow-x-auto lg:overflow-visible">
                <?php
                include "../config.php"; // database configuration

                /* Fetch data for the chart */
                $chart_data_sql = "SELECT post.title, post.views FROM post";
                $chart_result = mysqli_query($conn, $chart_data_sql);

                $titles = [];
                $views = [];

                while ($row = mysqli_fetch_assoc($chart_result)) {
                    $titles[] = $row['title']; // Add post title
                    $views[] = $row['views']; // Add post views
                }

                /* Pass the data as JSON to JavaScript */
                echo "<script>
                        const postTitles = " . json_encode($titles) . ";
                        const postViews = " . json_encode($views) . ";
                      </script>";
                ?>

                <!-- Existing Table Content -->
                <?php
                // Existing table and pagination logic remains the same
                ?>
            </div>
        </div>
    </div>

    <script>
        // Render Chart.js graph
        const ctx = document.getElementById('postViewsChart').getContext('2d');
        const postViewsChart = new Chart(ctx, {
            type: 'bar', // Use a bar chart
            data: {
                labels: postTitles, // Post titles from PHP
                datasets: [{
                    label: 'Views',
                    data: postViews, // Post views from PHP
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Views'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Posts'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>