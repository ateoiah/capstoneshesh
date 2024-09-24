<?php
//Edit the admin
include('Security.php');

    if(isset($_POST['updatebtn']))
    {
        $id = $_POST['edit_id'];
        $username = $_POST['edit_username'];
        $email = $_POST['edit_email'];
        $password = $_POST['edit_password'];
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE admintb SET username='$username', email='$email', password='$hashed_password' WHERE id='$id' ";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $_SESSION['success'] = "<h4>YOUR DATA IS UPDATED SUCCESSFULLY</h4>";
            header('Location: admin.php?status=success'); 
            exit(); // Make sure to exit after redirecting
        } else {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT UPDATED</h4>";
            $_SESSION['status_code'] = "error";
            header('Location: admin.php?status=error'); 
            exit(); // Make sure to exit after redirecting
        }
    }

    //Delete the admin
    if(isset($_POST['deletebtn'])) {
        $id = $_POST['delete_id'];

        $query = "DELETE FROM admintb WHERE id = '$id' ";
        $query_run = mysqli_query($connection, $query);

        if($query_run){
            
            $_SESSION['status'] = "<h4>YOUR DATA IS DELETED</h4>";
            header('Location: admin.php?admin_data==successfully-deleted-admin-removed');
            exit();
        }else {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT DELETED</h4>";
            header('Location: admin.php?admin_data==failed-to-delete:');
            exit();
        }
    }

    //Add admin
    // Initialize variables
    $error = '';
    $form_data = [];
    
    // Check if the form is submitted
    if (isset($_POST['addbtn'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['confirm_password'];
        $role = $_POST['role'];
    
        // Store form data in case of an error
        $form_data = [
            'username' => $username,
            'email' => $email,
            'role' => $role,
        ];
    
        // Check if passwords match
        if ($password === $cpassword) {
            // Check if email already exists in the database
            $check_email_query = "SELECT * FROM admintb WHERE email = ?";
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
                $query = "INSERT INTO admintb (username, email, password, position) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $hashed_password, $role);
    
                // Execute the query and check if it was successful
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = "<h4>NEW ADMIN ADDED</h4>";
                    $_SESSION['status_code'] = "success";
                    header('Location: admin.php?new_admin_data=successfully_added');
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add the new admin. Please try again.";
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
    
?>
