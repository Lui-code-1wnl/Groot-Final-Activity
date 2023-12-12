<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // Update the 'status' to 'offline' in the database
    require('includes/db.php');
    $username = $_SESSION['username'];
    $updateStmt = $conn->prepare("UPDATE user SET status='offline' WHERE username=?");
    $updateStmt->bind_param('s', $username);
    $updateStmt->execute();
    $updateStmt->close();

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page or any other appropriate page
    header('Location: index.php');
} else {
    // Redirect to the login page if the user is not logged in
    header('Location: index.php');
}
?>
