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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="css_admin/update-page.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../../assets/script/public/images/ograa.png">  <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id= "content-holder">

        <div id="navbar">
            <div id="navigation">
              <div class="logo-container">
                <div id="logo-title">
                  <img id="unique-logo" src="../../assets/script/public/images/slu-logo.png" alt="Logo">
                  <h1><a href="clients/welcome-page.html">Saint Louis University</a></h1>
                </div>
              </div>
              <ul>
                  <li><a href="#home">Home</a></li>
                  <li><a href="#users">Users</a></li>
              </ul>
                <img id="user-icon" src="../../assets/script/public/images/user-icon-white.png" alt="Logo">
            </div>
          </div>

        <div id = "input-section">
            <form action='../update.php' method="post">

                <h1><pre>Update User</pre></h1>

                <div class = "input-container">
                    <label for = "username">Username</label>
                    <input id = "username" type="text" name='username' required>
                    <span class="fa-input"><i class="fas fa-user"></i></span>
                </div>
                <br>
                <br>
                <div class = "input-container">
                    <label for = "password">Password</label>
                    <input id = "password" type="password" name='password' required>
                    <span class="fa-input"><i class="fas fa-lock"></i></span>
                </div>
                <br>
                <br>
                <input id="update-password-btn" type="submit" name="update-password" value="Update Password">
            </form>
        </div>
    </div>
</body>
</html>
