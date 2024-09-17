<?php   
session_start();
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
include('database/dbconfig.php'); // Include the database connection script

if (isset($_POST['login_btn'])) {
    $email_login = $_POST['emaill'];
    $password_login = $_POST['passwordd'];

    // Prepare the SQL query to prevent SQL Injection
    $stmt = $connection->prepare("SELECT * FROM admintb WHERE email = ?");
    $stmt->bind_param("s", $email_login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Fetch the hashed password and role
        $hashed_password = $row['password'];
        $role = $row['position'];

        // Verify the password
        if (password_verify($password_login, $hashed_password)) {
            // Store user information in session
            $_SESSION['username'] = $email_login;
            $_SESSION['position'] = $role; // Store role in session

            // Redirect based on role
            if ($role === 'admin') {
                header('Location: index.php?status=success-logged-in=admin');
                exit();
            } else {
                header('Location: manager_dashboard.php?status=success-logged-in=manager');
                exit();
            }
            exit(); // Ensure no further code is executed after redirection
        } else {
            $_SESSION['status'] = 'Invalid Email or Password!';
            $_SESSION['status_code'] = 'error';
            $_SESSION['email'] = $email_login; // Save email to session
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'Invalid Email or Password!';
        $_SESSION['status_code'] = 'error';
        $_SESSION['email'] = $email_login; // Save email to session
        header('Location: login.php');
        exit();
    }
    $stmt->close();
}
?>



