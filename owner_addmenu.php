<?php
session_start();
$restaurant_id = $_SESSION['restaurant_id'];

include('Security.php');
include('includes/header.php'); 
include('includes/owner_navbar.php'); 
?>

<?php
// Initialize variables to avoid "undefined variable" warnings
$itemname = '';
$price = '';
$description = '';

// Check if there are error messages in the session
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error after displaying
}

// Check if form values are set in the session
if (isset($_SESSION['form_data'])) {
    $itemname = $_SESSION['form_data']['item_name'];
    $price = $_SESSION['form_data']['price'];
    $description = $_SESSION['form_data']['description'];

    unset($_SESSION['form_data']); // Clear form data after using
}

?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add Menu </h6>
  </div>

  <div class="card-body">

  <div class="card-body">
            <!-- Display error message -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

                    <form action="owner_functions.php" method="POST" onsubmit="return confirmSubmit()">

                    <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">

                    <div class="form-group">
                        <label> Item Name </label>
                        <input type="text" name="item_name" class="form-control" placeholder="Enter Menu Name" 
                        value="<?php echo htmlspecialchars($itemname); ?>"
                        required>
                    </div>
                    <div class="form-group">
                        <label> Description </label>
                        <input type="text" name="description" class="form-control" placeholder="Enter Menu Name" 
                        value="<?php echo htmlspecialchars($description); ?>"
                        required>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price"  class="form-control" placeholder="Enter Price" required 
                        value="<?php echo htmlspecialchars($price); ?>"
                        required>
                    </div>

                    <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                    <button type="submit" name="addmenubtn" class="btn btn-primary"> Add </button>

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
