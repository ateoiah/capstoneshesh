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

            $query = "SELECT * FROM restauranttb WHERE restaurantid = '$id'";
            $query_run = mysqli_query($connection, $query);

            foreach($query_run as $row)
            {
                ?>

                    <form action="code.php" method="POST" onsubmit="return confirmSubmit()">

                    <input type="hidden" name="edit_id1" value="<?php echo $row['restaurantid'] ?>">

                    <div class="form-group">
                        <label> Product </label>
                        <input type="text" name="edit_product" value="<?php echo $row['restaurant_name'] ?>" class="form-control"
                            placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label>Adrress</label>
                        <input type="text" name="edit_price" value="<?php echo $row['adrress'] ?>" class="form-control"
                            placeholder="Enter Adrress">
                    </div>
                    <!-- <div class="form-group">
                        <label>Qantity</label>
                        <input type="text" name="edit_quantity" value="<?php echo $row['quantity'] ?>"
                            class="form-control" placeholder="Enter Password">
                    </div> -->

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