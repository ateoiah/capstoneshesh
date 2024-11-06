<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');

// Check if restaurantId is set in session
if (!isset($_SESSION['restaurant_id'])) {
    die('Restaurant ID is not available.');
}

// Retrieve the restaurantId from the session
$restaurantId = $_SESSION['restaurant_id'];

// Assuming $connection is your mysqli connection
$sql = "SELECT c.menu_category_name, COUNT(o.orderId) AS total_orders
        FROM ordertb o
        JOIN menutb m ON o.menuId = m.menu_id
        JOIN menu_categorytb c ON m.menu_category_id = c.menu_category_id
        WHERE o.restaurantId = ?
        GROUP BY c.menu_category_name
        ORDER BY total_orders DESC";

// Prepare the statement using mysqli
$stmt = $connection->prepare($sql);

// Check for any errors in preparing the statement
if ($stmt === false) {
    die('MySQL prepare error: ' . $connection->error);
}

// Bind the restaurantId parameter (assuming it's an integer)
$stmt->bind_param("i", $restaurantId);

// Execute the statement
$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Fetch the results
$orders = [];
$categories = [];
$totals = [];
$colors = [];
$totalOrders = 0; // Variable to store the total number of orders

// Define a set of colors (you can expand this list if needed)
$availableColors = [
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 99, 132, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(255, 159, 64, 0.6)',
    'rgba(255, 205, 86, 0.6)',
    'rgba(0, 123, 255, 0.6)',
    'rgba(40, 167, 69, 0.6)',
    'rgba(220, 53, 69, 0.6)',
    'rgba(23, 162, 184, 0.6)'
];

$colorIndex = 0;

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
    $categories[] = $row['menu_category_name'];
    $totals[] = $row['total_orders'];
    // Add the total orders for this category to the totalOrders variable
    $totalOrders += $row['total_orders'];
    // Assign a color to each category
    $colors[] = $availableColors[$colorIndex % count($availableColors)];
    $colorIndex++;
}

// Close the statement
$stmt->close();
?>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <h2>Orders by Category</h2>

    <!-- Display the total orders in a Bootstrap alert -->
    <div class="alert alert-info" role="alert">
        <strong>Total Orders: </strong> <?php echo number_format($totalOrders); ?>
    </div>

    <!-- Create a canvas element where the chart will be rendered with smaller width and height -->
    <canvas id="ordersChart" width="300" height="150"></canvas> <!-- Smaller canvas size -->

    <script>
        // Get the data from PHP
        var categories = <?php echo json_encode($categories); ?>;
        var totals = <?php echo json_encode($totals); ?>;
        var colors = <?php echo json_encode($colors); ?>;

        // Chart.js configuration for a bar chart
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar', // Type of chart (bar chart)
            data: {
                labels: categories, // Category names (from PHP)
                datasets: [{
                    data: totals, // Total orders for each category (from PHP)
                    backgroundColor: colors, // Different colors for each bar
                    borderColor: colors.map(color => color.replace('0.6', '1')), // Same color for border but with opacity 1
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Remove the legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true, // Start the y-axis from 0
                        ticks: {
                            stepSize: 1, // Ensure each tick is an integer
                            callback: function(value) {
                                return Number(value).toFixed(0); // Round the value to the nearest integer
                            }
                        }
                    }
                }
            }
        });
    </script>
</div>

<?php
include('includes/scripts.php');
?>