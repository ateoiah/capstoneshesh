<?php
include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Customer's Data</h6>
  </div>

  <div class="card-body">
<?php
    if(isset($_POST['customeredit_btn']))
        {
            $id = $_POST['customeredit_id'];

            $query = "SELECT * FROM customer WHERE id = '$id'";
            $query_run = mysqli_query($connection, $query);

            foreach($query_run as $row)
            {
                ?>
                    <form action="code.php" method="POST">
                    <input type="hidden" name="customeredit_id" value="<?php echo $row['id'] ?>">

                    <div class="form-group">
                        <label> Last Name </label>
                        <input type="text" name="edit_lastname" value="<?php echo $row['lastname'] ?>" class="form-control"
                            placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label> First Name </label>
                        <input type="text" name="edit_firstname" value="<?php echo $row['firstname'] ?>" class="form-control"
                            placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="edit_email" value="<?php echo $row['email'] ?>" class="form-control"
                            placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="edit_password" value="<?php echo $row['password'] ?>"
                            class="form-control" placeholder="Enter Password">
                    </div>

                    <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                    <button type="submit" name="customerupdatebtn" class="btn btn-primary"> Update </button>

</form>
  <?php
  }
  }
?>
  </div>
  </div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>