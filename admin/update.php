<?php
require "db.php";
session_start();

//Fetch list of users
$db = new DB();
$conn = $db->getConnection();
$stmtUsers = $conn->prepare("SELECT username FROM user");
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

$userList = [];
while ($row = $resultUsers->fetch_assoc()) {
    $userList[] = $row['username'];
}

// Redirect to listofusers.php if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: listofusers.php");
    exit();
}

if (isset($_POST['update-password'])) {
    $username = $_POST['username'];
    $password = trim($_POST['password']);

    // Validate if the username contains only alphanumeric characters and underscores
    if (!preg_match('/^\w+$/', $password)) {
        $_SESSION['error'] = "Invalid password format. Please enter a valid password.";
    } else {
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
                header('Location: listofusers.php');
                exit();
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
    }

    // Redirect to update.php after updating password (whether success or error)
    header('Location: listofusers.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="css_admin/update-page.css">  <!-- Css for index -->
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
               <ul id="navigation-links">
                              <li><a href="admin.php">HOME</a></li>
                              <li><a href="listofusers.php">USERS</a></li>
                              <li><a href="listoflogs.php">LOGS</a></li>
                              <div id="admin-display">ADMIN</div> <!-- Replace <li> with <div> or <span> -->
                              <div id="logout-container">
                                  <form id="logout-form" action="logout.php" method="post">
                                      <button id="logout-button" type="submit" name="logout">Logout</button>
                                  </form>
                              </div>
                          </ul>
                    </div>
                </div>
            </div>

<div id="input-section">
    <form action='' method="post">

        <h1><pre>Update User</pre></h1>

        <div class="input-container">
            <label for="username">Select User</label>
            <div class="select-container">
                <select id="username" name="username" required>
                    <?php foreach ($userList as $user) : ?>
                        <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="fa-input"><i class="fas fa-user"></i></span>
            </div>
        </div>

        <div class="input-container">
            <label for="password">New Password</label>
            <input id="password" type="password" name='password' required>
            <span class="fa-input"><i class="fas fa-lock"></i></span>
        </div>

        <input id="update-password-btn" type="submit" name="update-password" value="Update Password">
    </form>
</div>
    </div>
</body>
</html>

