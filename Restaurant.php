<?php
session_start();

include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>



<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Restaurants Data 
        <a href="restaurant_add.php" class="btn btn-primary">
          Add Restaurant
        </a>
      </h6>
    </div>
  </div>
</div>
  <div class="card-body">
  
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

    <?php        
        $query = "SELECT * FROM restauranttb";
        $query_run = mysqli_query($connection, $query);
    ?>

      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
          <tr>
            <th>ID </th>
            <th>Restaurant Name </th>
            <th>Adrress </th>
            <th>Contact Number </th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
          <?php
        if(mysqli_num_rows($query_run) > 0)
          {
            while($row = mysqli_fetch_assoc($query_run))
            {
              ?>

          <tr>
            <td> <?php echo $row['restaurant_id']; ?></td>
            <td> <?php echo $row['restaurant_name']; ?></td>
            <td> <?php echo $row['address']; ?></td>
            <td> <?php echo $row['contactnumber']; ?></td>


            <td>
                <form action="restaurant_edit.php" method="post">
                    <input type="hidden" name="edit_id1" value="<?php echo $row['restaurant_id']; ?>">
                    <button  type="submit" name="edit_btn1" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
            <form action="restaurant_functions.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="delete_id1" value="<?php echo $row['restaurant_id']; ?>">
                <button type="submit" name="restaurant_delete" class="btn btn-danger">DELETE</button>
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
           
          }
          else {
            echo "No Record Found";
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