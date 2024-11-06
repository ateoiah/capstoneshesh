<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');
?>

<div class="container-fluid">
    <div class="card shadow mb-0">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order List
            </h6>
        </div>
    </div>
</div>

<?php
$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT ordertb.orderId, 
               ordertb.totalPrice, 
               ordertb.quantity, 
               CONCAT(customertb.firstname, ' ', customertb.lastname) AS customerName,
               restauranttb.restaurant_id, 
               menutb.menu_name, 
               reservationtb.reservationId 
        FROM ordertb 
        JOIN customertb ON ordertb.customerId = customertb.customerId 
        JOIN restauranttb ON ordertb.restaurantId = restauranttb.restaurant_id 
        JOIN menutb ON ordertb.menuId = menutb.menu_id 
        JOIN reservationtb ON ordertb.reservationId = reservationtb.reservationId 
        JOIN statustb ON reservationtb.statusId = statustb.statusId 
        WHERE ordertb.restaurantId = ? 
        AND statustb.statusName = 'Pending'";



$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $restaurantId); // Assuming restaurant_id is an integer
$stmt->execute();
$result = $stmt->get_result();

$orders = [];


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = [ // Use the correct variable name
            'id' => $row['orderId'],
            'reservationId' => $row['reservationId'],
            'menu' => $row['menu_name'],
            'quantity' => $row['quantity'],
            'customerName' => $row['customerName'],
            'total' => $row['totalPrice']
        ];
    }
}




?>
<div class="container mt-5">
    <div class="row">
        <?php
        // Group orders by reservation ID
        $groupedOrders = [];
        foreach ($orders as $order) {
            $groupedOrders[$order['reservationId']][] = $order;
        }

        if (!empty($groupedOrders)):
            foreach ($groupedOrders as $reservationId => $orderGroup):
                // Get the customer name from the first order in the group
                $customerName = htmlspecialchars($orderGroup[0]['customerName']);

                // Calculate the total price for this reservation
                $totalPrice = 0;
                foreach ($orderGroup as $order) {
                    $totalPrice += $order['total']; // Add each order's total price
                }
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Reservation ID: <?php echo htmlspecialchars($reservationId); ?></h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Customer Name:</strong> <?php echo $customerName; ?></p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Menu Item</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderGroup as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['menu']); ?></td>
                                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <p class="mt-3"><strong>Total Price:</strong> <?php echo htmlspecialchars($totalPrice); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No orders found.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>




<?php
include('includes/scripts.php');
?>