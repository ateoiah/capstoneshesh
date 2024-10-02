<?php
session_start();

include('Security.php');
include('includes/header.php'); 
include('includes/owner_navbar.php'); 

?>


    <div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Menus Data 
        <a href="owner_addmenu.php" class="btn btn-primary">
          Add Menu
        </a>
      </h6>
    </div>
  </div>
</div>

<?php
echo '<div class="container mt-5">';

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

      <div class="table-responsive">
        <?php       
        $restaurant_id = $_SESSION['restaurant_id'];
        $query = "SELECT * FROM menutb WHERE restaurant_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $restaurant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        ?>

        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Item Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>EDIT</th>
              <th>DELETE</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                  <td><?php echo $row['menuid']; ?></td>
                  <td><?php echo $row['item_name']; ?></td>
                  <td><?php echo $row['description']; ?></td>
                  <td><?php echo $row['price']; ?></td>
                  <td>
                    <form action="menu_edit.php" method="post">
                      <input type="hidden" name="edit_id" value="<?php echo $row['menuid']; ?>">
                      <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                    </form>
                  </td>
                  <td>
                  <form action="admin_functions.php" method="post" onsubmit="return confirmDelete();">
                  <input type="hidden" name="delete_id" value="<?php echo $row['menuid']; ?>">
                  <button type="submit" name="deletebtn" class="btn btn-danger">DELETE</button>
              </form>

              <script>
                  function confirmDelete() {
                      if (confirm("Are you sure you want to delete?")) {
                          return true;
                      } else {
                          return false; 
                      }
                  }
              </script>
                  </td>
                </tr>
            <?php
              }
            } else {
              echo "<tr><td colspan='6'>No Record Found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>


