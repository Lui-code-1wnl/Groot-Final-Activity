<?php
include 'db.php';

session_start();

if(isset($_SESSION['user'])) {
    header("Location: listofusers.php");
    exit();
}

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

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new DB();
    $conn = $db->getConnection();

    // Example: Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows != 0) {
        $user = $result->fetch_assoc();
        
        if ($user['userRole'] == 'admin') {
            if ($user['status'] == 'online') {
                // Set error message if admin is already logged in
                $_SESSION['error'] = "Admin is already logged in.";
                header('Location: index.php');
            } else {
                $_SESSION['user'] = $username;
                $_SESSION['userRole'] = $user['userRole'];
                
                // Update the 'status' to 'online' in the database
                $updateStmt = $conn->prepare("UPDATE user SET status='online' WHERE username=?");
                $updateStmt->bind_param('s', $username);
                $updateStmt->execute();
                $updateStmt->close();
                
                // Redirect to the dashboard or any other page as needed
                header("Location: listofusers.php");
                exit();
            }
        } else {
            // Handle login for non-admin users if needed
            $_SESSION['error'] = "You do not have admin privileges.";
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header('Location: index.php');
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="../assets/script/public/css/login.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="../assets/script/public/images/ograa.png">  <!-- Favicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id = "title">
                    <img id = "slu" src="../assets/script/public/images/slu-logo.png" alt="slu-logo">
                    <div id="title-header">
                        <h1>Saint Louis University</h1>
                        <h2>Office of Global Relations and Alumni Affairs</h2>
                    </div>
                    <img id = "ograa" src="../assets/script/public/images/ograa.png" alt="ograa-logo">
                </div>

                <div id = ograa-logo>
                </div>
            </div>
            <div>
        <div>
            <form action='' method="post">
                <div class="input-container">
                    <label for="username">Username</label>
                    <input id="username" type="text" name='username' required>
                    <span class="fa-input"><i class="fas fa-user"></i></span>
                </div>
                <br>
                <br>
                <div class="input-container">
                    <label for="password">Password</label>
                    <input id="password" type="password" name='password' required>
                    <span class="fa-input"><i class="fas fa-lock"></i></span>
                </div>
                <br>
                <br>
                <input id="login-btn" name="login" value="Login" type="submit">
            </form>
            <br>
            <hr>
        </div>
    </div>
</body>
</html>