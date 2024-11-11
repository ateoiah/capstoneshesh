<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');
?>

<div class="container-fluid">
    <div class="card shadow mb-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reservation History
            </h6>
        </div>
    </div>
</div>

<?php

$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT reservationtb.reservationId, reservationtb.guestCount, reservationtb.event_time,
                CONCAT(customertb.firstname, ' ', customertb.lastname) AS customerName,
                statustb.statusName FROM reservationtb 
                JOIN customertb ON reservationtb.customerId = customertb.customerid
                JOIN restauranttb ON reservationtb.restaurantId = restauranttb.restaurant_id
                JOIN statustb ON reservationtb.statusId = statustb.statusId
                WHERE reservationtb.restaurantId = ?
                AND (statustb.statusName = 'Completed' OR statustb.statusName = 'Cancelled')";

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
                                <button type="submit" name="completeReservation" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to complete this reservation?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                History Empty.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include('includes/scripts.php');
?>