<?php
session_start();

include('Security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<?php
// Initialize variables to avoid "undefined variable" warnings
$error = '';
$username = '';
$email = '';
$role = '';

// Check if there are error messages in the session
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error after displaying
}

// Check if form values are set in the session
if (isset($_SESSION['form_data'])) {
    $username = $_SESSION['form_data']['username'];
    $email = $_SESSION['form_data']['email'];
    unset($_SESSION['form_data']); // Clear form data after using
}

?>


<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add Admin Profile </h6>
</div>

<div class="card-body">

    <div class="card-body">
        <!-- Display error message -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="admin_functions.php" method="POST" onsubmit="return confirmSubmit()">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username"
                    value="<?php echo htmlspecialchars($username); ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email"
                    value="<?php echo htmlspecialchars($email); ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>



            <a href="javascript:history.back()" class="btn btn-danger">CANCEL</a>
            <button type="submit" name="addbtn" class="btn btn-primary"> Add </button>

        </form>

    </div>
</div>

<script>
    function confirmSubmit() {
        return confirm('Are you sure you want to add this new admin?');
    }
</script>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>