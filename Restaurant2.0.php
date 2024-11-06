<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>



<div class="container-fluid">
  <div class="card shadow mb-0">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Restaurant Lists
        <a href="restaurant_add.php" class="btn btn-primary">
          Add Restaurant Profile
        </a>
      </h6>
    </div>
  </div>
</div>
<div class="card-body">

  <?php
  echo '<div class="container mt-1">';

  if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center" style="color: green;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Unset the success message after displaying
  }

  if (isset($_SESSION['status'])) {
    echo '<div class="alert alert-danger text-center" style="color: red;">' . $_SESSION['status'] . '</div>';
    unset($_SESSION['status']); // Unset the error message after displaying
  }

  echo '</div>';
  ?>

  <?php
  $sql = "SELECT restauranttb.restaurant_id, restauranttb.restaurant_name, restauranttb.restaurant_address, restauranttb.restaurant_logo FROM restauranttb";
  $result = $connection->query($sql);


  $restaurants = [];

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $restaurants[] = [
        'id' => $row['restaurant_id'],
        'restaurantName' => $row['restaurant_name'],
        'restaurantAddress' => $row['restaurant_address'],
        'restaurantLogo' => $row['restaurant_logo'],
      ];
    }
  }

  ?>
</div>


<div class="card-body">

  <?php if (!empty($restaurants)): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Restaurant Name</th>
          <th>Restaurant Address</th>
          <th>Restaurant Logo</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($restaurants as $restaurant): ?>
          <tr>
            <td><?php echo ($restaurant['id']); ?></td>
            <td><?php echo ($restaurant['restaurantName']); ?></td>
            <td><?php echo ($restaurant['restaurantAddress']); ?></td>
            <td>
              <img src="get_image.php?id=<?php echo ($restaurant['id']); ?>" alt="Restaurant Logo" style="width: 50px; height: 50px;" />
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No restaurants found.</p>
  <?php endif; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>