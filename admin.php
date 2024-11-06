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
        Admins Data
        <a href="add_admin.php" class="btn btn-primary ml-2">
          Add Admin
        </a>
      </h6>
      <form class="form-inline my-2 my-md-0 mw-100 navbar-search" action="searchAdmin.php" method="GET">
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
echo '<div class="container mt-1">';

if (isset($_SESSION['success'])) {
  echo '<div class="text-center mt-4" style="color: green;">' . $_SESSION['success'] . '</div>';

  unset($_SESSION['success']);
}

if (isset($_SESSION['status'])) {
  echo '<div class="text-center" style="color: red;">' . $_SESSION['status'] . '</div>';
  unset($_SESSION['status']);
}

echo '</div>';

$sql = "SELECT admintb.admin_id, admintb.admin_username, admintb.admin_email, admintb.admin_password FROM admintb";
$result = $connection->query($sql);

$admins = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $admins[] = [
      'id' => $row['admin_id'],
      'username' => $row['admin_username'],
      'email' => $row['admin_email'],
      'password' => $row['admin_password'],
    ];
  }
}
?>

<div class="card-body">
  <?php if (!empty($admins)): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Password</th>
          <th>Actions</th> <!-- New column for actions -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($admins as $admin): ?>
          <tr>
            <td><?php echo ($admin['id']); ?></td>
            <td><?php echo ($admin['username']); ?></td>
            <td><?php echo ($admin['email']); ?></td>
            <td><?php echo ($admin['password']); ?></td>
            <td>
              <!-- Edit Button -->
              <form action='admin_edit.php' method='post' style='display:inline;'>
                <input type='hidden' name='adminId' value='<?php echo $admin['id']; ?>'>
                <button type='submit' name='editAdmin' class='btn btn-success btn-sm' onclick='return confirm("Are you sure you want to edit this item?")'>Edit</button>
              </form>

              <!-- Delete Button -->
              <form action='admin_functions.php' method='post' style='display:inline;'>
                <input type='hidden' name='adminId' value='<?php echo $admin['id']; ?>'>
                <button type='submit' name='deleteAdmin' class='btn btn-danger btn-sm' onclick='return confirm("Are you sure you want to delete this item?")'>Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No admins found.</p>
  <?php endif; ?>
</div>

<?php
include('includes/scripts.php');
?>