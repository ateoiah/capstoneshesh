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

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();


$stmt = $connection->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $connection->error);
}
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
$categories = [];
$totals = [];
$colors = [];
$totalOrders = 0;

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
    $totalOrders += $row['total_orders'];
    $colors[] = $availableColors[$colorIndex % count($availableColors)];
    $colorIndex++;
}

$stmt->close();
?>

<?php
// Database queries to fetch counts
if (!isset($_SESSION['restaurant_id'])) {
    die('Restaurant ID is not available.');
}

// Retrieve the restaurantId from the session
$restaurantId = $_SESSION['restaurant_id'];

// Database queries to fetch counts based on restaurantId
$query = "SELECT COUNT(reservationId) AS completedReservation FROM reservationtb WHERE statusId = 3 AND restaurantId = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();
$completedReservation = $result->fetch_assoc()['completedReservation'];

$query = "SELECT COUNT(reservationId) AS cancelledReservation FROM reservationtb WHERE statusId = 2 AND restaurantId = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();
$cancelledReservation = $result->fetch_assoc()['cancelledReservation'];

$query = "SELECT COUNT(reservationId) AS pendingReservation FROM reservationtb WHERE statusId = 1 AND restaurantId = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();
$pendingReservation = $result->fetch_assoc()['pendingReservation'];

$query = "SELECT COUNT(reservationId) AS approvedReservation FROM reservationtb WHERE statusId = 4 AND restaurantId = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $restaurantId);
$stmt->execute();
$result = $stmt->get_result();
$approvedReservation = $result->fetch_assoc()['approvedReservation'];

// Close statement
$stmt->close();


?>

<!-- HTML Display -->
<div class="container mt-3">
    <div class="row">
        <!-- Completed Reservation Card -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-2">
                <div class="card-body text-center p-2">
                    <h6 class="card-title font-weight-bold mb-1">Completed Reservation</h6>
                    <p class="card-text h4 mb-1"><?php echo $completedReservation; ?></p>
                </div>
            </div>
        </div>

        <!-- Pending Reservation Card -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-2">
                <div class="card-body text-center p-2">
                    <h6 class="card-title font-weight-bold mb-1">Pending Reservation</h6>
                    <p class="card-text h4 mb-1"><?php echo $pendingReservation; ?></p>
                </div>
            </div>
        </div>

        <!-- Approved Reservation Card -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-2">
                <div class="card-body text-center p-2">
                    <h6 class="card-title font-weight-bold mb-1">Approved Reservation</h6>
                    <p class="card-text h4 mb-1"><?php echo $approvedReservation; ?></p>
                </div>
            </div>
        </div>

        <!-- Cancelled Reservation Card -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-2">
                <div class="card-body text-center p-2">
                    <h6 class="card-title font-weight-bold mb-1">Cancelled Reservation</h6>
                    <p class="card-text h4 mb-1"><?php echo $cancelledReservation; ?></p>
                </div>
            </div>
        </div>


    </div>
</div>



<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <!-- Styled hard-coded text at the top of the chart -->


    <!-- Display the total orders in a Bootstrap alert -->


    <!-- Horizontal line between totals and chart -->
    <hr class="my-4">
    <h2>Orders by Category</h2>
    <!-- Canvas for the chart -->
    <canvas id="ordersChart" width="300" height="150"></canvas>

    <script>
        // Get the data from PHP
        var categories = <?php echo json_encode($categories); ?>;
        var totals = <?php echo json_encode($totals); ?>;
        var colors = <?php echo json_encode($colors); ?>;

        // Chart.js configuration for a bar chart
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    data: totals,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.6', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Number(value).toFixed(0);
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