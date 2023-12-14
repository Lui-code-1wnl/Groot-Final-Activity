<?php
require "db.php";
session_start();

if (isset($_POST['update-password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate if the username contains only alphanumeric characters and underscores
    if (!preg_match('/^\w+$/', $username)) {
        $_SESSION['error'] = "Invalid username format. Please enter a valid username.";
        header('Location: includes/error.php');
        exit();
    }

    $db = new DB();
    $conn = $db->getConnection();
    // Check if the username exists
    $stmtCheck = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Username exists, proceed with updating the password
        $stmtUpdate = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
        $stmtUpdate->bind_param("ss", $password, $username);

        if ($stmtUpdate->execute()) {
            // Password updated successfully
            $_SESSION['success'] = "Password updated successfully.";
        } else {
            // Display error message
            $_SESSION['error'] = "Error updating password. Please try again.";
        }

        // Close the statement for updating password
        $stmtUpdate->close();
    } else {
        // Display error message if the username doesn't exist
        $_SESSION['error'] = "User not found. Please enter a valid username.";
    }

    // Close the statement for checking existing username
    $stmtCheck->close();

    // Redirect to listofusers.html after updating password
    header('Location: includes/listofusers.html');
}
?>
