<?php
include('Security.php');
include('includes/header.php');
include('includes/owner_navbar.php');
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Menu</div>
                            <?php
                            if ($connection->connect_error) {
                                die("Failed". $connection->connect_error. $connection->connect_error);
                            }else{
                                if (isset($_SESSION['restaurant_id'])) {
                                    $restaurant_id = $_SESSION['restaurant_id'];
                                
                                    // Use $restaurant_id to fetch menu items for this specific restaurant
                                    $query = "SELECT * FROM menutb WHERE restaurant_id = ?";
                                    $stmt = $connection->prepare($query);
                                    $stmt->bind_param("i", $restaurant_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    
                                    $menu_query = "SELECT COUNT(menuid) AS total_menu FROM menutb WHERE restaurant_id = ?";
                                    $stmt = $connection->prepare($menu_query);

                                    if ($stmt) {
                                        // Bind the restaurant_id parameter (make sure to set this variable to the desired restaurant ID)
                                        $restaurant_id = $_SESSION['restaurant_id']; // Set this to the actual restaurant ID you want to query
                                        $stmt->bind_param("i", $restaurant_id); // Assuming restaurant_id is an integer
                                    
                                        // Execute the prepared statement
                                        $stmt->execute();
                                    
                                        // Get the result
                                        $result = $stmt->get_result();
                                        
                                        // Check if there are any rows returned
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $totalmenu = $row["total_menu"];
                                            echo "<h4><strong>$totalmenu</strong></h4>";
                                        } else {
                                            echo "<h4><strong>No menus found.</strong></h4>";
                                        }
                                    
                                        // Close the statement
                                        $stmt->close();
                                    }
                                    
                                }
                            }
                            
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Orders</div>
                            <?php
                            if ($connection->connect_error) {
                                die("Failed". $connection->connect_error. $connection->connect_error);
                            }
                            $query = "SELECT COUNT(orderid) AS total_order FROM restauranttb";
                            $result = $connection->query($query);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalproduct = $row["total_product"];
                                echo "<h4><strong>$totalproduct</strong></h4>";
                            }
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-basket fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">TOTAL CUSTOMER</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                            <?php
                                if ($connection->connect_error) {
                                die("Failed". $connection->connect_error. $connection->connect_error);
                            }
                            $query = "SELECT COUNT(id) AS total_customer FROM customertb";
                            $result = $connection->query($query);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalcustomer = $row["total_customer"];
                                echo "<h4><strong>$totalcustomer</strong></h4>";
                            }
                            ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pending Orders</div>
                            <?php echo "<h4><strong>21</strong></h4>" ?>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                          </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>   
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
