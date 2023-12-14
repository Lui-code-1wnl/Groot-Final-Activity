<?php
include 'db.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['delete-username'])) {
    $usernameToDelete = $_POST['username'];

    $db = new DB();
    $conn = $db->getConnection();

    // Check if the user exists
    $checkQuery = "SELECT * FROM user WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $usernameToDelete);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows != 0) {
        // User exists, proceed with deletion
        $deleteQuery = "DELETE FROM user WHERE username = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("s", $usernameToDelete);
        $deleteStmt->execute();
        $deleteStmt->close();

        $_SESSION['success'] = "User '$usernameToDelete' has been deleted successfully.";
    } else {
        $_SESSION['error'] = "User '$usernameToDelete' not found.";
    }

    $checkStmt->close();
    header("Location: listofusers.php"); // Redirect back to the user list page
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="css_admin/delete-user.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png">  <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div id= "content-holder">

    <div id="navbar">
        <div id="navigation">
            <div class="logo-container">
                <div id="logo-title">
                    <img id="unique-logo" src="../assets/script/public/images/slu-logo.png" alt="Logo">
                    <h1><a href="clients/welcome-page.html">Saint Louis University</a></h1>
                </div>
            </div>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="listofusers.php">Users</a></li>
            </ul>
            <img id="user-icon" src="../assets/script/public/images/user-icon-white.png" alt="Logo">
        </div>
    </div>

    <div id = "input-section">
        <form action='' method="post">

            <h1><pre>Delete User</pre></h1>

            <div class = "input-container">
                <label for = "username">Username</label>
                <input id = "username" type="text" name='username' required>
                <span class="fa-input"><i class="fas fa-user"></i></span>
            </div>
            <br>
            <br>

            <br>
            <br>
            <input id="delete-username-btn" type="submit" name="delete-username" value="Delete">
        </form>
    </div>
</div>
</body>
</html>