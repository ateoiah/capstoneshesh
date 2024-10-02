   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<ul class="sidebar-brand d-flex align-items-center justify-content-center" >
  <div class="sidebar-brand-icon mx-3">EatEase</sup></div>
  </ul>



<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
  <a class="nav-link" href="owner_dashboard.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>

<li class="nav-item">
  <a class="nav-link" href="owner_menu.php">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Menu</span></a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Order</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="Restaurant.php">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Reports</span></a>
</li>

<!-- Divider 
<hr class="sidebar-divider">
-->
<!-- Heading -->

<!-- Nav Item - Pages Collapse Menu 
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Pages</span>
  </a>
  <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">USER LOGIN AND REGISTER</h6>
      <a class="collapse-item" href="userlogin.php">User Login</a>
      <a class="collapse-item" href="usersignup.php">User Register</a>
  </div>
</li>
-->
<!-- Divider 
<hr class="sidebar-divider d-none d-md-block"> -->

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="search.php" method="GET">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" name = "query"  placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
              <button class="btn btn-primary" type="submit">
<i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="admin.php" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <?php
            // Check if the username session variable is set
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; // Default value if not set
            ?>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow d-flex align-items-center">
                <span class="mr-2 text-gray-600 large">
                    <?php echo $_SESSION['username']; ?>
                </span>
                <button class="button ml-2" onclick="confirmLogout()">Log Out</button>
                
                <script>
                    function confirmLogout() {
                        // Display a confirmation dialog
                        const confirmation = confirm("Are you sure you want to log out?");

                        // If the user clicks "OK", redirect to the logout script
                        if (confirmation) {
                            location.href = 'logout.php'; // Redirect to the logout script
                        }
                        // If the user clicks "Cancel", do nothing (logout is canceled)
                    }
                </script>
            </li>


          </ul>

        </nav>
        <!-- End of Topbar -->


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="code.php" method="POST"> 
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>