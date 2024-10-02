<?php
session_start();

include('Security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
// Initialize variables to avoid "undefined variable" warnings
$restaurantname = '';
$address = '';
$contactnumber = '';

// Check if there are error messages in the session
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error after displaying
}

// Check if form values are set in the session
if (isset($_SESSION['form_data'])) {
    $restaurantname = $_SESSION['form_data']['restaurantname'];
    $address = $_SESSION['form_data']['adrress'];
    $contactnumber = $_SESSION['form_data']['contactnumber'];
    unset($_SESSION['form_data']); // Clear form data after using
}

?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add Restaurant Profile </h6>
  </div>

  <div class="card-body">

  <div class="card-body">
            <!-- Display error message -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

                    <form action="restaurant_functions.php" method="POST" onsubmit="return confirmSubmit()">

                    <div class="form-group">
                        <label> Restaurant Name </label>
                        <input type="text" name="restaurantname" class="form-control" placeholder="Enter Restaurant Name" 
                        value="<?php echo htmlspecialchars($restaurantname); ?>"
                        required>
                    </div>
                    <div class="form-group">
                        <label>Adrress</label>
                        <input type="text" name="adrress"  class="form-control" placeholder="Enter Address" required 
                        value="<?php echo htmlspecialchars($address); ?>"
                        required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contactnumber" class="form-control" placeholder="Enter Contact Number" 
                        value="<?php echo htmlspecialchars($contactnumber); ?>" required pattern="^[0-9]{10,15}$" title="Please enter a valid contact number (10 to 15 digits)">
                    </div>
                    <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                    <button type="submit" name="addrestaurantbtn" class="btn btn-primary"> Add </button>

</form>

  </div>
  </div>

<script>
    function confirmSubmit() {
        return confirm('Are you sure you want to add this new admin?');
    }
</script>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
