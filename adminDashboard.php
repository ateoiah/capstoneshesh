<?php
session_start();
include('Security.php');
include('includes/header.php');
include('includes/navbar.php');

// Query to retrieve all restaurant names with reservation counts, including those with zero reservations
$query = "SELECT restauranttb.restaurant_name, COUNT(reservationtb.reservationId) AS total_reservations
          FROM restauranttb
          LEFT JOIN reservationtb ON reservationtb.restaurantId = restauranttb.restaurant_id
          GROUP BY restauranttb.restaurant_id";

$result = $connection->query($query);

$restaurantNames = [];
$totalReservations = [];

while ($row = $result->fetch_assoc()) {
    $restaurantNames[] = $row['restaurant_name'];
    $totalReservations[] = $row['total_reservations'] ?: 0; // Set to 0 if there are no reservations
}

$connection->close();
?>

<!-- HTML to display the bar chart -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-center">Total Reservations per Restaurant</h5>
        </div>
        <div class="card-body">
            <canvas id="reservationChart"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get data from PHP
    const restaurantNames = <?php echo json_encode($restaurantNames); ?>;
    const totalReservations = <?php echo json_encode($totalReservations); ?>;

    // Create the bar chart
    const ctx = document.getElementById('reservationChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: restaurantNames,
            datasets: [{
                label: 'Total Reservations',
                data: totalReservations,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Hide the legend with color box
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Ensure whole numbers on y-axis
                    },
                    title: {
                        display: true,
                        text: 'Reservations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Restaurant Names'
                    }
                }
            }
        }
    });
</script>


<?php
include('includes/scripts.php');
?>