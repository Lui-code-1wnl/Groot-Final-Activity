<?php
require('includes/db.php');
session_start();

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result->num_rows != 0) {
    $user = $result->fetch_assoc();
    if ($user['userRole'] == 'admin') {
        if ($user['status'] == 'online') {
            // Set error message if admin is already logged in
            $_SESSION['error'] = "Admin is already logged in.";
            header('Location: index.php');
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['userRole'] = $user['userRole'];
            
            // Update the 'status' to 'online' in the database
            $updateStmt = $conn->prepare("UPDATE user SET status='online' WHERE username=?");
            $updateStmt->bind_param('s', $username);
            $updateStmt->execute();
            $updateStmt->close();

            $stmt->close();
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "You do not have permission to access this page.";
        header('Location: index.php');
    }
} else {
    $_SESSION['error'] = "Invalid username and password";
    header('Location: index.php');
}
?>
