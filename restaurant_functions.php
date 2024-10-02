<?php
include('Security.php');

if(isset($_POST['updatebtn1']))
{
    $id = $_POST['edit_id1'];
    $restaurantname = $_POST['edit_restoname'];
    $address = $_POST['edit_address'];
    $contactnumber = $_POST['edit_contact'];



    $query = "UPDATE restauranttb SET restaurant_name='$restaurantname', address = '$address', contactnumber = '$contactnumber' WHERE restaurant_id='$id' ";
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
if(isset($_POST['restaurant_delete'])) {
    $id = $_POST['delete_id1'];

    $query = "DELETE FROM restauranttb WHERE restaurant_id = '$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run){
        
        $_SESSION['success'] = "<h4>YOUR DATA IS DELETED</h4>";
        header('Location: Restaurant.php?admin_data==successfully-deleted-admin-removed');
        exit();
    }else {
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
        $adrress =$_POST['adrress'];
        $contactnumber = $_POST['contactnumber'];

    
        // Store form data in case of an error
        $form_data = [
            'restaurantname' => $restaurantname,
            'adrress' => $adrress,
            'contactnumber' => $contactnumber
        ];
    
            // Check if restaurant already exists in the database
            $check_restaurant_query = "SELECT * FROM restauranttb WHERE restaurant_name = ?";
            $stmt = mysqli_prepare($connection, $check_restaurant_query);
            mysqli_stmt_bind_param($stmt, 's', $restaurantname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if (mysqli_num_rows($result) > 0) {
                // Email already exists
                $_SESSION['error'] = "The restaurant is already registered.";
                $_SESSION['form_data'] = $form_data; // Store form data
                header('Location: restaurant_add.php');
                exit();
            } else {
    
                // Prepare the query using a prepared statement to insert the data into the database
                $query = "INSERT INTO restauranttb (restaurant_name, address, contactnumber) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, 'sss', $restaurantname, $adrress, $contactnumber);
    
                // Execute the query and check if it was successful
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = "<h4>NEW RESTAURANT ADDED</h4>";
                    $_SESSION['status_code'] = "success";
                    header('Location: Restaurant.php?new_admin_data=successfully_added');
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add the new admin. Please try again.";
                    $_SESSION['form_data'] = $form_data; // Store form data
                    header('Location: restaurant_add.php');
                    exit();
                }
    
                mysqli_stmt_close($stmt);
            }
        } 
    else {
        // Redirect if the form is not submitted
        header('Location: restaurant_add.php');
        exit();
    }
    

?>
