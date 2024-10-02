<?php
include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            <?php
            if (!empty($_GET['query'])) {
                $search = $_GET['query'];

                $query_admin = "SELECT * FROM admintb 
                                   WHERE username LIKE '%$search%' 
                                   OR email LIKE '%$search%'";

                $result_admin = mysqli_query($connection, $query_admin);

                $query_customer = "SELECT * FROM customertb
                WHERE customer_lname LIKE '%$search%' OR customer_fname LIKE '%$search%'
                OR customer_email LIKE '%$search%'";

                $result_customer = mysqli_query($connection, $query_customer);

                $query_product = "SELECT * FROM restauranttb 
                                  WHERE restaurant_name LIKE '%$search%'";

                $result_restaurant = mysqli_query($connection, $query_product);
            ?>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4 class="text-primary">Search Results for Admin Table</h4>
                            <table class="table table-bordered table-striped" id="dataTableAdmin" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>USERNAME </th>
                                        <th>EMAIL </th>
                                        <th>PASSWORD </th>
                                        <th>ROLE</th>
                                        <th>EDIT </th>
                                        <th>DELETE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    function displayAdminRows($result)
                                    {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['password']; ?></td>
                                                    <td><?php echo $row['position']; ?></td>
                                                    <td>
                                                        <form action="admin_edit.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                                            <button type="submit" name="edit_btn" class="btn btn-success btn-sm"> EDIT</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                    <form action="admin_functions.php" method="post" onsubmit="return confirmDelete();">
                                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                                        <button type="submit" name="deletebtn" class="btn btn-danger btn-sm">DELETE</button>
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
                                        } else {
                                            echo "<tr><td colspan='6'>No Record Found</td></tr>";
                                        }
                                    }

                                    displayAdminRows($result_admin);
                                            ?>
                                </tbody>
                            </table>

                            <h4 class="text-danger">Search Results for Customer Table</h4>
                            <table class="table table-bordered table-striped" id="dataTableCustomer" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>LASTNAME </th>
                                        <th>FISTNAME </th>
                                        <th>EMAIl </th>
                                        <th>PASSWORD </th>
                                        <th>EDIT </th>
                                        <th>DELETE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    function displayCustomerRows($result)
                                    {
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $row['customer_id']; ?></td>
                                                    <td><?php echo $row['customer_lname']; ?></td>
                                                    <td><?php echo $row['customer_fname']; ?></td>
                                                    <td><?php echo $row['customer_email']; ?></td>
                                                    <td><?php echo $row['customer_password']; ?></td>
                                                    <td>
                                                        <form action="Customer_edit.php" method="post">
                                                            <input type="hidden" name="customeredit_id" value="<?php echo $row['customer_id']; ?>">
                                                            <button type="submit" name="customeredit_btn" class="btn btn-success btn-sm"> EDIT</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="customer_functions.php" method="post" onsubmit="return confirmDelete();">
                                                            <input type="hidden" name="customerdelete_id1" value="<?php echo $row['customer_id']; ?>">
                                                            <button type="submit" name="customerdeletebtn" class="btn btn-danger btn-sm">DELETE</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No Record Found</td></tr>";
                                        }
                                    }

                                    displayCustomerRows($result_customer);
                                            ?>
                                </tbody>
                            </table>


                            <h4 class="text-success mt-4">Search Results for Restaurant Table</h4>
                            <table class="table table-bordered table-striped" id="dataTableProduct" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>RESTAURANT </th>
                                        <th>ADRRESS </th>
                                        <th>CONTACT NUMBER </th>
                                        <th>EDIT </th>
                                        <th>DELETE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    function displayProductRows($result)
                                    {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $row['restaurantid']; ?></td>
                                                    <td><?php echo $row['restaurant_name']; ?></td>
                                                    <td><?php echo $row['adrress']; ?></td>
                                                    <td><?php echo $row['contactnumber']; ?></td>
                                                    <td>
                                                        <form action="restaurant_edit.php" method="post">
                                                            <input type="hidden" name="edit_id1" value="<?php echo $row['restaurantid']; ?>">
                                                            <button type="submit" name="edit_btn1" class="btn btn-success btn-sm"> EDIT</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="restaurant_functions.php" method="post" onsubmit="return confirmDelete();">
                                                            <input type="hidden" name="delete_id1" value="<?php echo $row['restaurantid']; ?>">
                                                            <button type="submit" name="deletebtn1" class="btn btn-danger btn-sm">DELETE</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No Record Found</td></tr>";
                                        }
                                    }

                                    displayProductRows($result_restaurant);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php
            } else {
                echo "<div class='alert alert-warning mt-4' role='alert'>Please Enter a search term.</div>";
            }
            ?>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
?>
