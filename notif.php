<?php
session_start();

// Add a new notification
$_SESSION['notifications'][] = [
    'id' => uniqid(),
    'message' => 'New order placed by John Doe!',
    'timestamp' => date('Y-m-d H:i:s')
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notifications</title>
</head>

<body>
    <h2>Notifications</h2>
    <?php
    if (!empty($_SESSION['notifications'])) {
        echo '<ul>';
        foreach ($_SESSION['notifications'] as $notification) {
            echo "<li>{$notification['message']} ({$notification['timestamp']})</li>";
        }
        echo '</ul>';
    } else {
        echo '<p>No new notifications.</p>';
    }
    ?>
</body>

</html>
<?php
unset($_SESSION['notifications']);
?>