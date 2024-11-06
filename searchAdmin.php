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
if (!empty($_GET['query'])) {
    $search = $_GET['query'];

    // Query to search for admins by username or email
    $query_admin = "SELECT * FROM admintb 
                    WHERE admin_username LIKE '%$search%' 
                    OR admin_email LIKE '%$search%'";

    $result_admin = mysqli_query($connection, $query_admin);

    // Fetch all results in an associative array
    $admins = mysqli_fetch_all($result_admin, MYSQLI_ASSOC);
}
?>
<div class="card-body">
    <?php if (!empty($admins)): ?>
        <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
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
                        <td><?php echo htmlspecialchars($admin['admin_id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['admin_username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['admin_email']); ?></td>
                        <td><?php echo htmlspecialchars($admin['admin_password']); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <form action="admin_edit.php" method="post" style="display:inline;">
                                <input type="hidden" name="adminId" value="<?php echo htmlspecialchars($admin['admin_id']); ?>">
                                <button type="submit" name="editAdmin" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to edit this item?')">Edit</button>
                            </form>

                            <!-- Delete Button -->
                            <form action="admin_functions.php" method="post" style="display:inline;">
                                <input type="hidden" name="adminId" value="<?php echo htmlspecialchars($admin['admin_id']); ?>">
                                <button type="submit" name="deleteAdmin" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h6 class="text-center" style="color: red;"> No admins found </h6>
    <?php endif; ?>
</div>





<?php
include('includes/scripts.php');
?>