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
        <a href="restaurant_add.php" class="btn btn-primary ml-2">
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

$sql = "SELECT restauranttb.restaurant_id , restauranttb.restaurant_name, restauranttb.restaurant_address,
   restauranttb.restaurant_logo, restauranttb.restaurant_email , restauranttb.restaurant_password, restauranttb.restaurant_owner, 
   restauranttb.restaurant_phoneNumber
   FROM restauranttb";
$result = $connection->query($sql);

$restaurants = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $restaurants[] = [
      'id' => $row['restaurant_id'],
      'restaurantName' => $row['restaurant_name'],
      'restaurantAddress' => $row['restaurant_address'],
      'restaurantLogo' => $row['restaurant_logo'],
      'restaurantEmail' => $row['restaurant_email'],
      'restaurantOwner' => $row['restaurant_owner'],
      'restaurantPhone' => $row['restaurant_phoneNumber'],
    ];
  }
}
?>


<div class="card-body">
  <?php if (!empty($restaurants)): ?>
    <table class="table table-striped ">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
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

            <td><?php echo ($restaurant['id']); ?></td>
            <td><?php echo ($restaurant['restaurantName']); ?></td>
            <td><?php echo ($restaurant['restaurantOwner']); ?></td>
            <td><?php echo ($restaurant['restaurantAddress']); ?></td>
            <td><?php echo ($restaurant['restaurantEmail']); ?></td>
            <td><?php echo ($restaurant['restaurantPhone']); ?></td>
            <td>
              <?php if ($restaurant['restaurantLogo']): // Check if there is an image 
              ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($restaurant['restaurantLogo']); ?>" alt="Restaurant Image" style="width:100px;height:auto;" />
              <?php else: ?>
                No Image
              <?php endif; ?>
            </td>
            <td>
              <!-- Edit Button -->
              <form action='restaurant_edit.php' method='post' style='display:inline;'>
                <input type='hidden' name='restaurantId' value='<?php echo $restaurant['id']; ?>'>
                <button type='submit' name='editrestaurant' class='btn btn-success btn-sm' onclick='return confirm("Are you sure you want to edit this item?")'>Edit</button>
              </form>

              <!-- Delete Button -->
              <form action='restaurant_functions.php' method='post' style='display:inline;'>
                <input type='hidden' name='restaurantId' value='<?php echo $restaurant['id']; ?>'>
                <button type='submit' name='deleterestaurant' class='btn btn-danger btn-sm' onclick='return confirm("Are you sure you want to delete this item?")'>Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No restau$restaurants found.</p>
  <?php endif; ?>
</div>
</div>


<?php
include('includes/scripts.php');
?>