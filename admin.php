<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');

?>


<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Admins Data
        <a href="add_admin.php" class="btn btn-primary">
          Add Admin
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
  $query = "SELECT * FROM admintb";
  $query_run = mysqli_query($connection, $query);
  ?>

  <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <!-- <th>CREATED AT</th>
              <th>LAST LOGIN</th> -->
        <th>Role</th>
        <th>EDIT</th>
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
      ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['position']; ?></td>
            <td>
              <form action="admin_edit.php" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
              </form>
            </td>
            <td>
              <form action="admin_functions.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
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