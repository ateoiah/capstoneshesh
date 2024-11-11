<?php
include('Security.php');

// Handle Menu Update
if (isset($_POST['updateMenu'])) {
    $menu_id = $_POST['menuId'];
    $menu_name = $_POST['menuName'];
    $menu_price = $_POST['menuPrice'];
    $menu_description = $_POST['menuDescription'];
    $menu_category = $_POST['menuCategory'];
    $menu_type = $_POST['menuType'];

    // Handle image upload
    $image_query_part = '';
    if (!empty($_FILES['menuImage']['name'])) {
        $image_name = $_FILES['menuImage']['name'];
        $image_tmp = $_FILES['menuImage']['tmp_name'];
        $image_folder = "uploads/" . basename($image_name);
        move_uploaded_file($image_tmp, $image_folder);
        $image_query_part = ", menu_image='$image_name'";
    }

    // Update query
    $update_query = "UPDATE menutb SET menu_name='$menu_name', menu_price='$menu_price', 
                     menu_descriptions='$menu_description', menu_category_id='$menu_category', 
                     menu_type_id='$menu_type' $image_query_part WHERE menu_id='$menu_id'";

    if (mysqli_query($connection, $update_query)) {
        $_SESSION['success'] = "Menu updated successfully!";
    } else {
        $_SESSION['status'] = "Failed to update menu!";
    }
    header('Location: restaurantMenu.php');
    exit();
}

// Handle Menu Deletion
if (isset($_POST['deleteMenu'])) {
    $id = $_POST['menuId'];

    $query = "DELETE FROM menutb WHERE menu_id = '$id'";
    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "<h5>Menu is deleted.</h5>";
    } else {
        $_SESSION['status'] = "<h5>YOUR DATA IS NOT DELETED</h5>";
    }
    header('Location: restaurantMenu.php?admin_data=successfully-deleted-admin-removed');
    exit();
}

// Handle Adding Menu
if (isset($_POST['addmenubtn'])) {
    $item_name = $_POST['menu_name'];
    $price = $_POST['menu_price'];
    $description = $_POST['menu_description'];
    $image = $_POST['menu_image'];
    $menu_type = $_POST['menu_type'];
    $menu_category = $_POST['menu_category'];
    $restaurant_id = $_POST['restaurant_id'];

    // Check if the menu item already exists
    $check_menu_query = "SELECT * FROM menutb WHERE menu_name = ? AND restaurant_id = ?";
    $stmt = mysqli_prepare($connection, $check_menu_query);
    mysqli_stmt_bind_param($stmt, 'si', $item_name, $restaurant_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "The menu item already exists for this restaurant.";
        $_SESSION['form_data'] = $_POST; // Store the form data
    } else {
        // Insert new menu item
        $query = "INSERT INTO menutb (menu_name, menu_descriptions, menu_price, menu_image, menu_type_id, menu_category_id, restaurant_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'ssdsssi', $item_name, $description, $price, $image, $menu_type, $menu_category, $restaurant_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "<h4>NEW MENU ADDED</h4>";
            header('Location: restaurantMenu.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to add the new menu item. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
    header('Location: owner_addmenu.php');
    exit();
}

// Handle Completing Reservations
if (isset($_POST['completeReservation'])) {
    $reservation_id = $_POST['reservationId'];

    // Check if the reservation exists
    $check_reservation_query = "SELECT * FROM reservationtb WHERE reservationId = ?";
    $stmt = mysqli_prepare($connection, $check_reservation_query);
    mysqli_stmt_bind_param($stmt, 'i', $reservation_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "The reservation does not exist.";
    } else {
        // Update reservation status
        $query = "UPDATE reservationtb SET statusId = 3 WHERE reservationId = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $reservation_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "<h6>Reservation Completed Successfully</h6>";
        } else {
            $_SESSION['error'] = "<h6>Failed to complete the reservation. Please try again.</h6>";
        }
        mysqli_stmt_close($stmt);
    }
    header('Location: restaurantReservation.php');
    exit();
}

//Handle approving reservation
if (isset($_POST['approveReservation'])) {
    $reservation_id = $_POST['reservationId'];

    // Check if the reservation exists
    $check_reservation_query = "SELECT * FROM reservationtb WHERE reservationId = ?";
    $stmt = mysqli_prepare($connection, $check_reservation_query);
    mysqli_stmt_bind_param($stmt, 'i', $reservation_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "The reservation does not exist.";
    } else {
        // Update reservation status
        $query = "UPDATE reservationtb SET statusId = 4 WHERE reservationId = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $reservation_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "<h6>Reservation Approved Successfully</h6>";
        } else {
            $_SESSION['error'] = "<h6>Failed to complete the reservation. Please try again.</h6>";
        }
        mysqli_stmt_close($stmt);
    }
    header('Location: restaurantReservation.php');
    exit();
}
