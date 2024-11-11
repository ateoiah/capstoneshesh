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
        if (isset($_POST['editMenu'])) {
            $id = $_POST['menuId'];

            $query = "SELECT * FROM menutb WHERE menu_id = '$id'";
            $query_run = mysqli_query($connection, $query);

            foreach ($query_run as $row) {
        ?>

                <form action="owner_functions.php" method="POST" onsubmit="return confirmSubmit()">

                    <input type="hidden" name="menuId" value="<?php echo $row['menu_id']; ?>">
                    <div class="form-row">
                        <!-- Menu Name -->
                        <div class="form-group col-md-6">
                            <label>Menu Name</label>
                            <input type="text" name="menuName" value="<?php echo $row['menu_name'] ?>" class="form-control"
                                placeholder="Enter Menu Name" required>
                        </div>

                        <!-- Menu Price -->
                        <div class="form-group col-md-6">
                            <label>Price</label>
                            <input type="text" name="menuPrice" value="<?php echo $row['menu_price'] ?>" class="form-control"
                                placeholder="Enter Price" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- Description -->
                        <div class="form-group col-md-6">
                            <label>Description</label>
                            <input type="text" name="menuDescription" class="form-control" placeholder="Enter Description"
                                value="<?php echo $row['menu_descriptions'] ?>" required>
                        </div>

                        <!-- Menu Image -->
                        <div class="form-group col-md-6">
                            <label>Menu Image</label>
                            <input type="file" name="menuImage" class="form-control">
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Menu Category -->
                        <div class="form-group col-md-6">
                            <label for="menuCategory">Menu Category</label>
                            <select name="menuCategory" id="menuCategory" class="form-control" required>
                                <option value="" disabled>Select Category</option>
                                <option value="2" <?php if ($row['menu_category_id'] == 2) echo 'selected'; ?>>Pork</option>
                                <option value="3" <?php if ($row['menu_category_id'] == 3) echo 'selected'; ?>>Chicken</option>
                                <option value="4" <?php if ($row['menu_category_id'] == 4) echo 'selected'; ?>>Beef</option>
                                <option value="5" <?php if ($row['menu_category_id'] == 5) echo 'selected'; ?>>Shrimp</option>
                            </select>
                        </div>

                        <!-- Menu Type -->
                        <div class="form-group col-md-6">
                            <label>Menu Type</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="menuType" id="solo" value="1" <?php if ($row['menu_type_id'] == 1) echo 'checked'; ?> required>
                                <label class="form-check-label" for="solo">Solo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="menuType" id="main_dish" value="2" <?php if ($row['menu_type_id'] == 2) echo 'checked'; ?> required>
                                <label class="form-check-label" for="main_dish">Main Dish</label>
                            </div>
                        </div>

                    </div>



                    <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
                    <button type="submit" name="updateMenu" class="btn btn-primary"> Update </button>

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