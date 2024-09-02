<?php 
session_start(); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h2 class="text-center">GERVACIO'S MARBLE STORE</h2>
                <hr>
                    <h1 class="h4 text-center text-primary">Customer Login</h1>
                    <?php
                    if(isset($_SESSION['status']) && $_SESSION['status'] !='') {
                        echo '<div class="alert alert-danger">'.$_SESSION['status'].'</div>';
                        unset($_SESSION['status']);
                    }
                    ?>
                    <form class="user" action="code.php" method="POST">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="useremail" class="form-control" placeholder="Enter Email Address..." required>
                        </div>
                        <div class="form-group">
                        <label>Password</label>
                            <input type="password" name="userpassword" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" name="userlogin" class="btn btn-primary float-right" style="width: 180px;">Login</button>
                        <p>Don't have an account? <a href="usersignup.php">Register now</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('includes/scripts.php');
?>