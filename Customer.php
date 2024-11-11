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
$sql = "SELECT customertb.customerid, customertb.firstname, customertb.lastname, customertb.email FROM customertb";
$result = $connection->query($sql);


$customers = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $customers[] = [
      'id' => $row['customerid'],
      'firstName' => $row['firstname'],
      'lastName' => $row['lastname'],
      'email' => $row['email'],
    ];
  }
}
?>


<div class="card-body">

  <?php if (!empty($customers)): ?>
    <table class="table table-striped">
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
            <td><?php echo ($customer['id']); ?></td>
            <td><?php echo ($customer['firstName']); ?></td>
            <td><?php echo ($customer['lastName']); ?></td>
            <td><?php echo ($customer['email']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No customers found.</p>
  <?php endif; ?>
</div>

<?php
include('includes/scripts.php');
?>