<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
include('database/dbconfig.php');

// Check database connection
if (!$dbconfig) {
    // Redirect if there's an issue with the database connection
    header("Location: error.php?error=db_connection_failed");
    exit();
}

// Check if the user is logged in

?>
