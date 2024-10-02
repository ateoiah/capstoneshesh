<?php
include('Security.php');

if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $role = $_POST['edit_role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE admintb SET username='$username', email='$email', password='$hashed_password', position = '$role' WHERE id='$id' ";
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

?>