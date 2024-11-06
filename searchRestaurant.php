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
                Restaurants Data
                <a href="add_admin.php" class="btn btn-primary ml-2">
                    Add Restaurant
                </a>
            </h6>
            <form class="form-inline my-2 my-md-0 mw-100 navbar-search" action="searchRestaurant.php" method="GET">
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
    $query_restaurant = "SELECT * FROM restauranttb
                    WHERE restaurant_name LIKE '%$search%'";

    $result_restaurant = mysqli_query($connection, $query_restaurant);

    // Fetch all results in an associative array
    $restaurants = mysqli_fetch_all($result_restaurant, MYSQLI_ASSOC);
}
?>
<div class="card-body">
    <?php if (!empty($restaurants)): ?>
        <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Restaurant Name</th>
                    <th>Owner</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Logo</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurants as $restaurant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_id']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_name']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_owner']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_address']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_email']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_phoneNumber']); ?></td>
                        <td>
                            <?php if ($restaurant['restaurant_logo']): // Check if there is an image 
                            ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($restaurant['restaurant_logo']); ?>" alt="Restaurant Image" style="width:100px;height:auto;" />
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>

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
        <h6 class="text-center" style="color: red;"> No restaurants found </h6>
    <?php endif; ?>
</div>





<?php
include('includes/scripts.php');
?>