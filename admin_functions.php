<?php
//Edit the admin
include('Security.php');
if (isset($_POST['updatebtn'])) {
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $current_password = $_POST['edit_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Store form data in session in case of an error
    $_SESSION['edit_form_data'] = [
        'id' => $id,
        'username' => $username,
        'email' => $email
    ];

    // Query to get the current password from the database
    $query = "SELECT admin_password FROM admintb WHERE admin_id='$id'";
    $query_run = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($query_run);
    $stored_password = $row['admin_password']; // Assuming 'password' is the correct column name

    // Verify the current password
    if ($current_password === $stored_password) { // Remove password_verify for plain text
        // Check if a new password is provided, otherwise retain the old one
        if (!empty($new_password)) {
            $hashed_password = $new_password; // No hashing
        } else {
            $hashed_password = $stored_password;
        }

        if ($new_password === $confirm_password) {
            $update_query = "UPDATE admintb SET admin_username='$username', admin_email='$email', admin_password='$hashed_password' WHERE admin_id='$id'"; // Ensure you are using the correct field names
            $query_run = mysqli_query($connection, $update_query);

            if ($query_run) {
                $_SESSION['success'] = "<h5>Your data has been updated successfully!</h5>";
                header("Location: admin.php?edit_id=$id");
                unset($_SESSION['edit_form_data']);
                exit();
            } else {
                $_SESSION['status'] = "<h4>Your data could not be updated.</h4>";
            }
        } else {
            $_SESSION['status'] = "<h5>Password doesn't match.</h5>";
            header("Location: admin_edit.php?edit_id=$id");
            exit();
        }
    } else {
        // Incorrect password
        $_SESSION['status'] = "<h5>Incorrect current password. Please try again.</h5>";
        header("Location: admin_edit.php?edit_id=$id");
        exit();
    }

    // Redirect back to the edit page
    header("Location: admin_edit.php?edit_id=$id");
    exit();
}




//Delete the admin
if (isset($_POST['deleteAdmin'])) {
    $id = $_POST['adminId'];

    $query = "DELETE FROM admintb WHERE admin_id = '$id' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {

        $_SESSION['success'] = "<h6>Your data is deleted.</h6>";
        header('Location: admin.php?admin_data==successfully-deleted-admin-removed');
        exit();
    } else {
        $_SESSION['status'] = "<h6>Your data is not deleted.</h6>";
        header('Location: admin.php?admin_data==failed-to-delete:');
        exit();
    }
}

//Add admin
$error = '';
$form_data = [];

if (isset($_POST['addbtn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];

    // Store form data in case of an error
    $form_data = [
        'username' => $username,
        'email' => $email,
    ];

    // Check if passwords match
    if ($password === $cpassword) {
        // Check if email already exists in the database
        $check_email_query = "SELECT * FROM admintb WHERE admin_email = ?";
        $stmt = mysqli_prepare($connection, $check_email_query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            $_SESSION['error'] = "The email is already registered. Please use a different email.";
            $_SESSION['form_data'] = $form_data; // Store form data
            header('Location: add_admin.php');
            exit();
        } else {
            // Email does not exist, proceed with adding the new admin
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare the query using a prepared statement to insert the data into the database
            $query = "INSERT INTO admintb (admin_username, admin_email, admin_password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $password);

            // Execute the query and check if it was successful
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "<h6> New admin added </h6>";
                $_SESSION['status_code'] = "success";
                header('Location: admin.php?new_admin_data=successfully_added');
                exit();
            } else {
                $_SESSION['error'] = " <h6> Failed to add the new admin. Please try again. </h6>";
                $_SESSION['form_data'] = $form_data; // Store form data
                header('Location: add_admin.php');
                exit();
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        // Passwords do not match
        $_SESSION['error'] = "Password and Confirm Password Do Not Match";
        $_SESSION['form_data'] = $form_data; // Store form data
        header('Location: add_admin.php');
        exit();
    }
} else {
    // Redirect if the form is not submitted
    header('Location: add_admin.php');
    exit();
}
