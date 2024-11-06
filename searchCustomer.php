<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container-fluid">
    <div class="card shadow mb-0">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Customers Data
            </h6>
            <form class="form-inline my-2 my-md-0 mw-100 navbar-search" action="searchCustomer.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" name="query" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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

    // Query to search for admins by username or email
    $query_customer = "SELECT * FROM customertb 
                    WHERE firstname LIKE '%$search%' 
                    OR lastname LIKE '%$search%'
                    OR email LIKE '%$search%'";


    $result_customer = mysqli_query($connection, $query_customer);

    // Fetch all results in an associative array
    $customers = mysqli_fetch_all($result_customer, MYSQLI_ASSOC);
}
?>
<div class="card-body">
    <?php if (!empty($customers)): ?>
        <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['customerid']); ?></td>
                        <td><?php echo htmlspecialchars($customer['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($customer['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h6 class="text-center" style="color: red;"> No customers found </h6>
    <?php endif; ?>
</div>





<?php
include('includes/scripts.php');
?>