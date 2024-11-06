<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container mt-1">

  <?php
  if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center" style="color: green;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Unset the success message after displaying
  }

  if (isset($_SESSION['status'])) {
    echo '<div class="alert alert-danger text-center" style="color: red;">' . $_SESSION['status'] . '</div>';
    unset($_SESSION['status']); // Unset the error message after displaying
  }
  ?>

</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Admin Profile</h6>
  </div>

  <div class="card-body">
    <div class="card-body">
      <?php
      // Check if we are editing or showing an error
      if (isset($_POST['editAdmin']) || isset($_SESSION['edit_form_data'])) {
        $id = isset($_POST['adminId']) ? $_POST['adminId'] : $_SESSION['edit_form_data']['id'];

        if (!isset($_SESSION['edit_form_data'])) {
          // Fetch data from the database if not in session (i.e., the first time page loads)
          $query = "SELECT * FROM admintb WHERE admin_id = '$id'";
          $query_run = mysqli_query($connection, $query);
          $row = mysqli_fetch_assoc($query_run);

          // Store original data in session in case of errors
          $_SESSION['edit_form_data'] = [
            'id' => $row['admin_id'],
            'username' => $row['admin_username'],
            'email' => $row['admin_email']
          ];
        }

        // Use session data in case of errors
        $username = $_SESSION['edit_form_data']['username'];
        $email = $_SESSION['edit_form_data']['email'];

        // Show form with existing data
      ?>
        <form action="admin_functions.php" method="POST">

          <input type="hidden" name="edit_id" value="<?php echo $id; ?>">

          <div class="form-group">
            <label> Username </label>
            <input type="text" name="edit_username" value="<?php echo $username; ?>" class="form-control"
              placeholder="Enter Username" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="edit_email" value="<?php echo $email; ?>" class="form-control"
              placeholder="Enter Email" required>
          </div>
          <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="edit_password" class="form-control" placeholder="Enter Current Password" required>
          </div>
          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" required>
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
          </div>

          <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
          <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>

        </form>
      <?php
        // Unset the session data after showing the form so fresh inputs are used next time
        unset($_SESSION['edit_form_data']);
      }
      ?>
    </div>
  </div>

  <?php
  include('includes/scripts.php');
  include('includes/footer.php');
  ?>