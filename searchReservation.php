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
                Reservations Data
            </h6>
            <form class="form-inline my-2 my-md-0 mw-100 navbar-search" action="searchreservation.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" name="query" placeholder="Search for reservation ID" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (!empty($_GET['query'])) {
    $search = $_GET['query'];

    // Query to search for reservations by username or email
    $query_reservation = "SELECT 
    r.reservationId, 
    r.guestCount, 
    r.event_time,
    s.statusName,
    CONCAT(c.firstname, ' ', c.lastname) AS customerName
FROM 
    reservationtb r
JOIN 
    customertb c ON r.customerId = c.customerId
JOIN
    statustb s ON r.statusId = s.statusId
WHERE 
    r.reservationId LIKE '%$search%' 
AND 
    s.statusName = 'Approved'";



    $result_reservation = mysqli_query($connection, $query_reservation);

    // Fetch all results in an associative array
    $reservations = mysqli_fetch_all($result_reservation, MYSQLI_ASSOC);
}
?>
<div class="card-body">
    <?php if (!empty($reservations)): ?>
        <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Guest Count</th>
                    <th>Customer Name</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['reservationId']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['guestCount']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['customerName']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['event_time']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['statusName']); ?></td>
                        <td>
                            <form action="owner_functions.php" method="post" style="display:inline;">
                                <input type="hidden" name="reservationId" value="<?php echo ($reservation['reservationId']); ?>">
                                <button type="submit" name="completeReservation" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to complete this reservation?')">Complete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h6 class="text-center" style="color: red;"> No reservations found </h6>
    <?php endif; ?>
</div>





<?php
include('includes/scripts.php');
?>