<?php session_start(); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h2 class="text-center">GERVACIO'S MARBLE STORE</h2>
                <hr>
                    <h1 class="h4 text-center text-primary">Create Account</h1>
                    <?php
                    if(isset($_SESSION['status']) && $_SESSION['status'] !='') {
                        echo '<div class="alert alert-danger">'.$_SESSION['status'].'</div>';
                        unset($_SESSION['status']);
                    }
                    ?>
                    <form class="user" action="code.php" method="POST">
                        <div class="form-group row">
                            <div class="col">
                            <label> First Name </label>
                                <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col">
                            <label> Last Name </label>
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                        <label> Email Address </label>
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                        <label> Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                        <label> Confirm Password </label>
                            <input type="password" name="cpassword" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" name="signupbtn" class="btn btn-primary float-right" style="width: 180px;">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/scripts.php'); ?>
