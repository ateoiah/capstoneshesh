<?php
session_start();
$restaurant_id = $_SESSION['restaurant_id']; // Retrieve the restaurant ID from the session

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
    $itemname = $_SESSION['form_data']['menu_name'];
    $price = $_SESSION['form_data']['menu_price'];
    $description = $_SESSION['form_data']['menu_description'];

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

                <input type="hidden" name="restaurant_id" value="<?php echo htmlspecialchars($restaurant_id); ?>"> <!-- Ensure the restaurant_id is properly set -->

                <div class="form-group">
                    <label> Menu Name </label>
                    <input type="text" name="menu_name" class="form-control" placeholder="Enter Menu Name"
                        value="<?php echo htmlspecialchars($itemname); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label> Menu Description </label>
                    <input type="text" name="menu_description" class="form-control" placeholder="Enter Menu Description"
                        value="<?php echo htmlspecialchars($description); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label>Menu Price</label>
                    <input type="text" name="menu_price" class="form-control" placeholder="Enter Price" required
                        value="<?php echo htmlspecialchars($price); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="menuImage">Menu Image</label>
                    <input type="file" name="menu_image" class="form-control" id="menuImage" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="menuCategory">Menu Category</label>
                    <select name="menu_category" id="menuCategory" class="form-control" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="1">Flavored Wings</option>
                        <option value="2">Pork</option>
                        <option value="3">Chicken</option>
                        <option value="4">Beef</option>
                        <option value="5">Shrimp</option>
                        <option value="6">Fish</option>
                        <option value="7">Squid</option>
                        <option value="8">Pizzas</option>
                        <option value="9">Other offers</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Menu Type</label><br>
                    <div>
                        <input type="radio" name="menu_type" id="solo" value="2" required>
                        <label for="solo">Solo</label>
                    </div>
                    <div>
                        <input type="radio" name="menu_type" id="main_dish" value="1" required>
                        <label for="main_dish">Main Dish</label>
                    </div>
                </div>

                <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                <button type="submit" name="addmenubtn" class="btn btn-primary"> Add </button>

            </form>

        </div>
    </div>

    <script>
        function confirmSubmit() {
            return confirm('Are you sure you want to add this new menu item?'); // Updated message for clarity
        }
    </script>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>