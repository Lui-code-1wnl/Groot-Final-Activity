<?php
session_start();

// Check if there is an error message
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    echo '<p style="color: red;">' . $errorMessage . '</p>';
    // Clear the error message to avoid displaying it on subsequent visits
    unset($_SESSION['error']);
}

// Check if there is a success message
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    echo '<p style="color: green;">' . $successMessage . '</p>';
    // Clear the success message to avoid displaying it on subsequent visits
    unset($_SESSION['success']);
}

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header('Location: includes/login.html');
} else {
    header('Location: includes/listofusers.html');
}
?>
