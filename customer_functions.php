<?php
include('Security.php');

if (isset($_POST['customerupdatebtn'])) {
    $id = $_POST['customeredit_id'];
    $lastname = $_POST['edit_lastname'];
    $firstname = $_POST['edit_firstname'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE customertb SET customer_fname='$firstname', customer_lname = '$lastname', customer_email='$email', customer_password='$hashed_password' WHERE customer_id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "<h4>YOUR DATA IS UPDATED SUCCESSFULLY</h4>";
        header('Location: customer.php?status=success');
        exit(); // Make sure to exit after redirecting
    } else {
        $_SESSION['status'] = "<h4>YOUR DATA IS NOT UPDATED</h4>";
        $_SESSION['status_code'] = "error";
        header('Location: customer.php?status=error');
        exit(); // Make sure to exit after redirecting
    }
}

//Delete the admin
if (isset($_POST['customerdeletebtn'])) {
    $id = $_POST['customerdelete_id'];

    $query = "DELETE FROM customertb WHERE customer_id = '$id' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {

        $_SESSION['success'] = "<h4>YOUR DATA IS DELETED</h4>";
        header('Location: customer.php?admin_data==successfully-deleted-admin-removed');
        exit();
    } else {
        $_SESSION['status'] = "<h4>YOUR DATA IS NOT DELETED</h4>";
        header('Location: customer.php?admin_data==failed-to-delete:');
        exit();
    }
}

//Add Customer
//Add admin
// Initialize variables
$error = '';
$form_data = [];

// Check if the form is submitted
if (isset($_POST['addcustomerbtn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];

    // Store form data in case of an error
    $form_data = [
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
    ];

    // Check if passwords match
    if ($password === $cpassword) {
        // Check if email already exists in the database
        $check_email_query = "SELECT * FROM customertb WHERE customer_email = ?";
        $stmt = mysqli_prepare($connection, $check_email_query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            $_SESSION['error'] = "The email is already registered. Please use a different email.";
            $_SESSION['form_data'] = $form_data; // Store form data
            header('Location: customer_add.php');
            exit();
        } else {
            // Email does not exist, proceed with adding the new admin
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare the query using a prepared statement to insert the data into the database
            $query = "INSERT INTO customertb (customer_fname, customer_lname, customer_email, customer_password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'ssss', $fname, $lname, $email, $hashed_password);

            // Execute the query and check if it was successful
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "<h4>NEW CUSTOMER ADDED</h4>";
                $_SESSION['status_code'] = "success";
                header('Location: customer.php?new_admin_data=successfully_added');
                exit();
            } else {
                $_SESSION['error'] = "Failed to add the new admin. Please try again.";
                $_SESSION['form_data'] = $form_data; // Store form data
                header('Location: customer_add.php');
                exit();
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        // Passwords do not match
        $_SESSION['error'] = "Password and Confirm Password Do Not Match";
        $_SESSION['form_data'] = $form_data; // Store form data
        header('Location: customer_add.php');
        exit();
    }
} else {
    // Redirect if the form is not submitted
    header('Location: customer_add.php');
    exit();
}
