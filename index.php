<?php
include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
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
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Registered Admin</div>
                            <?php
                            if ($connection->connect_error) {
                                die("Failed". $connection->connect_error. $connection->connect_error);
                            }
                            $query = "SELECT COUNT(id) AS total_admin FROM admintb";
                            $result = $connection->query($query);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totaladmin = $row["total_admin"];
                                echo "<h4><strong>$totaladmin</strong></h4>";
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
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Registered Restaurant</div>
                            <?php
                            if ($connection->connect_error) {
                                die("Failed". $connection->connect_error. $connection->connect_error);
                            }
                            $query = "SELECT COUNT(id) AS total_product FROM restauranttb";
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
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Registered Customer</div>
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
