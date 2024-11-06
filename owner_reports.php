<?php
// Sample data for the chart
$foodCategories = ['Pizza', 'Burger', 'Pasta', 'Salad'];
$salesData = [120, 150, 90, 80];

// Convert the arrays to JSON format for use in JavaScript
$categoriesJson = json_encode($foodCategories);
$salesJson = json_encode($salesData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <style>
        canvas {
            max-width: 600px;
            /* Set max width for the chart */
            margin: auto;
            /* Center the chart */
        }
    </style>
</head>

<body>
    <h1>Food Sales Chart</h1>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'horizontalBar', // Use 'bar' for vertical, 'horizontalBar' for horizontal
            data: {
                labels: <?php echo $categoriesJson; ?>, // PHP variable to JavaScript
                datasets: [{
                    label: 'Sales',
                    data: <?php echo $salesJson; ?>, // PHP variable to JavaScript
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true // Start the x-axis at zero
                    }
                }
            }
        });
    </script>
</body>

</html>