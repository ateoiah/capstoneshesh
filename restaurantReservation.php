<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');
?>

<div class="container-fluid">
    <div class="card shadow mb-0">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Reservations List
            </h6>
            <form class="form-inline my-2 my-md-0 mw-100 navbar-search" action="searchReservation.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" name="query" placeholder="Search for reservation ID" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <img src="icons\magnifying-glass.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
echo '<div class="container mt-1">';

if (isset($_SESSION['success'])) {
    echo '<<div class="text-center mt-4" style="color: green;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Unset the success message after displaying
}

if (isset($_SESSION['status'])) {
    echo '<div class="alert alert-danger text-center" style="color: red;">' . $_SESSION['status'] . '</div>';
    unset($_SESSION['status']); // Unset the error message after displaying
}

echo '</div>';
?>

<?php

$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT reservationtb.reservationId, reservationtb.guestCount, reservationtb.event_time,
                CONCAT(customertb.firstname, ' ', customertb.lastname) AS customerName,
                statustb.statusName FROM reservationtb 
                JOIN customertb ON reservationtb.customerId = customertb.customerid
                JOIN restauranttb ON reservationtb.restaurantId = restauranttb.restaurant_id
                JOIN statustb ON reservationtb.statusId = statustb.statusId
                WHERE reservationtb.restaurantId = ?
                AND statustb.statusName = 'Pending'";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $restaurantId); // Assuming restaurant_id is an integer
$stmt->execute();
$result = $stmt->get_result();

$reservations = []; // Initialize the array

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = [ // Use the correct variable name
            'id' => $row['reservationId'],
            'guest' => $row['guestCount'],
            'customerName' => $row['customerName'],
            'status' => $row['statusName'],
            'time' => $row['event_time']
        ];
    }
}

?>

<div class="card-body mt-1">
    <h3>Pending Reservation</h3>
    <?php if (!empty($reservations)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Guest Count</th>
                    <th>Customer Name</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th> <!-- Added Actions header -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo ($reservation['id']); ?></td>
                        <td><?php echo ($reservation['guest']); ?></td>
                        <td><?php echo ($reservation['customerName']); ?></td>
                        <td><?php echo ($reservation['time']); ?></td>
                        <td><?php echo ($reservation['status']); ?></td>
                        <td>
                            <form action="owner_functions.php" method="post" style="display:inline;">
                                <input type="hidden" name="reservationId" value="<?php echo ($reservation['id']); ?>">
                                <button type="submit" name="approveReservation" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to approve this reservation?')">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                No reservations found.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
//Approved reservation
$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT reservationtb.reservationId, reservationtb.guestCount, reservationtb.event_time,
                CONCAT(customertb.firstname, ' ', customertb.lastname) AS customerName,
                statustb.statusName FROM reservationtb 
                JOIN customertb ON reservationtb.customerId = customertb.customerid
                JOIN restauranttb ON reservationtb.restaurantId = restauranttb.restaurant_id
                JOIN statustb ON reservationtb.statusId = statustb.statusId
                WHERE reservationtb.restaurantId = ?
                AND statustb.statusName = 'Approved'";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $restaurantId); // Assuming restaurant_id is an integer
$stmt->execute();
$result = $stmt->get_result();

$reservations = []; // Initialize the array

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = [ // Use the correct variable name
            'id' => $row['reservationId'],
            'guest' => $row['guestCount'],
            'customerName' => $row['customerName'],
            'status' => $row['statusName'],
            'time' => $row['event_time']
        ];
    }
}

?>

<div class="card-body mt-1">
    <h3>Approved Reservation</h3>
    <?php if (!empty($reservations)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Guest Count</th>
                    <th>Customer Name</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th> <!-- Added Actions header -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo ($reservation['id']); ?></td>
                        <td><?php echo ($reservation['guest']); ?></td>
                        <td><?php echo ($reservation['customerName']); ?></td>
                        <td><?php echo ($reservation['time']); ?></td>
                        <td><?php echo ($reservation['status']); ?></td>
                        <td>
                            <form action="owner_functions.php" method="post" style="display:inline;">
                                <input type="hidden" name="reservationId" value="<?php echo ($reservation['id']); ?>">
                                <button type="submit" name="completeReservation" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to complete this reservation?')">Complete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                No reservations found.
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
    // Refresh the page every 5 seconds (5000 milliseconds)
    setInterval(function() {
        location.reload();
    }, 5000);
</script>
<?php
include('includes/scripts.php');
?>