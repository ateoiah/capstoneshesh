<?php
include('Security.php');

$error = '';
$form_data = [];

// Check if the form is submitted
if (isset($_POST['addmenubtn'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $restaurant_id = $_POST['restaurant_id']; // Make sure the restaurant_id is passed from the form

    // Store form data in case of an error
    $form_data = [
        'item_name' => $item_name,
        'price' => $price,
        'description' => $description,
        'restaurant_id' => $restaurant_id,
    ];

    // Check if the menu item already exists in the database for the specific restaurant
    $check_menu_query = "SELECT * FROM menutb WHERE item_name = ? AND restaurant_id = ?";
    $stmt = mysqli_prepare($connection, $check_menu_query);
    mysqli_stmt_bind_param($stmt, 'si', $item_name, $restaurant_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Menu item already exists for this restaurant
        $_SESSION['error'] = "The menu item already exists for this restaurant.";
        $_SESSION['form_data'] = $form_data; // Store form data
        header('Location: owner_addmenu.php');
        exit();
    } else {
        // Prepare the query using a prepared statement to insert the data into the database
        $query = "INSERT INTO menutb (item_name, description, price,  restaurant_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'ssdi', $item_name, $description, $price, $restaurant_id);

        // Execute the query and check if it was successful
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "<h4>NEW MENU ADDED</h4>";
            $_SESSION['status_code'] = "success";
            header('Location: owner_menu.php?new_menu_data=successfully_added');
            exit();
        } else {
            $_SESSION['error'] = "Failed to add the new menu item. Please try again.";
            $_SESSION['form_data'] = $form_data; // Store form data
            header('Location: owner_addmenu.php');
            exit();
        }

        mysqli_stmt_close($stmt);
    }
} else {
    // Redirect if the form is not submitted
    header('Location: owner_addmenu.php');
    exit();
}

?>
