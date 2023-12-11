<?php
// Database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'groot_final';

// creation of connection
$conn = new mysqli($servername, $username, $password, $database);

// validate connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  PHP code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // to retrieve user data from the database
    $stmt = $conn->prepare("SELECT username, password FROM user WHERE username = ?");

    if (!$stmt) {
        // Handle prepare error
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // will Verify password
        if (password_verify($password, $user['password'])) {
            // Valid credentials, redirect to the appropriate location
            header("Location: ../admin/admin_html/listofusers.html");
            exit();
        } else {
            // will return Incorrect password
            echo "Invalid password";
            exit();
        }
    } else {
        // For User not found
        echo "Invalid username";
        exit();
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLU Document Tracker</title>
    <link rel="stylesheet" href="../assets/script/public/css/login.css">  <!-- Css for index -->
    <link rel="icon" type="image/x-icon" href="/assets/script/public/images/ograa.png">  <!-- Favicon -->
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
            <form action='../php/login.php' method="post">
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
                <input id="login-btn" type="submit">
            </form>
            <br>
            <hr>
            <p>Don't have an account yet? <u>Contact the Admin</u></p>
        </div>
    </div>
</body>
</html>
