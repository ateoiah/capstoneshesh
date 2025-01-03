<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('Security.php'); // Include your Security script if needed

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">EatEase</h2>
                    <hr>
                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                        $alert_type = ($_SESSION['status_code'] == 'success') ? 'alert-success' : 'alert-danger';
                        echo '<div class="alert ' . $alert_type . ' alert-dismissible fade show" role="alert">';
                        echo $_SESSION['status'];
                        echo '</div>';
                        unset($_SESSION['status']);
                        unset($_SESSION['status_code']);
                    }
                    ?>
                    <form class="user" action="" method="POST">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="emaill" class="form-control" placeholder="Enter Email Address..."
                                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="passwordd" class="form-control" placeholder="Password" required>
                        </div>
                        <!-- Admin Checkbox -->
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin"
                                <?php echo isset($_SESSION['is_admin']) && $_SESSION['is_admin'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_admin">Login as Admin</label>
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
<?php
/*
if (isset($_POST['login_btn'])) {
    $email_login = $_POST['emaill'];
    $password_login = $_POST['passwordd'];
    $is_admin = isset($_POST['is_admin']) ? true : false;

    if ($is_admin) {
        // Admin login process
        $stmt = $connection->prepare("SELECT * FROM admintb WHERE email = ?");
        $stmt->bind_param("s", $email_login);
    } else {
        // Owner login process
        $stmt = $connection->prepare("SELECT * FROM restauranttb WHERE restaurant_email = ?");
        $stmt->bind_param("s", $email_login);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Fetch the hashed password and role (admin or owner)
        $hashed_password = $is_admin ? $row['password'] : $row['restaurant_password'];


        // Verify the password
        if (password_verify($password_login, $hashed_password)) {
            // Store user information in session
            $_SESSION['username'] = $email_login;

            if ($is_admin) {
                // Redirect admin to dashboard
                header('Location: index.php?status=success-logged-in=admin');
            } else {
                // Store restaurant-specific information in session for owners
                $restaurant_id = $row['restaurant_id'];
                $_SESSION['restaurant_id'] = $restaurant_id;
                $_SESSION['restaurant_name'] = $row['restaurant_name'];
                // Redirect owner to dashboard
                header("Location: owner_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['status'] = 'Invalid Email or Password!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['email'] = $email_login;
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'Invalid Email or Password!';
        $_SESSION['status_code'] = 'error';
        $_SESSION['email'] = $email_login;
        header('Location: login.php');
        exit();
    }

    $stmt->close();
}
    */
if (isset($_POST['login_btn'])) {
    $email_login = $_POST['emaill'];
    $password_login = $_POST['passwordd'];
    $is_admin = isset($_POST['is_admin']) ? true : false;

    if ($is_admin) {
        // Admin login process
        $stmt = $connection->prepare("SELECT * FROM admintb WHERE admin_email = ?");
        $stmt->bind_param("s", $email_login);
    } else {
        // Owner login process
        $stmt = $connection->prepare("SELECT * FROM restauranttb WHERE restaurant_email = ?");
        $stmt->bind_param("s", $email_login);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Fetch the stored password (no hash verification)
        $stored_password = $is_admin ? $row['admin_password'] : $row['restaurant_password'];

        // Directly compare the passwords
        if ($password_login === $stored_password) {
            // Store user information in session
            $_SESSION['username'] = $email_login;

            if ($is_admin) {
                // Redirect admin to dashboard
                header('Location: adminDashboard.php?status=success-logged-in=admin');
            } else {
                // Store restaurant-specific information in session for owners
                $restaurant_id = $row['restaurant_id'];
                $_SESSION['restaurant_id'] = $restaurant_id;
                $_SESSION['restaurant_name'] = $row['restaurant_name'];
                // Redirect owner to dashboard
                header("Location: restaurantDashboard.php");
            }
            exit();
        } else {
            $_SESSION['status'] = 'Invalid Email or Password!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['email'] = $email_login;
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'Invalid Email or Password!';
        $_SESSION['status_code'] = 'error';
        $_SESSION['email'] = $email_login;
        header('Location: login.php');
        exit();
    }

    $stmt->close();
}

?>