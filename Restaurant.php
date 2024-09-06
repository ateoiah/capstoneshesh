<?php
include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Restaurant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<form action="code.php" method="POST">
  <div class="modal-body">
    <div class="form-group">
      <label for="product">Name</label>
      <input type="text" name="restaurant_name" class="form-control" id="name" placeholder="Enter Restaurant" required>
    </div>
    <div class="form-group">
      <label for="price">Adrress</label>
      <input type="text" name="adrress" class="form-control" id="adrress" placeholder="Enter Adrress" required>
    </div>
     <!-- <div class="form-group">
      <label for="quantity">Quantity</label>
      <input type="text" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity" required>
    </div> -->
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" name="productbtn1" class="btn btn-primary">Save</button>
  </div>
</form>
    </div>
  </div>
</div>

<div class="container-fluid">

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Restaurants Data
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
        Add Restaurant 
      </button>
    </h6>
  </div>

  <div class="card-body">
  
  <?php

              if(isset($_SESSION['success']) && $_SESSION['success'] !='')
              {
              echo '<h2 class="bg-primary text-white">'.$_SESSION['success']. ' </h2>'; 
              unset($_SESSION['success']);
              }
              if(isset($_SESSION['status']) && $_SESSION['status'] !='')
              {
              echo '<h2>'.$_SESSION['status'].' </h2>'; unset($_SESSION['status']);
              }
              ?>
    <div class="table-responsive">
    
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
            <td> <?php echo $row['restaurantid']; ?></td>
            <td> <?php echo $row['restaurant_name']; ?></td>
            <td> <?php echo $row['adrress']; ?></td>

            <td>
                <form action="Product_edit.php" method="post">
                    <input type="hidden" name="edit_id1" value="<?php echo $row['restaurantid']; ?>">
                    <button  type="submit" name="edit_btn1" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
            <form action="code.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="delete_id1" value="<?php echo $row['restaurantid']; ?>">
                <button type="submit" name="deletebtn1" class="btn btn-danger">DELETE</button>
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