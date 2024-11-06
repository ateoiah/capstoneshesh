<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');
?>

<div class="container-fluid">
  <div class="card shadow mb-0">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Menus Data
        <a href="owner_addmenu.php" class="btn btn-primary">Add Menu</a>
      </h6>
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
?>

<?php
// Array to hold the category-wise menu items
$categories = [];

// Assuming you have a database connection named $connection
// Get the restaurant ID from the session
$restaurantId = $_SESSION['restaurant_id']; // Assuming you store restaurant ID in session
$sql = "SELECT 
  menutb.menu_id, 
  menutb.menu_name, 
  menutb.menu_price, 
  menutypetb.menu_type_name, 
  menutb.menu_descriptions, 
  menutb.menu_image, 
  menu_categorytb.menu_category_name
FROM menutb
JOIN menu_categorytb ON menutb.menu_category_id = menu_categorytb.menu_category_id
JOIN menutypetb ON menutb.menu_type_id = menutypetb.menu_type_id
WHERE menutb.restaurant_id = ?"; // Filter by restaurant ID


// Prepare and bind the SQL statement to prevent SQL injection
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $restaurantId); // Assuming restaurant_id is an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Group menu items by their category, including price and description
    $categories[$row['menu_category_name']][] = [
      'id' => $row['menu_id'],
      'name' => $row['menu_name'],
      'price' => $row['menu_price'],
      'description' => $row['menu_descriptions'],
      'image' => $row['menu_image'],
      'type' => $row['menu_type_name']
    ];
  }
}
?>

<div class="card-body">
  <!-- Tabs Navigation -->
  <ul class="nav nav-tabs" id="menuTab" role="tablist">
    <?php
    if (empty($categories)) {
      // Show message when there are no menu items
      echo '<div class="alert alert-warning text-center" style="color: orange;">No menu items available for this restaurant.</div>';
    } else {
      $isActive = true; // Flag to set the first tab as active
      foreach ($categories as $category => $menuItems) {
        $activeClass = $isActive ? 'active' : '';
        $categoryId = preg_replace('/[^a-zA-Z0-9]/', '', $category); // Sanitize category name for HTML ID
        echo "<li class='nav-item' role='presentation'>
                  <button class='nav-link $activeClass' id='$categoryId-tab' data-bs-toggle='tab' data-bs-target='#$categoryId' type='button' role='tab' aria-controls='$categoryId' aria-selected='true'>$category</button>
                </li>";
        $isActive = false;
      }
    }
    ?>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="menuTabContent">
    <?php if (!empty($categories)): ?>
      <?php $isActive = true; // Reset flag for tab content 
      ?>
      <?php foreach ($categories as $category => $menuItems): ?>
        <?php $activeClass = $isActive ? 'show active' : ''; ?>
        <?php $categoryId = preg_replace('/[^a-zA-Z0-9]/', '', $category); ?>

        <div class="tab-pane fade <?= $activeClass ?>" id="<?= $categoryId ?>" role="tabpanel" aria-labelledby="<?= $categoryId ?>-tab">
          <table class="table table-bordered table-hover table-striped mt-2">
            <thead>
              <tr>
                <th>Menu Item</th>
                <th>Price</th>
                <th>Description</th>
                <th>Type</th>
                <th>Images</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($menuItems as $item): ?>
                <tr>
                  <td><?= $item['name'] ?></td>
                  <td><?= $item['price'] ?></td>
                  <td><?= $item['description'] ?></td>
                  <td><?= $item['type'] ?></td>
                  <td>
                    <?php if (!empty($item['image'])): ?>
                      <img src="data:image/png;base64,<?= base64_encode($item['image']) ?>" alt="Menu Item Image" style="width: 100px; height: auto;" />
                    <?php else: ?>
                      No Image
                    <?php endif; ?>
                  </td>
                  <td>
                    <form action="owner_menuEdit.php" method="post" style="display:inline;">
                      <input type="hidden" name="menuId" value="<?= $item['id'] ?>">
                      <button type="submit" name="editMenu" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to edit this item?')">Edit</button>
                    </form>
                    <form action="owner_functions.php" method="post" style="display:inline;">
                      <input type="hidden" name="menuId" value="<?= $item['id'] ?>">
                      <button type="submit" name="deleteMenu" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php $isActive = false; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No categories found.</p>
    <?php endif; ?>
  </div>


</div>
</div>
</div>

<?php
include('includes/scripts.php');
?>