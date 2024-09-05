<?php
include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="code.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="lastname">Last Name</label>
              <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter Lastname" required>
            </div>
            <div class="form-group">
              <label for="firstname">First Name</label>
              <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter Firstname" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
                  </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="customerbtn1" class="btn btn-primary">Save</button>
          </div>
        </form>
          </div>
        </div>
      </div>

<div class="container-fluid">

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Customers Data  
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
        Add New Customer <Datag></Datag>
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
        $query = "SELECT * FROM customertb";
        $query_run = mysqli_query($connection, $query);
    ?>

      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>LAST NAME</th>
            <th>FIRST NAME</th>
            <th>EMAIL</th>
            <th>PASSWORD</th>
            <th>EDIT</th>
            <th>DELETE</th>
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
            <td> <?php echo $row['id']; ?></td>
            <td> <?php echo $row['lastname']; ?></td>
            <td> <?php echo $row['firstname']; ?></td>
            <td> <?php echo $row['email']; ?></td>
            <td> <?php echo $row['password']; ?></td>

            <td>
                <form action="Customer_edit.php" method="post">
                    <input type="hidden" name="customeredit_id" value="<?php echo $row['id']; ?>">
                    <button  type="submit" name="customeredit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
<form action="code.php" method="post" onsubmit="return confirmDelete();">
    <input type="hidden" name="customerdelete_id1" value="<?php echo $row['id']; ?>">
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