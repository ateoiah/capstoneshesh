   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <ul class="sidebar-brand d-flex align-items-center justify-content-center">
       <div class="sidebar-brand-icon mx-3">EatEase</sup></div>
     </ul>



     <!-- Divider -->


     <hr class="sidebar-divider">
     <!-- Nav Item - Dashboard -->
     <!-- Navigation -->
     <ul class="navbar-nav">
       <li class="nav-item">
         <a class="nav-link" href="restaurantDashboard.php">
           <img src="icons\data-analysis.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
           <span>Dashboard</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="restaurantMenu.php">
           <img src="icons\fast-food.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
           <span>Menu</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="restaurantReservation.php">
           <img src="icons\booking.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
           <span>Reservations</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="restaurantOrder.php">
           <img src="icons\order.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
           <span>Orders</span>
         </a>
       </li>
       <li class="nav-item">
         <a class="nav-link" href="restaurantHistory.php">
           <img src="icons\history.png" alt="Dashboard Icon" style="width: 20px; height: 20px; vertical-align: middle;">
           <span>History</span>
         </a>
       </li>
     </ul>

     <script>
       document.addEventListener("DOMContentLoaded", function() {
         const currentPath = location.pathname.split("/").pop(); // Get the current filename
         const navLinks = document.querySelectorAll(".nav-item .nav-link"); // Select all nav links

         navLinks.forEach(link => {
           if (link.getAttribute("href") === currentPath) {
             link.closest(".nav-item").classList.add("active"); // Add active class to nav-item
           } else {
             link.closest(".nav-item").classList.remove("active"); // Remove active from non-matching items
           }
         });
       });
     </script>


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
               <?php //echo $_SESSION['username']; 
                ?>
             </span>
             <div class="d-flex justify-content-end">
               <button class="btn btn-primary ml-2" onclick="confirmLogout()">
                 <i class="fas fa-sign-out-alt"></i> Log Out
               </button>
             </div>

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