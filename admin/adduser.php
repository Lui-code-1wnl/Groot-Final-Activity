<?php
require('includes/db.php');
session_start();

if (isset($_POST['add-button'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $userRole = $_POST['list-of-user'];

    // Check if the username already exists
    $stmtCheck = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Username already exists, display error message
        $_SESSION['error'] = "Username already exists.";
    } else {
        // Username is unique, proceed with adding the new user
        $stmtAdd = $conn->prepare("INSERT INTO user (username, password, firstName, lastName, userRole, status) VALUES (?, ?, ?, ?, ?, 'offline')");
        $stmtAdd->bind_param('sssss', $username, $password, $firstName, $lastName, $userRole);

        if ($stmtAdd->execute()) {
            // Display success message
            $_SESSION['success'] = "User added successfully.";
        } else {
            // Display error message
            $_SESSION['error'] = "Error adding user. Please try again.";
        }

        // Close the statement for adding a user
        $stmtAdd->close();
    }

    // Close the statement for checking existing username
    $stmtCheck->close();

    // Redirect to the index.php page
    header('Location: index.php');
}
?>
