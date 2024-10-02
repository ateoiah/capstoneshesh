<?php
include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Restaurant Data </h6>
  </div>

  <div class="card-body">
<?php
    if(isset($_POST['edit_btn1']))
        {
            $id = $_POST['edit_id1'];

            $query = "SELECT * FROM restauranttb WHERE restaurant_id = '$id'";
            $query_run = mysqli_query($connection, $query);

            foreach($query_run as $row)
            {
                ?>

                    <form action="restaurant_functions.php" method="POST" onsubmit="return confirmSubmit()">

                    <input type="hidden" name="edit_id1" value="<?php echo $row['restaurant_id'] ?>">

                    <div class="form-group">
                        <label> Restaurant Name </label>
                        <input type="text" name="edit_restoname" value="<?php echo $row['restaurant_name'] ?>" class="form-control"
                            placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="edit_address" value="<?php echo $row['address'] ?>" class="form-control"
                            placeholder="Enter Address" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="edit_contact" class="form-control" placeholder="Enter Contact Number" 
                        value="<?php echo $row['contactnumber'] ?>" required pattern="^[0-9]{10,15}$" title="Please enter a valid contact number (10 to 15 digits)">
                    </div>

                    <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                    <button type="submit" name="updatebtn1" class="btn btn-primary"> Update </button>

</form>

<script>
    function confirmSubmit() {
        return confirm('Are you sure you want to update this restaurant?');
    }
</script>
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