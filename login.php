<?php 
session_start();
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h2 class="text-center">EatEase</h2>
                <hr>
                    <?php
                    if(isset($_SESSION['status']) && $_SESSION['status'] !='') {
                        echo '<div class="alert alert-danger">'.$_SESSION['status'].'</div>';
                        unset($_SESSION['status']);
                    }
                    ?>
                    <form class="user" action="code.php" method="POST">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="emaill" class="form-control" placeholder="Enter Email Address..." required>
                        </div>
                        <div class="form-group">
                        <label>Password</label>
                            <input type="password" name="passwordd" class="form-control" placeholder="Password" required>
                        </div>
                        <div>
                            <label>User Type:</label>
                            <input type="radio" id="admin" name="user_type" value="admin" required>
                            <label for="admin">Admin</label>
                            <input type="radio" id="resto" name="user_type" value="resto">
                            <label for="resto">Restaurant Admin</label><br>
                        </div>
                        <button type="submit" name="login_btn" class="btn btn-primary float-right" style="width: 180px;">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('includes/scripts.php');
?>