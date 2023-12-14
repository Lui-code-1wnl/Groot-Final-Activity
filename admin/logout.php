<?php
require 'db.php';
session_start();

if (isset($_POST['logout'])) {
    // Logout logic
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];

        $db = new DB();
        $conn = $db->getConnection();

        // Update the 'status' to 'offline' in the database
        $updateStmt = $conn->prepare("UPDATE user SET status='offline' WHERE username=?");
        $updateStmt->bind_param('s', $username);
        $updateStmt->execute();
        $updateStmt->close();

        // Clear the session variables
        session_unset();
        session_destroy();

        // Redirect to the login page or any other page as needed
        header("Location: index.php");
        exit();
    }
}

// Redirect to the login page if accessed directly
header("Location: index.php");
exit();
?>
