<?php
include('Security.php');

if (isset($_POST['updatebtn1'])) {
    $id = $_POST['edit_id1'];
    $restaurantname = $_POST['edit_restoname'];
    $owner = $_POST['edit_owner'];
    $address = $_POST['edit_address'];
    $email = $_POST['edit_email'];
    $contactnumber = $_POST['edit_contact'];


    $query = "UPDATE restauranttb 
          SET restaurant_name = '$restaurantname', 
              restaurant_address = '$address', 
              restaurant_phoneNumber = '$contactnumber', 
              restaurant_owner = '$owner', 
              restaurant_email = '$email' 
          WHERE restaurant_id = '$id'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "<h4>YOUR DATA IS UPDATED SUCCESSFULLY</h4>";
        header('Location: Restaurant.php?status=success');
        exit(); // Make sure to exit after redirecting
    } else {
        $_SESSION['status'] = "<h4>YOUR DATA IS NOT UPDATED</h4>";
        $_SESSION['status_code'] = "error";
        header('Location: Restaurant.php?status=error');
        exit(); // Make sure to exit after redirecting
    }
}

//Delete Restaurant
if (isset($_POST['deleterestaurant'])) {
    $id = $_POST['restaurantId'];

    $query = "DELETE FROM restauranttb WHERE restaurant_id = '$id' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {

        $_SESSION['success'] = "<h4>YOUR DATA IS DELETED</h4>";
        header('Location: Restaurant.php?admin_data==successfully-deleted-admin-removed');
        exit();
    } else {
        $_SESSION['status'] = "<h4>YOUR DATA IS NOT DELETED</h4>";
        header('Location: Restaurant.php?admin_data==failed-to-delete:');
        exit();
    }
}

//Add restaurant
$error = '';
$form_data = [];

// Check if the form is submitted
if (isset($_POST['addrestaurantbtn'])) {
    $restaurantname = $_POST['restaurantname'];
    $adrress = $_POST['adrress'];
    $contactnumber = $_POST['contactnumber'];
    $email = $_POST['email'];
    $owner = $_POST['owner'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $restaurant_image = $_FILES['restaurant_image'];

    // Store form data in case of an error
    $form_data = [
        'restaurantname' => $restaurantname,
        'adrress' => $adrress,
        'contactnumber' => $contactnumber,
        'email' => $email,
        'owner' => $owner
    ];

    // Check if passwords match
    if ($password === $cpassword) {
        // Check if email already exists
        $check_email_query = "SELECT * FROM restauranttb WHERE restaurant_email = ?";
        $stmt = mysqli_prepare($connection, $check_email_query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result_email = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result_email) > 0) {
            $_SESSION['error'] = "Please register with another email.";
            $_SESSION['form_data'] = $form_data;
            header('Location: restaurant_add.php');
            exit();
        }

        // Check if restaurant already exists in the database
        $check_restaurant_query = "SELECT * FROM restauranttb WHERE restaurant_name = ?";
        $stmt = mysqli_prepare($connection, $check_restaurant_query);
        mysqli_stmt_bind_param($stmt, 's', $restaurantname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "The restaurant is already registered.";
            $_SESSION['form_data'] = $form_data;
        } else {
            // Process image upload
            if (isset($restaurant_image) && $restaurant_image['error'] === UPLOAD_ERR_OK) {
                $image_info = getimagesize($restaurant_image['tmp_name']);
                if ($image_info !== false) {
                    $restaurantimage = mysqli_real_escape_string($connection, file_get_contents($restaurant_image['tmp_name']));
                } else {
                    $_SESSION['error'] = "Uploaded file is not a valid image.";
                    $_SESSION['form_data'] = $form_data;
                    header('Location: restaurant_add.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Failed to upload the image.";
                $_SESSION['form_data'] = $form_data;
                header('Location: restaurant_add.php');
                exit();
            }

            // Insert new restaurant
            $query = "INSERT INTO restauranttb (restaurant_name, restaurant_address, restaurant_phoneNumber, restaurant_owner, restaurant_email, restaurant_password, restaurant_logo) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'sssssss', $restaurantname, $adrress, $contactnumber, $owner, $email, $password, $restaurantimage);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "<h5>New Restaurant Added</h5>";
                header('Location: Restaurant.php?new_admin_data=successfully_added');
                exit();
            } else {
                $_SESSION['error'] = "Failed to add the new restaurant. Error: " . mysqli_error($connection);
                $_SESSION['form_data'] = $form_data;
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $_SESSION['error'] = "Password and Confirm Password Do Not Match.";
        $_SESSION['form_data'] = $form_data;
    }
    header('Location: restaurant_add.php');
    exit();
}
