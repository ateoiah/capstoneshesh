<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Customers Data
        <a href="customer_add.php" class="btn btn-primary">
          Add Customer
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
  $query = "SELECT * FROM customertb";
  $query_run = mysqli_query($connection, $query);
  ?>

  <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>FIRST NAME</th>
        <th>LAST NAME</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
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
            <td> <?php echo $row['customer_id']; ?></td>
            <td> <?php echo $row['customer_fname']; ?></td>
            <td> <?php echo $row['customer_lname']; ?></td>
            <td> <?php echo $row['customer_email']; ?></td>
            <td> <?php echo $row['customer_password']; ?></td>

            <td>
              <form action="Customer_edit.php" method="post">
                <input type="hidden" name="customeredit_id" value="<?php echo $row['customer_id']; ?>">
                <button type="submit" name="customeredit_btn" class="btn btn-success"> EDIT</button>
              </form>
            </td>
            <td>
              <form action="customer_functions.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="customerdelete_id" value="<?php echo $row['customer_id']; ?>">
                <button type="submit" name="customerdeletebtn" class="btn btn-danger">DELETE</button>
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